<?php
// Укажите токен вашего Telegram бота
$telegramBotToken = '6463860132:AAGai5Gv7btM0VegnJLxoZpbyJcgoVDV7RQ';
// Укажите ID чата, куда будут отправляться бекапы
$chatId = '408781731';

// Путь к папке, где будут храниться бекапы
$backupPath = './';

// Установите данные для подключения к MySQL
$dbHost = 'localhost';
$dbUser = 'root';
$dbPassword = '';

// Получите список всех баз данных
$databaseList = getDatabaseList($dbHost, $dbUser, $dbPassword);

// Создайте бекап для каждой базы данных
foreach ($databaseList as $database) {
    $backupFile = $backupPath . $database . '_' . date('YmdHis') . '.sql';
    createBackup($dbHost, $dbUser, $dbPassword, $database, $backupFile);

    // Отправка бекапа в Telegram
    sendBackupToTelegram($telegramBotToken, $chatId, $backupFile, $database . ' ' . date('Y-m-d H:i:s'));
    unlink($backupFile);
}

/**
 * Получает список всех баз данных на сервере MySQL.
 */
function getDatabaseList($host, $user, $password) {
    $link = mysqli_connect($host, $user, $password, null, 3306);
    $result = mysqli_query($link, 'SHOW DATABASES');
    $databases = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $databases[] = $row['Database'];
    }

    mysqli_close($link);
    return $databases;
}

/**
 * Создает бекап указанной базы данных.
 */
function createBackup($host, $user, $password, $database, $backupFile) {
    exec("mysqldump -h$host -u$user $database > $backupFile");
}

/**
 * Отправляет бекап в Telegram бот.
 */
function sendBackupToTelegram($token, $chatId, $backupFile, $name) {
    $url = "https://api.telegram.org/bot$token/sendDocument";
    $file = new CURLFile($backupFile);

    $postData = [
        'chat_id' => $chatId,
        'document' => $file,
        'caption' => $name,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // Добавьте обработку ответа, если необходимо
    // Например, можно проверить $response на наличие ошибок
    // и залогировать результат отправки бекапа в лог файл
}
?>
