<?php
/**
 * Advanced Polls tests
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace wolfsblvt\advancedpolls\tests;

use PHPUnit\Framework\TestCase;

class acp_cleanup_contract_test extends TestCase
{
	public function test_cleanup_mode_is_permission_protected_and_installed()
	{
		$root = dirname(__DIR__);
		$info = file_get_contents($root . '/acp/advancedpolls_info.php');
		$migration = file_get_contents($root . '/migrations/v1_7_2_data.php');

		$this->assertStringContainsString("'cleanup' =>", $info);
		$this->assertStringContainsString('acl_a_board', $info);
		$this->assertStringContainsString("'module.add'", $migration);
		$this->assertStringContainsString("'modes' => array('cleanup')", $migration);
	}

	public function test_cleanup_action_requires_csrf_confirmation_and_admin_log()
	{
		$module = file_get_contents(dirname(__DIR__) . '/acp/advancedpolls_module.php');

		$this->assertStringContainsString('check_form_key($this->form_key)', $module);
		$this->assertStringContainsString('$confirmed = confirm_box(true)', $module);
		$this->assertStringContainsString('$this->request->is_set_post(\'confirm\')', $module);
		$this->assertStringContainsString('\'i\' => $id', $module);
		$this->assertStringContainsString('\'mode\' => $mode', $module);
		$this->assertStringNotContainsString('\'form_token\' =>', $module);
		$this->assertStringNotContainsString('\'creation_time\' =>', $module);
		$this->assertStringContainsString("'LOG_AP_POLL_CLEANUP'", $module);
		$this->assertStringContainsString('$this->request->is_set_post(\'cancel\')', $module);
		$this->assertStringContainsString('in_array($action, array(\'selected\', \'all\', \'empty_wrappers\'), true)', $module);
		$this->assertStringContainsString('$cleanup->cleanup_with_report($topic_ids, $all_cleanable)', $module);
		$this->assertStringContainsString('$cleanup->cleanup_empty_title_wrappers()', $module);
		$this->assertStringContainsString("'AP_CLEANUP_RESULT_DETAIL'", $module);
		$this->assertStringNotContainsString('normalize_empty', $module);
	}

	public function test_cleanup_template_is_initialised_before_actions_can_raise_a_notice()
	{
		$module = file_get_contents(dirname(__DIR__) . '/acp/advancedpolls_module.php');
		$template_assignment = strpos($module, '$this->tpl_name = \'acp_advancedpolls_cleanup\';');
		$page_title_assignment = strpos($module, '$this->page_title = $this->user->lang(\'AP_CLEANUP_ACP\');');
		$action_branch = strpos($module, 'in_array($action');

		$this->assertNotFalse($template_assignment);
		$this->assertNotFalse($page_title_assignment);
		$this->assertNotFalse($action_branch);
		$this->assertLessThan($action_branch, $template_assignment);
		$this->assertLessThan($action_branch, $page_title_assignment);
	}

	public function test_cleanup_template_shows_raw_poll_evidence_and_safe_actions()
	{
		$template = file_get_contents(dirname(__DIR__) . '/adm/style/acp_advancedpolls_cleanup.html');

		$this->assertStringContainsString('{poll_row.POLL_TITLE}', $template);
		$this->assertStringContainsString('{poll_row.POLL_START}', $template);
		$this->assertStringContainsString('{poll_row.POLL_LENGTH}', $template);
		$this->assertStringContainsString('{poll_row.option.TEXT}', $template);
		$this->assertStringContainsString('name="topic_ids[]"', $template);
		$this->assertStringContainsString('value="selected"', $template);
		$this->assertStringContainsString('value="all"', $template);
		$this->assertStringContainsString('value="empty_wrappers"', $template);
		$this->assertStringContainsString('{EMPTY_WRAPPER_TOTAL}', $template);
		$this->assertStringNotContainsString('normalize_empty', $template);
		$this->assertStringContainsString('{S_FORM_TOKEN}', $template);
	}
}
