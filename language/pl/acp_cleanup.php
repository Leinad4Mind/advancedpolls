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
	'AP_CLEANUP_TITLE' => 'Czyszczenie danych ankiet',
	'AP_CLEANUP_EXPLAIN' => 'Sprawdź każdy temat zawierający metadane lub opcje ankiety. Automatycznie można wyczyścić tylko pozostałe tytuły bez żadnej opcji; niejednoznaczne wiersze pozostają tylko do odczytu i wymagają ręcznego przeglądu.',
	'AP_CLEANUP_BACKUP_WARNING' => 'Przed czyszczeniem wykonaj pełną kopię zapasową bazy danych. Operacja usuwa pozostałe metadane ankiet z wybranych wierszy tematów i nie może odtworzyć brakujących opcji ankiety.',
	'AP_CLEANUP_SUMMARY' => 'Podsumowanie integralności',
	'AP_CLEANUP_MARKED_TOTAL' => 'Tematy liczone według starej reguły opartej tylko na tytule',
	'AP_CLEANUP_VALID_TOTAL' => 'Prawidłowe ankiety',
	'AP_CLEANUP_RESIDUAL_TOTAL' => 'Pozostałe tytuły, które można bezpiecznie wyczyścić',
	'AP_CLEANUP_INCONSISTENT_TOTAL' => 'Wiersze wymagające ręcznego przeglądu',
	'AP_CLEANUP_EMPTY_WRAPPER_TOTAL' => 'Puste opakowania tytułów phpBB (&lt;t&gt;&lt;/t&gt;)',
	'AP_CLEANUP_ROWS' => 'wiersze',
	'AP_CLEANUP_FILTER_CLEANABLE' => 'Pozostałe tytuły',
	'AP_CLEANUP_FILTER_INCONSISTENT' => 'Ręczny przegląd',
	'AP_CLEANUP_FILTER_VALID' => 'Prawidłowe ankiety',
	'AP_CLEANUP_FILTER_ALL' => 'Wszystkie dane ankiet',
	'AP_CLEANUP_SELECT' => 'Wybierz',
	'AP_CLEANUP_TOPIC' => 'Temat',
	'AP_CLEANUP_POLL_TITLE' => 'Surowy tytuł ankiety',
	'AP_CLEANUP_TIMING' => 'Surowe dane czasowe',
	'AP_CLEANUP_OPTIONS' => 'Opcje ankiety i sumy',
	'AP_CLEANUP_VOTES' => 'Wiersze głosów',
	'AP_CLEANUP_STATUS' => 'Integralność',
	'AP_CLEANUP_EMPTY' => '(puste)',
	'AP_CLEANUP_START' => 'poll_start',
	'AP_CLEANUP_LENGTH' => 'poll_length',
	'AP_CLEANUP_END' => 'Obliczony koniec',
	'AP_CLEANUP_SAVED_REMAINING' => 'zapisany pozostały czas',
	'AP_CLEANUP_SCHEDULED_START' => 'zaplanowany start',
	'AP_CLEANUP_STATUS_CLEANABLE' => 'Pozostały tytuł; brak opcji',
	'AP_CLEANUP_STATUS_INCONSISTENT' => 'Opcje istnieją, ale brakuje tytułu lub startu',
	'AP_CLEANUP_STATUS_VALID' => 'Prawidłowa ankieta',
	'AP_CLEANUP_NO_ROWS' => 'Żaden wiersz nie pasuje do tego filtru.',
	'AP_CLEANUP_SELECT_PAGE' => 'Wybierz wiersze do wyczyszczenia na tej stronie',
	'AP_CLEANUP_SELECTED' => 'Wyczyść wybrane',
	'AP_CLEANUP_ALL' => 'Wyczyść wszystkie pozostałe tytuły',
	'AP_CLEANUP_EMPTY_WRAPPERS' => 'Wyczyść puste opakowania tytułów phpBB',
	'AP_CLEANUP_NOTHING_SELECTED' => 'Nie wybrano żadnego tematu do wyczyszczenia.',
	'AP_CLEANUP_CONFIRM_SELECTED' => 'Wyczyścić pozostałe metadane ankiet z wybranych wierszy tematów (%d)?',
	'AP_CLEANUP_CONFIRM_ALL' => 'Wyczyścić wszystkie wiersze z pozostałymi tytułami ankiet (%d)? Przed kontynuacją upewnij się, że istnieje pełna kopia zapasowa bazy danych.',
	'AP_CLEANUP_CONFIRM_EMPTY_WRAPPERS' => 'Wyczyścić puste opakowania tytułów ankiet phpBB (%d)? Zmienione zostanie tylko poll_title; opcje ankiety, głosy i pola czasowe zostaną zachowane.',
	'AP_CLEANUP_RESULT' => 'Wyczyszczono wiersze tematów z pozostałymi danymi: %d.',
	'AP_CLEANUP_RESULT_DETAIL' => 'Wyczyszczono wiersze tematów z pozostałymi danymi: %1$d. Pominięte wiersze: %2$d, ponieważ zawierają teraz opcje lub głosy albo nie mają już pozostałego tytułu.',
	'AP_CLEANUP_EMPTY_WRAPPERS_RESULT' => 'Wyczyszczono puste opakowania tytułów ankiet phpBB: %d. Opcje ankiety, głosy i pola czasowe zostały zachowane.',
	'AP_CLEANUP_PROGRESS_TITLE' => 'Czyszczenie w toku',
	'AP_CLEANUP_PROGRESS_EXPLAIN' => 'Pozostałe dane ankiet są czyszczone w bezpiecznych partiach po %d tematów. Ta strona przechodzi dalej automatycznie; jeśli zostanie przerwana, odśwież ostatnią stronę postępu, aby wznowić.',
	'AP_CLEANUP_PROGRESS' => 'Sprawdzono %1$d z %2$d wierszy kandydujących; wyczyszczone wiersze: %3$d.',
	'AP_CLEANUP_CONTINUE' => 'Kontynuuj czyszczenie',
));
