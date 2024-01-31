<aside class="auction__filterbar is-active">
    <form action="#" class="auction__filterbar-form">
        <div class="auction__filterbar-heading">
            <div class="auction__filterbar-heading-title">
                <p class="auction__filterbar-grayp">Фильтрация</p>
                <a href="lot.html" class="auction__filterbar-heading-showbtn is-active"></a>
            </div>
            <div class="auction__filterbar-heading-checked">
                <p style="font-size: 15px">Выбранные категории:</p>
                <ul class="auction__filterbar-heading-checked-items">
                    <li class="auction__filterbar-heading-checked-item" for="category--devices">
                        <p class="auction__filterbar-grayp">Гаджеты</p>
                    </li>
                </ul>
            </div>
        </div>

        <div class="auction__filterbar__attribute">
            <h3 class="auction__filterbar__attribute-heading">Категории</h3>
            <ul class="auction__filterbar__attribute-list is-active">
                <li class="auction__filterbar__attribute-item">
                    <input type="checkbox" class="auction__filterbar__attribute-input"
                           id="category--all">
                    <label for="category--all" class="auction__filterbar__attribute-label">Все
                        категории</label>
                </li>
                <li class="auction__filterbar__attribute-item">
                    <input type="checkbox" class="auction__filterbar__attribute-input"
                           id="category--devices">
                    <label for="category--devices"
                           class="auction__filterbar__attribute-label">Гаджеты</label>
                </li>
                <li class="auction__filterbar__attribute-item">
                    <input type="checkbox" class="auction__filterbar__attribute-input"
                           id="category--electronics">
                    <label for="category--electronics"
                           class="auction__filterbar__attribute-label">Электроника</label>
                </li>
                <li class="auction__filterbar__attribute-item">
                    <input type="checkbox" class="auction__filterbar__attribute-input"
                           id="category--certificates">
                    <label for="category--certificates"
                           class="auction__filterbar__attribute-label">Сертификаты</label>
                </li>
            </ul>
        </div>

        <div class="auction__filterbar__attribute">
            <h3 class="auction__filterbar__attribute-heading">Бренд</h3>
            <ul class="auction__filterbar__attribute-list">
                <li class="auction__filterbar__attribute-item">
                    <input type="checkbox" class="auction__filterbar__attribute-input"
                           id="brand--samsung">
                    <label for="brand--samsung"
                           class="auction__filterbar__attribute-label">Samsung</label>
                </li>
                <li class="auction__filterbar__attribute-item">
                    <input type="checkbox" class="auction__filterbar__attribute-input"
                           id="brand--apple">
                    <label for="brand--apple"
                           class="auction__filterbar__attribute-label">Apple</label>
                </li>
            </ul>
        </div>

        <div class="auction__filterbar__attribute">
            <h3 class="auction__filterbar__attribute-heading">Вид техники</h3>
            <ul class="auction__filterbar__attribute-list">
                <li class="auction__filterbar__attribute-item">
                    <input type="checkbox" class="auction__filterbar__attribute-input"
                           id="type--all">
                    <label for="type--all" class="auction__filterbar__attribute-label">Все виды
                        техники</label>
                </li>
            </ul>
        </div>
    </form>
</aside>
