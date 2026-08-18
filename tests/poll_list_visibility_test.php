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
use phpbb\db\driver\driver_interface;
use wolfsblvt\advancedpolls\controller\poll_list;
use wolfsblvt\advancedpolls\core\poll_options;

class poll_list_visibility_test extends TestCase
{
	public function test_open_default_poll_exposes_leader_after_viewer_votes()
	{
		$controller = $this->controller($this->leader_db());

		$leaders = $controller->visible_leaders($this->topics(poll_options::VISIBILITY_DEFAULT), array(10 => 1), array(10 => false));

		$this->assertSame(5, $leaders[10]['value']);
	}

	public function test_open_private_poll_keeps_leader_hidden_from_regular_viewer()
	{
		$db = $this->createMock(driver_interface::class);
		$db->expects($this->never())->method('sql_query');
		$controller = $this->controller($db);

		$leaders = $controller->visible_leaders($this->topics(poll_options::VISIBILITY_PRIVATE), array(10 => 1), array(10 => false));

		$this->assertSame(array(), $leaders);
	}

	public function test_open_private_poll_exposes_leader_to_moderator()
	{
		$controller = $this->controller($this->leader_db());

		$leaders = $controller->visible_leaders($this->topics(poll_options::VISIBILITY_PRIVATE), array(), array(10 => true));

		$this->assertSame(5, $leaders[10]['value']);
	}

	private function controller(driver_interface $db)
	{
		return new class($db) extends poll_list
		{
			public function __construct(driver_interface $db)
			{
				$this->db = $db;
			}

			public function visible_leaders(array $topics, array $participation, array $manageable)
			{
				return $this->load_visible_leaders($topics, 1000, $participation, $manageable);
			}
		};
	}

	private function topics($visibility)
	{
		return array(10 => array(
			'poll_start' => 900,
			'poll_length' => 0,
			'poll_max_options' => 1,
			'wolfsblvt_poll_visibility' => $visibility,
			'wolfsblvt_poll_type' => poll_options::TYPE_CHOICE,
			'wolfsblvt_poll_vote_mode' => poll_options::VOTE_MODE_NO_CHANGE,
			'wolfsblvt_poll_score_result' => poll_options::SCORE_RESULT_TOTAL,
		));
	}

	private function leader_db()
	{
		$db = $this->createMock(driver_interface::class);
		$db->method('sql_in_set')->willReturn('topic_id IN (10)');
		$db->method('sql_query')->willReturnOnConsecutiveCalls('ratings', 'options');
		$rows = array(
			'ratings' => array(),
			'options' => array(array(
				'topic_id' => 10,
				'poll_option_id' => 1,
				'poll_option_text' => 'Option A',
				'poll_option_total' => 5,
			)),
		);
		$db->method('sql_fetchrow')->willReturnCallback(function ($result) use (&$rows) {
			return empty($rows[$result]) ? false : array_shift($rows[$result]);
		});

		return $db;
	}
}
