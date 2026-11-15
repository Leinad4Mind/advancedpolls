<?php

/**
 *
 * Advanced Polls ACP cleanup language
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'AP_CLEANUP_TITLE' => 'Limpeza de dados de votações',
	'AP_CLEANUP_EXPLAIN' => 'Inspeciona todos os tópicos com metadados ou opções de votação. Só os títulos residuais sem nenhuma opção podem ser limpos automaticamente; as linhas ambíguas ficam só de leitura, para revisão manual.',
	'AP_CLEANUP_BACKUP_WARNING' => 'Cria uma cópia de segurança completa da base de dados antes de limpar. A operação apaga os metadados residuais de votação das linhas de tópicos selecionadas e não consegue reconstruir opções de votação em falta.',
	'AP_CLEANUP_SUMMARY' => 'Resumo da integridade',
	'AP_CLEANUP_MARKED_TOTAL' => 'Tópicos contados pela antiga regra baseada só no título',
	'AP_CLEANUP_VALID_TOTAL' => 'Votações válidas',
	'AP_CLEANUP_RESIDUAL_TOTAL' => 'Títulos residuais que podem ser limpos em segurança',
	'AP_CLEANUP_INCONSISTENT_TOTAL' => 'Linhas que precisam de revisão manual',
	'AP_CLEANUP_EMPTY_WRAPPER_TOTAL' => 'Invólucros de título vazios do phpBB (&lt;t&gt;&lt;/t&gt;)',
	'AP_CLEANUP_ROWS' => 'linhas',
	'AP_CLEANUP_FILTER_CLEANABLE' => 'Títulos residuais',
	'AP_CLEANUP_FILTER_INCONSISTENT' => 'Revisão manual',
	'AP_CLEANUP_FILTER_VALID' => 'Votações válidas',
	'AP_CLEANUP_FILTER_ALL' => 'Todos os dados de votações',
	'AP_CLEANUP_SELECT' => 'Selecionar',
	'AP_CLEANUP_TOPIC' => 'Tópico',
	'AP_CLEANUP_POLL_TITLE' => 'Título da votação em bruto',
	'AP_CLEANUP_TIMING' => 'Dados de tempo em bruto',
	'AP_CLEANUP_OPTIONS' => 'Opções da votação e totais',
	'AP_CLEANUP_VOTES' => 'Linhas de votos',
	'AP_CLEANUP_STATUS' => 'Integridade',
	'AP_CLEANUP_EMPTY' => '(vazio)',
	'AP_CLEANUP_START' => 'poll_start',
	'AP_CLEANUP_LENGTH' => 'poll_length',
	'AP_CLEANUP_END' => 'Fim calculado',
	'AP_CLEANUP_SAVED_REMAINING' => 'restante guardado',
	'AP_CLEANUP_SCHEDULED_START' => 'início agendado',
	'AP_CLEANUP_STATUS_CLEANABLE' => 'Título residual; sem opções',
	'AP_CLEANUP_STATUS_INCONSISTENT' => 'Existem opções, mas falta o título ou o início',
	'AP_CLEANUP_STATUS_VALID' => 'Votação válida',
	'AP_CLEANUP_NO_ROWS' => 'Nenhuma linha corresponde a este filtro.',
	'AP_CLEANUP_SELECT_PAGE' => 'Selecionar as linhas que podem ser limpas nesta página',
	'AP_CLEANUP_SELECTED' => 'Limpar selecionados',
	'AP_CLEANUP_ALL' => 'Limpar todos os títulos residuais',
	'AP_CLEANUP_EMPTY_WRAPPERS' => 'Limpar os invólucros de título vazios do phpBB',
	'AP_CLEANUP_NOTHING_SELECTED' => 'Não foi selecionado nenhum tópico que possa ser limpo.',
	'AP_CLEANUP_CONFIRM_SELECTED' => 'Limpar os metadados residuais de votação das %d linhas de tópicos selecionadas?',
	'AP_CLEANUP_CONFIRM_ALL' => 'Limpar todas as %d linhas de títulos residuais de votação? Confirma que existe uma cópia de segurança completa da base de dados antes de continuar.',
	'AP_CLEANUP_CONFIRM_EMPTY_WRAPPERS' => 'Limpar %d invólucros vazios de títulos de votação do phpBB? Só o poll_title é alterado; as opções, os votos e os campos de tempo da votação ficam intactos.',
	'AP_CLEANUP_RESULT' => 'Foram limpas %d linhas de tópicos residuais.',
	'AP_CLEANUP_RESULT_DETAIL' => 'Foram limpas %1$d linhas de tópicos residuais. %2$d linhas foram ignoradas porque agora têm opções ou votos, ou já não têm um título residual.',
	'AP_CLEANUP_EMPTY_WRAPPERS_RESULT' => 'Foram limpos %d invólucros vazios de títulos de votação do phpBB. As opções, os votos e os campos de tempo da votação ficaram intactos.',
	'AP_CLEANUP_PROGRESS_TITLE' => 'Limpeza em curso',
	'AP_CLEANUP_PROGRESS_EXPLAIN' => 'Os dados residuais de votações estão a ser limpos em lotes seguros de %d tópicos. Esta página avança sozinha; se for interrompida, volta a carregar a última página de progresso para retomar.',
	'AP_CLEANUP_PROGRESS' => '%1$d de %2$d linhas candidatas inspecionadas; %3$d linhas limpas.',
	'AP_CLEANUP_CONTINUE' => 'Continuar a limpeza',
));
