(function () {
	'use strict';

	var selectAllControls = Array.prototype.slice.call(document.querySelectorAll('[data-ap-select-all]'));
	var selections = Array.prototype.slice.call(document.querySelectorAll('[data-ap-poll-select]'));
	var actions = Array.prototype.slice.call(document.querySelectorAll('[data-ap-bulk-action]'));
	var updating = false;

	if (!selectAllControls.length || !selections.length) {
		return;
	}

	function iCheckInput(input, action) {
		if (!window.jQuery || !window.jQuery.fn || typeof window.jQuery.fn.iCheck !== 'function') {
			return false;
		}

		var $input = window.jQuery(input);
		if ($input.data('iCheck')) {
			$input.iCheck(action);
			return true;
		}

		return false;
	}

	function updateCheckbox(input, checked) {
		if (!iCheckInput(input, checked ? 'check' : 'uncheck')) {
			input.checked = checked;
		}
	}

	function updateSelectAll(input, checked, indeterminate) {
		if (iCheckInput(input, checked ? 'check' : 'uncheck')) {
			iCheckInput(input, indeterminate ? 'indeterminate' : 'determinate');
		} else {
			input.checked = checked;
			input.indeterminate = indeterminate;
		}
	}

	function synchronise() {
		var selected = selections.filter(function (selection) {
			return selection.checked;
		}).length;

		updating = true;
		selectAllControls.forEach(function (selectAll) {
			updateSelectAll(
				selectAll,
				selected === selections.length,
				selected > 0 && selected < selections.length
			);
		});
		updating = false;

		actions.forEach(function (action) {
			action.disabled = selected === 0;
		});
	}

	function selectAll(checked) {
		updating = true;
		selections.forEach(function (selection) {
			updateCheckbox(selection, checked);
		});
		updating = false;
		synchronise();
	}

	selectAllControls.forEach(function (selectAllControl) {
		selectAllControl.addEventListener('change', function () {
			if (!updating) {
				selectAll(selectAllControl.checked);
			}
		});
	});
	selections.forEach(function (selection) {
		selection.addEventListener('change', function () {
			if (!updating) {
				synchronise();
			}
		});
	});

	function bindICheckEvents() {
		if (!window.jQuery || !window.jQuery.fn || typeof window.jQuery.fn.iCheck !== 'function') {
			return;
		}

		window.jQuery(selectAllControls)
			.off('ifChanged.apPollManage')
			.on('ifChanged.apPollManage', function () {
				if (!updating) {
					selectAll(this.checked);
				}
			});
		window.jQuery(selections)
			.off('ifChanged.apPollManage')
			.on('ifChanged.apPollManage', function () {
				if (!updating) {
					synchronise();
				}
			});
		synchronise();
	}

	if (window.head && typeof window.head.ready === 'function') {
		window.head.ready(bindICheckEvents);
	} else {
		bindICheckEvents();
	}

	synchronise();
}());
