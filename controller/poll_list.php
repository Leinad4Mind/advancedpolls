<?php
/**
 *
 * Advanced Polls
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace wolfsblvt\advancedpolls\controller;

use wolfsblvt\advancedpolls\core\poll_options;
use wolfsblvt\advancedpolls\core\poll_integrity;
use wolfsblvt\advancedpolls\core\poll_status_manager;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Display approved polls from forums accessible to the current viewer.
 */
class poll_list
{
	protected $db;
	protected $auth;
	protected $config;
	protected $controller_helper;
	protected $pagination;
	protected $request;
	protected $template;
	protected $user;
	protected $poll_status_manager;
	protected $root_path;
	protected $php_ext;

	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\controller\helper $controller_helper, \phpbb\pagination $pagination, \phpbb\request\request_interface $request, \phpbb\template\template $template, \phpbb\user $user, poll_status_manager $poll_status_manager, $root_path, $php_ext)
	{
		$this->db = $db;
		$this->auth = $auth;
		$this->config = $config;
		$this->controller_helper = $controller_helper;
		$this->pagination = $pagination;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->poll_status_manager = $poll_status_manager;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	/**
	 * Render the accessible poll directory.
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function handle()
	{
		$this->user->add_lang_ext('wolfsblvt/advancedpolls', 'advancedpolls');
		$filter = $this->request->variable('status', 'all');
		if (!in_array($filter, array('all', 'open', 'closed'), true))
		{
			$filter = 'all';
		}
		$limit = max(1, (int) $this->config['topics_per_page']);
		$start = max(0, $this->request->variable('start', 0));
		$readable_forums = array_keys($this->auth->acl_getf('f_read', true));
		$now = time();
		$where = array(
			poll_integrity::valid_condition('t', POLL_OPTIONS_TABLE),
			'(t.wolfsblvt_poll_scheduled_start = 0 OR t.wolfsblvt_poll_scheduled_start <= ' . $now . ')',
			't.topic_visibility = ' . ITEM_APPROVED,
			't.topic_moved_id = 0',
			"f.forum_password = ''",
		);
		if ($readable_forums)
		{
			$where[] = $this->db->sql_in_set('t.forum_id', array_map('intval', $readable_forums));
		}
		else
		{
			$where[] = '1 = 0';
		}
		if ($filter === 'open')
		{
			$where[] = '(t.poll_length = 0 OR t.poll_start + t.poll_length > ' . $now . ')';
		}
		else if ($filter === 'closed')
		{
			$where[] = 't.poll_length > 0 AND t.poll_start + t.poll_length <= ' . $now;
		}
		$where_sql = implode(' AND ', $where);

		$sql = 'SELECT COUNT(t.topic_id) AS total
			FROM ' . TOPICS_TABLE . ' t
			INNER JOIN ' . FORUMS_TABLE . ' f ON f.forum_id = t.forum_id
			WHERE ' . $where_sql;
		$result = $this->db->sql_query($sql);
		$total = (int) $this->db->sql_fetchfield('total');
		$this->db->sql_freeresult($result);
		$start = $this->pagination->validate_start($start, $limit, $total);

		$sql = 'SELECT t.topic_id, t.forum_id, t.topic_title, t.topic_first_post_id,
				t.poll_title, t.poll_start, t.poll_length, t.poll_max_options,
				t.wolfsblvt_poll_visibility, t.wolfsblvt_poll_type, t.wolfsblvt_poll_vote_mode,
				t.wolfsblvt_poll_score_result, t.wolfsblvt_poll_max_value,
				f.forum_name, p.bbcode_uid, p.bbcode_bitfield
			FROM ' . TOPICS_TABLE . ' t
			INNER JOIN ' . FORUMS_TABLE . ' f ON f.forum_id = t.forum_id
			INNER JOIN ' . POSTS_TABLE . ' p ON p.post_id = t.topic_first_post_id
			WHERE ' . $where_sql . '
			ORDER BY t.poll_start DESC, t.topic_id DESC';
		$result = $this->db->sql_query_limit($sql, $limit, $start);
		$topics = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$topics[(int) $row['topic_id']] = $row;
		}
		$this->db->sql_freeresult($result);
		$manageable = array();
		foreach ($topics as $topic_id => $topic)
		{
			$manageable[$topic_id] = $this->poll_status_manager->can_manage((int) $topic['forum_id']);
		}
		$participation = $this->load_participation(array_keys($topics));
		$leaders = $this->load_visible_leaders($topics, $now, $participation, $manageable);
		$can_manage_any = in_array(true, $manageable, true);

		foreach ($topics as $topic_id => $topic)
		{
			$ended = !empty($topic['poll_length']) && (int) $topic['poll_start'] + (int) $topic['poll_length'] <= $now;
			$flags = ($topic['bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0) | OPTION_FLAG_SMILIES;
			$leader = isset($leaders[$topic_id]) ? $leaders[$topic_id] : false;
			$can_manage = !empty($manageable[$topic_id]);
			$this->template->assign_block_vars('poll', array(
				'TOPIC_ID' => $topic_id,
				'TOPIC_TITLE' => censor_text($topic['topic_title']),
				'POLL_TITLE' => generate_text_for_display($topic['poll_title'], $topic['bbcode_uid'], $topic['bbcode_bitfield'], $flags, true),
				'FORUM_NAME' => censor_text($topic['forum_name']),
				'STATUS' => $this->user->lang[$ended ? 'AP_POLL_LIST_CLOSED' : 'AP_POLL_LIST_OPEN'],
				'DATE_TEXT' => !empty($topic['poll_length'])
					? $this->user->lang(
						$ended ? 'AP_POLL_LIST_ENDED' : 'AP_POLL_LIST_ENDS',
						$this->user->format_date((int) $topic['poll_start'] + (int) $topic['poll_length'])
					)
					: '',
				'RESULT_SUMMARY' => $leader ? $this->format_leader($leader, $topic, $flags, $ended) : '',
				'S_ENDED' => $ended,
				'S_CAN_MANAGE' => $can_manage,
				'U_TOPIC' => append_sid("{$this->root_path}viewtopic.{$this->php_ext}", 'f=' . (int) $topic['forum_id'] . '&amp;t=' . $topic_id),
				'U_FORUM' => append_sid("{$this->root_path}viewforum.{$this->php_ext}", 'f=' . (int) $topic['forum_id']),
			));
		}

		$base_url = $this->controller_helper->route('wolfsblvt_advancedpolls_poll_list', $filter === 'all' ? array() : array('status' => $filter));
		$this->pagination->generate_template_pagination($base_url, 'pagination', 'start', $total, $limit, $start);
		if ($can_manage_any)
		{
			add_form_key('advancedpolls_manage');
		}
		$this->template->assign_vars(array(
			'S_AP_POLL_LIST_PAGE' => true,
			'AP_POLL_COUNT' => sprintf('%d %s', $total, $this->user->lang['AP_POLL_LIST']),
			'AP_POLL_FILTER' => $filter,
			'AP_POLL_START' => $start,
			'S_AP_CAN_MANAGE' => $can_manage_any,
			'U_AP_POLL_MANAGE' => $this->controller_helper->route('wolfsblvt_advancedpolls_poll_manage'),
			'U_AP_POLL_LIST_ALL' => $this->controller_helper->route('wolfsblvt_advancedpolls_poll_list'),
			'U_AP_POLL_LIST_OPEN' => $this->controller_helper->route('wolfsblvt_advancedpolls_poll_list', array('status' => 'open')),
			'U_AP_POLL_LIST_CLOSED' => $this->controller_helper->route('wolfsblvt_advancedpolls_poll_list', array('status' => 'closed')),
		));
		return $this->controller_helper->render('@wolfsblvt_advancedpolls/advancedpolls_poll_list.html', $this->user->lang['AP_POLL_LIST']);
	}

	/**
	 * Close or reopen selected polls, then return to the current list page.
	 *
	 * @return RedirectResponse
	 */
	public function manage()
	{
		$this->user->add_lang_ext('wolfsblvt/advancedpolls', 'advancedpolls');
		if (!check_form_key('advancedpolls_manage'))
		{
			trigger_error('FORM_INVALID');
		}

		$action = $this->request->variable('manage_action', '');
		$topic_ids = $this->request->variable('poll_ids', array(0));
		$this->poll_status_manager->change_status($topic_ids, $action, time());

		$filter = $this->request->variable('status', 'all');
		if (!in_array($filter, array('all', 'open', 'closed'), true))
		{
			$filter = 'all';
		}
		$params = array();
		if ($filter !== 'all')
		{
			$params['status'] = $filter;
		}
		$start = max(0, $this->request->variable('start', 0));
		if ($start)
		{
			$params['start'] = $start;
		}

		return new RedirectResponse($this->controller_helper->route('wolfsblvt_advancedpolls_poll_list', $params, false));
	}

	/**
	 * Load the current registered viewer's vote count per topic.
	 *
	 * @param array $topic_ids Topic IDs on the current page
	 * @return array
	 */
	protected function load_participation(array $topic_ids)
	{
		if (!$topic_ids || empty($this->user->data['is_registered']))
		{
			return array();
		}

		$sql = 'SELECT topic_id, COUNT(*) AS vote_count
			FROM ' . POLL_VOTES_TABLE . '
			WHERE ' . $this->db->sql_in_set('topic_id', array_map('intval', $topic_ids)) . '
				AND vote_user_id = ' . (int) $this->user->data['user_id'] . '
			GROUP BY topic_id';
		$result = $this->db->sql_query($sql);
		$participation = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$participation[(int) $row['topic_id']] = (int) $row['vote_count'];
		}
		$this->db->sql_freeresult($result);

		return $participation;
	}

	/**
	 * Load the leading visible option for each topic without leaking hidden results.
	 *
	 * @param array $topics Topic rows keyed by topic ID
	 * @param int   $now Current timestamp
	 * @param array $participation Current viewer vote counts keyed by topic ID
	 * @param array $manageable Whether the viewer may manage each topic
	 * @return array
	 */
	protected function load_visible_leaders(array $topics, $now, array $participation, array $manageable)
	{
		$visible = array();
		foreach ($topics as $topic_id => $topic)
		{
			$ended = !empty($topic['poll_length']) && (int) $topic['poll_start'] + (int) $topic['poll_length'] <= $now;
			$vote_count = isset($participation[$topic_id]) ? (int) $participation[$topic_id] : 0;
			$has_voted = $vote_count > 0;
			$incremental = (int) $topic['wolfsblvt_poll_vote_mode'] === poll_options::VOTE_MODE_INCREMENTAL;
			$required_votes = max(1, (int) $topic['poll_max_options']);
			$vote_completed = $has_voted && (!$incremental || $vote_count >= $required_votes);
			if (!poll_options::results_are_hidden(
				(int) $topic['wolfsblvt_poll_visibility'],
				$ended,
				$has_voted,
				$vote_completed,
				!empty($manageable[$topic_id])
			))
			{
				$visible[] = (int) $topic_id;
			}
		}
		if (!$visible)
		{
			return array();
		}
		$sql = 'SELECT topic_id, poll_option_id, COUNT(*) AS rating_count
			FROM ' . POLL_VOTES_TABLE . '
			WHERE ' . $this->db->sql_in_set('topic_id', $visible) . '
				AND poll_option_id > 0
			GROUP BY topic_id, poll_option_id';
		$result = $this->db->sql_query($sql);
		$rating_counts = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rating_counts[(int) $row['topic_id']][(int) $row['poll_option_id']] = (int) $row['rating_count'];
		}
		$this->db->sql_freeresult($result);

		$sql = 'SELECT topic_id, poll_option_id, poll_option_text, poll_option_total
			FROM ' . POLL_OPTIONS_TABLE . '
			WHERE ' . $this->db->sql_in_set('topic_id', $visible) . '
			ORDER BY topic_id, poll_option_id';
		$result = $this->db->sql_query($sql);
		$leaders = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$topic = $topics[(int) $row['topic_id']];
			$row['rating_count'] = isset($rating_counts[(int) $row['topic_id']][(int) $row['poll_option_id']])
				? $rating_counts[(int) $row['topic_id']][(int) $row['poll_option_id']]
				: 0;
			$average_mode = (int) $topic['wolfsblvt_poll_type'] === poll_options::TYPE_SCORING
				&& (int) $topic['wolfsblvt_poll_score_result'] === poll_options::SCORE_RESULT_AVERAGE;
			$value = $average_mode
				? poll_options::score_average((int) $row['poll_option_total'], (int) $row['rating_count'])
				: (int) $row['poll_option_total'];
			if ($value <= 0)
			{
				continue;
			}
			if (!isset($leaders[(int) $row['topic_id']]) || $value > $leaders[(int) $row['topic_id']]['value'])
			{
				$row['value'] = $value;
				$row['average_mode'] = $average_mode;
				$leaders[(int) $row['topic_id']] = $row;
			}
		}
		$this->db->sql_freeresult($result);
		return $leaders;
	}

	/**
	 * Format a safe result summary.
	 *
	 * @param array $leader Leading option
	 * @param array $topic Topic row
	 * @param int   $flags Text parsing flags
	 * @param bool  $ended Whether the poll has ended
	 * @return string
	 */
	protected function format_leader(array $leader, array $topic, $flags, $ended)
	{
		$caption = generate_text_for_display($leader['poll_option_text'], $topic['bbcode_uid'], $topic['bbcode_bitfield'], $flags, true);
		if ($leader['average_mode'])
		{
			$value = rtrim(rtrim(number_format((float) $leader['value'], 2, '.', ''), '0'), '.');
			$result = $this->user->lang('AP_SCORE_AVERAGE', $value, (int) $topic['wolfsblvt_poll_max_value']);
		}
		else if ((int) $topic['wolfsblvt_poll_type'] === poll_options::TYPE_RANKING)
		{
			$result = $this->user->lang('AP_RANK_TOTAL', (int) $leader['value']);
		}
		else if ((int) $topic['wolfsblvt_poll_type'] === poll_options::TYPE_SCORING)
		{
			$result = $this->user->lang('AP_SCORE_POINTS_TOTAL', (int) $leader['value']);
		}
		else
		{
			$result = $this->user->lang('AP_SCORE_TOTAL', (int) $leader['value']);
		}
		return $this->user->lang($ended ? 'AP_POLL_LIST_WINNER' : 'AP_POLL_LIST_LEADING', $caption, $result);
	}
}
