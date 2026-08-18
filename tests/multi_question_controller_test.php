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
use wolfsblvt\advancedpolls\controller\multi_question;
use wolfsblvt\advancedpolls\core\multi_question_manager;

class multi_question_controller_test extends TestCase
{
	public function test_scheduled_poll_rejects_multi_question_votes_before_start()
	{
		$auth = $this->createMock(\phpbb\auth\auth::class);
		$auth->method('acl_get')->willReturn(true);
		$user = $this->createMock(\phpbb\user::class);
		$user->data = array('is_bot' => false);
		$controller = new multi_question(
			$this->createMock(\phpbb\db\driver\driver_interface::class),
			$auth,
			$user,
			$this->createMock(\phpbb\request\request_interface::class),
			new \phpbb\config\config(array()),
			$this->createMock(multi_question_manager::class),
			'phpbb_'
		);
		$can_vote = new \ReflectionMethod($controller, 'can_vote');
		$can_vote->setAccessible(true);

		$this->assertFalse($can_vote->invoke($controller, array(
			'forum_id' => 2,
			'poll_start' => time(),
			'poll_length' => 0,
			'wolfsblvt_poll_scheduled_start' => time() + 3600,
		)));
	}
}
