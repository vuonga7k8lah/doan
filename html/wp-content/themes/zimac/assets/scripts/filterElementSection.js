import { handleErrorAxios } from "./utils/_handingErrorAxios";
import _setBgColorForAvatar from "./wilBgAvatar";

let isLoading = false;
const classCatFilterActive = "wil-nav-item__a--type3--active";
/**
 */
// Luu cac data da lay ve
let DATA_CACHE = {};
// Cau truc args hien tai -> sd cho param de axios fetch len
let DATA_AGRS = {};

export default function filterElementSection() {
	_declareDataArgsInit();
	//
	_processFilterByCatId();
	_processFilterBySelectOrderBy();
	_processFilterByPaged();
	// =================================================================================================================
}

/**
 *
 * @returns
 */
function _declareDataArgsInit() {
	const sections = document.querySelectorAll("[data-has-filter-api]");
	if (!sections.length) return;

	sections.forEach((element) => {
		const blockId = element.getAttribute("data-block-uid");
		const catId = element.getAttribute("data-init-cat-filter");
		const orderby = element.getAttribute("data-init-orderby-filter");
		const paged = Number(element.getAttribute("data-init-page")) || 1;
		const blockType = element.getAttribute("data-block-type");
		const settings = element.getAttribute("data-a-settings");

		DATA_AGRS = {
			...DATA_AGRS,
			[blockId]: {
				blockType,
				catId,
				orderby,
				paged,
				settings,
			},
		};
	});
}

/**
 *
 * @returns
 */
function _processFilterByPaged() {
	const listFilterByPaged = [
		...document.querySelectorAll("[data-filter-pagination-prev]"),
		...document.querySelectorAll("[data-filter-pagination-next]"),
	];
	if (!listFilterByPaged.length) return;
	listFilterByPaged.forEach((element) => {
		element.addEventListener("click", (event) => {
			event.preventDefault();
			_handleClickFilterByPaged(element);
		});
	});
}

/**
 *
 * @returns
 */
function _processFilterBySelectOrderBy() {
	const listFilterOrderby = [
		...document.querySelectorAll("[data-filter-orderby]"),
	];

	if (!listFilterOrderby.length) return;
	listFilterOrderby.forEach((element) => {
		element.addEventListener("click", (event) => {
			event.preventDefault();
			_handleClickFilterByOrderBy(element);
		});
	});
}

/**
 *
 * @returns
 */
function _processFilterByCatId() {
	const listFilterByIds = [...document.querySelectorAll("[data-filter-id]")];
	if (!listFilterByIds.length) return;
	listFilterByIds.forEach((element) => {
		element.addEventListener("click", (event) => {
			event.preventDefault();
			_handleClickFilterByCategory(element);
		});
	});
}

/**
 *
 * @param {Element} element
 * @returns
 */
async function _handleClickFilterByPaged(element) {
	if (isLoading) return;

	const blockId = element.getAttribute("data-block-id");
	const orderby = element.value;
	const $isNext = element.hasAttribute("data-filter-pagination-next");

	// update lai data DATA_AGRS de getDataFromRestApi
	DATA_AGRS = {
		...DATA_AGRS,
		[blockId]: {
			...DATA_AGRS[blockId],
			paged: $isNext
				? DATA_AGRS[blockId].paged + 1
				: DATA_AGRS[blockId].paged - 1,
		},
	};
	//
	let data = _getDataFromCache(blockId);
	if (!data) {
		data = await _getDataFromRestApi(blockId);
	}
	_renderContent(data, blockId);
}

/**
 *
 * @param {Element} element
 * @returns
 */
async function _handleClickFilterByOrderBy(element) {
	if (isLoading || element.classList.contains(classCatFilterActive)) {
		return;
	}

	const orderby = element.getAttribute("data-filter-orderby");
	const blockId = element.getAttribute("data-block-id");
	//	<-- TOOGLE CLASS ACTIVE -->
	const listOrderby = [...document.querySelectorAll("[data-filter-orderby]")];
	const listOrderbyOnBlock = listOrderby.filter(
		(item) => item.getAttribute("data-block-id") === blockId
	);
	listOrderbyOnBlock.forEach((item) => {
		item.classList.remove(classCatFilterActive);
	});
	element.classList.toggle(classCatFilterActive);

	// <-- HIEN THI ORDERBY DANG ACTIVE LEN DROPDOWN <--
	const dropdownfilterOrderbyFronts = [
		...document.querySelectorAll("[data-filter-orderby-front]"),
	];
	const thisDropdownfilterOrderbyFront = dropdownfilterOrderbyFronts.filter(
		(item) => item.getAttribute("data-block-id") === blockId
	);
	thisDropdownfilterOrderbyFront[0].innerHTML = element.textContent;

	// update lai data DATA_AGRS de getDataFromRestApi
	DATA_AGRS = {
		...DATA_AGRS,
		[blockId]: {
			...DATA_AGRS[blockId],
			orderby,
		},
	};
	//
	let data = _getDataFromCache(blockId);
	if (!data) {
		data = await _getDataFromRestApi(blockId);
	}
	_renderContent(data, blockId);
}

