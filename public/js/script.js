document.addEventListener("DOMContentLoaded", function () {
    const style_root = document.querySelector(":root");

    //sidebar menu current page highlight
    const current_page = document.querySelector(".page").id;
    const current_page_link = document.getElementById(
        `sidebar__menu-link--${current_page}`
    );
    if (current_page_link) current_page_link.classList.add("is-active");

    //sidebar menu collapse on 1279px
    const bg = document.querySelector(".sidebar_bg");
    const sidebar = document.querySelector(".sidebar");
    const expand_btn = document.querySelector("#header__menu-link--burger");
    if (expand_btn?.style.display != "none") {
        expand_btn?.addEventListener("click", function () {
            sidebar.classList.toggle("is-collapsed");
            bg.classList.toggle("sidebar_bg_show");
            expand_btn.classList.toggle("is-active");
        });
        bg?.addEventListener("click", () => {
            sidebar.classList.add("is-collapsed");
            bg.classList.remove("sidebar_bg_show");
        });
    }

    if (window.innerWidth <= 1279) {
        sidebar.classList.add("is-collapsed");
    } else {
        sidebar.classList.remove("is-collapsed");
    }
    window.addEventListener("resize", function () {
        if (window.innerWidth <= 1279) {
            sidebar.classList.add("is-collapsed");
        } else {
            sidebar.classList.remove("is-collapsed");
        }
    });

    //header notification tooltip
    if (window.matchMedia("(pointer: coarse)").matches) {
        document
            .getElementById("header__menu-link--notifications")?.addEventListener("click", function (e) {
            if (
                e.target === this ||
                e.target === this.querySelector(".header-notification-unread") ||
                e.target === this.querySelector(".header__menu-item-img") ||
                e.target === this.querySelector(".header__menu-item-img img")
            )
                e.preventDefault();
        });
    }
    window.addEventListener("resize", function () {
        if (window.matchMedia("(pointer: coarse)").matches) {
            document
                .querySelector("#header__menu-link--notifications")?.addEventListener("click", function (e) {
                if (
                    e.target === this ||
                    e.target === this.querySelector(".header-notification-unread") ||
                    e.target === this.querySelector(".header__menu-item-img") ||
                    e.target === this.querySelector(".header__menu-item-img img")
                )
                    e.preventDefault();
            });
        }
    });

    //header menu language icon change
    let user_lang = navigator.language || navigator.userLanguage;
    let headerLang = document.getElementById("header__menu-link--language");
    if (headerLang) {
        headerLang.style.background = `url('./img/icons/languages/${user_lang}.svg') center / contain no-repeat;`;
    }

    //page tab change
    const page_tab_btns = document.querySelectorAll(".page__tab-btn");

    if (page_tab_btns.length > 0) {
        for (let i = 0; i < page_tab_btns.length; i++) {
            if (page_tab_btns[i].classList.contains("is-active")) {
                document
                    .getElementById(page_tab_btns[i].getAttribute("for"))
                    .classList.add("is-active");
            } else
                document
                    .getElementById(page_tab_btns[i].getAttribute("for"))
                    .classList.remove("is-active");

            page_tab_btns[i].addEventListener("click", function (e) {
                page_tab_btns.forEach((element) => {
                    element.classList.remove("is-active");
                    document
                        .getElementById(element.getAttribute("for"))
                        .classList.remove("is-active");
                });

                document
                    .getElementById(e.target.getAttribute("for"))
                    .classList.add("is-active");
                e.target.classList.add("is-active");
            });
        }
    }

    //modal windows
    const modal_wrapper = document.querySelector(".modal-wrapper");
    if (modal_wrapper) {
        function closemodal() {
            modal_wrapper.classList.remove("is-active");
            document.querySelector(".body").style.overflow = "visible";
        }

        if (modal_wrapper.classList.contains("is-active")) {
            document.querySelector(".body").style.overflow = "hidden";
            modal_wrapper.addEventListener("click", function (e) {
                if (e.target === this) {
                    e.preventDefault();
                    closemodal();
                }
            });
        }

        const modal_slider = new Swiper(".modal.swiper", {
            direction: "horizontal",
            slidesPerView: "1",
            speed: 500,
            watchOverflow: false,
            loop: false,
            autoHeight: false,
            observer: true,
            observeParents: true,
            observeSlideChildren: true,
            allowTouchMove: false,
            pagination: {
                el: ".modal-pagination",
                type: "bullets",
                clickable: true,
            },
            navigation: {
                nextEl: ".modal-nextel",
            },
        });

        const modal_nextbtn = document.querySelector(".modal-nextel");
        const modal_slides = document.querySelectorAll(".modal-slide");
        const modal_last_slide_index = modal_slides.length - 1;
        let real_index = 0;

        modal_nextbtn.removeAttribute("disabled");
        modal_slider.on("slideChange", function () {
            real_index = modal_slider.realIndex;
            modal_nextbtn.removeAttribute("disabled");
        });

        modal_nextbtn.addEventListener("click", function (e) {
            if (!modal_slider.animating)
                if (
                    e.target.matches('[aria-disabled="true"]') &&
                    real_index === modal_last_slide_index
                )
                    closemodal();
        });
    }

    //код из файла login.js по регистрации\входу
    //password show btn
    showpass_btns = document.querySelectorAll(".login__password-show-btn");
    showpass_btns.forEach((element) => {
        element.addEventListener("click", function (e) {
            e.preventDefault();
            if (e.target.classList.contains("is-active")) {
                e.target.classList.remove("is-active");
                e.target.previousElementSibling.setAttribute("type", "password");
            } else {
                e.target.classList.add("is-active");
                e.target.previousElementSibling.setAttribute("type", "text");
            }
        });
    });

    //slider
    const login_slider = new Swiper(".login__slider", {
        direction: "horizontal",
        speed: 500,
        slidesPerView: "1",
        loop: true,
        navigation: {
            nextEl: ".login__slider-arrow.swiper-button-next",
            prevEl: ".login__slider-arrow.swiper-button-prev",
        },
        pagination: {
            el: ".login__slider-pagination",
            type: "bullets",
            clickable: true,
        },
    });

    //change forms
    const tab_btns = document.querySelectorAll(".login__form-tab-btn");
    if (tab_btns.length > 0) {
        tab_btns.forEach((btn) => {
            btn.addEventListener("click", function (e) {
                e.preventDefault();
                e.target.parentElement.parentElement.parentElement.classList.remove(
                    "is-active"
                );
                document
                    .getElementById(e.target.getAttribute("for"))
                    .classList.add("is-active");
            });
        });
    }

    //barchart !!(required defined width and height on main parent (parent of barchart-wrapper))
    const barcharts = document.querySelectorAll(".barchart");
    if (barcharts.length > 0) {
        barcharts.forEach((barchart) => {


            let data = []; // [index, key]

            let period = "week"; //week, month
            let monthTicks = [
                "Янв",
                "Февр",
                "Март",
                "Апр",
                "Май",
                "Июнь",
                "Июль",
                "Авг",
                "Сент",
                "Окт",
                "Нояб",
                "Дек",
            ];

            let weekTicks = ["ПН", "ВТ", "СР", "ЧТ", "ПТ", "СБ", "ВС"];

            function getWeekData() {
                $.ajax({
                    url: '/get-last-week-earning',
                    type: 'GET',
                    dataType: 'json',
                    success: function (datas) {
                        data = datas
                        drawBarChart()
                    },
                    error: function (error) {
                        console.error('Error:', error);
                    }
                });
            }

            function getMonthData() {
                $.ajax({
                    url: '/get-last-month-earning',
                    type: 'GET',
                    dataType: 'json',
                    success: function (datas) {
                        data = datas
                        drawBarChart()
                    },
                    error: function (error) {
                        console.error('Error:', error);
                    }
                });
            }

            getMonthData()

            let currency = "";
            let currencyText = "";
            let currencyColor = "#ffa01c";

            let barchartLegend = barchart.parentElement.querySelector(
                ".barchart-heading-legend"
            );
            let barchartTotal = barchart.parentElement.parentElement.querySelector(
                ".barchart-heading-total-span"
            );

            let nav_select = barchart.parentElement.querySelector(
                ".barchart-nav-select"
            );
            nav_select.addEventListener('change', function () {
                if(this.value === "month") {
                    getMonthData();
                } else {
                    getWeekData()
                }
            });


            window.addEventListener("resize", function (event) {
                drawBarChart();
            });

            function drawBarChart() {
                barchart.textContent = ""; //delete old barchart

                let totalProfit = 0;

                let xAxis = document.createElement("div");
                xAxis.classList.add(".barchart--xAxis");
                xAxis.style.position = "absolute";
                xAxis.style.left = "0";
                xAxis.style.bottom = "0";
                xAxis.style.height = "1px";
                xAxis.style.width = "100%";
                xAxis.style.backgroundColor = "rgba(255,255,255,0.1)";
                barchart.appendChild(xAxis);

                let yAxis = document.createElement("div");
                yAxis.classList.add(".barchart--yAxis");
                yAxis.style.position = "absolute";
                yAxis.style.top = "-10px";
                yAxis.style.left = "10px";
                yAxis.style.bottom = "0";
                yAxis.style.height = "calc(100% + 10px)";
                yAxis.style.width = "1px";
                yAxis.style.backgroundColor = "rgba(255,255,255,0.1)";
                barchart.appendChild(yAxis);

                let xMax = 0;
                let yMax = 0;

                for (let i = 0; i < data.length; i++) {
                    if (data[i][0] > xMax) {
                        xMax = data[i][0];
                    }
                    if (data[i][1] > yMax) {
                        yMax = data[i][1];
                    }
                }

                let xScale = xAxis.offsetWidth / (xMax + 1);
                let yScale = (yAxis.offsetHeight - 10) / yMax;

                for (let i = 0; i < data.length; i++) {
                    let bar = document.createElement("div");
                    bar.classList.add("barchart-bar");
                    bar.style.height = data[i][1] * yScale + "px";
                    bar.style.backgroundColor = currencyColor;
                    bar.style.top = yAxis.offsetHeight - 10 - data[i][1] * yScale + "px";
                    bar.style.left = data[i][0] * xScale + "px";
                    barchart.appendChild(bar);

                    bar.style.position = "absolute";
                    bar.style.zIndex = "2";
                    bar.style.width = "14px";
                    bar.style.borderRadius = "24px";

                    let barLabel = document.createElement("div");
                    barLabel.classList.add("barchart-bar-label");
                    barLabel.textContent = data[i][1];

                    barLabel.style.color = currencyColor;

                    barLabel.style.fontWeight = "600";
                    barLabel.style.fontSize = "10px";
                    barLabel.style.position = "absolute";
                    barLabel.style.left = "50%";
                    barLabel.style.WebkitTransform = "translateX(-50%)";
                    barLabel.style.transform = "translateX(-50%)";
                    barLabel.style.top = "-20px";
                    barLabel.style.backgroundColor = "#171A1E";

                    bar.appendChild(barLabel);

                    let xTick = document.createElement("div");
                    let xTick_line = document.createElement("div");
                    xTick.classList.add("barchart-xAxis-tick");
                    if (period === "week") xTick.textContent = weekTicks[data[i][0] - 1];
                    else if (period === "month")
                        xTick.textContent = monthTicks[data[i][0] - 1]; //switch for more
                    xTick.style.position = "absolute";
                    xTick.style.height = "calc(100% + 10px)";
                    xTick.style.top = yAxis.offsetHeight - data[i][0] * yScale + "px";
                    xTick.style.left = data[i][0] * xScale + "px";
                    xTick.style.fontWeight = "300";
                    xTick.style.fontSize = "10px";
                    xTick.style.color = "rgba(255,255,255,0.1)";

                    xTick_line.style.position = "absolute";
                    xTick_line.style.top = "calc(-100% - 10px)";
                    xTick_line.style.left = "5.5px";
                    xTick_line.style.backgroundColor = "rgba(255,255,255,0.1)";
                    xTick_line.style.width = "0.5px";
                    xTick_line.style.height = "100%";
                    xTick.appendChild(xTick_line);
                    barchart.appendChild(xTick);

                    let yTick = document.createElement("div");
                    let yTick_line = document.createElement("div");
                    yTick.classList.add("barchart-yAxis-tick");
                    let statusBar =
                        Math.abs(data[i][1]) > 999
                            ? Math.sign(data[i][1]) *
                            (Math.abs(data[i][1]) / 1000).toFixed(1) +
                            " k"
                            : Math.sign(data[i][1]) * Math.abs(data[i][1]) + " k";

                    yTick.textContent = statusBar;
                    yTick.style.position = "absolute";
                    yTick.style.width = "100%";

                    yTick.style.top =
                        yAxis.offsetHeight - 10 - data[i][1] * yScale - 6 + "px";
                    let n = 10;

                    yTick.style.left = -6 + "ch";
                    yTick.style.fontWeight = "300";
                    yTick.style.fontSize = "12px";
                    yTick.style.color = "rgba(255,255,255,0.1)";

                    yTick_line.style.position = "absolute";
                    yTick_line.style.left = `6ch`;
                    yTick_line.style.top = "50%";
                    yTick_line.style.transform = "translateY(-50%)";
                    yTick_line.style.backgroundColor = "rgba(255,255,255,0.1)";
                    yTick_line.style.height = "0.5px";
                    yTick_line.style.width = "100%";
                    yTick.appendChild(yTick_line);
                    barchart.appendChild(yTick);

                    totalProfit = totalProfit + data[i][1];
                }

                barchartLegend.textContent = currencyText;
                barchartLegend.style.color = currencyColor;
                barchartTotal.textContent = totalProfit.toString() + " " + currencyText;
            }

        });
    }

    //modal info
    const toggleInfoModal = (modalWindow, input) => {
        modalWindow.classList.toggle("info-wrapper__show");
        input.focus();
    };

    // вывод средств
    const cashOutputModal = document.querySelector(".cashOutput__modal-wrapper");
    const cashOutputModalCloseBtn = cashOutputModal?.querySelector(
        ".info-modal__close-btn"
    );
    const cashBankRows = cashOutputModal?.querySelectorAll(".bank-row");
    const cashCryptoRows = cashOutputModal?.querySelectorAll(".crypto-row");

    cashOutputModalCloseBtn?.addEventListener("click", () =>
        cashOutputModal?.classList.remove("info-wrapper__show")
    );
    if (window.jQuery) {
        if ($("#cashOutputType").length) {
            $("#cashOutputType").selectmenu({
                classes: {
                    "ui-selectmenu-button": "checkedInput",
                    "ui-selectmenu-text": "selectText",
                    "ui-selectmenu-icon": "selectIcon",
                },
                change: function () {
                    $("#cashOutputType option:selected").each(function () {
                        if ($(this).val() === "crypto") {
                            cashBankRows?.forEach((row) => {
                                row.classList.remove("bank-row__show");
                            });
                            cashCryptoRows?.forEach((row) => {
                                row.classList.add("crypto-row__show");
                            });
                            $("input:text").val("");
                        } else {
                            cashBankRows?.forEach((row) => {
                                row.classList.add("bank-row__show");
                            });
                            cashCryptoRows?.forEach((row) => {
                                row.classList.remove("crypto-row__show");
                                $("input:text").val("");
                            });
                            $("input:text").val("");
                        }
                    });
                },
            });
        }
        $(document).ready(function () {
            $('.auction__card.goto').click(function () {
                var target = $(this).attr('target');
                if (target) location.href = target;
            });
            $('.auction__card.goto a').click(function () {
                var target = $(this).attr('href');
                if (target) location.href = target;
                return false;
            });
            $('.auction__card.goto button').click(function () {
                return false;
            });
            $('.auction__card .fav_button').click(function () {
                if ($('form#login').length) {
                    location.href = '/login';
                    return false;
                }
                let butt = $(this);
                $.ajax({
                    url: '/add/favorite/' + $(this).parents('.auction_item').data('id'),
                    success: function (data) {
                        if (data == 'add') butt.addClass('active').children('.text').text('Убрать из избранного');
                        if (data == 'delete') butt.removeClass('active').children('.text').text('Добавить в избранное');
                    }
                });
                return false;
            });
            $('.lot__card .fav_button').click(function () {
                let butt = $(this);
                $.ajax({
                    url: '/add/favorite/' + $(this).data('id'),
                    success: function (data) {
                        if (data == 'add') butt.addClass('active').children('.text').text('Убрать из избранного');
                        if (data == 'delete') butt.removeClass('active').children('.text').text('Добавить в избранное');
                    }
                });
                return false;
            });
        });
    } else {
        console.log("jQuery не используется!");
    }

    //способы вывода
    const outputModal = document.querySelector(".output__modal-wrapper");
    const outputModalCloseBtn = outputModal?.querySelector(
        ".info-modal__close-btn"
    );
    const addBtn = outputModal?.querySelector(".action-modal__info-btn");
    const goBackBtn = outputModal?.querySelector("#deny-action__modal-btn-close");

    outputModalCloseBtn?.addEventListener("click", () =>
        outputModal?.classList.remove("info-wrapper__show")
    );
    goBackBtn?.addEventListener("click", () =>
        outputModal?.classList.remove("info-wrapper__show")
    );
    addBtn?.addEventListener("click", () => {
        outputModal?.classList.remove("info-wrapper__show");
        createOutputModal?.classList.add("info-wrapper__show");
    });

    // добавление способа вывода, заполнение полей
    const createOutputModal = document.querySelector(
        ".createOutput__modal-wrapper"
    );
    const submitBtn = createOutputModal?.querySelector(
        "#createOutput__modal-btn-submit"
    );
    const createOutputModalCloseBtn = createOutputModal?.querySelector(
        ".info-modal__close-btn"
    );
    const typePay = createOutputModal?.querySelector("#typePay");
    const cardNumInput = createOutputModal?.querySelector("#cardNum");
    const smsCodeInput = createOutputModal?.querySelector("#code");
    const networkInput = createOutputModal?.querySelector("#network");
    const accountInput = createOutputModal?.querySelector("#account");
    const bankRows = createOutputModal?.querySelectorAll(".bank-row");
    const cryptoRows = createOutputModal?.querySelectorAll(".crypto-row");

    const toggleDisableButton = () => {
        if (
            (cardNumInput?.value.trim() != "" && smsCodeInput?.value.trim() != "") ||
            (networkInput?.value.trim() != "" &&
                accountInput?.value.trim() != "" &&
                smsCodeInput?.value.trim() != "")
        ) {
            submitBtn?.removeAttribute("disabled", "");
            submitBtn?.classList.remove("gray-btn");
            submitBtn?.classList.add("submit-btn");
        } else {
            submitBtn?.setAttribute("disabled", "");
            submitBtn?.classList.remove("submit-btn");
            submitBtn?.classList.add("gray-btn");
        }
    };

    cardNumInput?.addEventListener("change", () => toggleDisableButton());
    smsCodeInput?.addEventListener("change", () => toggleDisableButton());
    networkInput?.addEventListener("change", () => toggleDisableButton());
    accountInput?.addEventListener("change", () => toggleDisableButton());
    createOutputModalCloseBtn?.addEventListener("click", () =>
        createOutputModal?.classList.remove("info-wrapper__show")
    );
    if (window.jQuery) {
        if ($("#typePay").length) {
            $("#typePay").selectmenu({
                width: "100%",

                classes: {
                    "ui-selectmenu-button": "typePay__checkedInput",
                    "ui-selectmenu-text": "typePay__selectText",
                    "ui-selectmenu-icon": "typePay__selectIcon",
                    "ui-selectmenu-open": "typePay__selectOption",
                },
                change: function () {
                    $("#typePay option:selected").each(function () {
                        if ($(this).text() === "Криптокошелек") {
                            bankRows?.forEach((row) => {
                                row.classList.remove("bank-row__show");
                            });
                            cryptoRows?.forEach((row) => {
                                row.classList.add("crypto-row__show");
                            });
                            $("input:text").val("");
                            submitBtn?.setAttribute("disabled", "");
                            submitBtn?.classList.remove("submit-btn");
                            submitBtn?.classList.add("gray-btn");
                        } else {
                            bankRows?.forEach((row) => {
                                row.classList.add("bank-row__show");
                            });
                            cryptoRows?.forEach((row) => {
                                row.classList.remove("crypto-row__show");
                                $("input:text").val("");
                            });
                            $("input:text").val("");
                            submitBtn?.setAttribute("disabled", "");
                            submitBtn?.classList.remove("submit-btn");
                            submitBtn?.classList.add("gray-btn");
                        }
                    });
                },
            });
        }
    } else {
        console.log("jQuery не используется!");
    }

    // окно Баланса
    const balanceBtn = document.querySelector("#balance-action-btn");
    const balanceSettingBtn = document.querySelector("#balance__setting");
    balanceBtn?.addEventListener("click", () => {
        cashOutputModal?.classList.add("info-wrapper__show");
    });
    balanceSettingBtn?.addEventListener("click", () =>
        outputModal?.classList.add("info-wrapper__show")
    );

    //не указаны данные Instagram
    const instagramInput = document.querySelector(
        "#settings-userdata--instagram"
    );
    const instagramModal = document.querySelector(".no-instagram__modal-wrapper");
    const instagramBtn = instagramModal?.querySelector(
        "#no-instagram__modal-btn"
    );
    const instagramCloseBtn = instagramModal?.querySelector(
        ".info-modal__close-btn"
    );
    //условие для показа модалки
    // if (instagramInput.value === "") {
    //   instagramModal.classList.toggle("info-wrapper__show");
    // }
    instagramBtn?.addEventListener("click", () =>
        toggleInfoModal(instagramModal, instagramInput)
    );
    instagramCloseBtn?.addEventListener("click", () =>
        instagramModal.classList.remove("info-wrapper__show")
    );

    //подтвердить почту
    const mailInput = document.querySelector("#settings-userdata--email");
    const mailModal = document.querySelector(
        ".settings-mailchange__modal-wrapper"
    );
    const mailBtn = mailModal?.querySelector("#settings-mailchange__modal-btn");
    const mailCloseBtn = mailModal?.querySelector(".info-modal__close-btn");
    //условие для показа модалки
    // if (mailInput.value === "") {
    //   mailModal.classList.toggle("info-wrapper__show");
    // }
    mailBtn?.addEventListener("click", () =>
        toggleInfoModal(mailModal, mailInput)
    );
    mailCloseBtn?.addEventListener("click", () =>
        mailModal?.classList.remove("info-wrapper__show")
    );

    //не привязан номер телефона
    const phoneInput = document.querySelector("#settings-userdata--phone");
    const phoneModal = document.querySelector(
        ".settings-phonechange__modal-wrapper"
    );
    const phoneBtn = phoneModal?.querySelector(
        "#settings-phonechange__modal-btn"
    );
    const phoneCloseBtn = phoneModal?.querySelector(".info-modal__close-btn");
    //условие для показа модалки
    // if (phoneInput.value === "") {
    //   phoneModal.classList.toggle("info-wrapper__show");
    // }
    phoneBtn?.addEventListener("click", () =>
        toggleInfoModal(phoneModal, phoneInput)
    );
    phoneCloseBtn?.addEventListener("click", () =>
        phoneModal?.classList.remove("info-wrapper__show")
    );

    //недостаточно
    const tokenValue = document.querySelector(
        "#header__menu-link--tockens"
    )?.outerText;
    const rotoInput = document.querySelector("#settings-userdata--phone");
    const rotoModal = document.querySelector(
        ".settings-rotochange__modal-wrapper"
    );
    const rotoBtn = rotoModal?.querySelector("#settings-rotochange__modal-btn");
    const rotoCloseBtn = rotoModal?.querySelector(".info-modal__close-btn");
    rotoBtn?.addEventListener("click", () =>
        toggleInfoModal(rotoModal, rotoInput)
    );
    rotoCloseBtn?.addEventListener("click", () =>
        rotoModal?.classList.remove("info-wrapper__show")
    );
    //условие для показа модалки
    // if (tokenValue == 20) {
    //   rotoModal.classList.add("info-wrapper__show");
    // }

    //места в лоте закончились
    const lotPlacesInput = document.querySelectorAll(".auction__card-placesleft");
    const lotPlacesModal = document.querySelector(".lot-places__modal-wrapper");
    const lotPlacesBtn = lotPlacesModal?.querySelector("#lot-places__modal-btn");
    const lotPlacesCloseBtn = lotPlacesModal?.querySelector(
        ".info-modal__close-btn"
    );
    //условие для показа модалки
    // if (lotPlacesInput.value === "") {
    //   lotPlacesModal.classList.toggle("info-wrapper__show");
    // }
    lotPlacesBtn?.addEventListener("click", () =>
        toggleInfoModal(lotPlacesModal, lotPlacesInput)
    );
    lotPlacesCloseBtn?.addEventListener("click", () =>
        lotPlacesModal.classList.remove("info-wrapper__show")
    );

    //вы не оплатили лот
    const lotModal = document.querySelector(".lot__modal-wrapper");
    const lotBtn = lotModal?.querySelector("#lot__modal-btn");
    const lotCloseBtn = lotModal?.querySelector(".info-modal__close-btn");
    //условие для показа модалки
    // if (lotInput.value === "") {
    //   lotModal.classList.toggle("info-wrapper__show");
    // }
    lotBtn?.addEventListener("click", () => toggleInfoModal(lotModal, lotInput));
    lotCloseBtn?.addEventListener("click", () =>
        lotModal?.classList.remove("info-wrapper__show")
    );

    //дополните почту
    // const mailInput = document.querySelector("#settings-userdata--email");
    const noMailModal = document.querySelector(".no-mail__modal-wrapper");
    const noMailBtn = noMailModal?.querySelector("#no-mail__modal-btn");
    const noMailCloseBtn = noMailModal?.querySelector(".info-modal__close-btn");
    //условие для показа модалки
    // if (mailInput.value === "") {
    //   noMailModal.classList.toggle("info-wrapper__show");
    // }
    noMailBtn?.addEventListener("click", () =>
        toggleInfoModal(noMailModal, noMailInput)
    );
    noMailCloseBtn?.addEventListener("click", () =>
        noMailModal?.classList.remove("info-wrapper__show")
    );

    //не подтвержден телефон
    const verifyPhoneInput = document.querySelector("#settings-userdata--phone");
    const verifyPhoneModal = document.querySelector(
        ".verify-phone__modal-wrapper"
    );
    const verifyPhoneBtn = verifyPhoneModal?.querySelector(
        "#verify-phone__modal-btn"
    );
    const verifyPhoneCloseBtn = verifyPhoneModal?.querySelector(
        ".info-modal__close-btn"
    );
    //условие для показа модалки
    // if (verifyPhoneInput.value === "") {
    //   verifyPhoneModal.classList.toggle("info-wrapper__show");
    // }
    verifyPhoneBtn?.addEventListener("click", () =>
        toggleInfoModal(verifyPhoneModal, verifyPhoneInput)
    );
    verifyPhoneCloseBtn?.addEventListener("click", () =>
        verifyPhoneModal?.classList.remove("info-wrapper__show")
    );

    // добавить лот в избранное
    const favIcon = document.querySelectorAll(".favorite-icon");
    const favText = document.querySelectorAll(".favorite-text");
    favIcon?.forEach((icon, index) => {
        icon.addEventListener("click", () => {
            icon.classList.toggle("isForite");
            if (icon.classList.contains("isForite")) {
                favText[index].textContent = "Добавлено в избранное";
            } else {
                favText[index].textContent = "Добавить в избранное";
            }
        });
    });

    //отмена операции
    const denyActionModal = document.querySelector(".deny-action__modal-wrapper");
    const denyBtn = document.querySelector("#outputHistory_deny-btn");
    const denyBtnMobile = document.querySelector(
        "#outputHistory_deny-btn__mobile"
    );
    const denyActionCloseBtn = denyActionModal?.querySelector(
        ".info-modal__close-btn"
    );
    const denyActionBtn = denyActionModal?.querySelector(
        "#deny-action__modal-btn-close"
    );

    denyBtn?.addEventListener("click", () =>
        denyActionModal?.classList.add("info-wrapper__show")
    );
    denyBtnMobile?.addEventListener("click", () =>
        denyActionModal?.classList.add("info-wrapper__show")
    );
    denyActionCloseBtn?.addEventListener("click", () =>
        denyActionModal?.classList.remove("info-wrapper__show")
    );
    denyActionBtn?.addEventListener("click", () =>
        denyActionModal?.classList.remove("info-wrapper__show")
    );

    //отвязать карту
    const untieCardModal = document.querySelector(".untieCard__modal-wrapper");
    const untieCardCloseBtn = untieCardModal?.querySelector(
        ".info-modal__close-btn"
    );
    const untieDenyBtn = untieCardModal?.querySelector(
        "#untieCard__modal-btn-close"
    );

    untieCardCloseBtn?.addEventListener("click", () =>
        untieCardModal?.classList.remove("info-wrapper__show")
    );
    untieDenyBtn?.addEventListener("click", () =>
        untieCardModal?.classList.remove("info-wrapper__show")
    );

    //добавление способа вывода
    const addOutputModal = document.querySelector(".addOutput__modal-wrapper");
    const addOutputModalCloseBtn = addOutputModal?.querySelector(
        ".info-modal__close-btn"
    );
    const addOutputBtn = addOutputModal?.querySelector(".action-modal__info-btn");
    const goBack = addOutputModal?.querySelector("#deny-action__modal-btn-close");

    addOutputModalCloseBtn?.addEventListener("click", () =>
        addOutputModal?.classList.remove("info-wrapper__show")
    );
    goBack?.addEventListener("click", () =>
        addOutputModal?.classList.remove("info-wrapper__show")
    );
    addOutputBtn?.addEventListener("click", () => {
        addOutputModal?.classList.remove("info-wrapper__show");
        createOutputModal?.classList.add("info-wrapper__show");
    });

    //подключение телеграм
    const addTelegramModal = document.querySelector(
        ".addTelegram__modal-wrapper"
    );
    const addTelegramCloseBtn = addTelegramModal?.querySelector(
        ".info-modal__close-btn"
    );
    const addTelegramGoBackBtn = addTelegramModal?.querySelector(
        "#addTelegram__modal-btn-close"
    );
    const addTelegram = document.querySelector("#add-telegram-btn");

    addTelegramCloseBtn?.addEventListener("click", () =>
        addTelegramModal?.classList.remove("info-wrapper__show")
    );
    addTelegramGoBackBtn?.addEventListener("click", () =>
        addTelegramModal?.classList.remove("info-wrapper__show")
    );
    addTelegram?.addEventListener("click", () =>
        addTelegramModal?.classList.add("info-wrapper__show")
    );

    // Подтверждение телефона
    const verificationModal = document.querySelector(
        ".verification__modal-wrapper"
    );
    const verificationInput = verificationModal?.querySelector(
        "#verificationPhoneCode"
    );
    const verificationBTN = verificationModal?.querySelector(
        "#verification__modal-btn"
    );
    const verificationCloseBtn = verificationModal?.querySelector(
        ".info-modal__close-btn"
    );

    const toggleVerificationButton = () => {
        if (verificationInput?.value.trim() != "") {
            verificationBTN?.removeAttribute("disabled", "");
            verificationBTN?.classList.remove("gray-btn");
            verificationBTN?.classList.add("submit-btn");
        } else {
            verificationBTN?.setAttribute("disabled", "");
            verificationBTN?.classList.remove("submit-btn");
            verificationBTN?.classList.add("gray-btn");
        }
    };

    verificationInput?.addEventListener("change", () =>
        toggleVerificationButton()
    );
    verificationCloseBtn?.addEventListener("click", () => {
        verificationModal?.classList.remove("info-wrapper__show");
    });

    // Подтверждение Instagram
    const verificationInstagramModal = document.querySelector(
        ".verificationInstagram__modal-wrapper"
    );
    const verificationInstagramCloseBtn =
        verificationInstagramModal?.querySelector(".info-modal__close-btn");
    const verificationInstagramBTN = verificationInstagramModal?.querySelector(
        "#verificationInstagram__modal-btn-close"
    );
    verificationInstagramCloseBtn?.addEventListener("click", () => {
        verificationInstagramModal?.classList.remove("info-wrapper__show");
    });
    verificationInstagramBTN?.addEventListener("click", () => {
        verificationInstagramModal?.classList.remove("info-wrapper__show");
    });

    // Подтверждение E-mail
    const verificationEmailModal = document.querySelector(
        ".verificationEmail__modal-wrapper"
    );
    const verificationEmailCloseBtn = verificationEmailModal?.querySelector(
        ".info-modal__close-btn"
    );
    const verificationEmailBTN = verificationEmailModal?.querySelector(
        "#verificationEmail__modal-btn-close"
    );
    verificationEmailCloseBtn?.addEventListener("click", () => {
        verificationEmailModal?.classList.remove("info-wrapper__show");
    });
    verificationEmailBTN?.addEventListener("click", () => {
        verificationEmailModal?.classList.remove("info-wrapper__show");
    });
    const user = {
        name: "Chacha",
        email: "dfsdf@sdg.er",
        password: "",
        role_id: "",
        confirmation_code: "",
        confirmed: "",
        referrals_id: "",
        news_subs: "",
        is_send_conf: "",
        active: "",
        user_insta: "",
        agreement: "",
        personal_data: "",
        bid: "",
        photo: "",
        ref_code: "",
        mailing: "",
        autobid_notification: "",
        news_notification: "",
        delivery_name: "",
        delivery_post_index: "",
        delivery_city: "",
        delivery_street: "",
        delivery_house: "",
        delivery_apartment: "",
        delivery_phone: "",
        delivery_email: "",
        reg_ip: "",
        is_ban: "",
        instagram_id: "",
        fio: "",
        show_notifications: "",
        notification_count: "",
    };
    // буква ника в кружке
    const nickIcon = () => {
        const lotImageWrapper = document.querySelector(".lot__card_img-wrapper");
        const mail = document.querySelector(".lot__card_img-wrapper-p");

        if (user.photo == "") {
            const letter = user.name[0];
            const text = document.createElement("span");
            const textWrapper = document.createElement("div");
            text.textContent = letter;
            text.classList.add("lot__card-letter-icon");
            textWrapper.classList.add("lot__card-letter-icon-wrapper");
            textWrapper.append(text);
            lotImageWrapper?.insertBefore(textWrapper, mail);
        } else {
            const img = document.createElement("img");
            img.src = user.photo;
            img.style.width = "100%";
            const textWrapper = document.createElement("div");
            textWrapper.classList.add("lot__card-letter-icon-wrapper");
            textWrapper.style.background = "none";
            textWrapper.append(img);
            lotImageWrapper?.insertBefore(textWrapper, mail);
        }
    };
    nickIcon();

    // кнопка назад
    const goBackButton = document.querySelector(".go-back-btn");
    goBackButton?.addEventListener("click", () => {
        history.back();
    });

    // поля телефона, почты, телеграма
    const userInfoRow = document.querySelector(".row2");
    const phoneStatus = document.querySelector(".phone-status");
    const mailStatus = document.querySelector(".mail-status");
    const telegramStatus = document.querySelector(".telegram-status");

    const hideRow = () => {
        if (
            phoneStatus?.classList.contains("is-enabled") &&
            mailStatus?.classList.contains("is-enabled") &&
            telegramStatus?.classList.contains("is-enabled")
        ) {
            userInfoRow.style.display = "none";
        }
    };

    hideRow();

    //filterbar
    const lotHeadingShowbtn = document.querySelector(
        ".lot__filterbar-heading-showbtn"
    );
    lotHeadingShowbtn?.addEventListener("click", function () {
        lotHeadingShowbtn.classList.toggle("is-active");
        document.querySelector(".lot__list-members").classList.toggle("is-active");
        if (lotHeadingShowbtn.classList.contains("is-active")) {
            document.querySelector(".lot__autoclick").style.top = "-232px";
        } else {
            document.querySelector(".lot__autoclick").style.top = "-622px";
        }
    });

    const bar = document.querySelector(".bar");
    const headerNonAuth = document.querySelector(".header")
    bar?.addEventListener("click", () => {
        headerNonAuth.classList.toggle("header-open");
    });
});
