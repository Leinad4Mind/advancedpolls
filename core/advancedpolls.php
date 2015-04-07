<?php
/**
 *
 * Advanced Polls
 *
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 */

namespace wolfsblvt\advancedpolls\core;

class advancedpolls
{
	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\event\dispatcher_interface */
	protected $dispatcher;

	/**
	 * Constructor
	 *
	 * @param \phpbb\db\driver\driver_interface		$db				Database
	 * @param \phpbb\config\config					$config			Config helper
	 * @param \phpbb\template\template				$template		Template object
	 * @param \phpbb\user							$user			User object
	 * @param \phpbb\auth\auth						$auth			Auth object
	 * @param \phpbb\request\request				$request		Request object
	 * @param \phpbb\event\dispatcher_interface		$dispatcher		The dispatcher object
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\config\config $config, \phpbb\template\template $template, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\request\request $request, \phpbb\event\dispatcher_interface $dispatcher)
	{
		$this->db = $db;
		$this->config = $config;
		$this->template = $template;
		$this->user = $user;
		$this->auth = $auth;
		$this->request = $request;
		$this->dispatcher = $dispatcher;

		// Add language vars
		$this->user->add_lang_ext('wolfsblvt/advancedpolls', 'advancedpolls');
	}

	/**
	 * Adds the configured poll options to the topic
	 *
	 * @param int	$topic_id	The topic id.
	 * @param array	$poll		The array of poll data for this topic
	 * @return void
	 */
	public function save_config_for_polls($topic_id, $poll)
	{
		$options = $this->get_possible_options();

		// Gather the options we should set
		$topic_sql = array();
		foreach ($options as $option)
		{
			//if ($this->request->is_set($option))
			//{
				$topic_sql[$option] = $this->request->variable($option, false);
			//}
		}

		if(empty($topic_sql))
		{
			return;
		}

		$sql = 'UPDATE ' . TOPICS_TABLE . '
				SET ' . $this->db->sql_build_array('UPDATE', $topic_sql) . "
				WHERE topic_id = $topic_id";
		$this->db->sql_query($sql);
	}

	/**
	 * Add the possible options to the template
	 *
	 * @param array	$post_data		The array of post data
	 * @param bool	$preview		Whether or not the post is being previewed
	 * @return void
	 */
	public function config_for_polls_to_template($post_data, $preview = false)
	{
		// Check stuff for official poll setting "can change vote
		if (!isset($post_data['poll_vote_change']) && !$this->request->is_set('poll_vote_change'))
		{
			$post_data['poll_vote_change'] = $this->config['wolfsblvt.advancedpolls.default_poll_votes_change'];
			$this->template->assign_vars(array(
				'VOTE_CHANGE_CHECKED'	=> ($this->config['wolfsblvt.advancedpolls.default_poll_votes_change']) ? ' checked="checked"' : '',
			));
		}

		$options = $this->get_possible_options();

		foreach ($options as $option)
		{
			if ($preview || $this->request->is_set($option))
			{
				$value_to_take = $this->request->variable($option, false);
			}
			else if (isset($post_data[$option]))
			{
				$value_to_take = ($post_data[$option] == 1) ? true : false;
			}
			else
			{
				$value_to_take = ($this->config[str_replace('wolfsblvt_', 'wolfsblvt.advancedpolls.default_', $option)] == 1) ? true : false;
			}

			$this->template->assign_vars(array(
				strtoupper($option)					=> true,
				strtoupper($option) . '_CHECKED'	=> ($value_to_take) ? ' checked="checked"' : '',
			));
		}

		return $post_data;
	}

	/**
	 * Perform all poll related modifications
	 *
	 * @param array	$topic_data		The array of topic data
	 * @return void
	 */
	public function do_poll_modification($topic_data)
	{
		// If we have ajax call here with no_vote, we exit save it here and return json_response
		if ($this->request->is_ajax() && $this->request->is_set('no_vote'))
		{
			if ($this->user->data['is_registered'])
			{
				$sql_ary = array(
					'topic_id'			=> (int) $topic_data['topic_id'],
					'poll_option_id'	=> (int) 0,
					'vote_user_id'		=> (int) $this->user->data['user_id'],
					'vote_user_ip'		=> (string) $this->user->ip,
				);

				$sql = 'INSERT INTO ' . POLL_VOTES_TABLE . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
				$this->db->sql_query($sql);

				$json_response = new \phpbb\json_response;
				$json_response->send(array('success' => true));
			}
		}

		$options = $this->get_possible_options();

		$javascript_vars = array(
			'wolfsblvt_poll_votes_hide_topic'		=> false,
			'wolfsblvt_poll_voters_show_topic'		=> false,
			'wolfsblvt_poll_voters_limit_topic'		=> false,
			'username_clean'						=> $this->user->data['username_clean'],
			'username_string'						=> get_username_string('full', $this->user->data['user_id'], $this->user->data['username'], $this->user->data['user_colour']),
			'l_seperator'							=> $this->user->lang['COMMA_SEPARATOR'],
			'l_none'								=> $this->user->lang['AP_NONE'],
		);

		// Check how many options
		$sql = 'SELECT poll_option_id
				FROM ' . POLL_OPTIONS_TABLE . '
				WHERE topic_id = ' . $topic_data['topic_id'] . '
				ORDER BY poll_option_id ASC';
		$result = $this->db->sql_query($sql);

		$poll_options = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$poll_options[] = $row['poll_option_id'];
		}
		$poll_options_count = count($poll_options);
		$this->db->sql_freeresult($result);

