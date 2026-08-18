<?php
/**
 *
 * Advanced Polls
 *
 * @copyright (c) 2015 Wolfsblvt & javiexin ( www.exincastillos.es/jxmods )
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 */

namespace wolfsblvt\advancedpolls\migrations;

class v1_2_0_configs extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\wolfsblvt\advancedpolls\migrations\v1_1_0_step3_configs'];
	}

	public function update_data()
	{
		return [
			['config.add', ['wolfsblvt.advancedpolls.activate_poll_show_ordered',		1]],
			['config.add', ['wolfsblvt.advancedpolls.default_poll_show_ordered',		0]],

			['config.add', ['wolfsblvt.advancedpolls.activate_poll_scoring',			1]],
			['config.add', ['wolfsblvt.advancedpolls.activate_incremental_votes',		0]],
			['config.add', ['wolfsblvt.advancedpolls.activate_closed_voting',			1]],
			['config.add', ['wolfsblvt.advancedpolls.activate_no_vote',				1]],
			['config.add', ['wolfsblvt.advancedpolls.activate_poll_end',				1]],
			['config.add', ['wolfsblvt.advancedpolls.pollend_last_gc',				0,	true]], // not to be cached
			['config.add', ['wolfsblvt.advancedpolls.pollend_gc',						0,	true]], // not to be cached
		];
	}
}
