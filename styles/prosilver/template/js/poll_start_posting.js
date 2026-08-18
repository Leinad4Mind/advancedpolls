/**
 * Advanced Polls - scheduled poll start controls
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

function apPollStartDateTimeValue(date)
{
	function pad(value)
	{
		return ('0' + value).slice(-2);
	}

	return date.getFullYear() + '-' + pad(date.getMonth() + 1) + '-' + pad(date.getDate())
		+ 'T' + pad(date.getHours()) + ':' + pad(date.getMinutes());
}

function apMinimumPollStart()
{
	var minimum = new Date();
	minimum.setSeconds(0, 0);
	minimum.setMinutes(minimum.getMinutes() + 1);
	return minimum;
}

function apRefreshPollStartMinimum()
{
	var input = document.getElementById('wolfsblvt_poll_start');
	var minimum = apMinimumPollStart();
	if (input)
	{
		input.min = apPollStartDateTimeValue(minimum);
	}
	return minimum;
}

function apAdjustStartDateTime(value)
{
	var input = document.getElementById('wolfsblvt_poll_start');
	var selected;
	var minimum;
	if (!input)
	{
		return;
	}
	if (value !== '')
	{
		selected = new Date(value);
		minimum = apRefreshPollStartMinimum();
		if (isNaN(selected.getTime()) || selected.getTime() < minimum.getTime())
		{
			selected = minimum;
		}
		selected.setSeconds(0, 0);
		input.value = apPollStartDateTimeValue(selected);
	}
	if (typeof apPollScheduleChanged === 'function')
	{
		apPollScheduleChanged();
	}
}

apRefreshPollStartMinimum();
