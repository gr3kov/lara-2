<div class="search_section_wrapper">
	<form action="#" class="auction__search-wrapper">
		<div>
			<input type="submit" class="auction__search-btn">
			<input type="search" class="auction__search" placeholder="Поиск">
		</div>
	</form>
	<div class="mobile_filter">
		<img src="./img/icons/candle.svg" alt="candle">
	</div>
</div>

<div class="auction__filterbarmobile">
	<form action="#" class="auction__filterbar-form">
		<div class="auction__filterbar-heading">
			<div class="auction__filterbar-heading-title"></div>
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
			<h3 class="auction__filterbar__attribute-heading">
				Категории
			</h3>
			<ul class="auction__filterbar__attribute-list is-active">
				<li class="auction__filterbar__attribute-item">
					<input type="checkbox" class="auction__filterbar__attribute-input" id="category--all">
					<label for="category--all" class="auction__filterbar__attribute-label">Все категории</label>
				</li>
				<li class="auction__filterbar__attribute-item">
					<input type="checkbox" class="auction__filterbar__attribute-input" id="category--devices">
					<label for="category--devices" class="auction__filterbar__attribute-label">Гаджеты</label>
				</li>
				<li class="auction__filterbar__attribute-item">
					<input type="checkbox" class="auction__filterbar__attribute-input" id="category--electronics">
					<label for="category--electronics" class="auction__filterbar__attribute-label">Электроника</label>
				</li>
				<li class="auction__filterbar__attribute-item">
					<input type="checkbox" class="auction__filterbar__attribute-input" id="category--certificates">
					<label for="category--certificates" class="auction__filterbar__attribute-label">Сертификаты</label>
				</li>
			</ul>
		</div>

		<div class="auction__filterbar__attribute">
			<h3 class="auction__filterbar__attribute-heading">
				Бренд
			</h3>
			<div class="auction__search-wrapper">
				<input type="submit" class="auction__search-btn">
				<input type="search" class="auction__search" placeholder="Поиск">
			</div>
			<ul class="auction__filterbar__attribute-list">
				<li class="auction__filterbar__attribute-item">
					<input type="checkbox" class="auction__filterbar__attribute-input" id="brand--samsung">
					<label for="brand--samsung" class="auction__filterbar__attribute-label">Samsung</label>
				</li>
				<li class="auction__filterbar__attribute-item">
					<input type="checkbox" class="auction__filterbar__attribute-input" id="brand--apple">
					<label for="brand--apple" class="auction__filterbar__attribute-label">Apple</label>
				</li>
			</ul>
		</div>

		<div class="auction__filterbar__attribute">
			<h3 class="auction__filterbar__attribute-heading">
				Вид техники
			</h3>
			<ul class="auction__filterbar__attribute-list">
				<li class="auction__filterbar__attribute-item">
					<input type="checkbox" class="auction__filterbar__attribute-input" id="type--all">
					<label for="type--all" class="auction__filterbar__attribute-label">Все виды техники</label>
				</li>
			</ul>
		</div>
	</form>
</div>
