<?php
/**
 *
 * Advanced Polls
 *
 * @copyright (c) 2015 Wolfsblvt
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 */

namespace wolfsblvt\advancedpolls\migrations;

class v1_0_0_configs extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return [
			['config.add', ['wolfsblvt.advancedpolls.activate_poll_votes_hide',		1]],
			['config.add', ['wolfsblvt.advancedpolls.activate_poll_voters_show',		1]],
			['config.add', ['wolfsblvt.advancedpolls.activate_poll_voters_limit',		1]],

			['config.add', ['wolfsblvt.advancedpolls.default_poll_votes_hide',		0]],
			['config.add', ['wolfsblvt.advancedpolls.default_poll_voters_show',		1]],
			['config.add', ['wolfsblvt.advancedpolls.default_poll_voters_limit',		0]],
		];
	}
}
