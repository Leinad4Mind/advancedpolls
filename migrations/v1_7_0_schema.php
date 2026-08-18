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

class v1_7_0_schema extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists($this->table_prefix . 'topics', 'wolfsblvt_poll_scheduled_start');
	}

	public static function depends_on()
	{
		return array('\wolfsblvt\advancedpolls\migrations\v1_6_1_schema');
	}

	public function update_schema()
	{
		return array(
			'add_columns' => array(
				$this->table_prefix . 'topics' => array(
					'wolfsblvt_poll_scheduled_start' => array('UINT', 0),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns' => array(
				$this->table_prefix . 'topics' => array(
					'wolfsblvt_poll_scheduled_start',
				),
			),
		);
	}
}
