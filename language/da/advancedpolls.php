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
	'ADVANCEDPOLLS_EXT_NAME' => 'Avancerede afstemninger',

// Viewtopic
	'AP_VOTES_HIDDEN'         => 'Stemmer skjult',
	'AP_POLL_RUN_TILL_APPEND' => ', indtil da er alle stemmer skjulte',
	'AP_VOTERS'               => 'Medlemmer',
	'AP_NONE'                 => 'Ingen',
	'AP_DELETED_USER'         => 'Slettet bruger',

	'AP_POLL_CANT_VOTE'              => 'Du kan ikke deltage i denne afstemning da:',
	'AP_POLL_REASON_NOT_POSTED'      => 'Du ikke har deltaget i dette emne',
	'AP_POLL_VOTES_ARE_VISIBLE'      => 'Bemærk venligst at afgivne stemmer er synlige.',
	'AP_POLL_DONT_VOTE_SHOW_RESULTS' => 'Tryk IKKE her hvis du vil stemme. Tryk på STEM hvis du vil stemme. Her trykkes KUN hvis du IKKE vil bruge din stemme.',
	'AP_POLL_RESULTS_ARE_ORDERED'    => 'Bemærk venligst, at resultatet er sorteret faldende efter antal stemmer.',
	'AP_POLL_TYPE_MISMATCH'          => 'Afstemningsdata passer ikke. Intern fejl',
	'AP_VOTE_CHANGED'                => 'Du har ikke tilladelse til at ændre din stemme.',
	'AP_TOO_MANY_VOTES'              => 'Du har forsøgt at afgive for mange stemmer.',
	'AP_ABSTAINERS'                  => 'Valgte ikke at stemme',
	'AP_DELETE_VOTE'                 => 'Slet min stemme',

	'AP_MAX_VOTES_SELECT' => [
		1 => 'Du må give op til <strong>%2$d</strong> stemmer til følgende: <strong>%1$d</strong>',
		2 => 'Du må give op til <strong>%2$d</strong> stemmer blandt følgende: <strong>%1$d</strong>',
	],
	'AP_GUEST_VOTES' => [
		1 => '%d stemme fra gæst',
		2 => '%d stemmer fra gæster',
	],
	'AP_SCORE_TOTAL' => [
		1 => '%d stemme',
		2 => '%d stemmer',
	],
	'AP_SCORE_POINTS_TOTAL' => [
		1 => '%d point',
		2 => '%d point',
	],
	'AP_SCORE_BREAKDOWN' => 'Fordeling af stemmer',
	'AP_SCORE_AVERAGE'   => 'Gennemsnit: %1$s / %2$d',
	'AP_SCORE_RATINGS'   => [
		1 => '%d bedømmelse',
		2 => '%d bedømmelser',
	],
	'AP_SCORE_OVERALL_AVERAGE'    => 'Samlet gennemsnit',
	'AP_SCORE_DISTRIBUTION_ENTRY' => [
		1 => '%1$d stemme på %2$d point',
		2 => '%1$d stemmer på %2$d point',
	],
	'AP_RANK_TOTAL' => [
		1 => '%d point',
		2 => '%d point',
	],
	'AP_RANK_BREAKDOWN'          => 'Fordeling af placeringer',
	'AP_RANK_DISTRIBUTION_ENTRY' => [
		1 => '%1$d stemme på plads %2$d',
		2 => '%1$d stemmer på plads %2$d',
	],
	'AP_RANK_SELECT_EXACTLY' => [
		1 => 'Vælg præcis %d valgmulighed i prioriteret rækkefølge.',
		2 => 'Vælg præcis %d valgmuligheder i prioriteret rækkefølge.',
	],
	'AP_POLL_LIST'         => 'Afstemninger',
	'AP_POLL_MANAGE_SELECT'     => 'Vælg afstemning',
	'AP_POLL_MANAGE_SELECT_ALL' => 'Vælg alle',
	'AP_POLL_MANAGE_CLOSE'      => 'Luk',
	'AP_POLL_MANAGE_OPEN'       => 'Åbn',
	'AP_POLL_LIST_ALL'     => 'Alle afstemninger',
	'AP_POLL_LIST_OPEN'    => 'Åbne',
	'AP_POLL_LIST_CLOSED'  => 'Lukkede',
	'AP_POLL_LIST_EMPTY'   => 'Der blev ikke fundet nogen tilgængelige afstemninger.',
	'AP_POLL_LIST_VIEW'    => 'Vis afstemning',
	'AP_POLL_LIST_ENDS'    => 'Slutter %s',
	'AP_POLL_LIST_ENDED'   => 'Sluttede %s',
	'AP_POLL_LIST_LEADING' => 'Førende resultat: %1$s - %2$s',
	'AP_POLL_LIST_WINNER'  => 'Vinder: %1$s - %2$s',