		$poll_votes_hidden = false;
		if ($topic_data['wolfsblvt_poll_votes_hide'] == 1 && in_array('wolfsblvt_poll_votes_hide', $options) && $topic_data['poll_length'] > 0 && ($topic_data['poll_start'] + $topic_data['poll_length']) > time())
		{
			$javascript_vars['wolfsblvt_poll_votes_hide_topic'] = true;

			// Overwrite options to hide values
			for ($i = 0; $i < $poll_options_count; $i++)
			{
				$this->template->alter_block_array('poll_option',  array(
					'POLL_OPTION_RESULT'		=> '??',
					'POLL_OPTION_PERCENT'		=> '??%',
					'POLL_OPTION_PERCENT_REL'	=> sprintf("%.1d%%", round(100 * (1/$poll_options_count))),
					'POLL_OPTION_PCT'			=> round(100 * (1/$poll_options_count)),
					'POLL_OPTION_WIDTH'			=> round(250 * (1/$poll_options_count)),
					'POLL_OPTION_MOST_VOTES'	=> false,
				), $i, 'change');
			}

			// Overwrite language vars to explain the hide
			$this->template->assign_vars(array(
				'L_NO_VOTES'			=> $this->user->lang['AP_VOTES_HIDDEN'],
				'AP_POLL_HIDE_VOTES'	=> true,
			));
			$this->template->append_var('L_POLL_LENGTH', $this->user->lang['AP_POLL_RUN_TILL_APPEND']);

			$poll_votes_hidden = true;
		}

		if ($topic_data['wolfsblvt_poll_voters_show'] == 1 && in_array('wolfsblvt_poll_voters_show', $options) && !$poll_votes_hidden && $this->auth->acl_get('u_see_voters'))
		{
			$javascript_vars['wolfsblvt_poll_voters_show_topic'] = true;

			$sql = 'SELECT poll_option_id, vote_user_id
					FROM ' . POLL_VOTES_TABLE . '
					WHERE poll_option_id > 0
						AND topic_id = ' . $topic_data['topic_id'];
			$result = $this->db->sql_query($sql);

			$option_voters = array_fill_keys($poll_options, array());
			$user_cache = array();
			while ($row = $this->db->sql_fetchrow($result))
			{
				$option_voters[$row['poll_option_id']][] = $row['vote_user_id'];
				$user_cache[$row['vote_user_id']] = null;
			}
			$this->db->sql_freeresult($result);

			// We need to get the user data so that we can print out their username
			if (!empty($user_cache))
			{
				$sql = 'SELECT user_id, username, username_clean, user_colour
						FROM ' . USERS_TABLE . '
						WHERE ' . $this->db->sql_in_set('user_id', array_keys($user_cache));
				$result = $this->db->sql_query($sql);
				while ($row = $this->db->sql_fetchrow($result))
				{
					$user_cache[$row['user_id']] = $row;
				}
				$this->db->sql_freeresult($result);
			}

			foreach ($option_voters as $option_id => $voter_ids)
			{
				$voter_list = array();
				$last_voter_id = end($voter_ids);
				foreach ($voter_ids as $voter_id)
				{
					$username = get_username_string('full', $voter_id, $user_cache[$voter_id]['username'], $user_cache[$voter_id]['user_colour']);
					$separator = ($voter_id != $last_voter_id) ? $this->user->lang['COMMA_SEPARATOR'] : '';
					$html_surrounded = '<span name="' . $user_cache[$voter_id]['username_clean'] . '">' . $username . $separator . '</span>';

					$voter_list[] = $html_surrounded;
				}

				$block_vars = array(
					'VOTER_LIST'			=> (!empty($voter_list)) ? implode($voter_list) : false,
				);
				$this->template->alter_block_array('poll_option', $block_vars, ($option_id - 1), 'change');
			}

			$message = $this->user->lang['AP_POLL_VOTES_ARE_VISIBLE'];

			$this->template->assign_vars(array(
				'AP_POLL_SHOW_VOTERS'		=> true,
			));
			$this->template->append_var('L_POLL_LENGTH', '<span class="poll_vote_notice">' . $message . '</span>');
		}

