export default function toggleHiddenStickyMetaPost() {
	const page = document.querySelector(".wil-detail-page--full");
	if (!page || window.innerWidth <= 1020) {
		return;
	}

	const stickys = [
		...document.querySelectorAll(".wil-detail-page--full .sticky"),
	];
	const divWides = [
		...document.querySelectorAll(".alignfull"),
		...document.querySelectorAll(".alignwide"),
	];
	if (!stickys.length || !divWides.length) {
		return;
	}
	stickys.forEach((sticky) => {
		sticky.classList.add("transition-all");
		window.addEventListener("scroll", function () {
			const stickyBottom = sticky.getBoundingClientRect().bottom;
			const divWideTops = divWides.map((item) => {
				return item.getBoundingClientRect().top;
			});
			console.log({ stickyBottom });
			if (
				divWides.some((item) => {
					const itemTop = item.getBoundingClientRect().top;
					const itemBot = item.getBoundingClientRect().bottom;
					return itemBot > 10 && itemTop < stickyBottom;
				})
			) {
				if (!sticky.classList.contains("opacity-0")) {
					sticky.classList.add("opacity-0");
				}
			} else {
				if (sticky.classList.contains("opacity-0")) {
					sticky.classList.remove("opacity-0");
				}
			}
		});
	});
}
