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
	'AP_CLEANUP_TITLE' => 'Oprydning af afstemningsdata',
	'AP_CLEANUP_EXPLAIN' => 'Gennemgå alle emner med afstemningsmetadata eller afstemningsmuligheder. Kun resterende titler uden nogen mulighed kan ryddes op automatisk; tvetydige rækker er skrivebeskyttede og skal gennemgås manuelt.',
	'AP_CLEANUP_BACKUP_WARNING' => 'Tag en fuld sikkerhedskopi af databasen før oprydningen. Handlingen fjerner resterende afstemningsmetadata fra de valgte emnerækker og kan ikke genskabe manglende afstemningsmuligheder.',
	'AP_CLEANUP_SUMMARY' => 'Integritetsoversigt',
	'AP_CLEANUP_MARKED_TOTAL' => 'Emner talt efter den gamle regel, der kun så på titlen',
	'AP_CLEANUP_VALID_TOTAL' => 'Gyldige afstemninger',
	'AP_CLEANUP_RESIDUAL_TOTAL' => 'Resterende titler, der sikkert kan ryddes op',
	'AP_CLEANUP_INCONSISTENT_TOTAL' => 'Rækker, der kræver manuel gennemgang',
	'AP_CLEANUP_EMPTY_WRAPPER_TOTAL' => 'Tomme phpBB-titelindpakninger (&lt;t&gt;&lt;/t&gt;)',
	'AP_CLEANUP_ROWS' => 'rækker',
	'AP_CLEANUP_FILTER_CLEANABLE' => 'Resterende titler',
	'AP_CLEANUP_FILTER_INCONSISTENT' => 'Manuel gennemgang',
	'AP_CLEANUP_FILTER_VALID' => 'Gyldige afstemninger',
	'AP_CLEANUP_FILTER_ALL' => 'Alle afstemningsdata',
	'AP_CLEANUP_SELECT' => 'Vælg',
	'AP_CLEANUP_TOPIC' => 'Emne',
	'AP_CLEANUP_POLL_TITLE' => 'Rå afstemningstitel',
	'AP_CLEANUP_TIMING' => 'Rå tidsdata',
	'AP_CLEANUP_OPTIONS' => 'Afstemningsmuligheder og totaler',
	'AP_CLEANUP_VOTES' => 'Stemmerækker',
	'AP_CLEANUP_STATUS' => 'Integritet',
	'AP_CLEANUP_EMPTY' => '(tom)',
	'AP_CLEANUP_START' => 'poll_start',
	'AP_CLEANUP_LENGTH' => 'poll_length',
	'AP_CLEANUP_END' => 'Beregnet slutning',
	'AP_CLEANUP_SAVED_REMAINING' => 'gemt resterende tid',
	'AP_CLEANUP_SCHEDULED_START' => 'planlagt start',
	'AP_CLEANUP_STATUS_CLEANABLE' => 'Resterende titel; ingen muligheder',
	'AP_CLEANUP_STATUS_INCONSISTENT' => 'Der findes muligheder, men titel eller start mangler',
	'AP_CLEANUP_STATUS_VALID' => 'Gyldig afstemning',
	'AP_CLEANUP_NO_ROWS' => 'Ingen rækker matcher dette filter.',
	'AP_CLEANUP_SELECT_PAGE' => 'Vælg rækker, der kan ryddes op, på denne side',
	'AP_CLEANUP_SELECTED' => 'Ryd op i valgte',
	'AP_CLEANUP_ALL' => 'Ryd op i alle resterende titler',
	'AP_CLEANUP_EMPTY_WRAPPERS' => 'Ryd op i tomme phpBB-titelindpakninger',
	'AP_CLEANUP_NOTHING_SELECTED' => 'Der blev ikke valgt noget emne, der kan ryddes op.',
	'AP_CLEANUP_CONFIRM_SELECTED' => 'Ryd op i resterende afstemningsmetadata i de %d valgte emnerækker?',
	'AP_CLEANUP_CONFIRM_ALL' => 'Ryd op i alle %d rækker med resterende afstemningstitler? Bekræft, at der findes en fuld sikkerhedskopi af databasen, før du fortsætter.',
	'AP_CLEANUP_CONFIRM_EMPTY_WRAPPERS' => 'Ryd op i %d tomme phpBB-afstemningstitelindpakninger? Kun poll_title ændres; afstemningsmuligheder, stemmer og tidsfelter bevares.',
	'AP_CLEANUP_RESULT' => '%d resterende emnerækker blev ryddet op.',
	'AP_CLEANUP_RESULT_DETAIL' => '%1$d resterende emnerækker blev ryddet op. %2$d rækker blev sprunget over, fordi de nu indeholder muligheder eller stemmer eller ikke længere har en resterende titel.',
	'AP_CLEANUP_EMPTY_WRAPPERS_RESULT' => '%d tomme phpBB-afstemningstitelindpakninger blev ryddet op. Afstemningsmuligheder, stemmer og tidsfelter blev bevaret.',
	'AP_CLEANUP_PROGRESS_TITLE' => 'Oprydning i gang',
	'AP_CLEANUP_PROGRESS_EXPLAIN' => 'Resterende afstemningsdata ryddes op i sikre portioner på %d emner. Siden fortsætter automatisk; hvis den afbrydes, så genindlæs den seneste statusside for at fortsætte.',
	'AP_CLEANUP_PROGRESS' => '%1$d af %2$d kandidatrækker gennemgået; %3$d rækker ryddet op.',
	'AP_CLEANUP_CONTINUE' => 'Fortsæt oprydningen',
));
