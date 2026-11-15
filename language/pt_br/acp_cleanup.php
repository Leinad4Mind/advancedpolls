<?php

/**
 *
 * Advanced Polls ACP cleanup language
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'AP_CLEANUP_TITLE' => 'Limpeza de dados de enquetes',
	'AP_CLEANUP_EXPLAIN' => 'Inspecione todos os tópicos com metadados ou opções de enquete. Somente os títulos residuais sem nenhuma opção podem ser limpos automaticamente; as linhas ambíguas ficam somente para leitura, para revisão manual.',
	'AP_CLEANUP_BACKUP_WARNING' => 'Faça um backup completo do banco de dados antes de limpar. A operação remove os metadados residuais de enquete das linhas de tópicos selecionadas e não consegue reconstruir opções de enquete ausentes.',
	'AP_CLEANUP_SUMMARY' => 'Resumo de integridade',
	'AP_CLEANUP_MARKED_TOTAL' => 'Tópicos contados pela antiga regra baseada apenas no título',
	'AP_CLEANUP_VALID_TOTAL' => 'Enquetes válidas',
	'AP_CLEANUP_RESIDUAL_TOTAL' => 'Títulos residuais que podem ser limpos com segurança',
	'AP_CLEANUP_INCONSISTENT_TOTAL' => 'Linhas que precisam de revisão manual',
	'AP_CLEANUP_EMPTY_WRAPPER_TOTAL' => 'Invólucros de título vazios do phpBB (&lt;t&gt;&lt;/t&gt;)',
	'AP_CLEANUP_ROWS' => 'linhas',
	'AP_CLEANUP_FILTER_CLEANABLE' => 'Títulos residuais',
	'AP_CLEANUP_FILTER_INCONSISTENT' => 'Revisão manual',
	'AP_CLEANUP_FILTER_VALID' => 'Enquetes válidas',
	'AP_CLEANUP_FILTER_ALL' => 'Todos os dados de enquetes',
	'AP_CLEANUP_SELECT' => 'Selecionar',
	'AP_CLEANUP_TOPIC' => 'Tópico',
	'AP_CLEANUP_POLL_TITLE' => 'Título bruto da enquete',
	'AP_CLEANUP_TIMING' => 'Dados brutos de tempo',
	'AP_CLEANUP_OPTIONS' => 'Opções da enquete e totais',
	'AP_CLEANUP_VOTES' => 'Linhas de votos',
	'AP_CLEANUP_STATUS' => 'Integridade',
	'AP_CLEANUP_EMPTY' => '(vazio)',
	'AP_CLEANUP_START' => 'poll_start',
	'AP_CLEANUP_LENGTH' => 'poll_length',
	'AP_CLEANUP_END' => 'Término calculado',
	'AP_CLEANUP_SAVED_REMAINING' => 'restante salvo',
	'AP_CLEANUP_SCHEDULED_START' => 'início agendado',
	'AP_CLEANUP_STATUS_CLEANABLE' => 'Título residual; sem opções',
	'AP_CLEANUP_STATUS_INCONSISTENT' => 'Há opções, mas falta o título ou o início',
	'AP_CLEANUP_STATUS_VALID' => 'Enquete válida',
	'AP_CLEANUP_NO_ROWS' => 'Nenhuma linha corresponde a este filtro.',
	'AP_CLEANUP_SELECT_PAGE' => 'Selecionar as linhas que podem ser limpas nesta página',
	'AP_CLEANUP_SELECTED' => 'Limpar selecionados',
	'AP_CLEANUP_ALL' => 'Limpar todos os títulos residuais',
	'AP_CLEANUP_EMPTY_WRAPPERS' => 'Limpar os invólucros de título vazios do phpBB',
	'AP_CLEANUP_NOTHING_SELECTED' => 'Nenhum tópico que possa ser limpo foi selecionado.',
	'AP_CLEANUP_CONFIRM_SELECTED' => 'Limpar os metadados residuais de enquete das %d linhas de tópicos selecionadas?',
	'AP_CLEANUP_CONFIRM_ALL' => 'Limpar todas as %d linhas de títulos residuais de enquete? Confirme que existe um backup completo do banco de dados antes de continuar.',
	'AP_CLEANUP_CONFIRM_EMPTY_WRAPPERS' => 'Limpar %d invólucros vazios de títulos de enquete do phpBB? Somente o poll_title será alterado; as opções, os votos e os campos de tempo da enquete serão preservados.',
	'AP_CLEANUP_RESULT' => '%d linhas de tópicos residuais foram limpas.',
	'AP_CLEANUP_RESULT_DETAIL' => '%1$d linhas de tópicos residuais foram limpas. %2$d linhas foram ignoradas porque agora contêm opções ou votos, ou não têm mais um título residual.',
	'AP_CLEANUP_EMPTY_WRAPPERS_RESULT' => '%d invólucros vazios de títulos de enquete do phpBB foram limpos. As opções, os votos e os campos de tempo da enquete foram preservados.',
	'AP_CLEANUP_PROGRESS_TITLE' => 'Limpeza em andamento',
	'AP_CLEANUP_PROGRESS_EXPLAIN' => 'Os dados residuais de enquetes estão sendo limpos em lotes seguros de %d tópicos. Esta página avança automaticamente; se for interrompida, recarregue a última página de progresso para continuar.',
	'AP_CLEANUP_PROGRESS' => '%1$d de %2$d linhas candidatas inspecionadas; %3$d linhas limpas.',
	'AP_CLEANUP_CONTINUE' => 'Continuar a limpeza',
));
