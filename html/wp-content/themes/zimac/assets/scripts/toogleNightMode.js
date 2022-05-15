const TEXT_LIGHT =
  (document.querySelector("[data-switch-night-mode-text-light]") || {})
    .textContent || "light";
const TEXT_DARK =
  (document.querySelector("[data-switch-night-mode-text-dark]") || {})
    .textContent || "dark";

export default function toogleNightMode() {
  // On page load or when changing themes, best to add inline in `head` to avoid FOUC
  const switchN = [...document.querySelectorAll(`[data-switch-night-mode]`)];
  const defaultTheme = document.querySelector(
    `[data-switch-night-mode-theme-default]`
  );

  const toDark = () => {
    document.querySelector("#root").classList.add("dark");
    if (!switchN.length) return;
    [...document.querySelectorAll("[data-switch-night-mode-text]")].forEach(
      (item) => (item.innerHTML = TEXT_DARK)
    );
    localStorage.theme = "dark";
  };
  const toLight = () => {
    document.querySelector("#root").classList.remove("dark");
    if (!switchN.length) return;
    [...document.querySelectorAll("[data-switch-night-mode-text]")].forEach(
      (item) => (item.innerHTML = TEXT_LIGHT)
    );
    localStorage.theme = "light";
  };

  // Firt time on site
  if (!localStorage.theme) {
    if (!defaultTheme) {
      return;
    }
    if (
      defaultTheme.getAttribute("data-switch-night-mode-theme-default") ===
      "light"
    ) {
      return toLight();
    } else {
      return toDark();
    }
  }

  // After firt time -- Check nightMode from localStore
  if (
    localStorage.theme === "dark" ||
    (!("theme" in localStorage) &&
      window.matchMedia("(prefers-color-scheme: dark)").matches)
  ) {
    toDark();
  } else {
    toLight();
  }

  if (!switchN.length) return;

  //   toogle nightMode from swicthNightMode
  switchN.forEach((el) => {
    el.addEventListener("click", function () {
      if (!document.querySelector("#root").classList.contains("dark")) {
        toDark();
      } else {
        toLight();
      }
    });
  });
}