		if ($topic_data['wolfsblvt_poll_voters_limit'] == 1 && in_array('wolfsblvt_poll_voters_limit', $options))
		{
			$javascript_vars['wolfsblvt_poll_voters_limit_topic'] = true;

			$not_be_able_to_vote = false;
			$reason = "";

			// Check if user has posted in this thread
			$sql = 'SELECT post_id
					FROM ' . POSTS_TABLE . '
					WHERE poster_id = ' . $this->user->data['user_id'] . '
						AND topic_id = ' . $topic_data['topic_id'];
			$result = $this->db->sql_query_limit($sql, 1);
			$has_posted = ($this->db->sql_fetchrow($result)) ? true : false;
			$this->db->sql_freeresult($result);

			if (!$has_posted)
			{
				$not_be_able_to_vote = true;
				$reason = $this->user->lang['AP_POLL_REASON_NOT_POSTED'];

				$this->template->assign_vars(array(
					'AP_POLL_REASON_NOT_POSTED'	=> true,
				));
			}

			/**
			 * Event to modify the limit poll modification
			 *
			 * @event wolfsblvt.advancedpolls.modify_poll_limit
			 * @var	bool	not_be_able_to_vote			Bool if the user should be able to vote.
			 * @var bool	has_posted					Bool if the user already has posted in this topic
			 * @var string	reason						The reason why the user can't vote. Should be translated already.
			 * @var	array	topic_data					The topic data array
			 * @since 1.0.0
			 */
			$vars = array('not_be_able_to_vote', 'has_posted', 'reason', 'topic_data');
			extract($this->dispatcher->trigger_event('wolfsblvt.advancedpolls.modify_poll_limit', compact($vars)));

			if ($not_be_able_to_vote)
			{
				$this->template->assign_vars(array(
					'S_CAN_VOTE'		=> false,
				));

				$vote_error = $this->user->lang['AP_POLL_CANT_VOTE'] . $this->user->lang['COLON'] . ' ' . $reason;

				$this->template->assign_vars(array(
					'L_POLL_LENGTH'				=> '<span class="poll_vote_notice">' . $vote_error . '</span>',
				));
			}

			$this->template->assign_vars(array(
				'AP_POLL_LIMIT_VOTES'		=> true,
			));
		}

		if ($topic_data['wolfsblvt_poll_show_ordered'] == 1 && in_array('wolfsblvt_poll_show_ordered', $options))
		{
			$message = $this->user->lang['AP_POLL_RESULTS_ARE_ORDERED'];
			$this->template->append_var('L_POLL_LENGTH', '<span class="poll_vote_notice">' . $message . '</span>');
		}

		// Add the "don't want to vote possibility
		$this->template->assign_vars(array(
			'L_VIEW_RESULTS'		=> $this->user->lang['AP_POLL_DONT_VOTE_SHOW_RESULTS'],
		));

		// Okay, lets push some of this information to the template
		$this->template->assign_vars(array(
			'AP_JSON_DATA'		=> 'var wolfsblvt_ap_json_data = ' . json_encode($javascript_vars) . ';',
		));
	}

	/**
	 * Modify the poll options block data before being sent to the (viewtopic) template
	 *
	 * @param array	$post_options_template_data		The array of poll options data to be sent to the template
	 * @return array								The modified array of poll options data to be sent to the template
	 */
	public function do_poll_block_modification($poll_options_template_data)
	{
		usort($poll_options_template_data, array($this, "order_by_votes"));
		return $poll_options_template_data;
	}

	/**
	 * Internal function to implement ordering of votes: decreasing by number of votes received, increasing by poll option id when same number of votes
	 *
	 * @param array	$a		Array of post option data
	 * @param array	$b		Array of post option data
	 * @return int 			Greater than 0 if a < b, 0 if a = b, less than 0 if a > b
	 */
	protected function order_by_votes($a, $b)
	{
		return (((int) $b['POLL_OPTION_RESULT'] - (int) $a['POLL_OPTION_RESULT']) ?: ((int) $a['POLL_OPTION_ID'] - (int) $b['POLL_OPTION_ID']) );
	}

	/**
	 * Internal function to get the possible options for polls, if they aren't deactivated in ACP
	 *
	 * @return void
	 */
	protected function get_possible_options()
	{
		$options = array(
			'wolfsblvt_poll_votes_hide',
			'wolfsblvt_poll_voters_show',
			'wolfsblvt_poll_voters_limit',
			'wolfsblvt_poll_show_ordered',
		);

		$valid_options = array();
		foreach ($options as $option)
		{
			$config_name = str_replace('wolfsblvt_', 'wolfsblvt.advancedpolls.activate_', $option);

			if ($this->config[$config_name] == 1)
			{
				$valid_options[] = $option;
			}
		}

		return $valid_options;
	}
}
