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

class v1_7_1_schema extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return array('\wolfsblvt\advancedpolls\migrations\v1_7_0_data');
	}

	public function update_schema()
	{
		return array(
			'change_columns' => array(
				$this->table_prefix . 'topics' => array(
					'wolfsblvt_poll_scheduled_start' => array('TIMESTAMP', 0),
				),
			),
		);
	}

	public function revert_schema()
	{
		// Do not shrink this column back to MEDIUMINT: populated Unix timestamps
		// would exceed its range. The 1.7.0 migration drops it during data purge.
		return array();
	}
}
