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

class v1_0_0_data_module extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\wolfsblvt\advancedpolls\migrations\v1_0_0_configs'];
	}

	public function update_data()
	{
		return [
			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'AP_TITLE_ACP'
			]],
			['module.add', [
				'acp',
				'AP_TITLE_ACP',
				[
					'module_basename' => '\wolfsblvt\advancedpolls\acp\advancedpolls_module',
					'modes'           => ['settings'],
				],
			]],
		];
	}
}
