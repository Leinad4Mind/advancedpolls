<?php
/**
 *
 * Advanced Polls
 *
 * @copyright (c) 2015 Wolfsblvt
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 */

namespace wolfsblvt\advancedpolls\acp;

use wolfsblvt\advancedpolls\core\poll_options;
use wolfsblvt\advancedpolls\core\poll_cleanup_manager;
use wolfsblvt\advancedpolls\core\poll_list_order;

class advancedpolls_module
{
	const CLEANUP_BATCH_SIZE = 100;
	const CLEANUP_LINK_PREFIX = 'acp_advancedpolls_cleanup_batch';

	/** @var string The currenct action */
	public $u_action;

	/** @var \phpbb\config\config */
	public $new_config = [];

	/** @var string form key */
	public $form_key;

	/** @var string ACP template name */
	public $tpl_name;

	/** @var string ACP page title */
	public $page_title;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\request\request */
	protected $request;

	public function main($id, $mode)
	{
		global $phpbb_container;

		// Initialization
		$this->config = $phpbb_container->get('config');
		$this->db = $phpbb_container->get('dbal.conn');
		$this->user = $phpbb_container->get('user');
		$this->template = $phpbb_container->get('template');
		$this->request = $phpbb_container->get('request');

		if ($mode === 'cleanup')
		{
			$this->user->add_lang_ext('wolfsblvt/advancedpolls', array('info_acp_advancedpolls', 'acp_cleanup'));
			$this->render_cleanup(
				$phpbb_container->get('wolfsblvt.advancedpolls.poll_cleanup_manager'),
				$phpbb_container->get('pagination'),
				$phpbb_container->get('log'),
				$phpbb_container->getParameter('core.root_path'),
				$phpbb_container->getParameter('core.php_ext')
			);
			return;
		}

		$this->user->add_lang_ext('wolfsblvt/advancedpolls', 'advancedpolls');
		$action = $this->request->variable('action', '', true);
		$submit = ($this->request->is_set_post('submit')) ? true : false;

		$this->form_key = 'acp_advancedpolls';
		add_form_key($this->form_key);

		$display_vars = [
			'title' => 'AP_TITLE_ACP',
			'vars'  => [
				'legend1'                                            => 'AP_GLOBAL_SETTINGS',
				'wolfsblvt.advancedpolls.activate_closed_voting'     => ['lang' => 'AP_ACT_CLOSED_VOTING',		'validate' => 'bool',		'type' => 'radio:enabled_disabled',	'explain' => true],
				'wolfsblvt.advancedpolls.activate_no_vote'           => ['lang' => 'AP_ACT_POLL_NO_VOTE',		'validate' => 'bool',		'type' => 'radio:enabled_disabled',	'explain' => true],
				'wolfsblvt.advancedpolls.activate_show_abstainers'   => ['lang' => 'AP_ACT_SHOW_ABSTAINERS',	'validate' => 'bool',		'type' => 'radio:enabled_disabled',	'explain' => true],
				'wolfsblvt.advancedpolls.activate_vote_delete'       => ['lang' => 'AP_ACT_VOTE_DELETE',		'validate' => 'bool',		'type' => 'radio:enabled_disabled',	'explain' => true],
				'wolfsblvt.advancedpolls.activate_poll_collapsible'  => ['lang' => 'AP_ACT_POLL_COLLAPSIBLE',	'validate' => 'bool',		'type' => 'radio:enabled_disabled',	'explain' => true],
				'wolfsblvt.advancedpolls.activate_poll_start'        => ['lang' => 'AP_ACT_POLL_START',		'validate' => 'bool',		'type' => 'radio:enabled_disabled',	'explain' => true],
				'wolfsblvt.advancedpolls.activate_poll_end'          => ['lang' => 'AP_ACT_POLL_END',			'validate' => 'bool',		'type' => 'radio:enabled_disabled',	'explain' => true],
				'wolfsblvt.advancedpolls.activate_notifications'     => ['lang' => 'AP_ACT_POLL_NOTIFICATIONS',	'validate' => 'bool',		'type' => 'radio:enabled_disabled',	'explain' => true],
				'wolfsblvt.advancedpolls.show_poll_list_navbar'      => ['lang' => 'AP_SHOW_POLL_LIST_NAVBAR',	'validate' => 'bool',		'type' => 'radio:enabled_disabled',	'explain' => true],
				'wolfsblvt.advancedpolls.poll_list_order'             => ['lang' => 'AP_POLL_LIST_ORDER',		'validate' => 'string',		'type' => 'select:1', 'method' => 'select_poll_list_order', 'explain' => true],
				'legend2'                                            => 'AP_PER_POLL_SETTINGS',
				'wolfsblvt.advancedpolls.default_poll_visibility'    => ['lang' => 'AP_DEFAULT_POLL_VISIBILITY',	'validate' => 'int:0:3',	'type' => 'select:1', 'method' => 'select_poll_visibility', 'explain' => true],
				'wolfsblvt.advancedpolls.default_poll_vote_mode'     => ['lang' => 'AP_DEFAULT_POLL_VOTE_MODE',	'validate' => 'int:0:2',	'type' => 'select:1', 'method' => 'select_poll_vote_mode', 'explain' => true],
				'wolfsblvt.advancedpolls.activate_poll_scoring'      => ['lang' => 'AP_ACT_POLL_SCORING',		'validate' => 'bool',		'type' => 'radio:enabled_disabled',	'explain' => true],
				'wolfsblvt.advancedpolls.default_poll_score_result'  => ['lang' => 'AP_DEFAULT_SCORE_RESULT',	'validate' => 'int:0:1',	'type' => 'select:1', 'method' => 'select_score_result', 'explain' => true],
				'wolfsblvt.advancedpolls.default_poll_show_percent'  => ['lang' => 'AP_DEFAULT_SHOW_PERCENT',	'validate' => 'bool',		'type' => 'radio:yes_no',	'explain' => true],
				'wolfsblvt.advancedpolls.activate_poll_voters_show'  => ['lang' => 'AP_ACT_VOTERS_SHOW',		'validate' => 'bool',		'type' => 'radio:enabled_disabled',	'explain' => true],
				'wolfsblvt.advancedpolls.default_poll_voters_show'   => ['lang' => 'AP_DEFAULT_VOTERS_SHOW',	'validate' => 'bool',		'type' => 'radio:yes_no',	'explain' => false],
				'wolfsblvt.advancedpolls.activate_poll_voters_limit' => ['lang' => 'AP_ACT_VOTERS_LIMIT',		'validate' => 'bool',		'type' => 'radio:enabled_disabled',	'explain' => true],
				'wolfsblvt.advancedpolls.default_poll_voters_limit'  => ['lang' => 'AP_DEFAULT_VOTERS_LIMIT',	'validate' => 'bool',		'type' => 'radio:yes_no',	'explain' => false],
				'wolfsblvt.advancedpolls.activate_poll_show_ordered' => ['lang' => 'AP_ACT_SHOW_ORDERED',		'validate' => 'bool',		'type' => 'radio:enabled_disabled',	'explain' => true],
				'wolfsblvt.advancedpolls.default_poll_show_ordered'  => ['lang' => 'AP_DEFAULT_SHOW_ORDERED',	'validate' => 'bool',		'type' => 'radio:yes_no',	'explain' => false],
				'legend3'                                            => 'ACP_SUBMIT_CHANGES'
			],
		];

		#region Submit
		if ($submit)
		{
			$submit = $this->do_submit_stuff($display_vars);

			// If the submit was valid, so still submitted
			if ($submit)
			{
				trigger_error($this->user->lang('CONFIG_UPDATED') . adm_back_link($this->u_action), E_USER_NOTICE);
			}
		}
		#endregion

		$this->generate_stuff_for_cfg_template($display_vars);

		// Output page template file
		$this->tpl_name = 'acp_advancedpolls';
		$this->page_title = $this->user->lang($display_vars['title']);
	}

