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

class v1_2_0_data_permissions extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\wolfsblvt\advancedpolls\migrations\v1_2_0_configs'];
	}

	public function update_data()
	{
		return [
			['permission.add', ['f_seevoters', false, 'f_votechg']],
			['permission.add', ['m_seevoters', true]],
			['permission.add', ['m_seevoters', false]],
			['permission.permission_set', ['ROLE_MOD_FULL', 'm_seevoters']],
		];
	}
}
