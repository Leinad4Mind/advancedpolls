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
	'AP_CLEANUP_TITLE' => 'Opschonen van pollgegevens',
	'AP_CLEANUP_EXPLAIN' => 'Controleer elk onderwerp met pollmetadata of pollopties. Alleen achtergebleven titels zonder enige optie kunnen automatisch worden opgeschoond; dubbelzinnige rijen blijven alleen-lezen voor handmatige controle.',
	'AP_CLEANUP_BACKUP_WARNING' => 'Maak een volledige databaseback-up voordat u opschoont. De bewerking wist achtergebleven pollmetadata uit de geselecteerde onderwerprijen en kan ontbrekende pollopties niet herstellen.',
	'AP_CLEANUP_SUMMARY' => 'Integriteitsoverzicht',
	'AP_CLEANUP_MARKED_TOTAL' => 'Onderwerpen geteld volgens de oude regel die alleen naar de titel keek',
	'AP_CLEANUP_VALID_TOTAL' => 'Geldige polls',
	'AP_CLEANUP_RESIDUAL_TOTAL' => 'Veilig op te schonen achtergebleven titels',
	'AP_CLEANUP_INCONSISTENT_TOTAL' => 'Rijen die handmatige controle vereisen',
	'AP_CLEANUP_EMPTY_WRAPPER_TOTAL' => 'Lege phpBB-titelomhulsels (&lt;t&gt;&lt;/t&gt;)',
	'AP_CLEANUP_ROWS' => 'rijen',
	'AP_CLEANUP_FILTER_CLEANABLE' => 'Achtergebleven titels',
	'AP_CLEANUP_FILTER_INCONSISTENT' => 'Handmatige controle',
	'AP_CLEANUP_FILTER_VALID' => 'Geldige polls',
	'AP_CLEANUP_FILTER_ALL' => 'Alle pollgegevens',
	'AP_CLEANUP_SELECT' => 'Selecteren',
	'AP_CLEANUP_TOPIC' => 'Onderwerp',
	'AP_CLEANUP_POLL_TITLE' => 'Ruwe polltitel',
	'AP_CLEANUP_TIMING' => 'Ruwe tijdgegevens',
	'AP_CLEANUP_OPTIONS' => 'Pollopties en totalen',
	'AP_CLEANUP_VOTES' => 'Stemrijen',
	'AP_CLEANUP_STATUS' => 'Integriteit',
	'AP_CLEANUP_EMPTY' => '(leeg)',
	'AP_CLEANUP_START' => 'poll_start',
	'AP_CLEANUP_LENGTH' => 'poll_length',
	'AP_CLEANUP_END' => 'Berekend einde',
	'AP_CLEANUP_SAVED_REMAINING' => 'opgeslagen resterende tijd',
	'AP_CLEANUP_SCHEDULED_START' => 'geplande start',
	'AP_CLEANUP_STATUS_CLEANABLE' => 'Achtergebleven titel; geen opties',
	'AP_CLEANUP_STATUS_INCONSISTENT' => 'Er zijn opties, maar de titel of start ontbreekt',
	'AP_CLEANUP_STATUS_VALID' => 'Geldige poll',
	'AP_CLEANUP_NO_ROWS' => 'Geen rijen komen overeen met dit filter.',
	'AP_CLEANUP_SELECT_PAGE' => 'Op te schonen rijen op deze pagina selecteren',
	'AP_CLEANUP_SELECTED' => 'Selectie opschonen',
	'AP_CLEANUP_ALL' => 'Alle achtergebleven titels opschonen',
	'AP_CLEANUP_EMPTY_WRAPPERS' => 'Lege phpBB-titelomhulsels opschonen',
	'AP_CLEANUP_NOTHING_SELECTED' => 'Er is geen op te schonen onderwerp geselecteerd.',
	'AP_CLEANUP_CONFIRM_SELECTED' => 'Achtergebleven pollmetadata uit de %d geselecteerde onderwerprijen opschonen?',
	'AP_CLEANUP_CONFIRM_ALL' => 'Alle %d rijen met achtergebleven polltitels opschonen? Controleer of er een volledige databaseback-up is voordat u verdergaat.',
	'AP_CLEANUP_CONFIRM_EMPTY_WRAPPERS' => '%d lege phpBB-polltitelomhulsels opschonen? Alleen poll_title wordt gewijzigd; pollopties, stemmen en tijdvelden blijven behouden.',
	'AP_CLEANUP_RESULT' => '%d achtergebleven onderwerprijen zijn opgeschoond.',
	'AP_CLEANUP_RESULT_DETAIL' => '%1$d achtergebleven onderwerprijen zijn opgeschoond. %2$d rijen zijn overgeslagen omdat ze nu opties of stemmen bevatten, of geen achtergebleven titel meer hebben.',
	'AP_CLEANUP_EMPTY_WRAPPERS_RESULT' => '%d lege phpBB-polltitelomhulsels zijn opgeschoond. Pollopties, stemmen en tijdvelden zijn behouden.',
	'AP_CLEANUP_PROGRESS_TITLE' => 'Opschonen bezig',
	'AP_CLEANUP_PROGRESS_EXPLAIN' => 'Achtergebleven pollgegevens worden opgeschoond in veilige batches van %d onderwerpen. Deze pagina gaat automatisch verder; als ze wordt onderbroken, laad dan de laatste voortgangspagina opnieuw om verder te gaan.',
	'AP_CLEANUP_PROGRESS' => '%1$d van %2$d kandidaatrijen gecontroleerd; %3$d rijen opgeschoond.',
	'AP_CLEANUP_CONTINUE' => 'Opschonen voortzetten',
));