/**
 *
 * @param {HTMLElement} element
 * @returns
 */
async function _handleClickFilterByCategory(element) {
	if (isLoading || element.classList.contains(classCatFilterActive)) {
		return;
	}

	const catId = element.getAttribute("data-filter-id");
	const blockId = element.getAttribute("data-block-id");

	// <-- TOOGLE CLASS ACTIVE -->
	const listCats = [...document.querySelectorAll("[data-filter-id]")];
	const listCatsOnBlock = listCats.filter(
		(item) => item.getAttribute("data-block-id") === blockId
	);
	listCatsOnBlock.forEach((item) => {
		item.classList.remove(classCatFilterActive);
	});
	element.classList.toggle(classCatFilterActive);

	// <--  HIEN THI CATEGORY DANG ACTIVE LEN DROPDOWN
	const dropdownfilterCategoryFronts = [
		...document.querySelectorAll("[data-filter-category-front]"),
	];
	const thisDropdownfilterCategoryFront = dropdownfilterCategoryFronts.filter(
		(item) => item.getAttribute("data-block-id") === blockId
	);
	thisDropdownfilterCategoryFront[0].innerHTML = element.textContent;
	// <--   update lai data DATA_AGRS de getDataFromRestApi
	DATA_AGRS = {
		...DATA_AGRS,
		[blockId]: {
			...DATA_AGRS[blockId],
			catId,
			// reset paged to 1
			paged: 1,
		},
	};
	//

	let data = _getDataFromCache(blockId);
	if (!data) {
		data = await _getDataFromRestApi(blockId);
	}
	_renderContent(data, blockId);
}

/**
 *Lay data tu rest api dua vao blockId va cac value trong DATA_AGRS.blockId
 * @param {string} blockId
 * @returns
 */
async function _getDataFromRestApi(blockId) {
	/**
	 * 	<--  Cau truc cac param client can truyen len: {
	 * 	queryArgs: {
	 * 		cat: (number),
	 * 		page_id: (number),
	 * 		orderby: (string)
	 * 	},
	 * 	blockName:  (string),
	 * 	blockId:  (string),
	 * 	aSettings:  (string)
	 * } -->
	 *
	 */
	isLoading = true;
	document.getElementById(blockId).style.opacity = ".5";

	let content = "";
	try {
		const { blockType, catId, settings, paged, orderby } = DATA_AGRS[
			blockId
		];
		const { data } = await axios.post(
			HSBLOG_GLOBAL.baseElementorFilterSectionApi,
			{
				blockName: blockType,
				blockId,
				catId,
				aSettings: settings,
				queryArgs: JSON.stringify({
					paged,
					orderby,
				}),
			}
		);
		content = data;
		//
		DATA_CACHE = {
			...DATA_CACHE,
			[blockId]: {
				...(DATA_CACHE[blockId] || []),
				[catId + "__" + orderby + "__" + paged]: content,
			},
		};
		//
	} catch (error) {
		handleErrorAxios(error);
	}

	document.getElementById(blockId).style.opacity = "";
	isLoading = false;
	return content;
}
//

/**
 *
 * @param {Object} data
 * @param {string} blockId
 */
function _renderContent(data, blockId) {
	const $blockContent = document.getElementById(blockId);
	/**
	 * data: {
	 *    html: string(html)
	 *    next: boolean
	 *    prev: boolean
	 * }
	 */
	_changeDisableStatePagination(data, blockId);

	$blockContent.innerHTML = data.html;
	// Reset BG for avatar affter render inner HTML
	setTimeout(() => {
		try {
			_setBgColorForAvatar();
		} catch (error) {
			console.log(error);
		}
	}, 1000);
}

/**
 *
 * @param {Object} data
 * @param {string} blockId
 */
function _changeDisableStatePagination(data, blockId) {
	const { next, prev } = data;
	// Them disable to next/pagination
	let $nextBtns = [
		...document.querySelectorAll("[data-filter-pagination-next]"),
	];
	let $prevBtns = [
		...document.querySelectorAll("[data-filter-pagination-prev]"),
	];

	$nextBtns = $nextBtns.filter(
		(item) => item.getAttribute("data-block-id") === blockId
	);
	$prevBtns = $prevBtns.filter(
		(item) => item.getAttribute("data-block-id") === blockId
	);

	if (!next && !$nextBtns[0].hasAttribute("disabled")) {
		$nextBtns[0].setAttribute("disabled", true);
	}
	if (next && $nextBtns[0].hasAttribute("disabled")) {
		$nextBtns[0].removeAttribute("disabled");
	}
	//
	if (!prev && !$prevBtns[0].hasAttribute("disabled")) {
		$prevBtns[0].setAttribute("disabled", true);
	}
	if (prev && $prevBtns[0].hasAttribute("disabled")) {
		$prevBtns[0].removeAttribute("disabled");
	}
}

function _getDataFromCache(blockId) {
	if (!DATA_AGRS[blockId] || !DATA_CACHE[blockId]) {
		return;
	}
	const { paged, catId, orderby } = DATA_AGRS[blockId];
	return DATA_CACHE[blockId][catId + "__" + orderby + "__" + paged];
}
