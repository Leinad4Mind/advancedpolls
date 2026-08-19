<?php
/**
 *
 * Advanced Polls
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace wolfsblvt\advancedpolls\migrations;

use wolfsblvt\advancedpolls\core\poll_list_order;

class v1_7_2_poll_list_order extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return array('\wolfsblvt\advancedpolls\migrations\v1_7_2_data');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('wolfsblvt.advancedpolls.poll_list_order', poll_list_order::DEFAULT_ORDER)),
		);
	}
}
