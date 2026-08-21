<?php
// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound
/**
 * Advanced Polls tests
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace wolfsblvt\advancedpolls\acp
{
	class cleanup_flow_spy
	{
		public static $confirmed = false;
		public static $form_key_valid = true;
		public static $confirm_checks = 0;
		public static $confirm_displays = 0;
		public static $form_key_checks = 0;
		public static $hidden_fields = array();
		public static $link_hash_valid = true;
		public static $checked_hash_names = array();
		public static $generated_hash_names = array();
		public static $meta_refresh_url = '';
		public static $template_vars = array();

		public static function reset()
		{
			self::$confirmed = false;
			self::$form_key_valid = true;
			self::$confirm_checks = 0;
			self::$confirm_displays = 0;
			self::$form_key_checks = 0;
			self::$hidden_fields = array();
			self::$link_hash_valid = true;
			self::$checked_hash_names = array();
			self::$generated_hash_names = array();
			self::$meta_refresh_url = '';
			self::$template_vars = array();
		}
	}

	class cleanup_flow_notice extends \RuntimeException
	{
	}

	function add_form_key($form_name)
	{
	}

	function check_form_key($form_name)
	{
		cleanup_flow_spy::$form_key_checks++;

		return cleanup_flow_spy::$form_key_valid;
	}

	function confirm_box($check, $title = '', $hidden = '', $html_body = 'confirm_body.html', $u_action = '')
	{
		if ($check)
		{
			cleanup_flow_spy::$confirm_checks++;

			return cleanup_flow_spy::$confirmed;
		}

		cleanup_flow_spy::$confirm_displays++;

		return false;
	}

	function build_hidden_fields($fields)
	{
		cleanup_flow_spy::$hidden_fields = $fields;

		return '';
	}

	function adm_back_link($url)
	{
		return ' [' . $url . ']';
	}

	function check_link_hash($hash, $link_name)
	{
		cleanup_flow_spy::$checked_hash_names[] = $link_name;

		return cleanup_flow_spy::$link_hash_valid;
	}

	function generate_link_hash($link_name)
	{
		cleanup_flow_spy::$generated_hash_names[] = $link_name;

		return 'generated-hash';
	}

	function meta_refresh($time, $url)
	{
		cleanup_flow_spy::$meta_refresh_url = $url;
	}

	function trigger_error($message, $severity = E_USER_NOTICE)
	{
		throw new cleanup_flow_notice($message, $severity);
	}
}

namespace wolfsblvt\advancedpolls\tests
{
	use PHPUnit\Framework\TestCase;
	use wolfsblvt\advancedpolls\acp\cleanup_flow_notice;
	use wolfsblvt\advancedpolls\acp\cleanup_flow_spy;
	use wolfsblvt\advancedpolls\core\poll_cleanup_manager;

	class acp_cleanup_flow_test extends TestCase
	{
		// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed
		protected function setUp(): void
		{
			cleanup_flow_spy::reset();
		}

		public function test_initial_request_validates_form_and_preserves_acp_route_for_confirmation()
		{
			$request = new cleanup_request_stub(array(
				'cleanup_action' => 'selected',
				'filter' => poll_cleanup_manager::FILTER_CLEANABLE,
				'start' => 50,
				'topic_ids' => array(4463, 4462),
			));
			$cleanup = $this->createMock(poll_cleanup_manager::class);
			$cleanup->expects($this->once())->method('get_summary')->willReturn($this->summary());

			$this->module($request)->run_cleanup($cleanup, $this->pagination(), new cleanup_log_stub());

			$this->assertSame(1, cleanup_flow_spy::$confirm_checks);
			$this->assertSame(1, cleanup_flow_spy::$form_key_checks);
			$this->assertSame(1, cleanup_flow_spy::$confirm_displays);
			$this->assertSame(array(
				'cleanup_action' => 'selected',
				'filter' => poll_cleanup_manager::FILTER_CLEANABLE,
				'start' => 50,
				'cleanup_total' => 2,
				'topic_ids' => array(4463, 4462),
			), cleanup_flow_spy::$hidden_fields);
		}

		public function test_valid_confirmation_executes_cleanup_without_original_form_token()
		{
			cleanup_flow_spy::$confirmed = true;
			$request = new cleanup_request_stub(array(
				'cleanup_action' => 'all',
				'filter' => poll_cleanup_manager::FILTER_CLEANABLE,
				'cleanup_total' => 2,
			), array('confirm'));
			$cleanup = $this->createMock(poll_cleanup_manager::class);
			$cleanup->expects($this->never())->method('get_summary');
			$cleanup->expects($this->once())
				->method('cleanup_batch')
				->with(0, 100, false)
				->willReturn(array('processed' => 2, 'cleaned' => 2, 'last_topic_id' => 4463, 'has_more' => false));
			$log = new cleanup_log_stub();

			try
			{
				$this->module($request)->run_cleanup($cleanup, $this->pagination(), $log);
				$this->fail('The ACP success notice was not raised.');
			}
			catch (cleanup_flow_notice $notice)
			{
				$this->assertStringContainsString('AP_CLEANUP_RESULT_DETAIL', $notice->getMessage());
			}

			$this->assertSame(1, cleanup_flow_spy::$confirm_checks);
			$this->assertSame(0, cleanup_flow_spy::$form_key_checks);
			$this->assertSame(0, cleanup_flow_spy::$confirm_displays);
			$this->assertCount(1, $log->entries);
		}

		public function test_rejected_confirmation_fails_explicitly_without_cleaning()
		{
			$request = new cleanup_request_stub(array(
				'cleanup_action' => 'all',
			), array('confirm'));
			$cleanup = $this->createMock(poll_cleanup_manager::class);
			$cleanup->expects($this->never())->method('get_summary');
			$cleanup->expects($this->never())->method('cleanup_with_report');
			$cleanup->expects($this->never())->method('cleanup_batch');

			try
			{
				$this->module($request)->run_cleanup($cleanup, $this->pagination(), new cleanup_log_stub());
				$this->fail('An invalid confirmation was accepted silently.');
			}
			catch (cleanup_flow_notice $notice)
			{
				$this->assertStringContainsString('FORM_INVALID', $notice->getMessage());
			}

			$this->assertSame(1, cleanup_flow_spy::$confirm_checks);
			$this->assertSame(0, cleanup_flow_spy::$form_key_checks);
			$this->assertSame(0, cleanup_flow_spy::$confirm_displays);
		}

		public function test_signed_continuation_processes_one_batch_and_can_be_resumed()
		{
			$request = new cleanup_request_stub(array(
				'cleanup_batch' => 'all',
				'cleanup_cursor' => 100,
				'cleanup_total' => 250,
				'cleanup_processed' => 100,
				'cleanup_cleaned' => 100,
				'hash' => 'valid-hash',
			));
			$cleanup = $this->createMock(poll_cleanup_manager::class);
			$cleanup->expects($this->once())
				->method('cleanup_batch')
				->with(100, 100, false)
				->willReturn(array('processed' => 100, 'cleaned' => 99, 'last_topic_id' => 200, 'has_more' => true));
			$log = new cleanup_log_stub();

			$this->module($request)->run_cleanup($cleanup, $this->pagination(), $log);

			$this->assertSame(array('acp_advancedpolls_cleanup_batch_all_100_250_100_100'), cleanup_flow_spy::$checked_hash_names);
			$this->assertSame(array('acp_advancedpolls_cleanup_batch_all_200_250_200_199'), cleanup_flow_spy::$generated_hash_names);
			$this->assertStringContainsString('cleanup_cursor=200', cleanup_flow_spy::$meta_refresh_url);
			$this->assertStringContainsString('cleanup_cleaned=199', cleanup_flow_spy::$meta_refresh_url);
			$this->assertTrue(cleanup_flow_spy::$template_vars['S_CLEANUP_PROGRESS']);
			$this->assertSame(200, cleanup_flow_spy::$template_vars['CLEANUP_PROGRESS_VALUE']);
			$this->assertCount(0, $log->entries);
		}

		private function module($request)
		{
			$module = new testable_advancedpolls_module();
			$module->u_action = 'adm/index.php?i=module-id&amp;mode=cleanup';
			$module->set_dependencies(new cleanup_user_stub(), $request);

			return $module;
		}

		private function pagination()
		{
			return $this->createMock(\phpbb\pagination::class);
		}

		private function summary()
		{
			return array(
				'marked' => 2823,
				'valid' => 112,
				'cleanable' => 2711,
				'inconsistent' => 0,
				'reported' => 2823,
				'empty_wrappers' => 2711,
			);
		}
	}

	class testable_advancedpolls_module extends \wolfsblvt\advancedpolls\acp\advancedpolls_module
	{
		public function set_dependencies($user, $request)
		{
			$this->user = $user;
			$this->request = $request;
			$this->template = new cleanup_template_stub();
		}

		public function run_cleanup(poll_cleanup_manager $cleanup, \phpbb\pagination $pagination, $log)
		{
			$this->render_cleanup($cleanup, $pagination, $log, './', 'php');
		}
	}

	class cleanup_template_stub
	{
		public function assign_vars(array $variables)
		{
			cleanup_flow_spy::$template_vars = array_merge(cleanup_flow_spy::$template_vars, $variables);
		}
	}

	class cleanup_request_stub
	{
		private $variables;
		private $post_fields;

		public function __construct(array $variables, array $post_fields = array())
		{
			$this->variables = $variables;
			$this->post_fields = $post_fields;
		}

		public function variable($name, $default, $multibyte = false)
		{
			return array_key_exists($name, $this->variables) ? $this->variables[$name] : $default;
		}

		public function is_set_post($name)
		{
			return in_array($name, $this->post_fields, true);
		}
	}

	class cleanup_user_stub
	{
		public $data = array('user_id' => 2);
		public $ip = '127.0.0.1';

		public function lang($key)
		{
			$arguments = func_get_args();
			array_shift($arguments);

			return $key . ($arguments ? ':' . implode(',', $arguments) : '');
		}
	}

	class cleanup_log_stub
	{
		public $entries = array();

		public function add()
		{
			$this->entries[] = func_get_args();
		}
	}
}
