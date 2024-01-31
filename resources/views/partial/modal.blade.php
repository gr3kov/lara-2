@push('styles')
    <link href="{!! asset('css/swiper-bundle.min.css') !!}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{!! asset('js/swiper-bundle.min.js') !!}" type="text/javascript"></script>
@endpush

<div class="auction__modal-wrapper modal-wrapper<?=!config('app.debug') ? ' is-active' : null;?>">
    <div class="auction__modal modal swiper">
        <div class="modal-pagination swiper-pagination"></div>
        <div class="swiper-wrapper">
            <div class="auction__modal-slide modal-slide swiper-slide">
                <div class="modal-img">
                    <img src="/img/modal/auc_dep.png" alt="">
                </div>
                <h3 class="modal-title">Обрати внимание!</h3>
                <p class="modal-paragraph">Депозит для участия в торгах данного лота сразу будет списан с
                    твоего
                    счёта. Депозит является невозвратным и сгорит, если ты не примешь участие в торгах.</p>
            </div>
            <div class="auction__modal-slide modal-slide swiper-slide">
                <div class="modal-img">
                    <img src="/img/modal/auc_anons.png" alt="">
                </div>
                <h3 class="modal-title">Обрати внимание!</h3>
                <p class="modal-paragraph">Ты теперь участник аукциона и можешь увидеть данный лот в разделе
                    “Мои аукционы” - “Анонсы”</p>
            </div>
            <div class="auction__modal-slide modal-slide swiper-slide">
                <div class="modal-img">
                    <img src="/img/modal/auc_active.png" alt="">
                </div>
                <h3 class="modal-title">Обрати внимание!</h3>
                <p class="modal-paragraph">Ты теперь участник аукциона и можешь увидеть данный лот в разделе
                    “Мои аукционы” - “Активные аукционы”</p>
            </div>
        </div>
        <button class="modal-nextel submit-btn swiper-slide-next"></button>
    </div>
</div>
