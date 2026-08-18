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

class v1_1_0_step1_data_permissions extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\wolfsblvt\advancedpolls\migrations\v1_0_0_schema'];
	}

	public function update_data()
	{
		return [
			['permission.add', ['u_see_voters']],
			['permission.permission_set', ['ROLE_USER_FULL', 'u_see_voters']],
			['permission.permission_set', ['ROLE_USER_STANDARD', 'u_see_voters']],
			['permission.permission_set', ['REGISTERED', 'u_see_voters', 'group']],
			['permission.permission_set', ['REGISTERED_COPPA', 'u_see_voters', 'group']],
		];
	}
}