	protected function render_cleanup(poll_cleanup_manager $cleanup, \phpbb\pagination $pagination, $log, $root_path, $php_ext)
	{
		// These must be available before any action can raise an ACP notice.
		$this->tpl_name = 'acp_advancedpolls_cleanup';
		$this->page_title = $this->user->lang('AP_CLEANUP_ACP');

		$this->form_key = 'acp_advancedpolls_cleanup';
		add_form_key($this->form_key);
		$filter = poll_cleanup_manager::normalise_filter($this->request->variable('filter', poll_cleanup_manager::FILTER_CLEANABLE));
		$start = max(0, $this->request->variable('start', 0));
		$action = $this->request->variable(
			'cleanup_action',
			'',
			false,
			\phpbb\request\request_interface::POST
		);
		$batch_action = $this->request->variable('cleanup_batch', '');
		$valid_actions = array('selected', 'all', 'empty_wrappers');
		$is_confirmation = $this->request->is_set_post('confirm');

		// Never turn a confirmed destructive request with missing state into an
		// ordinary page view. Some PHP/proxy configurations do not populate the
		// aggregate REQUEST bag consistently even though the POST body is intact.
		if ($is_confirmation && !in_array($action, $valid_actions, true))
		{
			trigger_error($this->user->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
		}

		if (in_array($batch_action, array('all', 'empty_wrappers'), true))
		{
			$cursor = max(0, $this->request->variable('cleanup_cursor', 0));
			$total = max(0, $this->request->variable('cleanup_total', 0));
			$processed = max(0, $this->request->variable('cleanup_processed', 0));
			$cleaned = max(0, $this->request->variable('cleanup_cleaned', 0));
			$hash_name = $this->cleanup_hash_name($batch_action, $cursor, $total, $processed, $cleaned);
			if (!check_link_hash($this->request->variable('hash', ''), $hash_name))
			{
				trigger_error($this->user->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			$this->run_cleanup_batch($batch_action, $cursor, $total, $processed, $cleaned, $cleanup, $log);
			return;
		}

		if (!$this->request->is_set_post('cancel') && in_array($action, $valid_actions, true))
		{
			$confirmed = confirm_box(true);
			if (!$confirmed && $this->request->is_set_post('confirm'))
			{
				trigger_error($this->user->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}
			if (!$confirmed && !check_form_key($this->form_key))
			{
				trigger_error($this->user->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			$topic_ids = array_values(array_unique(array_filter(array_map('intval', $this->request->variable(
				'topic_ids',
				array(0),
				false,
				\phpbb\request\request_interface::POST
			)))));
			$all_cleanable = $action === 'all';
			$empty_wrappers = $action === 'empty_wrappers';
			if (!$empty_wrappers && !$all_cleanable && !$topic_ids)
			{
				trigger_error($this->user->lang('AP_CLEANUP_NOTHING_SELECTED') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			if ($confirmed)
			{
				if ($empty_wrappers || $all_cleanable)
				{
					$requested = max(0, $this->request->variable(
						'cleanup_total',
						0,
						false,
						\phpbb\request\request_interface::POST
					));
					$this->run_cleanup_batch($action, 0, $requested, 0, 0, $cleanup, $log);
					return;
				}

				$result = $cleanup->cleanup_with_report($topic_ids);
				$affected = $result['cleaned'];
				$log->add(
					'admin',
					(int) $this->user->data['user_id'],
					$this->user->ip,
					'LOG_AP_POLL_CLEANUP',
					time(),
					array($affected)
				);
				trigger_error($this->user->lang('AP_CLEANUP_RESULT_DETAIL', $result['cleaned'], $result['skipped']) . adm_back_link($this->u_action), E_USER_NOTICE);
			}

			$summary = $cleanup->get_summary();
			$requested = $empty_wrappers ? (int) $summary['empty_wrappers'] : ($all_cleanable ? (int) $summary['cleanable'] : count($topic_ids));
			$hidden = array(
				'cleanup_action' => $action,
				'filter' => $filter,
				'start' => $start,
				'cleanup_total' => $requested,
			);
			if (!$empty_wrappers && !$all_cleanable)
			{
				$hidden['topic_ids'] = $topic_ids;
			}
			$confirm_key = $empty_wrappers ? 'AP_CLEANUP_CONFIRM_EMPTY_WRAPPERS' : ($all_cleanable ? 'AP_CLEANUP_CONFIRM_ALL' : 'AP_CLEANUP_CONFIRM_SELECTED');
			confirm_box(
				false,
				$this->user->lang($confirm_key, $requested),
				build_hidden_fields($hidden),
				'confirm_body.html',
				$this->u_action
			);
			return;
		}

		$summary = $cleanup->get_summary();
		$per_page = 50;
		$total = $cleanup->count_rows($filter);
		$start = $pagination->validate_start($start, $per_page, $total);
		$rows = $cleanup->get_rows($filter, $per_page, $start);

		foreach ($rows as $row)
		{
			$poll_start = (int) $row['poll_start'];
			$poll_length = (int) $row['poll_length'];
			$poll_end = $poll_length > 0 ? $poll_start + $poll_length : 0;
			$integrity = $row['integrity'];
			$this->template->assign_block_vars('poll_row', array(
				'TOPIC_ID' => (int) $row['topic_id'],
				'TOPIC_TITLE' => htmlspecialchars((string) $row['topic_title'], ENT_COMPAT, 'UTF-8'),
				'FORUM_NAME' => htmlspecialchars((string) $row['forum_name'], ENT_COMPAT, 'UTF-8'),
				'POLL_TITLE' => htmlspecialchars((string) $row['poll_title'], ENT_COMPAT, 'UTF-8'),
				'POLL_START' => $poll_start,
				'POLL_START_DATE' => $poll_start > 0 ? $this->user->format_date($poll_start) : '-',
				'POLL_LENGTH' => $poll_length,
				'POLL_END_DATE' => $poll_end > 0 ? $this->user->format_date($poll_end) : '-',
				'POLL_MAX_OPTIONS' => (int) $row['poll_max_options'],
				'POLL_LAST_VOTE' => (int) $row['poll_last_vote'],
				'SAVED_REMAINING' => (int) $row['wolfsblvt_poll_saved_remaining'],
				'SCHEDULED_START' => (int) $row['wolfsblvt_poll_scheduled_start'],
				'OPTION_COUNT' => (int) $row['option_count'],
				'VOTE_COUNT' => (int) $row['vote_count'],
				'S_CLEANABLE' => $integrity === poll_cleanup_manager::FILTER_CLEANABLE,
				'S_INCONSISTENT' => $integrity === poll_cleanup_manager::FILTER_INCONSISTENT,
				'S_VALID' => $integrity === poll_cleanup_manager::FILTER_VALID,
				'U_TOPIC' => append_sid($root_path . 'viewtopic.' . $php_ext, 'f=' . (int) $row['forum_id'] . '&amp;t=' . (int) $row['topic_id']),
			));

			foreach ($row['options'] as $option)
			{
				$this->template->assign_block_vars('poll_row.option', array(
					'ID' => (int) $option['poll_option_id'],
					'TEXT' => htmlspecialchars((string) $option['poll_option_text'], ENT_COMPAT, 'UTF-8'),
					'TOTAL' => (int) $option['poll_option_total'],
				));
			}
		}

		$base_url = $this->u_action . '&amp;filter=' . urlencode($filter);
		$pagination->generate_template_pagination($base_url, 'pagination', 'start', $total, $per_page, $start);
		$this->template->assign_vars(array(
			'U_ACTION' => $this->u_action,
			'U_FILTER_CLEANABLE' => $this->u_action . '&amp;filter=' . poll_cleanup_manager::FILTER_CLEANABLE,
			'U_FILTER_INCONSISTENT' => $this->u_action . '&amp;filter=' . poll_cleanup_manager::FILTER_INCONSISTENT,
			'U_FILTER_VALID' => $this->u_action . '&amp;filter=' . poll_cleanup_manager::FILTER_VALID,
			'U_FILTER_ALL' => $this->u_action . '&amp;filter=' . poll_cleanup_manager::FILTER_ALL,
			'CURRENT_FILTER' => $filter,
			'TOTAL_ROWS' => $total,
			'MARKED_TOTAL' => (int) $summary['marked'],
			'VALID_TOTAL' => (int) $summary['valid'],
			'CLEANABLE_TOTAL' => (int) $summary['cleanable'],
			'INCONSISTENT_TOTAL' => (int) $summary['inconsistent'],
			'EMPTY_WRAPPER_TOTAL' => (int) $summary['empty_wrappers'],
			'S_HAS_CLEANABLE' => (int) $summary['cleanable'] > 0,
			'S_HAS_EMPTY_WRAPPERS' => (int) $summary['empty_wrappers'] > 0,
		));

	}

	/**
	 * Process one cleanup batch and schedule the next request when required.
	 */
	protected function run_cleanup_batch($action, $cursor, $total, $processed, $cleaned, poll_cleanup_manager $cleanup, $log)
	{
		$empty_wrappers = $action === 'empty_wrappers';
		$result = $cleanup->cleanup_batch($cursor, self::CLEANUP_BATCH_SIZE, $empty_wrappers);
		$processed += (int) $result['processed'];
		$cleaned += (int) $result['cleaned'];

		if ($result['has_more'])
		{
			$cursor = (int) $result['last_topic_id'];
			$hash_name = $this->cleanup_hash_name($action, $cursor, $total, $processed, $cleaned);
			$continue_url = $this->u_action
				. '&amp;cleanup_batch=' . urlencode($action)
				. '&amp;cleanup_cursor=' . $cursor
				. '&amp;cleanup_total=' . $total
				. '&amp;cleanup_processed=' . $processed
				. '&amp;cleanup_cleaned=' . $cleaned
				. '&amp;hash=' . generate_link_hash($hash_name);
			meta_refresh(1, $continue_url);

			$this->template->assign_vars(array(
				'S_CLEANUP_PROGRESS' => true,
				'CLEANUP_PROGRESS_EXPLAIN' => $this->user->lang('AP_CLEANUP_PROGRESS_EXPLAIN', self::CLEANUP_BATCH_SIZE),
				'CLEANUP_PROGRESS_VALUE' => min($processed, max(1, $total)),
				'CLEANUP_PROGRESS_TOTAL' => max(1, $total),
				'CLEANUP_PROGRESS_PERCENT' => $total > 0 ? min(100, round(($processed / $total) * 100, 2)) : 100,
				'CLEANUP_PROGRESS_TEXT' => $this->user->lang('AP_CLEANUP_PROGRESS', $processed, $total, $cleaned),
				'U_CLEANUP_CONTINUE' => $continue_url,
			));
			return;
		}

		$skipped = max(0, $total - $cleaned);
		$log->add(
			'admin',
			(int) $this->user->data['user_id'],
			$this->user->ip,
			'LOG_AP_POLL_CLEANUP',
			time(),
			array($cleaned)
		);
		$message = $empty_wrappers
			? $this->user->lang('AP_CLEANUP_EMPTY_WRAPPERS_RESULT', $cleaned)
			: $this->user->lang('AP_CLEANUP_RESULT_DETAIL', $cleaned, $skipped);
		trigger_error($message . adm_back_link($this->u_action), E_USER_NOTICE);
	}

	/**
	 * Bind every continuation parameter to the session-scoped phpBB link hash.
	 */
	protected function cleanup_hash_name($action, $cursor, $total, $processed, $cleaned)
	{
		return self::CLEANUP_LINK_PREFIX . '_' . $action . '_' . (int) $cursor . '_' . (int) $total . '_' . (int) $processed . '_' . (int) $cleaned;
	}

	/**
	 * Build the default poll visibility selector.
	 *
	 * @param int    $value Current value
	 * @param string $key Configuration key
	 * @return string
	 */
	public function select_poll_visibility($value, $key)
	{
		return $this->select_options([
			poll_options::VISIBILITY_PUBLIC         => 'AP_VISIBILITY_PUBLIC',
			poll_options::VISIBILITY_DEFAULT        => 'AP_VISIBILITY_DEFAULT',
			poll_options::VISIBILITY_VOTE_COMPLETED => 'AP_VISIBILITY_VOTE_COMPLETED',
			poll_options::VISIBILITY_PRIVATE        => 'AP_VISIBILITY_PRIVATE',
		], $value);
	}

	/**
	 * Build the default vote mode selector.
	 *
	 * @param int    $value Current value
	 * @param string $key Configuration key
	 * @return string
	 */
	public function select_poll_vote_mode($value, $key)
	{
		return $this->select_options([
			poll_options::VOTE_MODE_NO_CHANGE   => 'AP_VOTE_MODE_NO_CHANGE',
			poll_options::VOTE_MODE_INCREMENTAL => 'AP_VOTE_MODE_INCREMENTAL',
			poll_options::VOTE_MODE_CHANGE      => 'AP_VOTE_MODE_CHANGE',
		], $value);
	}

	/**
	 * Build the default scoring result selector.
	 *
	 * @param int    $value Current value
	 * @param string $key Configuration key
	 * @return string
	 */
	public function select_score_result($value, $key)
	{
		return $this->select_options([
			poll_options::SCORE_RESULT_TOTAL   => 'AP_SCORE_RESULT_TOTAL',
			poll_options::SCORE_RESULT_AVERAGE => 'AP_SCORE_RESULT_AVERAGE',
		], $value);
	}

	/**
	 * Build the poll-directory tab-order selector.
	 *
	 * The first tab in each option is also the default directory filter.
	 *
	 * @param string $value Current order
	 * @param string $key Configuration key
	 * @return string
	 */
	public function select_poll_list_order($value, $key)
	{
		$language_keys = array(
			poll_list_order::FILTER_ALL => 'AP_POLL_LIST_ALL',
			poll_list_order::FILTER_OPEN => 'AP_POLL_LIST_OPEN',
			poll_list_order::FILTER_CLOSED => 'AP_POLL_LIST_CLOSED',
		);
		$selected = poll_list_order::serialise($value);
		$html = '';
		foreach (poll_list_order::supported_orders() as $order)
		{
			$serialised = implode(',', $order);
			$labels = array();
			foreach ($order as $filter)
			{
				$labels[] = $this->user->lang[$language_keys[$filter]];
			}
			$html .= '<option value="' . htmlspecialchars($serialised, ENT_COMPAT, 'UTF-8') . '"'
				. ($serialised === $selected ? ' selected="selected"' : '') . '>'
				. htmlspecialchars(implode(' > ', $labels), ENT_COMPAT, 'UTF-8') . '</option>';
		}

		return $html;
	}

	/**
	 * Build selector option markup from trusted language keys.
	 *
	 * @param array $options Value => language key
	 * @param int   $selected Selected value
	 * @return string
	 */
	protected function select_options(array $options, $selected)
	{
		$html = '';
		foreach ($options as $value => $language_key)
		{
			$html .= '<option value="' . (int) $value . '"' . ((int) $selected === (int) $value ? ' selected="selected"' : '') . '>'
				. htmlspecialchars($this->user->lang[$language_key], ENT_COMPAT, 'UTF-8') . '</option>';
		}
		return $html;
	}
	/**
	 * Abstracted method to do the submit part of the acp. Checks values, saves them
	 * and displays the message.
	 * If error happens, Error is shown and config not saved. (so this method quits and returns false.
	 *
	 * @param array $display_vars The display vars for this acp site
	 * @param array $special_functions Assoziative Array with config values where special functions should run on submit instead of simply save the config value. Array should contain 'config_value' => function ($this) { function code here }, or 'config_value' => null if no function should run.
	 * @return bool Submit valid or not.
	 */
	protected function do_submit_stuff($display_vars, $special_functions = [])
	{
		$this->new_config = $this->config;
		$cfg_array = ($this->request->is_set('config')) ? $this->request->variable('config', ['' => '']) : $this->new_config;
		$error = isset($error) ? $error : [];
		$order_key = 'wolfsblvt.advancedpolls.poll_list_order';
		if (isset($cfg_array[$order_key]))
		{
			$cfg_array[$order_key] = poll_list_order::serialise($cfg_array[$order_key]);
		}

		validate_config_vars($display_vars['vars'], $cfg_array, $error);

		if (!check_form_key($this->form_key))
		{
			$error[] = $this->user->lang['FORM_INVALID'];
		}

		// Do not write values if there is an error
		if (sizeof($error))
		{
			$submit = false;
			return false;
		}

		// We go through the display_vars to make sure no one is trying to set variables he/she is not allowed to...
		foreach ($display_vars['vars'] as $config_name => $null)
		{
			// We want to skip that, or run the function. (We do this before checking if there is a request value set for it,
			// cause maybe we want to run a function anyway, based on whatever. We can check stuff manually inside this function)
			if (is_array($special_functions) && array_key_exists($config_name, $special_functions))
			{
				$func = $special_functions[$config_name];
				if (isset($func) && is_callable($func))
				{
					$func();
				}

				continue;
			}

			if (!isset($cfg_array[$config_name]) || strpos($config_name, 'legend') !== false)
			{
				continue;
			}

			// Sets the config value
			$this->new_config[$config_name] = $cfg_array[$config_name];
			$this->config->set($config_name, $cfg_array[$config_name]);
		}

		return true;
	}

	/**
	 * Abstracted method to generate acp configuration pages out of a list of display vars, using
	 * the function build_cfg_template().
	 * Build configuration template for acp configuration pages
	 *
	 * @param array $display_vars The display vars for this acp site
	 */
	protected function generate_stuff_for_cfg_template($display_vars)
	{
		$this->new_config = $this->config;
		$cfg_array = ($this->request->is_set('config')) ? $this->request->variable('config', ['' => '']) : $this->new_config;
		$error = isset($error) ? $error : [];
		$order_key = 'wolfsblvt.advancedpolls.poll_list_order';
		if (isset($cfg_array[$order_key]))
		{
			$cfg_array[$order_key] = poll_list_order::serialise($cfg_array[$order_key]);
		}

		validate_config_vars($display_vars['vars'], $cfg_array, $error);

		foreach ($display_vars['vars'] as $config_key => $vars)
		{
			if (!is_array($vars) && strpos($config_key, 'legend') === false)
			{
				continue;
			}

			if (strpos($config_key, 'legend') !== false)
			{
				$this->template->assign_block_vars('options', [
					'S_LEGEND' => true,
					'LEGEND'   => (isset($this->user->lang[$vars])) ? $this->user->lang[$vars] : $vars]
				);

				continue;
			}

			$type = explode(':', $vars['type']);

			$l_explain = '';
			if ($vars['explain'] && isset($vars['lang_explain']))
			{
				$l_explain = (isset($this->user->lang[$vars['lang_explain']])) ? $this->user->lang[$vars['lang_explain']] : $vars['lang_explain'];
			}
			else if ($vars['explain'])
			{
				$l_explain = (isset($this->user->lang[$vars['lang'] . '_EXPLAIN'])) ? $this->user->lang[$vars['lang'] . '_EXPLAIN'] : '';
			}

			$content = build_cfg_template($type, $config_key, $this->new_config, $config_key, $vars);

			if (empty($content))
			{
				continue;
			}

			$this->template->assign_block_vars('options', [
				'KEY'           => $config_key,
				'TITLE'         => (isset($this->user->lang[$vars['lang']])) ? $this->user->lang[$vars['lang']] : $vars['lang'],
				'S_EXPLAIN'     => $vars['explain'],
				'TITLE_EXPLAIN' => $l_explain,
				'CONTENT'       => $content,
			]);
		}

		$this->template->assign_vars([
			'S_ERROR'   => (sizeof($error)) ? true : false,
			'ERROR_MSG' => implode('<br />', $error),

			'U_ACTION' => $this->u_action]
		);
	}
}
