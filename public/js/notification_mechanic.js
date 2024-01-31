$.ajax({
    url: urlGetNotification,
    dataType: 'json',
    success: function (data) {
        renderNotification(data.notifications);
        renderUnread(data.notificationCount);
    },
    error: function () {
        alert('Не удалось получить уведомления');
    }
});

/**
 * Функция помечает есть ли у юзера непрочитанные уведомления
 *
 * @param notificationCount Количество непрочитанных уведомлений
 */
function renderUnread(notificationCount) {
    if (notificationCount > 0) {
        $('#header__menu-link--notifications .header-notification-unread').addClass('unread');
    }
}

/**
 * Функция отрисовки уведомлений
 *
 * @param notifications Массив уведомлений
 */
function renderNotification(notifications) {
    var resultArray = [],
        template = '';

    // Перебираем все уведомления, пришедшие нам аяксом
    $.each(notifications, function(index, notification) {
        if (notification.auction) {
            template = getLotTemplate(notification);
        } else {
            template = getNewsTemplate(notification);
        }
        resultArray.push(template);
    });

    // Добавляем разделитель между элементами
    result = resultArray.join(getSeparatorTemplate());

    // Добавляем получившиайся результат в соответствующий блок уведомлений
    $('#header__menu-link--notifications .tooltip-content').html(result);
}

/**
 * Функция возвращает элемент шаблона новостей со вставленными данными
 *
 * @param notification Элемент массива уведомлений
 * @return {string}
 */
function getNewsTemplate(notification) {
    var result = '',
        template = '<div class="tooltip-notification">' +
        '    <div class="tooltip-notification-img">' +
        '        <img src="%image%" alt="">' +
        '    </div>' +
        '    <div class="tooltip-notification-text">' +
        '        <p class="tooltip-notification-title">%title%</p>' +
        '        <p class="tooltip-notification-date">%date%</p>' +
        '    </div>' +
        '    <div class="unread"></div>' +
        '</div>';

    result = template.replace('%image%', notification.image);
    result = result.replace('%title%', notification.title);
    result = result.replace('%date%', notification.date);
    return result;
}

/**
 * Функция возвращает элемент шаблона лота со вставленными данными
 *
 * @param notification Элемент массива уведомлений
 * @return {string}
 */
function getLotTemplate(notification) {
    var result = '',
        template = '<a href="/item/%id%"><div class="tooltip-notification is-unread">' +
        '    <div class="tooltip-notification-img tooltip-notification-awardimg">' +
        '        <img src="%lotImage%" alt="">' +
        '    </div>' +
        '    <div class="tooltip-notification-text">' +
        '        <p class="tooltip-notification-title">%title%</p>' +
        '        <p class="tooltip-notification-date">%date%</p>' +
        '    </div>' +
        '    <div class="unread"></div>' +
        '</div></a>';
    if(notification.auction.image === null) {
        notification.auction.image = "/img/icons/auction.svg"
    }

    result = template.replace('%lotImage%', notification.auction.image);
    result = result.replace('%id%', notification.auction.id)
    result = result.replace('%lotTitle%', notification.auction.title);
    result = result.replace('%title%', notification.title);
    result = result.replace('%date%', notification.date);
    return result;
}

/**
 * Функция возвращает шаблон разделителя между уведомлениями
 *
 * @return {string}
 */
function getSeparatorTemplate() {
    return '<div class="line-separator"></div>';
}
