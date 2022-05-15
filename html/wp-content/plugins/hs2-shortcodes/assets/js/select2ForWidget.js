jQuery(document).ready(function ($) {
	"use strict";
	// THE FIRST TIME LOAD PAGE

	const itemsss = !!$(".widget-liquid-right").length
		? $(".widget-liquid-right select.js-tuan-select2-ajax") || []
		: $("select.js-tuan-select2-ajax");

	_initSelect2($, itemsss || []);

	// WHEN DRAG DROP A NEW WIDGET
	$(document).on("widget-added", function (e, widget) {
		setTimeout(() => {
			_initSelect2($, widget.find("select.js-tuan-select2-ajax") || []);
		}, 1000);
	});

	// WHEN UPDATED A WIDGET
	$(document).on("widget-updated", function (e, widget) {
		_initSelect2($, widget.find("select.js-tuan-select2-ajax") || []);
	});
});

/**
 *
 * @param {object} $
 * @param {array} listSelects
 */
function _initSelect2($, listSelects) {
	if (!listSelects.length) {
		return;
	}
	listSelects.each(function () {
		$(this).select2({
			ajax: {
				dataType: "json",
				delay: 250,
				complete: function (xhr) {
					totalPages = xhr.getResponseHeader("X-WP-TotalPages");
				},
				data: function (params) {
					console.log(params);
					return {
						search: params.term, // search term
						page: params.page,
						per_page: 20,
					};
				},
				processResults: function (data, params) {
					params.page = params.page || 1;
					return {
						results: data.map((i) => {
							const text = _getOptionText(i);
							return { id: i.id, text };
						}),
						pagination: { more: params.page < totalPages },
					};
				},
				cache: true,
			},
			minimumInputLength: 1,
			templateResult: _formatItem,
			templateSelection: _formatItemSelection,
		});
	});
}

function _formatItem(item) {
	if (item.loading) {
		return item.text;
	}
	return item.text || item.id;
}

function _formatItemSelection(item) {
	return item.text || item.id;
}

function _getOptionText(oItem = {}) {
	return oItem.name
		? oItem.name
		: oItem.title
		? oItem.title.rendered
		: oItem.id;
}
