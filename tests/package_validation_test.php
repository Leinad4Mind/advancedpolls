<?php
/**
 *
 * Advanced Polls tests
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace wolfsblvt\advancedpolls\tests;

use PHPUnit\Framework\TestCase;

class package_validation_test extends TestCase
{
	public function test_composer_runtime_contract_matches_compatibility_policy()
	{
		$composer = json_decode(file_get_contents($this->extension_root() . '/composer.json'), true);

		$this->assertSame(JSON_ERROR_NONE, json_last_error());
		$this->assertSame('phpbb-extension', $composer['type']);
		$this->assertSame('1.7.0', $composer['version']);
		$this->assertSame('>=7.1.3', $composer['require']['php']);
		$this->assertSame('>=3.3.0,<4.0.0@dev', $composer['extra']['soft-require']['phpbb/phpbb']);
		$this->assertSame('https://github.com/Leinad4Mind/advancedpolls', $composer['homepage']);
		$this->assertArrayNotHasKey('version-check', $composer['extra']);
		$this->assertFileExists($this->extension_root() . '/README.md');
		$this->assertFileExists($this->extension_root() . '/CHANGELOG.md');
	}

	public function test_services_register_listener_core_controller_cron_and_notification()
	{
		$services = file_get_contents($this->extension_root() . '/config/services.yml');
		$routing = file_get_contents($this->extension_root() . '/config/routing.yml');
		$parsed_services = \Symfony\Component\Yaml\Yaml::parse($services);
		$parsed_routing = \Symfony\Component\Yaml\Yaml::parse($routing);

		$this->assertArrayHasKey('wolfsblvt.advancedpolls.controller.infopoll', $parsed_services['services']);
		$this->assertArrayHasKey('wolfsblvt.advancedpolls.controller.multi_question', $parsed_services['services']);
		$this->assertArrayHasKey('wolfsblvt.advancedpolls.controller.poll_list', $parsed_services['services']);
		$this->assertArrayHasKey('wolfsblvt.advancedpolls.multi_question_manager', $parsed_services['services']);
		$this->assertArrayHasKey('wolfsblvt.advancedpolls.poll_option_appender', $parsed_services['services']);
		$this->assertArrayHasKey('wolfsblvt.advancedpolls.poll_status_manager', $parsed_services['services']);
		$this->assertArrayHasKey('wolfsblvt.advancedpolls.notification.type.optionsadded', $parsed_services['services']);
		$this->assertArrayHasKey('wolfsblvt_advancedpolls_infopoll', $parsed_routing);
		$this->assertArrayHasKey('wolfsblvt_advancedpolls_multi_question_vote', $parsed_routing);
		$this->assertArrayHasKey('wolfsblvt_advancedpolls_poll_list', $parsed_routing);
		$this->assertArrayHasKey('wolfsblvt_advancedpolls_poll_manage', $parsed_routing);
		$this->assertSame(array('POST'), $parsed_routing['wolfsblvt_advancedpolls_multi_question_vote']['methods']);
		$this->assertSame(array('POST'), $parsed_routing['wolfsblvt_advancedpolls_poll_manage']['methods']);
		$this->assertStringContainsString('wolfsblvt.advancedpolls.listener:', $services);
		$this->assertStringContainsString('wolfsblvt.advancedpolls.advancedpolls:', $services);
		$this->assertStringContainsString('wolfsblvt.advancedpolls.controller.infopoll:', $services);
		$this->assertStringContainsString('wolfsblvt.advancedpolls.vote_user_lifecycle:', $services);
		$this->assertStringContainsString("- '@controller.helper'", $services);
		$this->assertStringContainsString('wolfsblvt.advancedpolls.notification.type.pollended:', $services);
		$this->assertStringContainsString('wolfsblvt.advancedpolls.cron.task.pollend:', $services);
		$this->assertStringContainsString('{name: event.listener}', $services);
		$this->assertStringContainsString('{name: notification.type}', $services);
		$this->assertStringContainsString('{name: cron.task}', $services);
		$this->assertStringContainsString('wolfsblvt_advancedpolls_infopoll:', $routing);
		$this->assertStringContainsString('/advancedpolls/infopoll/{topic_id}', $routing);
		$this->assertStringContainsString('/advancedpolls/polls', $routing);
		$this->assertStringContainsString('methods: [GET]', $routing);
	}

	public function test_english_and_portuguese_have_all_new_feature_language_keys()
	{
		$catalogues = array('en', 'pt');
		$poll_keys = array(
			'AP_ABSTAINERS',
			'AP_DELETE_VOTE',
			'AP_VISIBILITY_PUBLIC',
			'AP_VISIBILITY_DEFAULT',
			'AP_VISIBILITY_VOTE_COMPLETED',
			'AP_VISIBILITY_PRIVATE',
			'AP_VOTE_MODE_NO_CHANGE',
			'AP_VOTE_MODE_INCREMENTAL',
			'AP_VOTE_MODE_CHANGE',
			'AP_SCORE_TOTAL',
			'AP_SCORE_POINTS_TOTAL',
			'AP_SCORE_AVERAGE',
			'AP_SCORE_RATINGS',
			'AP_SCORE_OVERALL_AVERAGE',
			'AP_SCORE_BREAKDOWN',
			'AP_SCORE_DISTRIBUTION_ENTRY',
			'AP_POLL_LIST',
			'AP_POLL_LIST_WINNER',
			'AP_POLL_MANAGE_SELECT',
			'AP_POLL_MANAGE_SELECT_ALL',
			'AP_POLL_MANAGE_CLOSE',
			'AP_POLL_MANAGE_OPEN',
			'AP_SCORE_RESULT',
			'AP_RANK_SELECT_EXACTLY',
			'AP_RANK_TOTAL',
			'AP_RANK_BREAKDOWN',
			'AP_RANK_DISTRIBUTION_ENTRY',
			'AP_POLL_TYPE',
			'AP_POLL_TYPE_RANKING',
			'AP_RANK_POINTS',
			'AP_RANK_SELECTION_INCOMPLETE',
			'AP_ADDITIONAL_QUESTIONS',
			'AP_REQUIRED_QUESTION_MISSING',
			'AP_POLL_MIN_VALUE',
			'AP_VOTE_OUTSIDE_RANGE',
			'AP_POLL_COLLAPSIBLE',
			'AP_COLLAPSE_POLL',
			'AP_EXPAND_POLL',
			'AP_APPEND_OPTIONS',
			'AP_APPEND_OPTIONS_WARNING',
			'AP_APPEND_REQUIRES_CHANGES',
			'AP_APPEND_STRUCTURE_CHANGED',
			'AP_POLL_START',
			'AP_POLL_START_EXPLAIN',
			'AP_POLL_START_INVALID',
		);
		$acp_keys = array(
			'AP_DEFAULT_POLL_VISIBILITY',
			'AP_DEFAULT_POLL_VOTE_MODE',
			'AP_ACT_SHOW_ABSTAINERS',
			'AP_ACT_VOTE_DELETE',
			'AP_ACT_POLL_NOTIFICATIONS',
			'AP_ACT_POLL_COLLAPSIBLE',
			'AP_ENABLE_NOTICE',
			'AP_DEFAULT_SCORE_RESULT',
			'AP_DEFAULT_SHOW_PERCENT',
			'AP_SHOW_POLL_LIST_NAVBAR',
			'AP_ACT_POLL_START',
		);

		foreach ($catalogues as $catalogue)
		{
			$poll = $this->load_language($catalogue . '/advancedpolls.php');
			$acp = $this->load_language($catalogue . '/info_acp_advancedpolls.php');
			$common = $this->load_language($catalogue . '/advancedpolls_common.php');
			foreach ($poll_keys as $key)
			{
				$this->assertArrayHasKey($key, $poll, $catalogue . ': ' . $key);
			}
			foreach ($acp_keys as $key)
			{
				$this->assertArrayHasKey($key, $acp, $catalogue . ': ' . $key);
			}
			$this->assertArrayHasKey('NOTIFICATION_AP_POLL_ENDED', $common);
			$this->assertArrayHasKey('NOTIFICATION_TYPE_AP_POLL_ENDED', $common);
			$this->assertArrayHasKey('NOTIFICATION_AP_POLL_OPTIONS_ADDED', $common);
			$this->assertArrayHasKey('NOTIFICATION_TYPE_AP_POLL_OPTIONS_ADDED', $common);
			$this->assertArrayHasKey('LOG_AP_POLL_OPTIONS_ADDED', $common);
		}
	}

	public function test_poll_list_result_labels_use_simple_hyphen_separator()
	{
		$files = glob($this->extension_root() . '/language/*/advancedpolls.php');

		foreach ($files as $file)
		{
			$catalogue = basename(dirname($file));
			$poll = $this->load_language($catalogue . '/advancedpolls.php');

			foreach (array('AP_POLL_LIST_LEADING', 'AP_POLL_LIST_WINNER') as $key)
			{
				$this->assertArrayHasKey($key, $poll, $catalogue . ': ' . $key);
				$this->assertStringContainsString('%1$s - %2$s', $poll[$key], $catalogue . ': ' . $key);
				$this->assertStringNotContainsString('—', $poll[$key], $catalogue . ': ' . $key);
			}
		}
	}

	public function test_phpbb_poll_title_limit_is_100_characters()
	{
		$phpbb_root = getenv('PHPBB_ROOT_PATH');
		$phpbb_root = $phpbb_root ? rtrim($phpbb_root, '/\\') : dirname($this->extension_root(), 3);
		$parser = file_get_contents($phpbb_root . '/includes/message_parser.php');

		$this->assertMatchesRegularExpression(
			"/utf8_strlen\\(preg_replace\\([^\\r\\n]+\\)\\) > 100\\)/",
			$parser
		);
	}

	public function test_all_three_themes_expose_each_interactive_feature_safely()
	{
		$styles = array('prosilver', 'FLATBOOTS', 'BBOOTS');
		$required = array(
			'template/event/overall_header_head_append.html',
			'template/event/posting_editor_subject_before.html',
			'template/event/posting_poll_body_options_after.html',
			'template/event/viewtopic_body_poll_option_after.html',
			'template/event/viewtopic_body_poll_after.html',
			'template/event/viewtopic_body_poll_question_append.html',
			'template/js/functions.js',
			'template/js/onload.js',
			'template/js/poll_length_posting.js',
			'template/js/poll_start_posting.js',
			'template/js/poll_length_reposition.js',
			'template/js/scoring_preview.js',
			'template/js/scoring_topic.js',
			'template/js/poll_type_posting.js',
			'template/js/multi_question_posting.js',
			'template/js/multi_question_vote.js',
			'template/js/poll_collapsible.js',
			'template/js/poll_manage.js',
			'template/lib/jxtools.js',
			'theme/advancedpolls.css',
		);

		foreach ($styles as $style)
		{
			$root = $this->extension_root() . '/styles/' . $style . '/';
			foreach ($required as $file)
			{
				$this->assertFileExists($root . $file, $style . ': ' . $file);
			}

			$navigation_event = $style === 'FLATBOOTS'
				? 'template/event/overall_header_navigation_new.html'
				: 'template/event/overall_header_navigation_append.html';
			$navigation = file_get_contents($root . $navigation_event);
			$head = file_get_contents($root . 'template/event/overall_header_head_append.html');
			$this->assertStringContainsString('S_AP_POLL_LIST_NAVBAR', $navigation);
			$this->assertStringContainsString('href="{U_AP_POLL_LIST}"', $navigation);
			$this->assertStringContainsString('{L_AP_POLL_LIST}', $navigation);
			$this->assertStringContainsString('S_AP_POLL_LIST_PAGE', $head);
			if ($style === 'FLATBOOTS')
			{
				$this->assertStringContainsString('navbar-nav-fancy', $navigation);
				$this->assertFileDoesNotExist($root . 'template/event/overall_header_navigation_append.html');
			}

			$poll_list_template = file_get_contents($root . 'template/advancedpolls_poll_list.html');
			$poll_list_theme = file_get_contents($root . 'theme/advancedpolls.css');
			$poll_manage_js = file_get_contents($root . 'template/js/poll_manage.js');
			$this->assertStringContainsString('S_AP_CAN_MANAGE', $poll_list_template);
			$this->assertStringContainsString('poll.S_CAN_MANAGE', $poll_list_template);
			$this->assertStringContainsString('name="poll_ids[]"', $poll_list_template);
			$this->assertStringContainsString('name="manage_action"', $poll_list_template);
			$this->assertStringContainsString('{S_FORM_TOKEN}', $poll_list_template);
			$this->assertSame(2, substr_count($poll_list_template, 'data-ap-select-all'));
			$this->assertSame(2, substr_count($poll_list_template, 'ap-poll-filter-buttons'));
			$this->assertSame(1, substr_count($poll_list_template, 'ap-poll-manage-bar-bottom'));
			$this->assertSame(1, substr_count($poll_list_template, 'id="ap-poll-manage-form"'));
			$this->assertSame(2, substr_count($poll_list_template, 'form="ap-poll-manage-form" data-ap-bulk-action'));
			$this->assertMatchesRegularExpression(
				'/ap-poll-manage-bar-bottom[\s\S]*(?:action-bar bar-bottom|ap-poll-list-pagination)/',
				$poll_list_template
			);
			$this->assertStringContainsString('@wolfsblvt_advancedpolls/js/poll_manage.js', $poll_list_template);
			$this->assertStringContainsString("querySelectorAll('[data-ap-select-all]')", $poll_manage_js);
			$this->assertStringContainsString('selectAllControls.forEach', $poll_manage_js);
			$this->assertStringContainsString("typeof window.jQuery.fn.iCheck !== 'function'", $poll_manage_js);
			$this->assertStringContainsString('$input.data(\'iCheck\')', $poll_manage_js);
			$this->assertStringContainsString(".on('ifChanged.apPollManage'", $poll_manage_js);
			$this->assertStringContainsString('window.head.ready(bindICheckEvents)', $poll_manage_js);
			$this->assertStringContainsString("checked ? 'check' : 'uncheck'", $poll_manage_js);
			$this->assertStringContainsString('ap-poll-filter-buttons', $poll_list_template);
			$this->assertStringContainsString('class="ap-poll-manage-controls"', $poll_list_template);
			$this->assertMatchesRegularExpression(
				'/ap-poll-filter-buttons[\s\S]*<!-- IF S_AP_CAN_MANAGE -->[\s\S]*ap-poll-manage-controls[\s\S]*data-ap-select-all[\s\S]*value="close"[\s\S]*value="open"/',
				$poll_list_template
			);
			$this->assertStringContainsString('poll.S_ROW_COUNT is odd', $poll_list_template);
			$this->assertStringContainsString('ap-poll-state-closed', $poll_list_template);
			$this->assertStringContainsString('ap-poll-state-open', $poll_list_template);
			$this->assertStringContainsString('ap-poll-select-corner', $poll_list_template);
			$this->assertStringContainsString('aria-label="{L_AP_POLL_MANAGE_SELECT}"', $poll_list_template);
			$this->assertStringContainsString('<span class="sr-only">{L_AP_POLL_MANAGE_SELECT}</span>', $poll_list_template);
			$this->assertStringNotContainsString('data-ap-poll-select> {L_AP_POLL_MANAGE_SELECT}', $poll_list_template);
			$this->assertStringContainsString('.ap-poll-list-item.ap-poll-row-odd', $poll_list_theme);
			$this->assertStringContainsString('border-inline-start-color: #6f8975;', $poll_list_theme);
			$this->assertStringContainsString('border-inline-start-color: #96716f;', $poll_list_theme);
			$this->assertStringContainsString(
				$style === 'prosilver'
					? 'background-color: #ECF3F7;'
					: ($style === 'FLATBOOTS' ? 'background-color: #f8fafb;' : 'background-color: #fff;'),
				$poll_list_theme
			);
			$this->assertStringContainsString(
				$style === 'prosilver'
					? 'background-color: #E1EBF2;'
					: ($style === 'FLATBOOTS' ? 'background-color: #eef2f4;' : 'background-color: #fafafa;'),
				$poll_list_theme
			);
			$this->assertStringContainsString('.ap-poll-select-corner', $poll_list_theme);
			$this->assertStringContainsString(
				$style === 'prosilver'
					? 'inset-block-start: 0;'
					: ($style === 'FLATBOOTS' ? 'inset-block-start: 15px;' : 'inset-block-start: 3px;'),
				$poll_list_theme
			);
			$this->assertStringContainsString('.ap-poll-filter-buttons', $poll_list_theme);
			$this->assertStringContainsString('.ap-poll-manage-controls', $poll_list_theme);
			$this->assertStringContainsString('margin-inline-start: auto;', $poll_list_theme);
			if ($style === 'FLATBOOTS')
			{
				$this->assertStringContainsString('border-bottom-color: #d6d9e0;', $poll_list_theme);
			}
			if ($style === 'prosilver')
			{
				$this->assertStringContainsString('<h2 class="solo"><a href="{U_AP_POLL_LIST_ALL}">{L_AP_POLL_LIST}</a></h2>', $poll_list_template);
			}
			if ($style !== 'prosilver')
			{
				$this->assertStringContainsString(
					$style === 'FLATBOOTS'
						? '<div class="panel panel-forum ap-poll-list-shell">'
						: '<div class="panel panel-default ap-poll-list-shell">',
					$poll_list_template
				);
				$this->assertStringContainsString('<div class="panel-heading ap-poll-list-heading">', $poll_list_template);
				$this->assertStringContainsString('<div class="ap-poll-list-content">', $poll_list_template);
				$this->assertStringContainsString('<div class="ap-poll-list-toolbar-top<!-- IF S_AP_CAN_MANAGE --> ap-poll-list-toolbar-top-separated<!-- ENDIF -->">', $poll_list_template);
				$this->assertStringContainsString('<div class="ap-poll-list-toolbar-bottom<!-- IF S_AP_CAN_MANAGE --> ap-poll-list-toolbar-bottom-separated<!-- ENDIF -->">', $poll_list_template);
				$this->assertStringContainsString('<h2 class="panel-title">{L_AP_POLL_LIST}</h2>', $poll_list_template);
				$this->assertStringNotContainsString('<div class="panel-body clearfix">', $poll_list_template);
				$this->assertStringNotContainsString('<div class="side-segment"><h3>{L_AP_POLL_LIST}</h3></div>', $poll_list_template);
				$this->assertStringContainsString('.ap-poll-list-heading .panel-title', $poll_list_theme);
				$this->assertStringContainsString('.ap-poll-manage-controls > label', $poll_list_theme);
				$this->assertStringContainsString('color: #fff;', $poll_list_theme);
				$this->assertStringContainsString('text-align: left;', $poll_list_theme);
				$this->assertMatchesRegularExpression('/\.ap-poll-list-heading\s*\{[^}]*align-items:\s*center;[^}]*display:\s*flex;[^}]*justify-content:\s*space-between;/s', $poll_list_theme);
				$this->assertMatchesRegularExpression('/\.ap-poll-list-content\s*\{[^}]*background-color:\s*#fff;[^}]*padding:\s*15px;/s', $poll_list_theme);
				$this->assertMatchesRegularExpression('/\.ap-poll-list-toolbar-top,\s*\.ap-poll-list-toolbar-bottom\s*\{[^}]*align-items:\s*center;[^}]*display:\s*flex;[^}]*justify-content:\s*space-between;[^}]*width:\s*100%;/s', $poll_list_theme);
				$divider_color = $style === 'FLATBOOTS' ? 'rgba(0, 0, 0, .05)' : '#dde1e7';
				$this->assertStringContainsString('border-bottom: 1px solid ' . $divider_color . ';', $poll_list_theme);
				$this->assertStringContainsString('border-top: 1px solid ' . $divider_color . ';', $poll_list_theme);
				$this->assertStringContainsString('border-bottom: 0;', $poll_list_theme);
				$this->assertStringContainsString('box-shadow: none;', $poll_list_theme);
				$this->assertStringNotContainsString('.ap-poll-list-toolbar-right', $poll_list_theme);
				$this->assertStringContainsString('.ap-poll-list-toolbar-top .ap-poll-list-pagination', $poll_list_theme);
				$this->assertStringContainsString('.ap-poll-list-toolbar-bottom .ap-poll-list-pagination', $poll_list_theme);
				$this->assertStringContainsString('margin-bottom: 10px;', $poll_list_theme);
				$this->assertStringContainsString('<ul class="pagination pagination-sm ap-poll-list-pagination">', $poll_list_template);
				$this->assertStringContainsString('<li class="active"><a>{AP_POLL_COUNT}</a></li>', $poll_list_template);
				$this->assertStringNotContainsString('ap-poll-list-pagination pull-right', $poll_list_template);
				$heading_start = strpos($poll_list_template, '<div class="panel-heading ap-poll-list-heading">');
				$heading_end = strpos($poll_list_template, '</div>', $heading_start);
				$this->assertNotFalse($heading_start);
				$this->assertNotFalse($heading_end);
				$this->assertStringNotContainsString('ap-poll-list-pagination', substr($poll_list_template, $heading_start, $heading_end - $heading_start));
				$toolbar_start = strpos($poll_list_template, '<div class="ap-poll-list-toolbar-top');
				$filter_position = strpos($poll_list_template, 'ap-poll-filter-buttons', $toolbar_start);
				$pagination_position = strpos($poll_list_template, 'ap-poll-list-pagination', $toolbar_start);
				$manage_position = strpos($poll_list_template, 'ap-poll-manage-controls', $toolbar_start);
				$this->assertTrue($filter_position < $pagination_position);
				$this->assertTrue($pagination_position < $manage_position);
				$bottom_bar_start = strpos($poll_list_template, 'ap-poll-manage-bar-bottom');
				$bottom_manage_position = strpos($poll_list_template, 'ap-poll-manage-controls', $bottom_bar_start);
				$bottom_toolbar_position = strpos($poll_list_template, 'ap-poll-list-toolbar-bottom', $bottom_bar_start);
				$bottom_filter_position = strpos($poll_list_template, 'ap-poll-filter-buttons', $bottom_toolbar_position);
				$bottom_pagination_position = strpos($poll_list_template, 'ap-poll-list-pagination', $bottom_toolbar_position);
				$this->assertTrue($bottom_manage_position < $bottom_toolbar_position);
				$this->assertTrue($bottom_filter_position < $bottom_pagination_position);
			}

			$posting = file_get_contents($root . 'template/event/posting_poll_body_options_after.html');
			$this->assertStringContainsString('name="wolfsblvt_poll_visibility"', $posting);
			$this->assertStringContainsString('{AP_POLL_VISIBILITY_OPTIONS}', $posting);
			$this->assertStringContainsString('name="wolfsblvt_poll_vote_mode"', $posting);
			$this->assertStringContainsString('{AP_POLL_VOTE_MODE_OPTIONS}', $posting);
			$this->assertStringContainsString('name="wolfsblvt_poll_type"', $posting);
			$this->assertStringContainsString('{AP_POLL_TYPE_OPTIONS}', $posting);
			$this->assertStringContainsString('{AP_RANK_POINT_INPUTS}', $posting);
			$this->assertStringContainsString('name="wolfsblvt_poll_min_value"', $posting);
			$this->assertStringContainsString('name="wolfsblvt_poll_required"', $posting);
			$this->assertStringContainsString('WOLFSBLVT_POLL_COLLAPSIBLE', $posting);
			$this->assertStringContainsString('name="wolfsblvt_poll_collapsible"', $posting);
			$this->assertStringContainsString('name="ap_multi_questions"', $posting);
			$this->assertStringContainsString('name="ap_append_poll_options"', $posting);
			$this->assertStringContainsString('AP_CAN_APPEND_OPTIONS', $posting);
			$this->assertStringContainsString('WOLFSBLVT_POLL_START', $posting);
			$this->assertStringContainsString('name="wolfsblvt_poll_start"', $posting);
			$this->assertStringContainsString('{WOLFSBLVT_POLL_START_VALUE}', $posting);
			$this->assertStringContainsString('js/poll_start_posting.js', $posting);
			$multi_posting = file_get_contents($root . 'template/js/multi_question_posting.js');
			if ($style === 'prosilver')
			{
				$this->assertStringContainsString('type="button" class="button2 ap-add-question"', $posting);
				$this->assertStringNotContainsString('<button type="button" class="button2 ap-add-question">', $posting);
			}
			else
			{
				$theme = file_get_contents($root . 'theme/advancedpolls.css');
				$this->assertStringContainsString("var optionsId = 'ap_question_options_' + index;", $multi_posting);
				$this->assertStringContainsString("class=\"control-label\" for=\"' + optionsId + '\"", $multi_posting);
				$this->assertStringContainsString("id=\"' + optionsId + '\" class=\"form-control ap-question-options\"", $multi_posting);
				$this->assertStringNotContainsString('ap-question-options-label', $multi_posting);
				$this->assertMatchesRegularExpression('/\.ap-question-card \.ap-question-text,\s*\.ap-question-card \.ap-question-options\s*\{[^}]*width:\s*100%;/s', $theme);
				$this->assertStringContainsString('<div class="ap-question-actions">', $multi_posting);
				$this->assertStringContainsString('<div class="ap-question-required-control">', $multi_posting);
				$this->assertMatchesRegularExpression('/\.ap-question-actions\s*\{[^}]*display:\s*flex;[^}]*align-items:\s*center;[^}]*justify-content:\s*space-between;/s', $theme);
				$this->assertMatchesRegularExpression('/\.ap-question-required-control\s*\{[^}]*display:\s*flex;[^}]*align-items:\s*center;/s', $theme);
				$this->assertStringNotContainsString('margin-left: auto;', $theme);

				$checkbox_ids = array(
					'wolfsblvt_poll_show_percent',
					'wolfsblvt_poll_voters_limit',
					'wolfsblvt_poll_voters_show',
					'wolfsblvt_poll_show_ordered',
					'wolfsblvt_poll_collapsible',
					'wolfsblvt_poll_required',
					'ap_append_poll_options',
				);
				foreach ($checkbox_ids as $checkbox_id)
				{
					$this->assertStringContainsString('<label class="checkbox-inline" for="' . $checkbox_id . '">', $posting);
				}
				$this->assertStringContainsString("var requiredId = 'ap_question_required_' + index;", $multi_posting);
				$this->assertStringContainsString("id=\"' + requiredId + '\" class=\"ap-question-required\"", $multi_posting);
				$this->assertStringContainsString("class=\"checkbox-inline\" for=\"' + requiredId + '\"", $multi_posting);
				$this->assertStringContainsString('head.ready(function () {', $multi_posting);
				$checkbox_class = $style === 'FLATBOOTS' ? 'icheckbox_flat-aero' : 'icheckbox_minimal-grey';
				$this->assertStringContainsString("checkboxClass: '" . $checkbox_class . "'", $multi_posting);
			}

			if ($style !== 'prosilver')
			{
				$this->assertSame(6, substr_count($posting, 'class="selectpicker"'));
				$this->assertSame(6, substr_count($posting, 'data-container="body" data-width="auto" data-style="btn btn-default form-control"'));
				$this->assertStringContainsString('id="wolfsblvt_poll_score_result" name="wolfsblvt_poll_score_result" class="selectpicker"', $posting);
				$this->assertStringNotContainsString('ap-config-select', $posting);
				$this->assertStringNotContainsString('name="wolfsblvt_poll_score_result" class="form-control input-sm"', $posting);
				$this->assertStringNotContainsString('ap-config-select', $theme);
			}

			$option = file_get_contents($root . 'template/event/viewtopic_body_poll_option_after.html');
			$this->assertStringContainsString('AP_CAN_DELETE_VOTE', $option);
			$this->assertStringContainsString('AP_DELETE_VOTE', $option);
			$this->assertStringContainsString('AP_SCORE_BREAKDOWN', $option);
			$this->assertStringContainsString('aria-expanded="false"', $option);
			$this->assertStringContainsString('class="ap-rank-choice"', $option);
			$this->assertStringContainsString('data-current-value=', $option);
			if ($style !== 'prosilver')
			{
				$this->assertStringContainsString('form-control input-sm ap-score-select', $option);
			}

			$info_file = $style === 'prosilver'
				? 'template/event/viewtopic_body_poll_question_prepend.html'
				: 'template/event/viewtopic_topic_tools_before.html';
			$info = file_get_contents($root . $info_file);
			$this->assertStringContainsString('class="', $info);
			$this->assertStringContainsString('ap-infopoll-button', $info);
			$this->assertStringContainsString('data-infopoll-url="{U_AP_POLL_INFO_AJAX}"', $info);

			$onload = file_get_contents($root . 'template/js/onload.js');
			$this->assertStringContainsString('res.results_hidden', $onload);
			$this->assertMatchesRegularExpression('/no_vote:\s*true/', $onload);
			$this->assertMatchesRegularExpression('/delete_vote:\s*true/', $onload);
			$this->assertSame(2, substr_count($onload, 'form_token:'));
			$this->assertStringContainsString('installScoreBreakdowns', $onload);
			$this->assertStringContainsString('res.score_breakdowns', $onload);
			$this->assertStringContainsString("$('.topic_poll [data-poll-option-id=\"' + optionId + '\"]').first()", $onload);
			$this->assertStringContainsString("\$option.find('.progress-bar').first().empty()", $onload);
			$this->assertStringNotContainsString("\$source.closest('dl[data-poll-option-id]')", $onload);
			$this->assertStringContainsString("$(document).on('click', '.ap-infopoll-button'", $onload);
			$this->assertStringContainsString("type: 'GET'", $onload);
			$this->assertStringContainsString('phpbb.alert(', $onload);
			$this->assertStringContainsString('event.preventDefault()', $onload);
			$this->assertStringContainsString('installRanking', $onload);
			$this->assertStringContainsString("'vote_id[' + optionId + ']'", $onload);

			$date = file_get_contents($root . 'template/js/poll_length_posting.js');
			$start_date = file_get_contents($root . 'template/js/poll_start_posting.js');
			$this->assertStringContainsString('type="datetime-local" id="wolfsblvt_poll_end_datetime"', $posting);
			$this->assertStringContainsString('step="60"', $posting);
			$this->assertStringContainsString('onfocus="apRefreshPollEndMinimum();"', $posting);
			$this->assertStringContainsString('type="hidden" id="wolfsblvt_poll_end_year"', $posting);
			$this->assertStringNotContainsString('type="number" onchange="apAdjustEnd(', $posting);
			$this->assertStringContainsString('apPollEnd.getHours()).slice(-2)', $date);
			$this->assertStringContainsString('apPollEnd.getMinutes()).slice(-2)', $date);
			$this->assertStringContainsString('function apAdjustEndDateTime(val)', $date);
			$this->assertStringContainsString('input.min = apDateTimeValue(minimum)', $date);
			$this->assertStringContainsString('new Date(apPollStart.getTime())', $date);
			$this->assertStringContainsString('function apSelectedPollStart()', $date);
			$this->assertStringContainsString('function apPollScheduleChanged()', $date);
			$this->assertStringContainsString("document.getElementById('wolfsblvt_poll_start')", $date);
			$this->assertStringContainsString('function apRefreshPollStartMinimum()', $start_date);
			$this->assertStringContainsString('function apAdjustStartDateTime(value)', $start_date);
			$this->assertStringContainsString("typeof apPollScheduleChanged === 'function'", $start_date);

			$multi_template = file_get_contents($root . 'template/event/viewtopic_body_poll_after.html');
			$this->assertStringContainsString('data-vote-url="{AP_MULTI_VOTE_URL}"', $multi_template);
			$this->assertStringContainsString('ap-poll-previous', $multi_template);
			$this->assertStringContainsString('ap-poll-next', $multi_template);
			$multi_vote = file_get_contents($root . 'template/js/multi_question_vote.js');
			$this->assertStringContainsString("method: 'POST'", $multi_vote);
			$this->assertStringContainsString('JSON.stringify(collectBallot())', $multi_vote);
			$this->assertStringContainsString('updateBreakdowns', $multi_vote);
			$this->assertStringContainsString('updateVoters', $multi_vote);
			$this->assertStringContainsString("removeAttr('data-ajax').off('submit')", $multi_vote);
			$this->assertStringNotContainsString('window.location.reload', $multi_vote);

			$collapse_template = file_get_contents($root . 'template/event/viewtopic_body_poll_question_append.html');
			$this->assertStringContainsString('AP_POLL_COLLAPSIBLE', $collapse_template);
			$this->assertStringContainsString('aria-expanded="true"', $collapse_template);
			$this->assertStringContainsString('data-topic-id="{AP_POLL_TOPIC_ID}"', $collapse_template);
			$collapse = file_get_contents($root . 'template/js/poll_collapsible.js');
			$this->assertStringContainsString('window.localStorage', $collapse);
			$this->assertStringContainsString("window.jQuery(document).on('ajaxComplete', initialise)", $collapse);
			$this->assertStringContainsString("document.getElementById('ap-multi-poll')", $collapse);
		}
	}

	public function test_security_regressions_and_excluded_ordering_feature_stay_enforced()
	{
		$core = file_get_contents($this->extension_root() . '/core/advancedpolls.php');
		$notification = file_get_contents($this->extension_root() . '/notification/pollended.php');
		$schema = file_get_contents($this->extension_root() . '/migrations/v1_4_0_schema.php');
		$infopoll = file_get_contents($this->extension_root() . '/controller/infopoll.php');
		$lifecycle = file_get_contents($this->extension_root() . '/core/vote_user_lifecycle.php');
		$listener = file_get_contents($this->extension_root() . '/event/listener.php');
		$multi_controller = file_get_contents($this->extension_root() . '/controller/multi_question.php');
		$appender = file_get_contents($this->extension_root() . '/core/poll_option_appender.php');
		$options_notification = file_get_contents($this->extension_root() . '/notification/optionsadded.php');
		$poll_list = file_get_contents($this->extension_root() . '/controller/poll_list.php');
		$poll_manager = file_get_contents($this->extension_root() . '/core/poll_status_manager.php');

		$this->assertStringContainsString("is_set_post('delete_vote')", $core);
		$this->assertStringContainsString("check_form_key('posting')", $core);
		$this->assertStringContainsString("sql_transaction('rollback')", $core);
		$this->assertStringContainsString("is_set_post('no_vote')", $core);
		$this->assertStringContainsString('vote_user_id <> ' . "' . ANONYMOUS", $notification);
		$this->assertStringContainsString("acl_get('f_read'", $infopoll);
		$this->assertStringContainsString("acl_get('m_seevoters'", $infopoll);
		$this->assertStringContainsString('is_ajax()', $infopoll);
		$this->assertStringContainsString("'Cache-Control', 'private, no-store'", $infopoll);
		$this->assertStringContainsString('LEFT JOIN ' . "' . USERS_TABLE", $infopoll);
		$this->assertStringContainsString('$mode === \'retain\'', $lifecycle);
		$this->assertStringContainsString('$mode === \'remove\'', $lifecycle);
		$this->assertStringContainsString('SUM(wolfsblvt_poll_option_value)', $lifecycle);
		$this->assertStringContainsString("htmlspecialchars(\$json ?: '[]', ENT_COMPAT, 'UTF-8')", $listener);
		$this->assertStringContainsString("htmlspecialchars(censor_text(\$question['text']), ENT_QUOTES, 'UTF-8')", $listener);
		$this->assertSame(2, substr_count($listener, "raw_variable('ap_multi_questions'"));
		$this->assertStringContainsString("raw_variable('answers'", $multi_controller);
		$this->assertStringContainsString('AP_POLL_COLLAPSIBLE', $core);
		$this->assertStringContainsString('activate_poll_collapsible', $core);
		$this->assertStringContainsString('get_authorised_recipients($users', $options_notification);
		$this->assertStringContainsString("vote_user_id <> ' . ANONYMOUS", $options_notification);
		$this->assertStringContainsString("sql_transaction('rollback')", $appender);
		$this->assertStringContainsString('poll_options::VOTE_MODE_CHANGE', $appender);
		$this->assertStringContainsString("'poll_option_total' => 0", $appender);
		$this->assertStringContainsString("'option_total' => 0", $appender);
		$this->assertStringContainsString("acl_getf('f_read', true)", $poll_list);
		$this->assertStringContainsString('t.topic_visibility = ' . "' . ITEM_APPROVED", $poll_list);
		$this->assertStringContainsString("f.forum_password = ''", $poll_list);
		$this->assertStringContainsString('t.wolfsblvt_poll_scheduled_start = 0 OR t.wolfsblvt_poll_scheduled_start <= ', $poll_list);
		$this->assertStringContainsString("'TOPIC_TITLE' => censor_text(\$topic['topic_title'])", $poll_list);
		$this->assertStringContainsString("'FORUM_NAME' => censor_text(\$topic['forum_name'])", $poll_list);
		$this->assertStringNotContainsString("htmlspecialchars(censor_text(\$topic['topic_title'])", $poll_list);
		$this->assertStringNotContainsString("htmlspecialchars(censor_text(\$topic['forum_name'])", $poll_list);
		$this->assertStringContainsString('t.wolfsblvt_poll_vote_mode', $poll_list);
		$this->assertStringContainsString('COUNT(*) AS vote_count', $poll_list);
		$this->assertStringContainsString("AND vote_user_id = ' . (int) \$this->user->data['user_id']", $poll_list);
		$this->assertStringContainsString('poll_options::results_are_hidden(', $poll_list);
		$this->assertStringContainsString('poll_options::VOTE_MODE_INCREMENTAL', $poll_list);
		$this->assertStringContainsString('!empty($manageable[$topic_id])', $poll_list);
		$this->assertStringContainsString("\$ended ? 'AP_POLL_LIST_WINNER' : 'AP_POLL_LIST_LEADING'", $poll_list);
		$this->assertStringContainsString("check_form_key('advancedpolls_manage')", $poll_list);
		$this->assertStringContainsString("'S_AP_POLL_LIST_PAGE' => true", $poll_list);
		$this->assertStringContainsString(
			"route('wolfsblvt_advancedpolls_poll_list', \$params, false)",
			$poll_list
		);
		$this->assertStringNotContainsString(
			"route('wolfsblvt_advancedpolls_poll_list', \$params))",
			$poll_list
		);
		$this->assertStringContainsString("acl_get('m_lock'", $poll_manager);
		$this->assertStringContainsString("acl_get('f_read'", $poll_manager);
		$this->assertStringContainsString(
			"sprintf('%d %s', \$total, \$this->user->lang['AP_POLL_LIST'])",
			$poll_list
		);
		$this->assertStringNotContainsString('order_items', $schema);
		$this->assertStringNotContainsString('purchase', strtolower($schema));
	}

	public function test_removed_ap_copyright_key_does_not_return()
	{
		$removed_key = 'AP_' . 'COPYRIGHT';
		$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->extension_root()));
		foreach ($iterator as $file)
		{
			if (!$file->isFile())
			{
				continue;
			}
			$this->assertStringNotContainsString($removed_key, file_get_contents($file->getPathname()), $file->getPathname());
		}
	}

	private function load_language($relative_file)
	{
		$file = $this->extension_root() . '/language/' . $relative_file;
		return (static function ($file) {
			$lang = array();
			include $file;
			return $lang;
		})($file);
	}

	private function extension_root()
	{
		return dirname(__DIR__);
	}
}
