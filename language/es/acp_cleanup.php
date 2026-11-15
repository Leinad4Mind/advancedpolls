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
	'AP_CLEANUP_TITLE' => 'Limpieza de datos de encuestas',
	'AP_CLEANUP_EXPLAIN' => 'Inspecciona todos los temas que contienen metadatos u opciones de encuesta. Solo los títulos residuales sin ninguna opción se pueden limpiar automáticamente; las filas ambiguas quedan en solo lectura para su revisión manual.',
	'AP_CLEANUP_BACKUP_WARNING' => 'Haz una copia de seguridad completa de la base de datos antes de limpiar. La operación borra los metadatos residuales de encuesta de las filas de temas seleccionadas y no puede reconstruir las opciones de encuesta que falten.',
	'AP_CLEANUP_SUMMARY' => 'Resumen de integridad',
	'AP_CLEANUP_MARKED_TOTAL' => 'Temas contados por la antigua regla basada solo en el título',
	'AP_CLEANUP_VALID_TOTAL' => 'Encuestas válidas',
	'AP_CLEANUP_RESIDUAL_TOTAL' => 'Títulos residuales que se pueden limpiar con seguridad',
	'AP_CLEANUP_INCONSISTENT_TOTAL' => 'Filas que requieren revisión manual',
	'AP_CLEANUP_EMPTY_WRAPPER_TOTAL' => 'Envoltorios de título vacíos de phpBB (&lt;t&gt;&lt;/t&gt;)',
	'AP_CLEANUP_ROWS' => 'filas',
	'AP_CLEANUP_FILTER_CLEANABLE' => 'Títulos residuales',
	'AP_CLEANUP_FILTER_INCONSISTENT' => 'Revisión manual',
	'AP_CLEANUP_FILTER_VALID' => 'Encuestas válidas',
	'AP_CLEANUP_FILTER_ALL' => 'Todos los datos de encuestas',
	'AP_CLEANUP_SELECT' => 'Seleccionar',
	'AP_CLEANUP_TOPIC' => 'Tema',
	'AP_CLEANUP_POLL_TITLE' => 'Título de la encuesta sin procesar',
	'AP_CLEANUP_TIMING' => 'Datos de tiempo sin procesar',
	'AP_CLEANUP_OPTIONS' => 'Opciones de la encuesta y totales',
	'AP_CLEANUP_VOTES' => 'Filas de votos',
	'AP_CLEANUP_STATUS' => 'Integridad',
	'AP_CLEANUP_EMPTY' => '(vacío)',
	'AP_CLEANUP_START' => 'poll_start',
	'AP_CLEANUP_LENGTH' => 'poll_length',
	'AP_CLEANUP_END' => 'Fin calculado',
	'AP_CLEANUP_SAVED_REMAINING' => 'restante guardado',
	'AP_CLEANUP_SCHEDULED_START' => 'inicio programado',
	'AP_CLEANUP_STATUS_CLEANABLE' => 'Título residual; sin opciones',
	'AP_CLEANUP_STATUS_INCONSISTENT' => 'Hay opciones, pero falta el título o el inicio',
	'AP_CLEANUP_STATUS_VALID' => 'Encuesta válida',
	'AP_CLEANUP_NO_ROWS' => 'Ninguna fila coincide con este filtro.',
	'AP_CLEANUP_SELECT_PAGE' => 'Seleccionar las filas que se pueden limpiar en esta página',
	'AP_CLEANUP_SELECTED' => 'Limpiar seleccionados',
	'AP_CLEANUP_ALL' => 'Limpiar todos los títulos residuales',
	'AP_CLEANUP_EMPTY_WRAPPERS' => 'Limpiar los envoltorios de título vacíos de phpBB',
	'AP_CLEANUP_NOTHING_SELECTED' => 'No se seleccionó ningún tema que se pueda limpiar.',
	'AP_CLEANUP_CONFIRM_SELECTED' => '¿Limpiar los metadatos residuales de encuesta de las %d filas de temas seleccionadas?',
	'AP_CLEANUP_CONFIRM_ALL' => '¿Limpiar las %d filas de títulos residuales de encuesta? Confirma que existe una copia de seguridad completa de la base de datos antes de continuar.',
	'AP_CLEANUP_CONFIRM_EMPTY_WRAPPERS' => '¿Limpiar %d envoltorios vacíos de títulos de encuesta de phpBB? Solo se cambiará poll_title; las opciones, los votos y los campos de tiempo de la encuesta se conservarán.',
	'AP_CLEANUP_RESULT' => 'Se limpiaron %d filas de temas residuales.',
	'AP_CLEANUP_RESULT_DETAIL' => 'Se limpiaron %1$d filas de temas residuales. Se omitieron %2$d filas porque ahora contienen opciones o votos, o ya no tienen un título residual.',
	'AP_CLEANUP_EMPTY_WRAPPERS_RESULT' => 'Se limpiaron %d envoltorios vacíos de títulos de encuesta de phpBB. Las opciones, los votos y los campos de tiempo de la encuesta se conservaron.',
	'AP_CLEANUP_PROGRESS_TITLE' => 'Limpieza en curso',
	'AP_CLEANUP_PROGRESS_EXPLAIN' => 'Los datos residuales de encuestas se están limpiando en lotes seguros de %d temas. Esta página avanza sola; si se interrumpe, vuelve a cargar la última página de progreso para reanudar.',
	'AP_CLEANUP_PROGRESS' => '%1$d de %2$d filas candidatas inspeccionadas; %3$d filas limpiadas.',
	'AP_CLEANUP_CONTINUE' => 'Continuar la limpieza',
));
