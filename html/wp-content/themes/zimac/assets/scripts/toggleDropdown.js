export default function handleToggleDropdown() {
  const btns = [...document.querySelectorAll(".wil-dropdown__btn")];
  const dropdowns = [...document.querySelectorAll(".wil-dropdown__panel")];
  if (!btns || !btns.length) return;
  btns.forEach((element, key, parent) => {
    const panel = element.nextElementSibling;
    const panelClass = panel.classList;

    if (!panel) return;
    element.addEventListener("click", (event) => {
      event && event.preventDefault();

      dropdowns.forEach((item) => {
        if (item === panel) {
          return;
        }
        if (!item.classList.contains("hidden")) {
          item.classList.add("hidden");
        }
      });
      panelClass.toggle("hidden");
    });

    // === Close DROPDOWN function
    const btnCloses = document.querySelectorAll("[wil-close-dropdown]");
    if (!btnCloses) return;
    btnCloses.forEach((el) => {
      el.addEventListener("click", (event) => {
        event && event.preventDefault();
        panelClass.add("hidden");
      });
    });
  });
}
// Close the dropdown if the user clicks outside of it
document.addEventListener("click", function (event) {
  const btns = [...document.querySelectorAll(".wil-dropdown__btn")];
  const dropdowns = [...document.querySelectorAll(".wil-dropdown__panel")];

  if (btns.some((item) => item.contains(event.target))) {
    return;
  }
  if (!event.target.classList.contains("isClose")) {
    if (dropdowns.some((item) => item.contains(event.target))) {
      return;
    }
  }

  dropdowns.forEach((item) => {
    if (!item.classList.contains("hidden")) {
      item.classList.add("hidden");
    }
  });
});
