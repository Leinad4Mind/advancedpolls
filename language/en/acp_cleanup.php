<?php
/**
 * Advanced Polls ACP cleanup language
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'AP_CLEANUP_TITLE' => 'Poll data cleanup',
	'AP_CLEANUP_EXPLAIN' => 'Inspect every topic carrying poll metadata or poll options. Only residual titles without any option can be cleaned automatically; ambiguous rows remain read-only for manual review.',
	'AP_CLEANUP_BACKUP_WARNING' => 'Create a complete database backup before cleaning. The operation clears residual poll metadata from selected topic rows and cannot reconstruct missing poll options.',
	'AP_CLEANUP_SUMMARY' => 'Integrity summary',
	'AP_CLEANUP_MARKED_TOTAL' => 'Topics counted by the old title-only rule',
	'AP_CLEANUP_VALID_TOTAL' => 'Valid polls',
	'AP_CLEANUP_RESIDUAL_TOTAL' => 'Safe-to-clean residual titles',
	'AP_CLEANUP_INCONSISTENT_TOTAL' => 'Rows requiring manual review',
	'AP_CLEANUP_EMPTY_WRAPPER_TOTAL' => 'Empty phpBB title wrappers (&lt;t&gt;&lt;/t&gt;)',
	'AP_CLEANUP_ROWS' => 'rows',
	'AP_CLEANUP_FILTER_CLEANABLE' => 'Residual titles',
	'AP_CLEANUP_FILTER_INCONSISTENT' => 'Manual review',
	'AP_CLEANUP_FILTER_VALID' => 'Valid polls',
	'AP_CLEANUP_FILTER_ALL' => 'All poll data',
	'AP_CLEANUP_SELECT' => 'Select',
	'AP_CLEANUP_TOPIC' => 'Topic',
	'AP_CLEANUP_POLL_TITLE' => 'Raw poll title',
	'AP_CLEANUP_TIMING' => 'Raw timing data',
	'AP_CLEANUP_OPTIONS' => 'Poll options and totals',
	'AP_CLEANUP_VOTES' => 'Vote rows',
	'AP_CLEANUP_STATUS' => 'Integrity',
	'AP_CLEANUP_EMPTY' => '(empty)',
	'AP_CLEANUP_START' => 'poll_start',
	'AP_CLEANUP_LENGTH' => 'poll_length',
	'AP_CLEANUP_END' => 'Calculated end',
	'AP_CLEANUP_SAVED_REMAINING' => 'saved remaining',
	'AP_CLEANUP_SCHEDULED_START' => 'scheduled start',
	'AP_CLEANUP_STATUS_CLEANABLE' => 'Residual title; no options',
	'AP_CLEANUP_STATUS_INCONSISTENT' => 'Options exist, but title/start is missing',
	'AP_CLEANUP_STATUS_VALID' => 'Valid poll',
	'AP_CLEANUP_NO_ROWS' => 'No rows match this filter.',
	'AP_CLEANUP_SELECT_PAGE' => 'Select cleanable rows on this page',
	'AP_CLEANUP_SELECTED' => 'Clean selected',
	'AP_CLEANUP_ALL' => 'Clean all residual titles',
	'AP_CLEANUP_NOTHING_SELECTED' => 'No cleanable topic was selected.',
	'AP_CLEANUP_CONFIRM_SELECTED' => 'Clean residual poll metadata from the %d selected topic rows?',
	'AP_CLEANUP_CONFIRM_ALL' => 'Clean all %d residual poll title rows? Confirm that a complete database backup exists before continuing.',
	'AP_CLEANUP_RESULT' => '%d residual topic rows were cleaned.',
	'AP_CLEANUP_RESULT_DETAIL' => '%1$d residual topic rows were cleaned. %2$d rows were skipped because they now contain options or votes, or no longer have a residual title.',
));
