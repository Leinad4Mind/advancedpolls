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

class v1_7_2_data extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return array('\wolfsblvt\advancedpolls\migrations\v1_7_1_schema');
	}

	public function update_data()
	{
		return array(
			array('module.add', array(
				'acp',
				'AP_TITLE_ACP',
				array(
					'module_basename' => '\wolfsblvt\advancedpolls\acp\advancedpolls_module',
					'modes' => array('cleanup'),
				),
			)),
		);
	}
}
