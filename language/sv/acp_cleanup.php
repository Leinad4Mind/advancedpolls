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
	'AP_CLEANUP_TITLE' => 'Rensning av omröstningsdata',
	'AP_CLEANUP_EXPLAIN' => 'Granska varje ämne som innehåller omröstningsmetadata eller omröstningsalternativ. Endast kvarvarande titlar utan något alternativ kan rensas automatiskt; tvetydiga rader förblir skrivskyddade för manuell granskning.',
	'AP_CLEANUP_BACKUP_WARNING' => 'Gör en fullständig säkerhetskopia av databasen innan du rensar. Åtgärden tar bort kvarvarande omröstningsmetadata från de valda ämnesraderna och kan inte återskapa saknade omröstningsalternativ.',
	'AP_CLEANUP_SUMMARY' => 'Integritetssammanfattning',
	'AP_CLEANUP_MARKED_TOTAL' => 'Ämnen räknade enligt den gamla regeln som bara såg på titeln',
	'AP_CLEANUP_VALID_TOTAL' => 'Giltiga omröstningar',
	'AP_CLEANUP_RESIDUAL_TOTAL' => 'Kvarvarande titlar som kan rensas säkert',
	'AP_CLEANUP_INCONSISTENT_TOTAL' => 'Rader som kräver manuell granskning',
	'AP_CLEANUP_EMPTY_WRAPPER_TOTAL' => 'Tomma phpBB-titelomslag (&lt;t&gt;&lt;/t&gt;)',
	'AP_CLEANUP_ROWS' => 'rader',
	'AP_CLEANUP_FILTER_CLEANABLE' => 'Kvarvarande titlar',
	'AP_CLEANUP_FILTER_INCONSISTENT' => 'Manuell granskning',
	'AP_CLEANUP_FILTER_VALID' => 'Giltiga omröstningar',
	'AP_CLEANUP_FILTER_ALL' => 'Alla omröstningsdata',
	'AP_CLEANUP_SELECT' => 'Välj',
	'AP_CLEANUP_TOPIC' => 'Ämne',
	'AP_CLEANUP_POLL_TITLE' => 'Rå omröstningstitel',
	'AP_CLEANUP_TIMING' => 'Råa tidsdata',
	'AP_CLEANUP_OPTIONS' => 'Omröstningsalternativ och summor',
	'AP_CLEANUP_VOTES' => 'Röstrader',
	'AP_CLEANUP_STATUS' => 'Integritet',
	'AP_CLEANUP_EMPTY' => '(tom)',
	'AP_CLEANUP_START' => 'poll_start',
	'AP_CLEANUP_LENGTH' => 'poll_length',
	'AP_CLEANUP_END' => 'Beräknat slut',
	'AP_CLEANUP_SAVED_REMAINING' => 'sparad återstående tid',
	'AP_CLEANUP_SCHEDULED_START' => 'schemalagd start',
	'AP_CLEANUP_STATUS_CLEANABLE' => 'Kvarvarande titel; inga alternativ',
	'AP_CLEANUP_STATUS_INCONSISTENT' => 'Alternativ finns, men titel eller start saknas',
	'AP_CLEANUP_STATUS_VALID' => 'Giltig omröstning',
	'AP_CLEANUP_NO_ROWS' => 'Inga rader matchar detta filter.',
	'AP_CLEANUP_SELECT_PAGE' => 'Välj rader som kan rensas på denna sida',
	'AP_CLEANUP_SELECTED' => 'Rensa valda',
	'AP_CLEANUP_ALL' => 'Rensa alla kvarvarande titlar',
	'AP_CLEANUP_EMPTY_WRAPPERS' => 'Rensa tomma phpBB-titelomslag',
	'AP_CLEANUP_NOTHING_SELECTED' => 'Inget ämne som kan rensas har valts.',
	'AP_CLEANUP_CONFIRM_SELECTED' => 'Rensa kvarvarande omröstningsmetadata från de %d valda ämnesraderna?',
	'AP_CLEANUP_CONFIRM_ALL' => 'Rensa alla %d rader med kvarvarande omröstningstitlar? Bekräfta att det finns en fullständig säkerhetskopia av databasen innan du fortsätter.',
	'AP_CLEANUP_CONFIRM_EMPTY_WRAPPERS' => 'Rensa %d tomma phpBB-omröstningstitelomslag? Endast poll_title ändras; omröstningsalternativ, röster och tidsfält bevaras.',
	'AP_CLEANUP_RESULT' => '%d kvarvarande ämnesrader har rensats.',
	'AP_CLEANUP_RESULT_DETAIL' => '%1$d kvarvarande ämnesrader har rensats. %2$d rader hoppades över eftersom de nu innehåller alternativ eller röster, eller inte längre har en kvarvarande titel.',
	'AP_CLEANUP_EMPTY_WRAPPERS_RESULT' => '%d tomma phpBB-omröstningstitelomslag har rensats. Omröstningsalternativ, röster och tidsfält bevarades.',
	'AP_CLEANUP_PROGRESS_TITLE' => 'Rensning pågår',
	'AP_CLEANUP_PROGRESS_EXPLAIN' => 'Kvarvarande omröstningsdata rensas i säkra omgångar om %d ämnen. Sidan fortsätter automatiskt; om den avbryts, ladda om den senaste förloppssidan för att återuppta.',
	'AP_CLEANUP_PROGRESS' => '%1$d av %2$d kandidatrader granskade; %3$d rader rensade.',
	'AP_CLEANUP_CONTINUE' => 'Fortsätt rensningen',
));
