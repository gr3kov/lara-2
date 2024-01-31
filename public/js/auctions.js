//sliders
const auc_category_slider = new Swiper(".auction__categories-wrapper", {
    direction: "horizontal",
    slidesPerView: "1",
    speed: 500,
    spaceBetween: 15,
    autoHeight: false,
    observer: true,
    observeParents: true,
    pagination: {
        el: ".auction__categories-pagination",
        type: "bullets",
        clickable: true,
    },
    mousewheel: {
        enabled: true, // Включение поддержки колеса мыши
    },
    breakpoints: {
        1280: {
            slidesPerView: "3",
        },
        768: {
            slidesPerView: "2",
        },
    },
});


const prof_category_slider = new Swiper(".row3__col2.row3__col.row__col", {
  direction: "horizontal",
  slidesPerView: "1",
  speed: 500,
  spaceBetween: 15,
  autoHeight: false,
  observer: true,
  observeParents: true,
  pagination: {
    el: ".auction__categories-pagination",
    type: "bullets",
    clickable: true,
  },
  breakpoints: {
    1280: {
      slidesPerView: "3",
    },
    768: {
      slidesPerView: "2",
    },
  },
});

//filterbar
const showbtn = document.querySelector(".auction__filterbar-heading-showbtn");
showbtn.addEventListener("click", function (e) {
  e.preventDefault();
  e.target.classList.toggle("is-active");
  e.target.parentElement.parentElement.parentElement.parentElement.classList.toggle(
    "is-active"
  );
});

const showbtnFilter = document.querySelector(".mobile_filter");
const filter_bar = document.querySelector(".auction__filterbarmobile");
const seachWrapper = document.querySelector(".search_section_wrapper");
const filter_bar_close = document.querySelector(".mobile_filter-close");
showbtnFilter.addEventListener("click", function (e) {
  e.preventDefault();

  if (filter_bar.style.display === "none") {
    filter_bar.style.display = "block";
    seachWrapper.style.display = "none";
  } else {
    filter_bar.style.display = "none";
  }
});
filter_bar_close?.addEventListener("click", function (e) {
  e.preventDefault();
  seachWrapper.style.display = "flex";
  filter_bar.style.display = "none";
});

const spoilers = document.querySelectorAll(
  ".auction__filterbar__attribute-heading"
);
spoilers.forEach((element) => {
  element.addEventListener("click", function (e) {
    e.target.classList.toggle("is-active");
    e.target.parentElement
      .querySelector(".auction__filterbar__attribute-list")
      .classList.toggle("is-active");
  });
});
