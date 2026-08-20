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
use wolfsblvt\advancedpolls\core\poll_cleanup_manager;

class poll_cleanup_manager_test extends TestCase
{
	public function test_summary_distinguishes_marked_valid_and_residual_topics()
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$queries = array();
		$db->expects($this->exactly(6))->method('sql_query')->willReturnCallback(function ($sql) use (&$queries) {
			$queries[] = $sql;
			return 'count-' . count($queries);
		});
		$db->method('sql_fetchfield')->willReturnOnConsecutiveCalls(2824, 103, 2720, 1, 2824, 2718);
		$db->expects($this->exactly(6))->method('sql_freeresult');

		$manager = new poll_cleanup_manager($db, 'phpbb_');
		$this->assertSame(array(
			'marked' => 2824,
			'valid' => 103,
			'cleanable' => 2720,
			'inconsistent' => 1,
			'reported' => 2824,
			'empty_wrappers' => 2718,
		), $manager->get_summary());
		$this->assertStringContainsString("t.poll_title <> ''", $queries[0]);
		$this->assertStringContainsString('t.poll_start > 0', $queries[1]);
		$this->assertStringContainsString('NOT EXISTS', $queries[2]);
		$this->assertStringContainsString('FROM phpbb_poll_votes', $queries[2]);
		$this->assertStringContainsString('FROM phpbb_poll_votes', $queries[3]);
		$this->assertStringContainsString('FROM phpbb_poll_votes', $queries[4]);
		$this->assertStringContainsString("t.poll_title = '<t></t>'", $queries[5]);
	}

	public function test_diagnostic_rows_include_option_and_vote_details()
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->method('sql_query_limit')->willReturn('topics');
		$db->method('sql_in_set')->willReturn('topic_id IN (5)');
		$db->method('sql_query')->willReturnCallback(function ($sql) {
			return strpos($sql, 'poll_votes') !== false ? 'votes' : 'options';
		});
		$rows = array(
			'topics' => array(array(
				'topic_id' => 5,
				'forum_id' => 2,
				'topic_title' => 'Topic',
				'poll_title' => 'Question',
				'poll_start' => 100,
				'poll_length' => 0,
				'poll_max_options' => 1,
				'poll_last_vote' => 0,
				'poll_vote_change' => 0,
				'wolfsblvt_poll_saved_remaining' => 0,
				'wolfsblvt_poll_scheduled_start' => 0,
				'forum_name' => 'Forum',
			)),
			'topics_with_vote_history' => array(
				'topic_id' => 6,
				'forum_id' => 2,
				'topic_title' => 'Damaged poll',
				'poll_title' => '<t></t>',
				'poll_start' => 100,
				'poll_length' => 0,
				'poll_max_options' => 1,
				'poll_last_vote' => 0,
				'poll_vote_change' => 0,
				'wolfsblvt_poll_saved_remaining' => 0,
				'wolfsblvt_poll_scheduled_start' => 0,
				'forum_name' => 'Forum',
			),
			'options' => array(array(
				'topic_id' => 5,
				'poll_option_id' => 1,
				'poll_option_text' => 'Yes',
				'poll_option_total' => 3,
			)),
			'votes' => array(
				array('topic_id' => 5, 'total' => 3),
				array('topic_id' => 6, 'total' => 2),
			),
		);
		$rows['topics'][] = $rows['topics_with_vote_history'];
		$db->method('sql_fetchrow')->willReturnCallback(function ($result) use (&$rows) {
			return empty($rows[$result]) ? false : array_shift($rows[$result]);
		});

		$manager = new poll_cleanup_manager($db, 'phpbb_');
		$result = $manager->get_rows(poll_cleanup_manager::FILTER_ALL, 50, 0);

		$this->assertCount(2, $result);
		$this->assertSame('valid', $result[0]['integrity']);
		$this->assertSame(1, $result[0]['option_count']);
		$this->assertSame('Yes', $result[0]['options'][0]['poll_option_text']);
		$this->assertSame(3, $result[0]['vote_count']);
		$this->assertSame('inconsistent', $result[1]['integrity']);
		$this->assertSame(2, $result[1]['vote_count']);
	}

	public function test_cleanup_resets_only_selected_title_rows_without_options()
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$transactions = array();
		$fields = array();
		$update = '';
		$db->method('sql_transaction')->willReturnCallback(function ($action) use (&$transactions) {
			$transactions[] = $action;
			return true;
		});
		$db->expects($this->once())->method('sql_in_set')
			->with('phpbb_topics.topic_id', array(5, 6))
			->willReturn('phpbb_topics.topic_id IN (5, 6)');
		$db->expects($this->once())->method('sql_build_array')->willReturnCallback(function ($mode, $values) use (&$fields) {
			$fields = $values;
			return "poll_title = ''";
		});
		$db->expects($this->once())->method('sql_query')->willReturnCallback(function ($sql) use (&$update) {
			$update = $sql;
			return true;
		});
		$db->method('sql_affectedrows')->willReturn(2);

		$manager = new poll_cleanup_manager($db, 'phpbb_');
		$this->assertSame(2, $manager->cleanup(array(5, 6, 5)));
		$this->assertSame(array('begin', 'commit'), $transactions);
		$this->assertSame('', $fields['poll_title']);
		$this->assertSame(0, $fields['poll_start']);
		$this->assertSame(0, $fields['poll_length']);
		$this->assertStringContainsString('NOT EXISTS', $update);
		$this->assertStringContainsString('FROM phpbb_poll_options', $update);
		$this->assertStringContainsString('FROM phpbb_poll_votes', $update);
		$this->assertStringContainsString('phpbb_topics.topic_id IN (5, 6)', $update);
	}

	public function test_cleanup_report_exposes_rows_skipped_during_revalidation()
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$manager = $this->getMockBuilder(poll_cleanup_manager::class)
			->setConstructorArgs(array($db, 'phpbb_'))
			->onlyMethods(array('cleanup'))
			->getMock();
		$manager->expects($this->once())->method('cleanup')
			->with(array(5, 6), false)
			->willReturn(1);

		$this->assertSame(array(
			'requested' => 2,
			'cleaned' => 1,
			'skipped' => 1,
		), $manager->cleanup_with_report(array(5, 6, 5)));
	}

	public function test_unknown_filter_defaults_to_cleanable_rows()
	{
		$this->assertSame(poll_cleanup_manager::FILTER_CLEANABLE, poll_cleanup_manager::normalise_filter('invalid'));
		$this->assertSame(poll_cleanup_manager::FILTER_VALID, poll_cleanup_manager::normalise_filter('valid'));
	}
}
