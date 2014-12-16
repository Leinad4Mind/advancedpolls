<?php
/**
 * 
 * Advanced Polls
 * 
 * @copyright (c) 2014 Wolfsblvt ( www.pinkes-forum.de )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 */

namespace wolfsblvt\advancedpolls\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	/** @var \wolfsblvt\advancedpolls\core\advancedpolls */
	protected $advancedpolls;

	/** @var \phpbb\path_helper */
	protected $path_helper;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\request\request */
	protected $request;

	/**
	 * Constructor of event listener
	 *
	 * @param \wolfsblvt\advancedpolls\core\advancedpolls	$advancedpolls		Online Time
	 * @param \phpbb\path_helper					$path_helper	phpBB path helper
	 * @param \phpbb\template\template				$template		Template object
	 * @param \phpbb\user							$user			User object
	 * @param \phpbb\request\request				$request		Request object
	 */
	public function __construct(\wolfsblvt\advancedpolls\core\advancedpolls $advancedpolls, \phpbb\path_helper $path_helper, \phpbb\template\template $template, \phpbb\user $user, \phpbb\request\request $request)
	{
		$this->advancedpolls = $advancedpolls;
		$this->path_helper = $path_helper;
		$this->template = $template;
		$this->user = $user;
		$this->request = $request;

		$this->ext_root_path = 'ext/wolfsblvt/advancedpolls';
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 */
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'						=> 'page_load',
			'core.page_header'						=> 'assign_template_vars',
		);
	}

	/**
	 * Adds functionality to page_header
	 *
	 * @param object $event The event object
	 * @return void
	 */
	public function page_load($event)
	{
		// Do something here
	}

	/**
	 * Assigns the global template vars
	 * 
	 * @return void
	 */
	public function assign_template_vars()
	{
		$this->template->assign_vars(array(
			'T_EXT_ADVANCEDPOLLS_PATH'				=> $this->path_helper->get_web_root_path() . $this->ext_root_path,
			'T_EXT_ADVANCEDPOLLS_THEME_PATH'		=> $this->path_helper->get_web_root_path() . $this->ext_root_path . '/styles/' . $this->user->style['style_path'] . '/theme',
		));
	}
}
