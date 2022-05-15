import { handleErrorAxios } from "./utils/_handingErrorAxios";

let isLoadingObj = {};
let currentStatus = {};

/**
 *
 * @param {Element} btnElement
 */
function postDone(btnElement) {
	btnElement.setAttribute("data-is-following", "yes");
	btnElement.classList.add("bg-primary");
	btnElement.classList.remove("bg-gray-200");
	btnElement.innerHTML = "Following";
}
/**
 *
 * @param {Element} btnElement
 */
function deleteDone(btnElement) {
	btnElement.setAttribute("data-is-following", "no");
	btnElement.classList.remove("bg-primary");
	btnElement.classList.add("bg-gray-200");
	btnElement.innerHTML = "Follow";
}

/**
 *
 * @param {string} method delete|post
 * @param {number} userID
 * @param {Element} btnElement
 */
async function axiosFetchFollow(method, userID, btnElement) {
	isLoadingObj[userID] = true;
	//
	currentStatus[userID] = method;
	if (method === "delete") {
		deleteDone(btnElement);
	} else {
		postDone(btnElement);
	}
	//
	await axios({
		method,
		url: HSBLOG_GLOBAL.baseFlowedUserApi,
		data: {
			follower_id: userID,
		},
		withCredentials: true,
	})
		.then(function (response) {
			if (method === "delete") {
				currentStatus[userID] !== method && deleteDone(btnElement);
			} else {
				currentStatus[userID] !== method && postDone(btnElement);
			}
		})
		.catch((e) => {
			btnElement.innerHTML += `<span class="text-red-600 text-[10px]">
				${handleErrorAxios(e)}</span>`;
		});
	//
	isLoadingObj[userID] = false;
}

export function toggleFollowUser() {
	const btns = [...document.querySelectorAll("[data-user-id]")];
	btns.forEach((btn) => {
		btn.addEventListener("click", (e) => {
			e && e.preventDefault();
			const id = btn.getAttribute("data-user-id");
			const statusFollowing = btn.getAttribute("data-is-following");
			if (!id || isLoadingObj[id]) {
				return;
			}
			if (statusFollowing === "yes") {
				axiosFetchFollow("delete", id, btn);
			} else {
				axiosFetchFollow("post", id, btn);
			}
		});
	});
}
