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
use wolfsblvt\advancedpolls\core\poll_integrity;

class poll_integrity_test extends TestCase
{
	public function test_valid_poll_requires_title_start_and_options()
	{
		$condition = poll_integrity::valid_condition('t', 'phpbb_poll_options');

		$this->assertStringContainsString("t.poll_title <> ''", $condition);
		$this->assertStringContainsString("t.poll_title <> '<t></t>'", $condition);
		$this->assertStringContainsString('t.poll_start > 0', $condition);
		$this->assertStringContainsString('FROM phpbb_poll_options ap_poll_option', $condition);
		$this->assertStringContainsString('ap_poll_option.topic_id = t.topic_id', $condition);
	}

	public function test_cleanable_poll_metadata_must_have_no_options()
	{
		$condition = poll_integrity::cleanable_condition('topic_row', 'custom_poll_options');

		$this->assertStringContainsString("topic_row.poll_title <> ''", $condition);
		$this->assertStringContainsString('NOT EXISTS', $condition);
		$this->assertStringContainsString('FROM custom_poll_options ap_poll_option', $condition);
	}

	public function test_inconsistent_and_reported_conditions_retain_rows_for_review()
	{
		$inconsistent = poll_integrity::inconsistent_condition('t', 'phpbb_poll_options');
		$reported = poll_integrity::reported_condition('t', 'phpbb_poll_options');

		$this->assertStringContainsString("t.poll_title = ''", $inconsistent);
		$this->assertStringContainsString("t.poll_title = '<t></t>'", $inconsistent);
		$this->assertStringContainsString("t.poll_title <> '' OR EXISTS", $reported);
	}

	public function test_phpbb_empty_title_wrapper_is_not_meaningful()
	{
		$this->assertFalse(poll_integrity::title_is_meaningful(''));
		$this->assertFalse(poll_integrity::title_is_meaningful('<t></t>'));
		$this->assertFalse(poll_integrity::title_is_meaningful('  <t></t>  '));
		$this->assertTrue(poll_integrity::title_is_meaningful('<t>Question</t>'));
		$this->assertSame("topic.poll_title = '<t></t>'", poll_integrity::empty_wrapper_condition('topic'));
	}
}
