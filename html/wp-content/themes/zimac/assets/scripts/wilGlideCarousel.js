import Glide from "@glidejs/glide";

export default function _newGlideCarousel() {
  const _toggleDisabledArrow =
    (glide, nextArrow, prevArrow, totalSlides, controls) => () => {
      if (nextArrow && prevArrow) {
        if (!glide._i) {
          prevArrow.setAttribute("disabled", true);
        } else {
          prevArrow.removeAttribute("disabled", true);
        }
        if (glide._i === totalSlides - 1) {
          nextArrow.setAttribute("disabled", true);
        } else {
          nextArrow.removeAttribute("disabled", true);
        }
      }

      if (!controls) {
        controls = glide._c.Controls;
        totalSlides = glide._c.Html.slides.length;
        nextArrow = [...controls._c[0].children].filter(
          (el) => el.getAttribute("data-glide-dir") === ">"
        )[0];
        prevArrow = [...controls._c[0].children].filter(
          (el) => el.getAttribute("data-glide-dir") === "<"
        )[0];
      }
    };

  /**
   *
   * @param {Element} element
   */
  const _intantSlide = (element) => {
    const animationDuration =
      element.getAttribute("data-glide-animationDuration") || 400;
    const glide = new Glide(element, {
      rewind: false,
      animationDuration,
    });
    let controls = null;
    let totalSlides = null;
    let nextArrow = null;
    let prevArrow = null;
    glide.on(
      ["mount.after", "run"],
      _toggleDisabledArrow(glide, nextArrow, prevArrow, totalSlides, controls)
    );
    glide.mount();
  };
  const _intantSlideFade = (element) => {
    const glide = new Glide(element, {
      animationDuration: 1,
      rewindDuration: 1,
      throttle: 1,
      rewind: true,
    });
    let controls = null;
    let totalSlides = null;
    let nextArrow = null;
    let prevArrow = null;

    glide.on(
      ["mount.after", "run"],
      _toggleDisabledArrow(glide, nextArrow, prevArrow, totalSlides, controls)
    );
    glide.mount();
  };
  setTimeout(() => {
    const sliders = [...document.querySelectorAll(".glide")];
    const sliderFades = [...document.querySelectorAll(".glide-fade")];
    sliders.forEach(_intantSlide);
    sliderFades.forEach(_intantSlideFade);
  }, 10);
}
