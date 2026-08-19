<?php
/**
 *
 * Advanced Polls
 *
 * @copyright (c) 2015 Wolfsblvt
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 */

namespace wolfsblvt\advancedpolls\acp;

class advancedpolls_info
{
	public function module()
	{
		return [
			'filename' => '\wolfsblvt\advancedpolls\acp\advancedpolls_module',
			'title'    => 'AP_TITLE_ACP',
			'modes'    => [
				'settings' => ['title' => 'AP_SETTINGS_ACP', 'auth' => 'ext_wolfsblvt/advancedpolls && acl_a_board', 'cat' => ['AP_TITLE_ACP']],
				'cleanup' => ['title' => 'AP_CLEANUP_ACP', 'auth' => 'ext_wolfsblvt/advancedpolls && acl_a_board', 'cat' => ['AP_TITLE_ACP']],
			],
		];
	}
}
