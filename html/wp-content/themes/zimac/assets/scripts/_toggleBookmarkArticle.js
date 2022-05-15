import { handleErrorAxios } from "./utils/_handingErrorAxios";

let isLoadingObj = {};
let currentStatus = {};
const btns = [...document.querySelectorAll("[data-saved]")];

export function toggleBookmarkArticle() {
	btns.forEach((btn) => {
		btn.addEventListener("click", (e) => {
			e && e.preventDefault();
			const id = btn.getAttribute("data-id");
			const status = btn.getAttribute("data-saved");
			if (!id || isLoadingObj[id]) {
				return;
			}
			if (status === "yes") {
				axiosFetchBookmark("delete", id, status, btn);
			} else {
				axiosFetchBookmark("post", id, status, btn);
			}
		});
	});
}

/**
 *
 * @param {string} method
 * @param {number} postID
 * @param {string} status yes|no
 * @param {Element} btnElement
 */
async function axiosFetchBookmark(method, postID, status, btnElement) {
	//
	isLoadingObj[postID] = true;
	currentStatus[postID] = method;
	if (method === "delete") {
		delelteDone(btnElement);
	} else {
		postDone(btnElement);
	}

	await axios({
		method,
		url: HSBLOG_GLOBAL.baseBookmarkApi,
		data: {
			post_id: postID,
			status,
		},
		withCredentials: true,
	})
		.then(function (response) {
			if (method === "delete") {
				currentStatus[postID] !== method && delelteDone(btnElement);
			} else {
				currentStatus[postID] !== method && postDone(btnElement);
			}
		})
		.catch((e) => {
			btnElement.innerHTML += `<span class="text-red-600 text-[10px]">
				${handleErrorAxios(e)}</span>`;
		});
	isLoadingObj[postID] = false;
}

/**
 *
 * @param {Element} btnElement
 */
function delelteDone(btnElement) {
	const id = btnElement.getAttribute("data-id");
	const allOfBtns = btns.filter((item) => {
		return item.getAttribute("data-id") === id;
	});
	if (!allOfBtns) return;
	allOfBtns.forEach((item) => {
		item.setAttribute("data-saved", "no");
		item.firstElementChild.setAttribute("fill", "none");

		if (!item.firstElementChild.classList.contains("text-gray-600")) {
			item.firstElementChild.classList.add("text-gray-600");
		}
		if (item.firstElementChild.classList.contains("text-gray-800")) {
			item.firstElementChild.classList.remove("text-gray-800");
		}
	});
}
/**
 *
 * @param {Element} btnElement
 */
function postDone(btnElement) {
	const id = btnElement.getAttribute("data-id");
	const allOfBtns = btns.filter((item) => {
		return item.getAttribute("data-id") === id;
	});
	if (!allOfBtns) return;

	allOfBtns.forEach((item) => {
		item.setAttribute("data-saved", "yes");
		item.firstElementChild.setAttribute("fill", "currentColor");
		if (item.firstElementChild.classList.contains("text-gray-600")) {
			item.firstElementChild.classList.remove("text-gray-600");
		}
		if (!item.firstElementChild.classList.contains("text-gray-800")) {
			item.firstElementChild.classList.add("text-gray-800");
		}
	});
}
