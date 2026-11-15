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
	'AP_CLEANUP_TITLE' => 'Pulizia dei dati dei sondaggi',
	'AP_CLEANUP_EXPLAIN' => 'Esamina ogni argomento che contiene metadati o opzioni di sondaggio. Solo i titoli residui senza alcuna opzione possono essere puliti automaticamente; le righe ambigue restano in sola lettura per la revisione manuale.',
	'AP_CLEANUP_BACKUP_WARNING' => 'Crea un backup completo del database prima della pulizia. L’operazione rimuove i metadati residui del sondaggio dalle righe degli argomenti selezionati e non può ricostruire le opzioni di sondaggio mancanti.',
	'AP_CLEANUP_SUMMARY' => 'Riepilogo dell’integrità',
	'AP_CLEANUP_MARKED_TOTAL' => 'Argomenti contati dalla vecchia regola basata solo sul titolo',
	'AP_CLEANUP_VALID_TOTAL' => 'Sondaggi validi',
	'AP_CLEANUP_RESIDUAL_TOTAL' => 'Titoli residui pulibili in sicurezza',
	'AP_CLEANUP_INCONSISTENT_TOTAL' => 'Righe che richiedono una revisione manuale',
	'AP_CLEANUP_EMPTY_WRAPPER_TOTAL' => 'Contenitori di titolo phpBB vuoti (&lt;t&gt;&lt;/t&gt;)',
	'AP_CLEANUP_ROWS' => 'righe',
	'AP_CLEANUP_FILTER_CLEANABLE' => 'Titoli residui',
	'AP_CLEANUP_FILTER_INCONSISTENT' => 'Revisione manuale',
	'AP_CLEANUP_FILTER_VALID' => 'Sondaggi validi',
	'AP_CLEANUP_FILTER_ALL' => 'Tutti i dati dei sondaggi',
	'AP_CLEANUP_SELECT' => 'Seleziona',
	'AP_CLEANUP_TOPIC' => 'Argomento',
	'AP_CLEANUP_POLL_TITLE' => 'Titolo grezzo del sondaggio',
	'AP_CLEANUP_TIMING' => 'Dati temporali grezzi',
	'AP_CLEANUP_OPTIONS' => 'Opzioni del sondaggio e totali',
	'AP_CLEANUP_VOTES' => 'Righe dei voti',
	'AP_CLEANUP_STATUS' => 'Integrità',
	'AP_CLEANUP_EMPTY' => '(vuoto)',
	'AP_CLEANUP_START' => 'poll_start',
	'AP_CLEANUP_LENGTH' => 'poll_length',
	'AP_CLEANUP_END' => 'Fine calcolata',
	'AP_CLEANUP_SAVED_REMAINING' => 'tempo residuo salvato',
	'AP_CLEANUP_SCHEDULED_START' => 'inizio programmato',
	'AP_CLEANUP_STATUS_CLEANABLE' => 'Titolo residuo; nessuna opzione',
	'AP_CLEANUP_STATUS_INCONSISTENT' => 'Esistono opzioni, ma manca il titolo o l’inizio',
	'AP_CLEANUP_STATUS_VALID' => 'Sondaggio valido',
	'AP_CLEANUP_NO_ROWS' => 'Nessuna riga corrisponde a questo filtro.',
	'AP_CLEANUP_SELECT_PAGE' => 'Seleziona le righe pulibili in questa pagina',
	'AP_CLEANUP_SELECTED' => 'Pulisci i selezionati',
	'AP_CLEANUP_ALL' => 'Pulisci tutti i titoli residui',
	'AP_CLEANUP_EMPTY_WRAPPERS' => 'Pulisci i contenitori di titolo phpBB vuoti',
	'AP_CLEANUP_NOTHING_SELECTED' => 'Non è stato selezionato alcun argomento pulibile.',
	'AP_CLEANUP_CONFIRM_SELECTED' => 'Pulire i metadati residui del sondaggio dalle %d righe di argomenti selezionate?',
	'AP_CLEANUP_CONFIRM_ALL' => 'Pulire tutte le %d righe con titoli di sondaggio residui? Verifica che esista un backup completo del database prima di continuare.',
	'AP_CLEANUP_CONFIRM_EMPTY_WRAPPERS' => 'Pulire %d contenitori vuoti di titoli di sondaggio phpBB? Verrà modificato solo poll_title; opzioni, voti e campi temporali del sondaggio saranno conservati.',
	'AP_CLEANUP_RESULT' => 'Sono state pulite %d righe di argomenti residue.',
	'AP_CLEANUP_RESULT_DETAIL' => 'Sono state pulite %1$d righe di argomenti residue. %2$d righe sono state saltate perché ora contengono opzioni o voti, oppure non hanno più un titolo residuo.',
	'AP_CLEANUP_EMPTY_WRAPPERS_RESULT' => 'Sono stati puliti %d contenitori vuoti di titoli di sondaggio phpBB. Opzioni, voti e campi temporali del sondaggio sono stati conservati.',
	'AP_CLEANUP_PROGRESS_TITLE' => 'Pulizia in corso',
	'AP_CLEANUP_PROGRESS_EXPLAIN' => 'I dati residui dei sondaggi vengono puliti in blocchi sicuri di %d argomenti. Questa pagina avanza automaticamente; se viene interrotta, ricarica l’ultima pagina di avanzamento per riprendere.',
	'AP_CLEANUP_PROGRESS' => '%1$d di %2$d righe candidate esaminate; %3$d righe pulite.',
	'AP_CLEANUP_CONTINUE' => 'Continua la pulizia',
));
