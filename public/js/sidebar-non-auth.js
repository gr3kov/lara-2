document.write(`
<div class="sidebar_bg"></div>
<aside class="sidebar">
    <div class="sidebar__wrapper">
        <div class="logo">
            <a href="index.html" class="logo-img">
                <img src="./img/new-logo.svg" alt="">
            </a>
        </div>
        <div class="login__form-wrapper sidebar-login__form-wrapper">
            <form action="#" class="login__form" id="registration">
                <div class="login__form-heading">
                    <h1 class="login__form-title">Завести аккаунт</h1>
                    <p class="login__form-subtitle">Уже есть аккаунт? <button
                            class="login__form-tab-btn" for="login">Войти</button></p>
                </div>
                <ul class="login__form-items">
                    <li class="form-item">
                        <label for="registration--email">E-mail</label>
                        <input type="text" id="registration--email" placeholder="email@example.com">
                        <p class="system-msg"></p>
                    </li>
                    <li class="form-item">
                        <label for="registration--phone">Номер телефона</label>
                        <input type="text" id="registration--phone" placeholder="+7">
                        <p class="system-msg"></p>
                    </li>
                    <li class="form-item">
                        <label for="registration--password">Пароль</label>
                        <input type="password" id="registration--password">
                        <button class="login__password-show-btn"></button>
                        <p class="system-msg">Минимум 6 символов, не менее 1 цифры, хотя бы 1 символ с
                            верхним регистром</p>
                    </li>
                    <li class="form-item">
                        <label for="registration--promo">Промокод</label>
                        <input type="text" id="registration--promo" placeholder="Необязательный">
                    </li>
                    <li class="form-item login-terms">
                        <input type="checkbox" id="registration--terms">
                        <p class="system-msg">Я прочитал и согласен с&nbsp<a href="terms.html">Условиями и
                                положениями Flame auction</a></p>
                    </li>
                </ul>
                <button class="submit-btn is-disabled" disabled>Зарегистрироваться</button>
            </form>
            <form action="#" class="login__form is-active" id="login">
                <div class="login__form-heading">
                    <h1 class="login__form-title">Вход</h1>
                    <p class="login__form-subtitle">Нет аккаунта?<button
                            class="login__form-tab-btn" for="registration">Создать аккаунт</button>
                    </p>
                </div>
                <ul class="login__form-items">
                    <li class="form-item">
                        <label for="login--email">E-mail</label>
                        <input type="text" id="login--email">
                        <p class="system-msg"></p>
                    </li>
                    <li class="form-item">
                        <label for="login--password">Пароль</label>
                        <input type="password" id="login--password">
                        <button class="login__password-show-btn"></button>
                        <p class="system-msg"></p>
                    </li>
                </ul>
                <button class="submit-btn is-disabled" disabled>Войти</button>
                <div>
                    <div>
                        <button class="login__form-tab-btn" for="passwordrecovery" style="display: block; margin: 10px auto 0;">Забыли пароль?</button>
                    </div>
                </div>
            </form>
            <form action="#" class="login__form" id="passwordrecovery">
                <div class="login__form-heading">
                    <h1 class="login__form-title">Восстановить пароль</h1>
                    <p class="login__form-subtitle">Есть аккаунт?<button
                            class="login__form-tab-btn" for="login">Войти</button>
                    </p>
                </div>
                <ul class="login__form-items">
                    <li class="form-item">
                        <label for="passwordrecovery--email">E-mail</label>
                        <input type="text" id="passwordrecovery--email">
                        <p class="system-msg"></p>
                    </li>
                </ul>
                <button class="submit-btn is-disabled" disabled>Восстановить</button>
                <div class="passwordrecovery-approved-text">
                    <h3>Письмо отправлено</h3>
                    <br>
                    <p>На адрес <span class="passwordrecovery-approved-email">email@example.com</span> выслана ссылка для восстановления пароля. Перейдите по ссылке и установите новый пароль.</p>
                </div>
            </form>
        </div>
        <div class="sidebar__info">
            <div class="sidebar__info-row">
                <img src="./img/icons/phone-grey.svg" alt="">
                <div>
                    <p class="grey-text sidebar__info-row-text">Телефон в России</p>
                    <p class="grey-text">+7(985) 666 34 23</p>
                </div>
            </div>
            <div class="sidebar__info-row">
                <img src="./img/icons/mail-icon.svg" alt="">
                <div>
                    <p class="grey-text sidebar__info-row-text">E-mail</p>
                    <p class="grey-text">info@royal-auction.com</p>
                </div>
            </div>
        </div>
    </div>
</aside>
`);
