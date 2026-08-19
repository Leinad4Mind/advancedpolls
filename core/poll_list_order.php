<?php
/**
 *
 * Advanced Polls
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace wolfsblvt\advancedpolls\core;

/**
 * Validate the configured poll-directory tab order and expose its default tab.
 */
class poll_list_order
{
	const FILTER_ALL = 'all';
	const FILTER_OPEN = 'open';
	const FILTER_CLOSED = 'closed';
	const DEFAULT_ORDER = 'all,open,closed';

	public static function normalise($value)
	{
		$order = array_map('trim', explode(',', strtolower((string) $value)));
		$allowed = array(self::FILTER_ALL, self::FILTER_OPEN, self::FILTER_CLOSED);
		if (count($order) !== 3 || count(array_unique($order)) !== 3 || array_diff($order, $allowed))
		{
			return explode(',', self::DEFAULT_ORDER);
		}

		return $order;
	}

	public static function serialise($value)
	{
		return implode(',', self::normalise($value));
	}

	public static function default_filter($value)
	{
		$order = self::normalise($value);
		return $order[0];
	}

	public static function supported_orders()
	{
		return array(
			array(self::FILTER_ALL, self::FILTER_OPEN, self::FILTER_CLOSED),
			array(self::FILTER_ALL, self::FILTER_CLOSED, self::FILTER_OPEN),
			array(self::FILTER_OPEN, self::FILTER_CLOSED, self::FILTER_ALL),
			array(self::FILTER_OPEN, self::FILTER_ALL, self::FILTER_CLOSED),
			array(self::FILTER_CLOSED, self::FILTER_OPEN, self::FILTER_ALL),
			array(self::FILTER_CLOSED, self::FILTER_ALL, self::FILTER_OPEN),
		);
	}
}
