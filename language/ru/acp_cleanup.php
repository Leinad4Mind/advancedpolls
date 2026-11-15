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
	'AP_CLEANUP_TITLE' => 'Очистка данных опросов',
	'AP_CLEANUP_EXPLAIN' => 'Проверьте каждую тему, содержащую метаданные или варианты опроса. Автоматически можно очистить только остаточные заголовки без вариантов; неоднозначные строки остаются доступными только для чтения и требуют ручной проверки.',
	'AP_CLEANUP_BACKUP_WARNING' => 'Перед очисткой создайте полную резервную копию базы данных. Операция удаляет остаточные метаданные опросов из выбранных строк тем и не может восстановить отсутствующие варианты опроса.',
	'AP_CLEANUP_SUMMARY' => 'Сводка целостности',
	'AP_CLEANUP_MARKED_TOTAL' => 'Темы, учтённые по старому правилу только по заголовку',
	'AP_CLEANUP_VALID_TOTAL' => 'Корректные опросы',
	'AP_CLEANUP_RESIDUAL_TOTAL' => 'Остаточные заголовки, которые можно безопасно очистить',
	'AP_CLEANUP_INCONSISTENT_TOTAL' => 'Строки, требующие ручной проверки',
	'AP_CLEANUP_EMPTY_WRAPPER_TOTAL' => 'Пустые обёртки заголовков phpBB (&lt;t&gt;&lt;/t&gt;)',
	'AP_CLEANUP_ROWS' => 'строк',
	'AP_CLEANUP_FILTER_CLEANABLE' => 'Остаточные заголовки',
	'AP_CLEANUP_FILTER_INCONSISTENT' => 'Ручная проверка',
	'AP_CLEANUP_FILTER_VALID' => 'Корректные опросы',
	'AP_CLEANUP_FILTER_ALL' => 'Все данные опросов',
	'AP_CLEANUP_SELECT' => 'Выбрать',
	'AP_CLEANUP_TOPIC' => 'Тема',
	'AP_CLEANUP_POLL_TITLE' => 'Исходный заголовок опроса',
	'AP_CLEANUP_TIMING' => 'Исходные временные данные',
	'AP_CLEANUP_OPTIONS' => 'Варианты опроса и итоги',
	'AP_CLEANUP_VOTES' => 'Строки голосов',
	'AP_CLEANUP_STATUS' => 'Целостность',
	'AP_CLEANUP_EMPTY' => '(пусто)',
	'AP_CLEANUP_START' => 'poll_start',
	'AP_CLEANUP_LENGTH' => 'poll_length',
	'AP_CLEANUP_END' => 'Расчётное окончание',
	'AP_CLEANUP_SAVED_REMAINING' => 'сохранённый остаток',
	'AP_CLEANUP_SCHEDULED_START' => 'запланированное начало',
	'AP_CLEANUP_STATUS_CLEANABLE' => 'Остаточный заголовок; нет вариантов',
	'AP_CLEANUP_STATUS_INCONSISTENT' => 'Варианты есть, но отсутствует заголовок или начало',
	'AP_CLEANUP_STATUS_VALID' => 'Корректный опрос',
	'AP_CLEANUP_NO_ROWS' => 'Нет строк, соответствующих этому фильтру.',
	'AP_CLEANUP_SELECT_PAGE' => 'Выбрать строки для очистки на этой странице',
	'AP_CLEANUP_SELECTED' => 'Очистить выбранные',
	'AP_CLEANUP_ALL' => 'Очистить все остаточные заголовки',
	'AP_CLEANUP_EMPTY_WRAPPERS' => 'Очистить пустые обёртки заголовков phpBB',
	'AP_CLEANUP_NOTHING_SELECTED' => 'Не выбрано ни одной темы для очистки.',
	'AP_CLEANUP_CONFIRM_SELECTED' => 'Очистить остаточные метаданные опросов в выбранных строках тем (%d)?',
	'AP_CLEANUP_CONFIRM_ALL' => 'Очистить все строки с остаточными заголовками опросов (%d)? Перед продолжением убедитесь, что существует полная резервная копия базы данных.',
	'AP_CLEANUP_CONFIRM_EMPTY_WRAPPERS' => 'Очистить пустые обёртки заголовков опросов phpBB (%d)? Будет изменено только poll_title; варианты, голоса и временные поля опроса сохранятся.',
	'AP_CLEANUP_RESULT' => 'Очищено строк тем с остаточными данными: %d.',
	'AP_CLEANUP_RESULT_DETAIL' => 'Очищено строк тем с остаточными данными: %1$d. Пропущено строк: %2$d, так как теперь они содержат варианты или голоса либо больше не имеют остаточного заголовка.',
	'AP_CLEANUP_EMPTY_WRAPPERS_RESULT' => 'Очищено пустых обёрток заголовков опросов phpBB: %d. Варианты, голоса и временные поля опроса сохранены.',
	'AP_CLEANUP_PROGRESS_TITLE' => 'Идёт очистка',
	'AP_CLEANUP_PROGRESS_EXPLAIN' => 'Остаточные данные опросов очищаются безопасными пакетами по %d тем. Страница переходит дальше автоматически; если процесс прервётся, перезагрузите последнюю страницу прогресса, чтобы продолжить.',
	'AP_CLEANUP_PROGRESS' => 'Проверено %1$d из %2$d строк-кандидатов; очищено строк: %3$d.',
	'AP_CLEANUP_CONTINUE' => 'Продолжить очистку',
));
