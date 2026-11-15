<?php

/**
 *
 * Advanced Polls ACP cleanup language
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
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
	'AP_CLEANUP_TITLE' => '投票データのクリーンアップ',
	'AP_CLEANUP_EXPLAIN' => '投票のメタデータまたは選択肢を持つすべてのトピックを点検します。自動でクリーンアップできるのは、選択肢が一つもない残留タイトルだけです。判断できない行は手動確認用に読み取り専用のまま残ります。',
	'AP_CLEANUP_BACKUP_WARNING' => 'クリーンアップの前にデータベースの完全なバックアップを作成してください。この操作は選択したトピック行から残留した投票メタデータを消去し、失われた投票の選択肢を復元することはできません。',
	'AP_CLEANUP_SUMMARY' => '整合性の概要',
	'AP_CLEANUP_MARKED_TOTAL' => 'タイトルのみを見る旧ルールで数えられたトピック',
	'AP_CLEANUP_VALID_TOTAL' => '有効な投票',
	'AP_CLEANUP_RESIDUAL_TOTAL' => '安全にクリーンアップできる残留タイトル',
	'AP_CLEANUP_INCONSISTENT_TOTAL' => '手動確認が必要な行',
	'AP_CLEANUP_EMPTY_WRAPPER_TOTAL' => '空の phpBB タイトルラッパー (&lt;t&gt;&lt;/t&gt;)',
	'AP_CLEANUP_ROWS' => '行',
	'AP_CLEANUP_FILTER_CLEANABLE' => '残留タイトル',
	'AP_CLEANUP_FILTER_INCONSISTENT' => '手動確認',
	'AP_CLEANUP_FILTER_VALID' => '有効な投票',
	'AP_CLEANUP_FILTER_ALL' => 'すべての投票データ',
	'AP_CLEANUP_SELECT' => '選択',
	'AP_CLEANUP_TOPIC' => 'トピック',
	'AP_CLEANUP_POLL_TITLE' => '投票タイトル（生データ）',
	'AP_CLEANUP_TIMING' => '日時データ（生データ）',
	'AP_CLEANUP_OPTIONS' => '投票の選択肢と合計',
	'AP_CLEANUP_VOTES' => '投票行',
	'AP_CLEANUP_STATUS' => '整合性',
	'AP_CLEANUP_EMPTY' => '（空）',
	'AP_CLEANUP_START' => 'poll_start',
	'AP_CLEANUP_LENGTH' => 'poll_length',
	'AP_CLEANUP_END' => '計算上の終了日時',
	'AP_CLEANUP_SAVED_REMAINING' => '保存された残り時間',
	'AP_CLEANUP_SCHEDULED_START' => '予定開始日時',
	'AP_CLEANUP_STATUS_CLEANABLE' => '残留タイトル。選択肢なし',
	'AP_CLEANUP_STATUS_INCONSISTENT' => '選択肢はありますが、タイトルまたは開始日時がありません',
	'AP_CLEANUP_STATUS_VALID' => '有効な投票',
	'AP_CLEANUP_NO_ROWS' => 'このフィルターに一致する行はありません。',
	'AP_CLEANUP_SELECT_PAGE' => 'このページのクリーンアップ可能な行を選択',
	'AP_CLEANUP_SELECTED' => '選択した行をクリーンアップ',
	'AP_CLEANUP_ALL' => 'すべての残留タイトルをクリーンアップ',
	'AP_CLEANUP_EMPTY_WRAPPERS' => '空の phpBB タイトルラッパーをクリーンアップ',
	'AP_CLEANUP_NOTHING_SELECTED' => 'クリーンアップ可能なトピックが選択されていません。',
	'AP_CLEANUP_CONFIRM_SELECTED' => '選択した %d 件のトピック行から残留した投票メタデータをクリーンアップしますか？',
	'AP_CLEANUP_CONFIRM_ALL' => '残留した投票タイトルの行 %d 件をすべてクリーンアップしますか？ 続行する前に、データベースの完全なバックアップがあることを確認してください。',
	'AP_CLEANUP_CONFIRM_EMPTY_WRAPPERS' => '空の phpBB 投票タイトルラッパー %d 件をクリーンアップしますか？ 変更されるのは poll_title だけで、投票の選択肢、投票、日時フィールドは保持されます。',
	'AP_CLEANUP_RESULT' => '残留したトピック行 %d 件をクリーンアップしました。',
	'AP_CLEANUP_RESULT_DETAIL' => '残留したトピック行 %1$d 件をクリーンアップしました。%2$d 件の行は、選択肢や投票を含むようになったか、残留タイトルがなくなったためスキップしました。',
	'AP_CLEANUP_EMPTY_WRAPPERS_RESULT' => '空の phpBB 投票タイトルラッパー %d 件をクリーンアップしました。投票の選択肢、投票、日時フィールドは保持されました。',
	'AP_CLEANUP_PROGRESS_TITLE' => 'クリーンアップ中',
	'AP_CLEANUP_PROGRESS_EXPLAIN' => '残留した投票データを %d トピックずつ安全なバッチでクリーンアップしています。このページは自動的に進みます。中断された場合は、最後の進行状況ページを再読み込みすると再開できます。',
	'AP_CLEANUP_PROGRESS' => '候補行 %2$d 件中 %1$d 件を点検し、%3$d 件をクリーンアップしました。',
	'AP_CLEANUP_CONTINUE' => 'クリーンアップを続行',
));
