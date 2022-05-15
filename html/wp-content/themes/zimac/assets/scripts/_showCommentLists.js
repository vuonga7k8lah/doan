export function _showCommentLists() {
  const overlays = [...document.querySelectorAll(".comment__overlay")];
  const btn = document.querySelector("#comment-overlay-loadmore-btn");
  if (!btn || !overlays || !overlays.length) {
    return;
  }
  const lists = [...document.querySelectorAll(".comment-body-hidden")];
  btn.addEventListener("click", function (event) {
    event.preventDefault();
    btn.classList.add("hidden");
    lists.forEach((item) => {
      item.classList.remove("hidden");
    });
    overlays.forEach((item) => {
      item.classList.add("hidden");
    });
  });
}
