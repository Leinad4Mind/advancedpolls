<?php
/**
 *
 * Advanced Polls [Danish]
 *
 * @copyright (c) 2015 Wolfsblvt
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'AP_TITLE_ACP'    => 'Avancerede afstemninger',
	'AP_SETTINGS_ACP' => 'Indstillinger',
	'AP_CLEANUP_ACP' => 'Oprydning af afstemningsdata',
	'LOG_AP_POLL_CLEANUP' => '<strong>Advanced Polls:</strong> Ryddede %1$d emnerækker med resterende afstemningsdata',

	'AP_TITLE'         => 'Avancerede afstemninger',
	'AP_TITLE_EXPLAIN' => 'Udvider phpBB´s standard afstemningssystem med nye funktioner som mulighed for at skjule afgivne stemmer til afstemningens ophør, visning af hvem der har stemt hvad, begrænsning af stemmemuligheder m.m.',

	'AP_SETTINGS'                        => 'Indstillinger for avancerede afstemninger',
	'AP_GLOBAL_SETTINGS'                 => 'Globale indstillinger for avancerede afstemninger (gælder alle afstemninger)',
	'AP_PER_POLL_SETTINGS'               => 'Specifikke indstillinger for enkelte afstemninger (vælges pr. afstemning hvor standard indstillingen vælges her.)',
	'AP_DEFAULT_POLL_VISIBILITY'         => 'Standard synlighed af resultat',
	'AP_DEFAULT_POLL_VISIBILITY_EXPLAIN' => 'Den indledende synlighedstilstand der er valgt, når en afstemning oprettes.',
	'AP_DEFAULT_POLL_VOTE_MODE'          => 'Standard tilstand for ændring af stemmer',
	'AP_DEFAULT_POLL_VOTE_MODE_EXPLAIN'  => 'Den indledende tilstand for ændring af stemmer der er valgt, når en afstemning oprettes.',
	'AP_VISIBILITY_PUBLIC'               => 'Offentlig — vis altid resultater',
	'AP_VISIBILITY_DEFAULT'              => 'Efter første stemme',
	'AP_VISIBILITY_VOTE_COMPLETED'       => 'Når alle tilgængelige stemmer er brugt',
	'AP_VISIBILITY_PRIVATE'              => 'Privat — kun efter afstemningen er slut',
	'AP_VOTE_MODE_NO_CHANGE'             => 'Ingen ændring',
	'AP_VOTE_MODE_INCREMENTAL'           => 'Løbende afstemning',
	'AP_VOTE_MODE_CHANGE'                => 'Tillad ændringer',
	'AP_DEFAULT_SCORE_RESULT'            => 'Standard bedømmelsesresultat',
	'AP_DEFAULT_SCORE_RESULT_EXPLAIN'    => 'Vælg om nye afstemninger med numerisk bedømmelse indledningsvis viser akkumulerede point eller det aritmetiske gennemsnit for hver valgmulighed.',
	'AP_DEFAULT_SHOW_PERCENT'            => 'Vis procent som standard',
	'AP_DEFAULT_SHOW_PERCENT_EXPLAIN'    => 'Den indledende synlighed af procentangivelse for nye afstemninger med numerisk bedømmelse.',
	'AP_SCORE_RESULT_TOTAL'              => 'Akkumulerede point',
	'AP_SCORE_RESULT_AVERAGE'            => 'Gennemsnitlig bedømmelse',

	'AP_ACT_VOTES_HIDE'                 => 'Aktivér skjul stemmer',
	'AP_ACT_VOTES_HIDE_EXPLAIN'         => 'Aktiverer muligheden for at vælge at stemmer skjules ti afstemningen er slut.',
	'AP_ACT_VOTERS_SHOW'                => 'Aktiver vis medlemmer',
	'AP_ACT_VOTERS_SHOW_EXPLAIN'        => 'Aktiverer muligheden for at vælge at medlemmer vises for hver afstemnings mulighed.',
	'AP_ACT_VOTERS_LIMIT'               => 'Aktiver begræns medlemmer',
	'AP_ACT_VOTERS_LIMIT_EXPLAIN'       => 'Aktiverer muligheden for at vælge at begrænse muligheden for at afgive stemme til de medlemmer der har deltaget i emnet.',
	'AP_ACT_POLL_NO_VOTE'               => 'Aktivere undlad at stemme',
	'AP_ACT_POLL_NO_VOTE_EXPLAIN'       => 'Ændrer standard "Se resultat" link til "Undlad at stemme - se resultat" link, som ikke vil tillade at afgives stemme efter man har set resultatet med mindre "Ændre stemme" er valgt.',
	'AP_ACT_SHOW_ABSTAINERS'            => 'Vis antal der undlod at stemme',
	'AP_ACT_SHOW_ABSTAINERS_EXPLAIN'    => 'Viser hvor mange registrerede brugere aktivt har valgt ikke at stemme. Navne vises kun når visning af stemmeberettigede er aktiveret, og den der ser det har tilladelse.',
	'AP_ACT_VOTE_DELETE'                => 'Tillad sletning af stemme',
	'AP_ACT_VOTE_DELETE_EXPLAIN'        => 'Giver registrerede brugere mulighed for at slette deres egen stemme, mens en åben afstemning tillader ændring af stemmer.',
	'AP_ACT_SHOW_ORDERED'               => 'Aktivere sorteret visning',
	'AP_ACT_SHOW_ORDERED_EXPLAIN'       => 'Aktiverer muligheden for at resultaterne vises sorteret med flest stemmer først.',
	'AP_ACT_POLL_SCORING'               => 'Aktiverer vægtede stemmer',
	'AP_ACT_POLL_SCORING_EXPLAIN'       => 'Aktiverer muligheden for at tildele forskellig vægtning til afstemnings mulighederne.',
	'AP_ACT_INCREMENTAL_VOTES'          => 'Aktiverer muligheden for at stemme delvis',
	'AP_ACT_INCREMENTAL_VOTES_EXPLAIN'  => 'Med denne mulighed valgt, kan man afbryde sin afstemning, og senere vende tilbage og stemme videre.',
	'AP_ACT_CLOSED_VOTING'              => 'Aktiverer lukket afstemning',
	'AP_ACT_CLOSED_VOTING_EXPLAIN'      => 'Aktiverer muligheden for a stemme i en åben afstemning selv om det tilhørende emne er låst.',
	'AP_ACT_POLL_START'                 => 'Aktiver planlagt afstemningsstart',
	'AP_ACT_POLL_START_EXPLAIN'         => 'Gør det muligt at vælge en fremtidig dato og et klokkeslæt, hvor afstemningen bliver synlig og modtager stemmer.',
	'AP_ACT_POLL_END'                   => 'Aktiverer afstemnings afslutning',
	'AP_ACT_POLL_END_EXPLAIN'           => 'Tillader at specificere med dato og klokkeslet hvornår en afstemning ophører i stedet for blot at specificere varigheden.',
	'AP_ACT_POLL_NOTIFICATIONS'         => 'Aktiverer afstemnings notifikationer',
	'AP_ACT_POLL_NOTIFICATIONS_EXPLAIN' => 'Aktiverer afsendelse af notifikation til alle der har stemt i en skjult afstemning når astemningen er slut, og resultatet dermed er synlig.',
	'AP_ACT_POLL_COLLAPSIBLE'           => 'Aktiver sammenklappelige afstemninger',
	'AP_ACT_POLL_COLLAPSIBLE_EXPLAIN'   => 'Viser muligheden for sammenklapning, når en afstemning oprettes eller redigeres. Ved installation aktiveres denne indstilling automatisk, hvis Collapsible Forum Categories er installeret; administratorer kan altid tilsidesætte det.',
	'AP_SHOW_POLL_LIST_NAVBAR'          => 'Vis link til afstemninger i navigationsbjælken',
	'AP_SHOW_POLL_LIST_NAVBAR_EXPLAIN'  => 'Tilføjer et link til listen over tilgængelige afstemninger i forummets navigationsbjælke.',

	'AP_DEFAULT_VOTES_CHANGE' => 'Standard valg for ændre stemme',
	'AP_DEFAULT_VOTES_HIDE'   => 'Standard valg for skjul stemmer',
	'AP_DEFAULT_VOTERS_SHOW'  => 'Standard valg for vis medlemmer',
	'AP_DEFAULT_VOTERS_LIMIT' => 'Standard valg for begræns medlemmer',
	'AP_DEFAULT_SHOW_ORDERED' => 'Standard valg for vis sorteret',

	'AP_ENABLE_NOTICE' => '<br /><br /><div class="phpinfo"><p><strong>Næste trin</strong></p><ol><li>Gennemgå udvidelsens indstillinger under <strong>%1$s » %2$s » %3$s</strong>, og konfigurer de afstemningsfunktioner og standardværdier, dit forum har brug for.</li><li>Gennemgå rettighederne <strong>%8$s</strong> og <strong>%9$s</strong> under <strong>%4$s » %5$s » %6$s</strong> (medlemmer) og <strong>%4$s » %5$s » %7$s</strong> (moderatorer). Giv kun disse rettigheder til roller eller grupper, der må se hvem der har stemt.</li></ol><p>Der kræves ingen yderligere opsætning for de øvrige afstemningsfunktioner.</p></div>',
]);
