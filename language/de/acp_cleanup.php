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
	'AP_CLEANUP_TITLE' => 'Bereinigung der Umfragedaten',
	'AP_CLEANUP_EXPLAIN' => 'Prüfe jedes Thema, das Umfrage-Metadaten oder Umfrageoptionen enthält. Nur Resttitel ohne jegliche Option können automatisch bereinigt werden; mehrdeutige Zeilen bleiben schreibgeschützt und müssen manuell geprüft werden.',
	'AP_CLEANUP_BACKUP_WARNING' => 'Erstelle vor der Bereinigung eine vollständige Datenbanksicherung. Der Vorgang entfernt verbliebene Umfrage-Metadaten aus den ausgewählten Themenzeilen und kann fehlende Umfrageoptionen nicht wiederherstellen.',
	'AP_CLEANUP_SUMMARY' => 'Integritätsübersicht',
	'AP_CLEANUP_MARKED_TOTAL' => 'Themen, die nach der alten Nur-Titel-Regel gezählt wurden',
	'AP_CLEANUP_VALID_TOTAL' => 'Gültige Umfragen',
	'AP_CLEANUP_RESIDUAL_TOTAL' => 'Sicher bereinigbare Resttitel',
	'AP_CLEANUP_INCONSISTENT_TOTAL' => 'Zeilen, die eine manuelle Prüfung erfordern',
	'AP_CLEANUP_EMPTY_WRAPPER_TOTAL' => 'Leere phpBB-Titelhüllen (&lt;t&gt;&lt;/t&gt;)',
	'AP_CLEANUP_ROWS' => 'Zeilen',
	'AP_CLEANUP_FILTER_CLEANABLE' => 'Resttitel',
	'AP_CLEANUP_FILTER_INCONSISTENT' => 'Manuelle Prüfung',
	'AP_CLEANUP_FILTER_VALID' => 'Gültige Umfragen',
	'AP_CLEANUP_FILTER_ALL' => 'Alle Umfragedaten',
	'AP_CLEANUP_SELECT' => 'Auswählen',
	'AP_CLEANUP_TOPIC' => 'Thema',
	'AP_CLEANUP_POLL_TITLE' => 'Roher Umfragetitel',
	'AP_CLEANUP_TIMING' => 'Rohe Zeitdaten',
	'AP_CLEANUP_OPTIONS' => 'Umfrageoptionen und Summen',
	'AP_CLEANUP_VOTES' => 'Stimmzeilen',
	'AP_CLEANUP_STATUS' => 'Integrität',
	'AP_CLEANUP_EMPTY' => '(leer)',
	'AP_CLEANUP_START' => 'poll_start',
	'AP_CLEANUP_LENGTH' => 'poll_length',
	'AP_CLEANUP_END' => 'Berechnetes Ende',
	'AP_CLEANUP_SAVED_REMAINING' => 'gespeicherte Restzeit',
	'AP_CLEANUP_SCHEDULED_START' => 'geplanter Start',
	'AP_CLEANUP_STATUS_CLEANABLE' => 'Resttitel; keine Optionen',
	'AP_CLEANUP_STATUS_INCONSISTENT' => 'Optionen vorhanden, aber Titel oder Start fehlt',
	'AP_CLEANUP_STATUS_VALID' => 'Gültige Umfrage',
	'AP_CLEANUP_NO_ROWS' => 'Keine Zeile entspricht diesem Filter.',
	'AP_CLEANUP_SELECT_PAGE' => 'Bereinigbare Zeilen auf dieser Seite auswählen',
	'AP_CLEANUP_SELECTED' => 'Auswahl bereinigen',
	'AP_CLEANUP_ALL' => 'Alle Resttitel bereinigen',
	'AP_CLEANUP_EMPTY_WRAPPERS' => 'Leere phpBB-Titelhüllen bereinigen',
	'AP_CLEANUP_NOTHING_SELECTED' => 'Es wurde kein bereinigbares Thema ausgewählt.',
	'AP_CLEANUP_CONFIRM_SELECTED' => 'Verbliebene Umfrage-Metadaten aus den %d ausgewählten Themenzeilen bereinigen?',
	'AP_CLEANUP_CONFIRM_ALL' => 'Alle %d Zeilen mit Umfrage-Resttiteln bereinigen? Stelle vor dem Fortfahren sicher, dass eine vollständige Datenbanksicherung vorhanden ist.',
	'AP_CLEANUP_CONFIRM_EMPTY_WRAPPERS' => '%d leere phpBB-Umfragetitelhüllen bereinigen? Nur poll_title wird geändert; Umfrageoptionen, Stimmen und Zeitfelder bleiben erhalten.',
	'AP_CLEANUP_RESULT' => '%d Themenzeilen mit Restdaten wurden bereinigt.',
	'AP_CLEANUP_RESULT_DETAIL' => '%1$d Themenzeilen mit Restdaten wurden bereinigt. %2$d Zeilen wurden übersprungen, weil sie inzwischen Optionen oder Stimmen enthalten oder keinen Resttitel mehr haben.',
	'AP_CLEANUP_EMPTY_WRAPPERS_RESULT' => '%d leere phpBB-Umfragetitelhüllen wurden bereinigt. Umfrageoptionen, Stimmen und Zeitfelder blieben erhalten.',
	'AP_CLEANUP_PROGRESS_TITLE' => 'Bereinigung läuft',
	'AP_CLEANUP_PROGRESS_EXPLAIN' => 'Verbliebene Umfragedaten werden in sicheren Paketen von je %d Themen bereinigt. Diese Seite läuft automatisch weiter; falls sie unterbrochen wird, lade die letzte Fortschrittsseite neu, um fortzufahren.',
	'AP_CLEANUP_PROGRESS' => '%1$d von %2$d Kandidatenzeilen geprüft; %3$d Zeilen bereinigt.',
	'AP_CLEANUP_CONTINUE' => 'Bereinigung fortsetzen',
));
