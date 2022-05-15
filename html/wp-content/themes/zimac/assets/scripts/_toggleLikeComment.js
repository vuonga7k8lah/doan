import { handleErrorAxios } from "./utils/_handingErrorAxios";

const activeClass = "text-blue-500";
let isLoadingObj = {};
let currentStatus = {};

/**
 *
 * @param {string} method
 * @param {string} status
 * @param {Element} btnElement
 * @returns
 */
function _changeAttrForBtn(method, status, btnElement) {
	_toggleStatusForButton(method, btnElement, status);
	const btnEmotionType = btnElement.getAttribute("data-comment-emotion-type");

	if (method === "delete") {
		return;
	}

	// DELETE ACTIVE STATE FOR NEXT/PREV BUTTON
	if (btnEmotionType === "like") {
		const btnDislike = btnElement.nextElementSibling;
		const commentStatus = btnDislike.getAttribute("data-comment-status");
		if (!commentStatus || commentStatus === "none") {
			return;
		}
		_toggleStatusForButton("delete", btnDislike, "none");
	}

	if (btnEmotionType === "dislike") {
		const btnlike = btnElement.previousElementSibling;
		const commentStatus = btnlike.getAttribute("data-comment-status");
		if (!commentStatus || commentStatus === "none") {
			return;
		}
		_toggleStatusForButton("delete", btnlike, "none");
	}
}

/**
 *
 * @param {string} method
 * @param {Element} btnElement
 */
function _toggleStatusForButton(method, btnElement, status) {
	const spanElement = btnElement.getElementsByTagName("span")[0];
	const count = Number(spanElement.innerText) || 0;
	if (method === "delete") {
		btnElement.setAttribute("data-comment-status", "none");
		btnElement.classList.remove(activeClass);
		spanElement.innerText = count - 1;
	} else {
		btnElement.setAttribute("data-comment-status", status);
		btnElement.classList.add(activeClass);
		spanElement.innerText = count + 1;
	}
}

/**
 *
 * @param {string} method delete|post
 * @param {string} status
 * @param {number} commentId
 * @param {Element} btnElement
 */
async function axiosFetchFollow(method, status, commentId, btnElement) {
	isLoadingObj[commentId] = true;
	currentStatus[commentId] = method;
	_changeAttrForBtn(method, status, btnElement);

	await axios({
		method,
		url: HSBLOG_GLOBAL.baseCommentEmotionApi,
		data: {
			comment_id: commentId,
			status,
		},
		withCredentials: true,
	})
		.then(function (response) {
			const { emotions } = response.data;
			currentStatus[commentId] !== method &&
				_changeAttrForBtn(method, status, btnElement);
		})
		.catch((e) => {
			btnElement.innerHTML += `<span class="text-red-600 text-[10px]">
				${handleErrorAxios(e)}</span>`;
		});
	isLoadingObj[commentId] = false;
}

/**
 *
 */
export function toggleLikeComment() {
	const btns = [...document.querySelectorAll("[data-comment-status]")];
	btns.forEach((btn) => {
		btn.addEventListener("click", (e) => {
			e && e.preventDefault();
			const emotionType = btn.getAttribute("data-comment-emotion-type");
			const userId = btn.getAttribute("data-comment-user-ID");
			const commentId = btn.getAttribute("data-comment-ID");
			const status = btn.getAttribute("data-comment-status");

			if (!userId || isLoadingObj[commentId]) {
				return;
			}

			if (emotionType === "like") {
				if (status !== "none") {
					axiosFetchFollow("delete", status, commentId, btn);
				} else {
					axiosFetchFollow("post", "like", commentId, btn);
				}
			}
			if (emotionType === "dislike") {
				if (status !== "none") {
					axiosFetchFollow("delete", status, commentId, btn);
				} else {
					axiosFetchFollow("post", "dislike", commentId, btn);
				}
			}
		});
	});
}
