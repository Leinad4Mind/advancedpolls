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
 * Shared SQL predicates for distinguishing real polls from stale topic data.
 */
class poll_integrity
{
	/**
	 * A usable phpBB poll has a title, a start time and at least one option.
	 *
	 * @param string $topic_alias Topic table alias
	 * @param string $options_table Fully qualified poll options table
	 * @return string SQL condition
	 */
	public static function valid_condition($topic_alias, $options_table)
	{
		return $topic_alias . ".poll_title <> ''
			AND " . $topic_alias . '.poll_start > 0
			AND ' . self::has_options_condition($topic_alias, $options_table);
	}

	/**
	 * A stale poll title with no options is safe to clean from the topic row.
	 *
	 * @param string $topic_alias Topic table alias
	 * @param string $options_table Fully qualified poll options table
	 * @return string SQL condition
	 */
	public static function cleanable_condition($topic_alias, $options_table)
	{
		return $topic_alias . ".poll_title <> ''
			AND NOT " . self::has_options_condition($topic_alias, $options_table);
	}

	/**
	 * Poll options without a title or start time require manual inspection.
	 *
	 * @param string $topic_alias Topic table alias
	 * @param string $options_table Fully qualified poll options table
	 * @return string SQL condition
	 */
	public static function inconsistent_condition($topic_alias, $options_table)
	{
		return self::has_options_condition($topic_alias, $options_table) . '
			AND (' . $topic_alias . ".poll_title = '' OR " . $topic_alias . '.poll_start = 0)';
	}

	/**
	 * Include every topic carrying either poll metadata or actual options.
	 *
	 * @param string $topic_alias Topic table alias
	 * @param string $options_table Fully qualified poll options table
	 * @return string SQL condition
	 */
	public static function reported_condition($topic_alias, $options_table)
	{
		return $topic_alias . ".poll_title <> '' OR " . self::has_options_condition($topic_alias, $options_table);
	}

	protected static function has_options_condition($topic_alias, $options_table)
	{
		return 'EXISTS (SELECT 1
			FROM ' . $options_table . ' ap_poll_option
			WHERE ap_poll_option.topic_id = ' . $topic_alias . '.topic_id)';
	}
}