// Posting
	'AP_POLL_TYPE'                 => 'Afstemningstype',
	'AP_POLL_TYPE_EXPLAIN'         => 'Vælg hvordan brugere fordeler deres stemmer eller point.',
	'AP_POLL_TYPE_CHOICE'          => 'Valg',
	'AP_POLL_TYPE_SCORING'         => 'Numerisk bedømmelse',
	'AP_POLL_TYPE_RANKING'         => 'Prioriteret rangering',
	'AP_SCORE_RESULT'              => 'Bedømmelsesresultat',
	'AP_SCORE_RESULT_EXPLAIN'      => 'Vis enten akkumulerede point eller det aritmetiske gennemsnit af de afgivne bedømmelser for hver valgmulighed.',
	'AP_SCORE_RESULT_TOTAL'        => 'Akkumulerede point',
	'AP_SCORE_RESULT_AVERAGE'      => 'Gennemsnitlig bedømmelse',
	'AP_POLL_SHOW_PERCENT'         => 'Vis procent',
	'AP_POLL_SHOW_PERCENT_EXPLAIN' => 'Vis procentangivelsen ved siden af hver resultatbjælke. I gennemsnitstilstand skaleres selve bjælken altid i forhold til den maksimale bedømmelse.',
	'AP_POLL_VISIBILITY'           => 'Synlighed af resultat',
	'AP_POLL_VISIBILITY_EXPLAIN'   => 'Vælg hvornår de samlede afstemningsresultater bliver synlige.',
	'AP_VISIBILITY_PUBLIC'         => 'Offentlig — vis altid resultater',
	'AP_VISIBILITY_DEFAULT'        => 'Efter første stemme',
	'AP_VISIBILITY_VOTE_COMPLETED' => 'Når alle tilgængelige stemmer er brugt',
	'AP_VISIBILITY_PRIVATE'        => 'Privat — kun efter afstemningen er slut',
	'AP_POLL_VOTE_MODE'            => 'Ændring af stemmer',
	'AP_POLL_VOTE_MODE_EXPLAIN'    => 'Vælg om stemmer er endelige, kan afgives løbende, eller kan ændres mens afstemningen er åben.',
	'AP_VOTE_MODE_NO_CHANGE'       => 'Ingen ændring',
	'AP_VOTE_MODE_INCREMENTAL'     => 'Løbende afstemning',
	'AP_VOTE_MODE_CHANGE'          => 'Tillad ændringer',
	'AP_POLL_VOTES_HIDE'           => 'Skjul stemmer',
	'AP_POLL_VOTES_HIDE_EXPLAIN'   => 'Hvis aktiv vil stemmer være skjult til afstemningen er slut. Dette valg fungerer kun hvis der er specificeret en slutdato.',
	'AP_POLL_VOTERS_SHOW'          => 'Vis hvem der har stemt',
	'AP_POLL_VOTERS_SHOW_EXPLAIN'  => 'Hvis aktiv vil medlemmer der har stemt være synlig for dem der har tilladelse til at se det. Bemærk, at medlemmer fortsat vil være skjulte hvis stemmer er skjulte.',
	'AP_POLL_VOTERS_LIMIT'         => 'Begræns medlemmer',
	'AP_POLL_VOTERS_LIMIT_EXPLAIN' => 'Hvis aktiv er det kun medlemmer der har deltaget i emnet der kan stemme.',
	'AP_POLL_SHOW_ORDERED'         => 'Vis resultater sorteret',
	'AP_POLL_SHOW_ORDERED_EXPLAIN' => 'Resultatet vises i faldende orden efteer afgivne stemmer (flest stemmer først. Ellers vises resultat i nummerorden.',
	'AP_POLL_COLLAPSIBLE'          => 'Sammenklappelig afstemning',
	'AP_POLL_COLLAPSIBLE_EXPLAIN'  => 'Tillad brugere at klappe denne afstemning sammen og folde den ud.',
	'AP_COLLAPSE_POLL'             => 'Klap afstemning sammen',
	'AP_EXPAND_POLL'               => 'Fold afstemning ud',
	'AP_RUN_POLL'                  => 'Afstemning aktiv',
	'AP_RUN_POLL_FOR'              => 'i',
	'AP_RUN_POLL_UNTIL'            => 'til',
	'AP_RUN_POLL_INDEFINITELY'     => 'uendelig',
	'AP_POLL_START'                => 'Afstemningen starter',
	'AP_POLL_START_EXPLAIN'        => 'Lad feltet stå tomt for at gøre afstemningen tilgængelig med det samme. Indtil denne dato og dette klokkeslæt forbliver emnet synligt, men afstemningen er skjult.',
	'AP_POLL_START_INVALID'        => 'Afstemningens start skal være en gyldig dato og tid i fremtiden',
	'AP_POLL_END'                  => 'Afstemning slutter',
	'AP_POLL_END_EXPLAIN'          => 'Angiv dato og tid for afstemnings afslutning. Hvis nogle af disse felter er udfyldt gælder det frem for afstemnings varighed. Tomme datofelter gælder som afstemningens gældende slutdato; tomme timefelter gælder som 0. Hvis du vil gå tilbage til at bruge "Afstemnings længde" skal du tømme alle disse felter.',

	'AP_YYYY_MM_DD'                 => 'ÅÅÅÅ-MM-DD',
	'AP_HH_MM'                      => 'TT:MM',
	'AP_POLL_END_INVALID'           => 'Specificeret dato/tid er ugyldig',
	'AP_POLL_TOTAL_LOWER_MAX_VOTES' => 'Det maximale antal stemmer på en enkelt valgmulighed kan ikke overstige det maksimale antal stemmer man har i afstmningen.',
	'AP_POLL_TOTAL_LOWER_MAX_OPTS'  => 'Det maksimale antal valgte valgmuligheder kan ikke overstige det antal stemmer man har i afstemningen.',

	'AP_POLL_MAX_VALUE'           => 'Maximale antal stemmer',
	'AP_POLL_MAX_VALUE_EXPLAIN'   => 'Dette er det maksimale antal stemmer man kan give til en enkelt valgmuliged.',
	'AP_POLL_TOTAL_VALUE'         => 'Total antal stemmer',
	'AP_POLL_TOTAL_VALUE_EXPLAIN' => 'Dette er det totale antal stemmer man kan fordele blandt alle valgmuligheder.',
	'AP_RANK_POINTS'              => 'Point efter placering',
	'AP_RANK_POINTS_EXPLAIN'      => 'Angiv en positiv, faldende pointværdi for hver placering. Antallet af placeringer styres af Maksimalt antal valgmuligheder pr. bruger.',
	'AP_RANK_POSITION'            => 'Placering %d',

	'AP_VOTE_GREATER_THAN_MAXVALUE'        => 'Du kan ikke tildele et antal stemmer større end max. tilladte.',
	'AP_POLL_VALUES_INVALID'               => 'Den mindste score kan ikke overstige den højeste score; maksimalt antal valgmuligheder, maksimal score og total score skal være større end nul.',
	'AP_RANK_POSITIONS_INVALID'            => 'Antallet af placeringer skal være mellem 1 og antallet af valgmuligheder i afstemningen.',
	'AP_RANK_POINTS_INCOMPLETE'            => 'Angiv én pointværdi for hver placering.',
	'AP_RANK_POINTS_INVALID'               => 'Hver pointværdi skal være mellem 1 og 999.',
	'AP_RANK_POINTS_ORDER'                 => 'Pointværdierne skal falde strengt fra første til sidste placering.',
	'AP_RANK_INCREMENTAL_UNSUPPORTED'      => 'Løbende afstemning kan ikke bruges sammen med prioriteret rangering.',
	'AP_RANK_SELECTION_INCOMPLETE'         => 'Vælg præcis det konfigurerede antal valgmuligheder i prioriteret rækkefølge.',
	'AP_QUESTION'                          => 'Spørgsmål',
	'AP_QUESTION_REQUIRED'                 => 'Obligatorisk spørgsmål',
	'AP_PRIMARY_QUESTION_REQUIRED_EXPLAIN' => 'Kræv et svar på det første spørgsmål, før hele stemmesedlen kan indsendes.',
	'AP_APPEND_OPTIONS'                    => 'Tilføj valgmuligheder uden at nulstille stemmer',
	'AP_APPEND_OPTIONS_EXPLAIN'            => 'Bevar alle eksisterende stemmer og tilføj kun de nye valgmuligheder i slutningen af et spørgsmåls liste over valgmuligheder.',
	'AP_APPEND_OPTIONS_WARNING'            => 'Eksisterende spørgsmål og valgmuligheder må ikke omdøbes, fjernes eller omarrangeres. Ændring af stemmer skal være tilladt. Tidligere registrerede stemmeberettigede vil blive underrettet i henhold til ACP-indstillingen og deres notifikationspræferencer.',
	'AP_APPEND_INVALID'                    => 'Der kan ikke tilføjes valgmuligheder sikkert til denne afstemning.',
	'AP_APPEND_REQUIRES_CHANGES'           => 'Tillad ændring af stemmer, før der tilføjes valgmuligheder uden at nulstille eksisterende stemmer.',
	'AP_APPEND_POLL_ENDED'                 => 'Der kan ikke tilføjes valgmuligheder uden at nulstille stemmer, efter afstemningen er afsluttet.',
	'AP_APPEND_STRUCTURE_CHANGED'          => 'Eksisterende afstemningsspørgsmål eller valgmuligheder er blevet ændret. Gendan den oprindelige definition, og tilføj kun nye valgmuligheder til sidst.',
	'AP_APPEND_TOO_MANY'                   => 'De tilføjede valgmuligheder overstiger det konfigurerede maksimale antal valgmuligheder.',
	'AP_APPEND_NONE'                       => 'Der blev ikke tilføjet nogen nye valgmuligheder.',
	'AP_ADDITIONAL_QUESTIONS'              => 'Yderligere spørgsmålssider',
	'AP_ADDITIONAL_QUESTIONS_EXPLAIN'      => 'Hver side bruger samme afstemningstype, grænser, point, synlighed og regler for ændring af stemmer. Indtast én valgmulighed pr. linje.',
	'AP_ADD_QUESTION'                      => 'Tilføj spørgsmål',
	'AP_MULTI_INVALID'                     => 'Data for de yderligere spørgsmål er ugyldige.',
	'AP_MULTI_TOO_MANY'                    => 'En afstemning kan højst indeholde 20 yderligere spørgsmål.',
	'AP_MULTI_CONTENT_INVALID'             => 'Hvert yderligere spørgsmål skal have en titel og tilstrækkeligt mange gyldige valgmuligheder til at opfylde de globale afstemningsgrænser.',
	'AP_REQUIRED_QUESTION_MISSING'         => 'Besvar dette obligatoriske spørgsmål, før du fortsætter.',
	'AP_POLL_NAVIGATION'                   => 'Navigation mellem afstemningsspørgsmål',
	'AP_POLL_MIN_VALUE'                    => 'Mindste score',
	'AP_POLL_MIN_VALUE_EXPLAIN'            => 'Dette er den mindste score, en stemmeberettiget kan give en valgt valgmulighed.',
	'AP_VOTE_OUTSIDE_RANGE'                => 'Hver angivet score skal ligge mellem de konfigurerede minimum- og maksimumværdier.',
]);
