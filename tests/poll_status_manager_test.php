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
use wolfsblvt\advancedpolls\core\poll_status_manager;

class poll_status_manager_test extends TestCase
{
	public function test_close_preserves_timed_poll_remaining_duration()
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$auth = $this->createMock(\phpbb\auth\auth::class);
		$updates = array();
		$db->method('sql_in_set')->willReturn('topic_id IN (5, 6)');
		$db->method('sql_build_array')->willReturnCallback(function ($mode, $values) use (&$updates) {
			$updates[] = $values;
			return 'poll_length = ' . (int) $values['poll_length'];
		});
		$db->method('sql_query')->willReturnOnConsecutiveCalls('polls', true, true);
		$db->method('sql_fetchrow')->willReturnOnConsecutiveCalls(
			array(
				'topic_id' => 5,
				'forum_id' => 2,
				'poll_start' => 500,
				'poll_length' => 700,
				'wolfsblvt_poll_saved_remaining' => 0,
			),
			array(
				'topic_id' => 6,
				'forum_id' => 2,
				'poll_start' => 700,
				'poll_length' => 0,
				'wolfsblvt_poll_saved_remaining' => 0,
			),
			false
		);
		$auth->method('acl_get')->willReturn(true);

		$manager = new poll_status_manager($db, $auth, 'phpbb_');
		$this->assertSame(2, $manager->change_status(array(5, 6), poll_status_manager::ACTION_CLOSE, 1000));
		$this->assertSame(array(
			array(
				'poll_start' => 500,
				'poll_length' => 500,
				'wolfsblvt_poll_saved_remaining' => 200,
				'wolfsblvt_poll_notified' => 0,
			),
			array(
				'poll_start' => 700,
				'poll_length' => 300,
				'wolfsblvt_poll_saved_remaining' => 0,
				'wolfsblvt_poll_notified' => 0,
			),
		), $updates);
	}

	public function test_open_restores_saved_duration_and_reopens_natural_expiry_indefinitely()
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$auth = $this->createMock(\phpbb\auth\auth::class);
		$updates = array();
		$db->method('sql_in_set')->willReturn('topic_id IN (7, 8)');
		$db->method('sql_build_array')->willReturnCallback(function ($mode, $values) use (&$updates) {
			$updates[] = $values;
			return 'poll_length = ' . (int) $values['poll_length'];
		});
		$db->method('sql_query')->willReturnOnConsecutiveCalls('polls', true, true);
		$db->method('sql_fetchrow')->willReturnOnConsecutiveCalls(
			array(
				'topic_id' => 7,
				'forum_id' => 3,
				'poll_start' => 500,
				'poll_length' => 500,
				'wolfsblvt_poll_saved_remaining' => 100,
			),
			array(
				'topic_id' => 8,
				'forum_id' => 3,
				'poll_start' => 500,
				'poll_length' => 400,
				'wolfsblvt_poll_saved_remaining' => 0,
			),
			false
		);
		$auth->method('acl_get')->willReturn(true);

		$manager = new poll_status_manager($db, $auth, 'phpbb_');
		$this->assertSame(2, $manager->change_status(array(7, 8), poll_status_manager::ACTION_OPEN, 1000));
		$this->assertSame(array(
			array(
				'poll_length' => 600,
				'wolfsblvt_poll_saved_remaining' => 0,
				'wolfsblvt_poll_notified' => 0,
			),
			array(
				'poll_length' => 0,
				'wolfsblvt_poll_saved_remaining' => 0,
				'wolfsblvt_poll_notified' => 0,
			),
		), $updates);
	}

	public function test_forum_without_m_lock_permission_cannot_change_poll()
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$auth = $this->createMock(\phpbb\auth\auth::class);
		$db->method('sql_in_set')->willReturn('topic_id = 9');
		$db->expects($this->once())->method('sql_query')->willReturn('polls');
		$db->method('sql_fetchrow')->willReturnOnConsecutiveCalls(
			array(
				'topic_id' => 9,
				'forum_id' => 4,
				'poll_start' => 500,
				'poll_length' => 0,
				'wolfsblvt_poll_saved_remaining' => 0,
			),
			false
		);
		$auth->method('acl_get')->willReturnCallback(function ($permission) {
			return $permission === 'f_read';
		});

		$manager = new poll_status_manager($db, $auth, 'phpbb_');
		$this->assertSame(0, $manager->change_status(array(9), poll_status_manager::ACTION_CLOSE, 1000));
	}

	public function test_scheduled_poll_cannot_be_closed_before_it_starts()
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$auth = $this->createMock(\phpbb\auth\auth::class);
		$db->method('sql_in_set')->willReturn('topic_id = 10');
		$db->expects($this->once())->method('sql_query')->willReturn('polls');
		$db->method('sql_fetchrow')->willReturnOnConsecutiveCalls(
			array(
				'topic_id' => 10,
				'forum_id' => 4,
				'poll_start' => 500,
				'poll_length' => 0,
				'wolfsblvt_poll_saved_remaining' => 0,
				'wolfsblvt_poll_scheduled_start' => 2000,
			),
			false
		);
		$db->expects($this->never())->method('sql_build_array');
		$auth->method('acl_get')->willReturn(true);

		$manager = new poll_status_manager($db, $auth, 'phpbb_');
		$this->assertSame(0, $manager->change_status(array(10), poll_status_manager::ACTION_CLOSE, 1000));
	}

}
