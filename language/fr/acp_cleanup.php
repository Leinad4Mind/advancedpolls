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
	'AP_CLEANUP_TITLE' => 'Nettoyage des données de sondage',
	'AP_CLEANUP_EXPLAIN' => 'Inspectez chaque sujet contenant des métadonnées ou des options de sondage. Seuls les titres résiduels sans aucune option peuvent être nettoyés automatiquement ; les lignes ambiguës restent en lecture seule pour un examen manuel.',
	'AP_CLEANUP_BACKUP_WARNING' => 'Créez une sauvegarde complète de la base de données avant le nettoyage. L’opération efface les métadonnées résiduelles de sondage des lignes de sujets sélectionnées et ne peut pas reconstruire les options de sondage manquantes.',
	'AP_CLEANUP_SUMMARY' => 'Résumé de l’intégrité',
	'AP_CLEANUP_MARKED_TOTAL' => 'Sujets comptés par l’ancienne règle fondée uniquement sur le titre',
	'AP_CLEANUP_VALID_TOTAL' => 'Sondages valides',
	'AP_CLEANUP_RESIDUAL_TOTAL' => 'Titres résiduels pouvant être nettoyés sans risque',
	'AP_CLEANUP_INCONSISTENT_TOTAL' => 'Lignes nécessitant un examen manuel',
	'AP_CLEANUP_EMPTY_WRAPPER_TOTAL' => 'Enveloppes de titre phpBB vides (&lt;t&gt;&lt;/t&gt;)',
	'AP_CLEANUP_ROWS' => 'lignes',
	'AP_CLEANUP_FILTER_CLEANABLE' => 'Titres résiduels',
	'AP_CLEANUP_FILTER_INCONSISTENT' => 'Examen manuel',
	'AP_CLEANUP_FILTER_VALID' => 'Sondages valides',
	'AP_CLEANUP_FILTER_ALL' => 'Toutes les données de sondage',
	'AP_CLEANUP_SELECT' => 'Sélectionner',
	'AP_CLEANUP_TOPIC' => 'Sujet',
	'AP_CLEANUP_POLL_TITLE' => 'Titre brut du sondage',
	'AP_CLEANUP_TIMING' => 'Données temporelles brutes',
	'AP_CLEANUP_OPTIONS' => 'Options du sondage et totaux',
	'AP_CLEANUP_VOTES' => 'Lignes de votes',
	'AP_CLEANUP_STATUS' => 'Intégrité',
	'AP_CLEANUP_EMPTY' => '(vide)',
	'AP_CLEANUP_START' => 'poll_start',
	'AP_CLEANUP_LENGTH' => 'poll_length',
	'AP_CLEANUP_END' => 'Fin calculée',
	'AP_CLEANUP_SAVED_REMAINING' => 'restant enregistré',
	'AP_CLEANUP_SCHEDULED_START' => 'début programmé',
	'AP_CLEANUP_STATUS_CLEANABLE' => 'Titre résiduel ; aucune option',
	'AP_CLEANUP_STATUS_INCONSISTENT' => 'Des options existent, mais le titre ou le début manque',
	'AP_CLEANUP_STATUS_VALID' => 'Sondage valide',
	'AP_CLEANUP_NO_ROWS' => 'Aucune ligne ne correspond à ce filtre.',
	'AP_CLEANUP_SELECT_PAGE' => 'Sélectionner les lignes nettoyables de cette page',
	'AP_CLEANUP_SELECTED' => 'Nettoyer la sélection',
	'AP_CLEANUP_ALL' => 'Nettoyer tous les titres résiduels',
	'AP_CLEANUP_EMPTY_WRAPPERS' => 'Nettoyer les enveloppes de titre phpBB vides',
	'AP_CLEANUP_NOTHING_SELECTED' => 'Aucun sujet nettoyable n’a été sélectionné.',
	'AP_CLEANUP_CONFIRM_SELECTED' => 'Nettoyer les métadonnées résiduelles de sondage des %d lignes de sujets sélectionnées ?',
	'AP_CLEANUP_CONFIRM_ALL' => 'Nettoyer les %d lignes de titres de sondage résiduels ? Vérifiez qu’une sauvegarde complète de la base de données existe avant de continuer.',
	'AP_CLEANUP_CONFIRM_EMPTY_WRAPPERS' => 'Nettoyer %d enveloppes de titre de sondage phpBB vides ? Seul poll_title sera modifié ; les options, les votes et les champs temporels du sondage seront conservés.',
	'AP_CLEANUP_RESULT' => '%d lignes de sujets résiduelles ont été nettoyées.',
	'AP_CLEANUP_RESULT_DETAIL' => '%1$d lignes de sujets résiduelles ont été nettoyées. %2$d lignes ont été ignorées, car elles contiennent désormais des options ou des votes, ou n’ont plus de titre résiduel.',
	'AP_CLEANUP_EMPTY_WRAPPERS_RESULT' => '%d enveloppes de titre de sondage phpBB vides ont été nettoyées. Les options, les votes et les champs temporels du sondage ont été conservés.',
	'AP_CLEANUP_PROGRESS_TITLE' => 'Nettoyage en cours',
	'AP_CLEANUP_PROGRESS_EXPLAIN' => 'Les données de sondage résiduelles sont nettoyées par lots sûrs de %d sujets. Cette page avance automatiquement ; si elle est interrompue, rechargez la dernière page de progression pour reprendre.',
	'AP_CLEANUP_PROGRESS' => '%1$d lignes candidates sur %2$d inspectées ; %3$d lignes nettoyées.',
	'AP_CLEANUP_CONTINUE' => 'Poursuivre le nettoyage',
));
