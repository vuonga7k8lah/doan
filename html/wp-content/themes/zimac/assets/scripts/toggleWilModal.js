export default function toogleWilModal() {
  const btnOpens = [...document.querySelectorAll(`[data-open-modal]`)];
  if (!btnOpens || !btnOpens.length) return;
  btnOpens.forEach((elment) => {
    // const modalId = elment.getAttribute("wil-open-modal");
    const modalId = elment.getAttribute("data-open-modal");
    const modalNode = document.querySelector(`#${modalId}`);
    if (!modalNode) return;

    // DANH CHO NHUNG MODAL HIEN NGAY TU DAU TIEN
    if (!modalNode.classList.contains("hidden")) {
      window.onclick = function (event) {
        console.log(event.target);
        if (event.target === modalNode) {
          modalNode.classList.add("hidden");
        }
      };
    }

    elment.addEventListener("click", (event) => {
      event && event.preventDefault();
      modalNode.classList.toggle("hidden");
      //=== When the user clicks anywhere outside of the modal, close it
      window.onclick = function (event) {
        console.log(event.target);
        if (event.target === modalNode) {
          modalNode.classList.add("hidden");
        }
      };
    });

    // === Close modal function
    const btnCloses = document.querySelectorAll(
      `[data-wil-close-modal='${modalId}']`
    );
    if (!btnCloses) return;
    btnCloses.forEach((el) => {
      el.addEventListener("click", (event) => {
        event && event.preventDefault();
        modalNode.classList.add("hidden");
      });
    });
  });
}
