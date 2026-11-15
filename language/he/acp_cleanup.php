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
	'AP_CLEANUP_TITLE' => 'ניקוי נתוני סקרים',
	'AP_CLEANUP_EXPLAIN' => 'בדוק כל נושא שמכיל מטא־נתונים או אפשרויות של סקר. ניתן לנקות אוטומטית רק כותרות שאריות ללא אף אפשרות; שורות לא חד־משמעיות נשארות לקריאה בלבד לבדיקה ידנית.',
	'AP_CLEANUP_BACKUP_WARNING' => 'צור גיבוי מלא של מסד הנתונים לפני הניקוי. הפעולה מוחקת מטא־נתוני סקר שאריים משורות הנושאים שנבחרו ואינה יכולה לשחזר אפשרויות סקר חסרות.',
	'AP_CLEANUP_SUMMARY' => 'סיכום תקינות',
	'AP_CLEANUP_MARKED_TOTAL' => 'נושאים שנספרו לפי הכלל הישן שבדק רק את הכותרת',
	'AP_CLEANUP_VALID_TOTAL' => 'סקרים תקינים',
	'AP_CLEANUP_RESIDUAL_TOTAL' => 'כותרות שאריות שניתן לנקות בבטחה',
	'AP_CLEANUP_INCONSISTENT_TOTAL' => 'שורות שדורשות בדיקה ידנית',
	'AP_CLEANUP_EMPTY_WRAPPER_TOTAL' => 'עטיפות כותרת ריקות של phpBB (&lt;t&gt;&lt;/t&gt;)',
	'AP_CLEANUP_ROWS' => 'שורות',
	'AP_CLEANUP_FILTER_CLEANABLE' => 'כותרות שאריות',
	'AP_CLEANUP_FILTER_INCONSISTENT' => 'בדיקה ידנית',
	'AP_CLEANUP_FILTER_VALID' => 'סקרים תקינים',
	'AP_CLEANUP_FILTER_ALL' => 'כל נתוני הסקרים',
	'AP_CLEANUP_SELECT' => 'בחר',
	'AP_CLEANUP_TOPIC' => 'נושא',
	'AP_CLEANUP_POLL_TITLE' => 'כותרת סקר גולמית',
	'AP_CLEANUP_TIMING' => 'נתוני זמן גולמיים',
	'AP_CLEANUP_OPTIONS' => 'אפשרויות הסקר וסיכומים',
	'AP_CLEANUP_VOTES' => 'שורות הצבעה',
	'AP_CLEANUP_STATUS' => 'תקינות',
	'AP_CLEANUP_EMPTY' => '(ריק)',
	'AP_CLEANUP_START' => 'poll_start',
	'AP_CLEANUP_LENGTH' => 'poll_length',
	'AP_CLEANUP_END' => 'סיום מחושב',
	'AP_CLEANUP_SAVED_REMAINING' => 'זמן נותר שנשמר',
	'AP_CLEANUP_SCHEDULED_START' => 'התחלה מתוזמנת',
	'AP_CLEANUP_STATUS_CLEANABLE' => 'כותרת שארית; אין אפשרויות',
	'AP_CLEANUP_STATUS_INCONSISTENT' => 'קיימות אפשרויות, אך חסרים הכותרת או ההתחלה',
	'AP_CLEANUP_STATUS_VALID' => 'סקר תקין',
	'AP_CLEANUP_NO_ROWS' => 'אין שורות שתואמות למסנן זה.',
	'AP_CLEANUP_SELECT_PAGE' => 'בחר שורות שניתן לנקות בעמוד זה',
	'AP_CLEANUP_SELECTED' => 'נקה את הנבחרים',
	'AP_CLEANUP_ALL' => 'נקה את כל כותרות השאריות',
	'AP_CLEANUP_EMPTY_WRAPPERS' => 'נקה עטיפות כותרת ריקות של phpBB',
	'AP_CLEANUP_NOTHING_SELECTED' => 'לא נבחר אף נושא שניתן לנקות.',
	'AP_CLEANUP_CONFIRM_SELECTED' => 'לנקות מטא־נתוני סקר שאריים מ־%d שורות הנושאים שנבחרו?',
	'AP_CLEANUP_CONFIRM_ALL' => 'לנקות את כל %d שורות כותרות הסקר השאריות? ודא שקיים גיבוי מלא של מסד הנתונים לפני שתמשיך.',
	'AP_CLEANUP_CONFIRM_EMPTY_WRAPPERS' => 'לנקות %d עטיפות ריקות של כותרות סקר ב־phpBB? רק poll_title ישתנה; אפשרויות הסקר, ההצבעות ושדות הזמן יישמרו.',
	'AP_CLEANUP_RESULT' => 'נוקו %d שורות נושאים שאריות.',
	'AP_CLEANUP_RESULT_DETAIL' => 'נוקו %1$d שורות נושאים שאריות. %2$d שורות דולגו כי הן מכילות כעת אפשרויות או הצבעות, או שאין להן עוד כותרת שארית.',
	'AP_CLEANUP_EMPTY_WRAPPERS_RESULT' => 'נוקו %d עטיפות ריקות של כותרות סקר ב־phpBB. אפשרויות הסקר, ההצבעות ושדות הזמן נשמרו.',
	'AP_CLEANUP_PROGRESS_TITLE' => 'ניקוי בתהליך',
	'AP_CLEANUP_PROGRESS_EXPLAIN' => 'נתוני סקר שאריים מנוקים במנות בטוחות של %d נושאים. העמוד מתקדם אוטומטית; אם הוא נקטע, טען מחדש את עמוד ההתקדמות האחרון כדי להמשיך.',
	'AP_CLEANUP_PROGRESS' => 'נבדקו %1$d מתוך %2$d שורות מועמדות; נוקו %3$d שורות.',
	'AP_CLEANUP_CONTINUE' => 'המשך בניקוי',
));
