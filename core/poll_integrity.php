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
	const EMPTY_STORED_TITLE = '<t></t>';

	/**
	 * A usable phpBB poll has a title, a start time and at least one option.
	 *
	 * @param string $topic_alias Topic table alias
	 * @param string $options_table Fully qualified poll options table
	 * @return string SQL condition
	 */
	public static function valid_condition($topic_alias, $options_table)
	{
		return self::meaningful_title_condition($topic_alias) . '
			AND ' . $topic_alias . '.poll_start > 0
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
			AND (' . self::empty_title_condition($topic_alias) . ' OR ' . $topic_alias . '.poll_start = 0)';
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

	/**
	 * A meaningful title excludes phpBB's rich-text wrapper for an empty value.
	 *
	 * @param string $topic_alias Topic table alias
	 * @return string SQL condition
	 */
	public static function meaningful_title_condition($topic_alias)
	{
		return $topic_alias . ".poll_title <> ''
			AND " . $topic_alias . ".poll_title <> '" . self::EMPTY_STORED_TITLE . "'";
	}

	/**
	 * Match raw database values which represent an empty poll title.
	 *
	 * @param string $topic_alias Topic table alias
	 * @return string SQL condition
	 */
	public static function empty_title_condition($topic_alias)
	{
		return '(' . $topic_alias . ".poll_title = '' OR " . self::empty_wrapper_condition($topic_alias) . ')';
	}

	/**
	 * Match phpBB's stored rich-text wrapper for an empty value.
	 *
	 * @param string $topic_alias Topic table alias
	 * @return string SQL condition
	 */
	public static function empty_wrapper_condition($topic_alias)
	{
		return $topic_alias . ".poll_title = '" . self::EMPTY_STORED_TITLE . "'";
	}

	/**
	 * Determine whether a raw stored poll title contains actual text.
	 *
	 * @param string $title Stored poll title
	 * @return bool
	 */
	public static function title_is_meaningful($title)
	{
		$title = trim((string) $title);

		return $title !== '' && $title !== self::EMPTY_STORED_TITLE;
	}

	protected static function has_options_condition($topic_alias, $options_table)
	{
		return 'EXISTS (SELECT 1
			FROM ' . $options_table . ' ap_poll_option
			WHERE ap_poll_option.topic_id = ' . $topic_alias . '.topic_id)';
	}
}
