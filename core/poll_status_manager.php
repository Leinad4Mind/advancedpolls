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
 * Safely close and reopen polls which the current user may moderate.
 */
class poll_status_manager
{
	const ACTION_CLOSE = 'close';
	const ACTION_OPEN = 'open';

	protected $db;
	protected $auth;
	protected $table_prefix;

	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, $table_prefix)
	{
		$this->db = $db;
		$this->auth = $auth;
		$this->table_prefix = $table_prefix;
	}

	/**
	 * Check the native phpBB permission used to lock poll topics.
	 *
	 * @param int $forum_id Forum ID
	 * @return bool
	 */
	public function can_manage($forum_id)
	{
		$forum_id = (int) $forum_id;
		return $this->auth->acl_get('f_read', $forum_id) && $this->auth->acl_get('m_lock', $forum_id);
	}

	/**
	 * Change selected poll states after rechecking every forum permission.
	 *
	 * Timed polls retain their remaining duration while manually closed.
	 * A naturally expired poll has no saved duration and reopens indefinitely.
	 *
	 * @param array  $topic_ids Topic IDs
	 * @param string $action close or open
	 * @param int    $now Current timestamp
	 * @return int Number of polls changed
	 */
	public function change_status(array $topic_ids, $action, $now)
	{
		if (!in_array($action, array(self::ACTION_CLOSE, self::ACTION_OPEN), true))
		{
			return 0;
		}

		$topic_ids = array_values(array_unique(array_filter(array_map('intval', $topic_ids))));
		if (!$topic_ids)
		{
			return 0;
		}

		$changed = 0;
		$this->db->sql_transaction('begin');
		try
		{
			$sql = 'SELECT topic_id, forum_id, poll_start, poll_length, wolfsblvt_poll_saved_remaining,
					wolfsblvt_poll_scheduled_start
				FROM ' . $this->table_prefix . 'topics
				WHERE poll_title <> \'\'
					AND ' . $this->db->sql_in_set('topic_id', $topic_ids);
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				if (!$this->can_manage((int) $row['forum_id']))
				{
					continue;
				}
				if (!empty($row['wolfsblvt_poll_scheduled_start']) && (int) $row['wolfsblvt_poll_scheduled_start'] > $now)
				{
					continue;
				}

				$poll_start = (int) $row['poll_start'];
				$poll_length = (int) $row['poll_length'];
				$ended = $poll_length > 0 && $poll_start + $poll_length <= $now;
				$sql_ary = array();

				if ($action === self::ACTION_CLOSE && !$ended)
				{
					$remaining = $poll_length > 0 ? max(0, $poll_start + $poll_length - $now) : 0;
					$closed_start = min($poll_start, $now - 1);
					$sql_ary = array(
						'poll_start' => $closed_start,
						'poll_length' => max(1, $now - $closed_start),
						'wolfsblvt_poll_saved_remaining' => $remaining,
						'wolfsblvt_poll_notified' => 0,
					);
				}
				else if ($action === self::ACTION_OPEN && $ended)
				{
					$remaining = (int) $row['wolfsblvt_poll_saved_remaining'];
					$sql_ary = array(
						'poll_length' => $remaining > 0 ? max(1, $now - $poll_start + $remaining) : 0,
						'wolfsblvt_poll_saved_remaining' => 0,
						'wolfsblvt_poll_notified' => 0,
					);
				}

				if ($sql_ary)
				{
					$sql = 'UPDATE ' . $this->table_prefix . 'topics
						SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
						WHERE topic_id = ' . (int) $row['topic_id'];
					$this->db->sql_query($sql);
					$changed++;
				}
			}
			$this->db->sql_freeresult($result);
			$this->db->sql_transaction('commit');
		}
		catch (\Throwable $exception)
		{
			$this->db->sql_transaction('rollback');
			throw $exception;
		}

		return $changed;
	}
}
