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

class v1_0_0_schema extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\wolfsblvt\advancedpolls\migrations\v1_0_0_data_module'];
	}

	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'topics' => [
					'wolfsblvt_poll_votes_hide'   => ['BOOL', 0],
					'wolfsblvt_poll_voters_show'  => ['BOOL', 0],
					'wolfsblvt_poll_voters_limit' => ['BOOL', 0],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'topics' => [
					'wolfsblvt_poll_votes_hide',
					'wolfsblvt_poll_voters_show',
					'wolfsblvt_poll_voters_limit',
				],
			],
		];
	}
}
