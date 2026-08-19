<?php
/**
 *
 * Advanced Polls
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace wolfsblvt\advancedpolls\core;

/**
 * Inspect and safely clear residual poll metadata from phpBB topic rows.
 */
class poll_cleanup_manager
{
	const FILTER_CLEANABLE = 'cleanable';
	const FILTER_INCONSISTENT = 'inconsistent';
	const FILTER_VALID = 'valid';
	const FILTER_ALL = 'all';

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var string */
	protected $table_prefix;

	public function __construct(\phpbb\db\driver\driver_interface $db, $table_prefix)
	{
		$this->db = $db;
		$this->table_prefix = $table_prefix;
	}

	public static function normalise_filter($filter)
	{
		return in_array($filter, array(
			self::FILTER_CLEANABLE,
			self::FILTER_INCONSISTENT,
			self::FILTER_VALID,
			self::FILTER_ALL,
		), true) ? $filter : self::FILTER_CLEANABLE;
	}

	/**
	 * Return board-wide integrity counters.
	 *
	 * @return array
	 */
	public function get_summary()
	{
		return array(
			'marked' => $this->count_condition("t.poll_title <> ''"),
			'valid' => $this->count_condition($this->condition_for_filter(self::FILTER_VALID)),
			'cleanable' => $this->count_condition($this->condition_for_filter(self::FILTER_CLEANABLE)),
			'inconsistent' => $this->count_condition($this->condition_for_filter(self::FILTER_INCONSISTENT)),
			'reported' => $this->count_condition($this->condition_for_filter(self::FILTER_ALL)),
		);
	}

	public function count_rows($filter)
	{
		return $this->count_condition($this->condition_for_filter(self::normalise_filter($filter)));
	}

	/**
	 * Load one diagnostic page and its option/vote details.
	 *
	 * @param string $filter Integrity filter
	 * @param int $limit Page size
	 * @param int $start Offset
	 * @return array
	 */
	public function get_rows($filter, $limit, $start)
	{
		$filter = self::normalise_filter($filter);
		$sql = 'SELECT t.topic_id, t.forum_id, t.topic_title, t.poll_title,
				t.poll_start, t.poll_length, t.poll_max_options, t.poll_last_vote,
				t.poll_vote_change, t.wolfsblvt_poll_saved_remaining,
				t.wolfsblvt_poll_scheduled_start, f.forum_name
			FROM ' . $this->table_prefix . 'topics t
			LEFT JOIN ' . $this->table_prefix . 'forums f ON f.forum_id = t.forum_id
			WHERE ' . $this->condition_for_filter($filter) . '
			ORDER BY t.topic_id DESC';
		$result = $this->db->sql_query_limit($sql, max(1, (int) $limit), max(0, (int) $start));
		$rows = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rows[(int) $row['topic_id']] = $row;
		}
		$this->db->sql_freeresult($result);

		if (!$rows)
		{
			return array();
		}

		$options = $this->load_options(array_keys($rows));
		$votes = $this->load_vote_counts(array_keys($rows));
		foreach ($rows as $topic_id => &$row)
		{
			$row['options'] = isset($options[$topic_id]) ? $options[$topic_id] : array();
			$row['option_count'] = count($row['options']);
			$row['vote_count'] = isset($votes[$topic_id]) ? $votes[$topic_id] : 0;
			$row['integrity'] = $this->classify($row);
		}
		unset($row);

		return array_values($rows);
	}

	/**
	 * Clear only topic metadata which still has a title but no poll options.
	 *
	 * @param array $topic_ids Selected topic IDs
	 * @param bool $all_cleanable Clean every currently cleanable topic
	 * @return int Number of rows changed
	 */
	public function cleanup(array $topic_ids, $all_cleanable = false)
	{
		$topic_ids = array_values(array_unique(array_filter(array_map('intval', $topic_ids))));
		if (!$all_cleanable && !$topic_ids)
		{
			return 0;
		}

		$topics_table = $this->table_prefix . 'topics';
		$where = poll_integrity::cleanable_condition($topics_table, $this->table_prefix . 'poll_options');
		if (!$all_cleanable)
		{
			$where .= ' AND ' . $this->db->sql_in_set($topics_table . '.topic_id', $topic_ids);
		}
		$fields = array(
			'poll_title' => '',
			'poll_start' => 0,
			'poll_length' => 0,
			'poll_max_options' => 1,
			'poll_last_vote' => 0,
			'poll_vote_change' => 0,
			'wolfsblvt_poll_saved_remaining' => 0,
			'wolfsblvt_poll_scheduled_start' => 0,
			'wolfsblvt_poll_notified' => 0,
		);

		$this->db->sql_transaction('begin');
		try
		{
			$sql = 'UPDATE ' . $topics_table . '
				SET ' . $this->db->sql_build_array('UPDATE', $fields) . '
				WHERE ' . $where;
			$this->db->sql_query($sql);
			$affected = (int) $this->db->sql_affectedrows();
			$this->db->sql_transaction('commit');
		}
		catch (\Throwable $exception)
		{
			$this->db->sql_transaction('rollback');
			throw $exception;
		}

		return $affected;
	}

	protected function count_condition($condition)
	{
		$sql = 'SELECT COUNT(t.topic_id) AS total
			FROM ' . $this->table_prefix . 'topics t
			WHERE ' . $condition;
		$result = $this->db->sql_query($sql);
		$total = (int) $this->db->sql_fetchfield('total');
		$this->db->sql_freeresult($result);
		return $total;
	}

	protected function condition_for_filter($filter)
	{
		$options_table = $this->table_prefix . 'poll_options';
		switch ($filter)
		{
			case self::FILTER_VALID:
				return poll_integrity::valid_condition('t', $options_table);
			case self::FILTER_INCONSISTENT:
				return poll_integrity::inconsistent_condition('t', $options_table);
			case self::FILTER_ALL:
				return poll_integrity::reported_condition('t', $options_table);
			case self::FILTER_CLEANABLE:
			default:
				return poll_integrity::cleanable_condition('t', $options_table);
		}
	}

	protected function load_options(array $topic_ids)
	{
		$sql = 'SELECT topic_id, poll_option_id, poll_option_text, poll_option_total
			FROM ' . $this->table_prefix . 'poll_options
			WHERE ' . $this->db->sql_in_set('topic_id', array_map('intval', $topic_ids)) . '
			ORDER BY topic_id, poll_option_id';
		$result = $this->db->sql_query($sql);
		$options = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$options[(int) $row['topic_id']][] = $row;
		}
		$this->db->sql_freeresult($result);
		return $options;
	}

	protected function load_vote_counts(array $topic_ids)
	{
		$sql = 'SELECT topic_id, COUNT(*) AS total
			FROM ' . $this->table_prefix . 'poll_votes
			WHERE ' . $this->db->sql_in_set('topic_id', array_map('intval', $topic_ids)) . '
			GROUP BY topic_id';
		$result = $this->db->sql_query($sql);
		$votes = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$votes[(int) $row['topic_id']] = (int) $row['total'];
		}
		$this->db->sql_freeresult($result);
		return $votes;
	}

	protected function classify(array $row)
	{
		if ((string) $row['poll_title'] !== '' && (int) $row['option_count'] === 0)
		{
			return self::FILTER_CLEANABLE;
		}
		if ((int) $row['option_count'] > 0 && ((string) $row['poll_title'] === '' || (int) $row['poll_start'] === 0))
		{
			return self::FILTER_INCONSISTENT;
		}
		return self::FILTER_VALID;
	}
}
