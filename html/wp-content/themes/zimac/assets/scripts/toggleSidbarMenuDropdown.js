export default function toggleSidbarMenuDropdown() {
	// nav-after-icon
	const btns = [
		...document.querySelectorAll(
			".site-header-nav-sidebar .menu-item-has-children > a"
		),
	];
	if (!btns.length) return;

	btns.forEach((item) => {
		item.querySelector(".nav-after-icon").addEventListener(
			"click",
			(event) => {
				event.preventDefault();
				item.nextElementSibling.classList.toggle("open-sub");
			}
		);
	});
}
