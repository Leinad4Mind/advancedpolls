<?php
/**
 *
 * Advanced Polls tests
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace wolfsblvt\advancedpolls\tests;

use PHPUnit\Framework\TestCase;
use wolfsblvt\advancedpolls\core\poll_list_order;
use wolfsblvt\advancedpolls\controller\poll_list;

class poll_list_order_test extends TestCase
{
	public function test_initial_order_preserves_all_as_the_default()
	{
		$this->assertSame(array('all', 'open', 'closed'), poll_list_order::normalise(''));
		$this->assertSame('all', poll_list_order::default_filter(poll_list_order::DEFAULT_ORDER));
	}

	public function test_first_configured_tab_becomes_the_default()
	{
		$this->assertSame(array('open', 'closed', 'all'), poll_list_order::normalise('open,closed,all'));
		$this->assertSame('open', poll_list_order::default_filter('open,closed,all'));
	}

	public function test_invalid_or_duplicate_filters_fall_back_safely()
	{
		$this->assertSame(poll_list_order::DEFAULT_ORDER, poll_list_order::serialise('open,open,all'));
		$this->assertSame(poll_list_order::DEFAULT_ORDER, poll_list_order::serialise('open,closed,invalid'));
	}

	public function test_all_six_unique_orders_are_available_to_the_acp()
	{
		$this->assertCount(6, poll_list_order::supported_orders());
		foreach (poll_list_order::supported_orders() as $order)
		{
			$this->assertCount(3, array_unique($order));
		}
	}

	public function test_controller_uses_the_first_tab_for_clean_directory_urls()
	{
		$helper = new class
		{
			public function route($name, array $params = array(), $is_amp = true)
			{
				return '/polls' . (isset($params['status']) ? '?status=' . $params['status'] : '');
			}
		};
		$controller = new class(array(
			'wolfsblvt.advancedpolls.poll_list_order' => 'open,closed,all',
		), $helper) extends poll_list
		{
			public function __construct(array $config, $helper)
			{
				$this->config = $config;
				$this->controller_helper = $helper;
			}

			public function order()
			{
				return $this->configured_order();
			}

			public function url($filter, $default_filter)
			{
				return $this->poll_list_url($filter, $default_filter);
			}
		};

		$this->assertSame(array('open', 'closed', 'all'), $controller->order());
		$this->assertSame('/polls', $controller->url('open', 'open'));
		$this->assertSame('/polls?status=all', $controller->url('all', 'open'));

		$controller_class = get_class($controller);
		$fallback = new $controller_class(array(), $helper);
		$this->assertSame(array('all', 'open', 'closed'), $fallback->order());
	}
}
