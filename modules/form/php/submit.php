<?php

function generateSpamToken() {
    $ip = $_SERVER['REMOTE_ADDR'];
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $time = time();

    // Объедините IP-адрес, User-Agent и время в одну строку
    $spamData = $ip . $userAgent . $time;

    // Сгенерируйте хэш-код для данных антиспама
    $spamToken = md5($spamData);

    // Сохраните токен антиспама в cookies
    setcookie('spam_token', $spamToken, time() + (60 * 60), '/'); // Здесь установлено время жизни в 1 час (можно настроить по вашему усмотрению)

    // Верните токен антиспама для использования на клиентской стороне
    return $spamToken;
}




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    // Генерация токена антиспама
    $spamToken = generateSpamToken();

    // Проверка антиспама
    if (!checkSpamToken($spamToken)) {
        // Ошибка антиспама, выполните соответствующие действия
        // Например, отклоните запрос или отправьте сообщение об ошибке
        http_response_code(403);
        exit();
    }
    // Отправка на email
    $to = 'example@gmail.com';
    $subject = 'New message from contact form';
    $headers = 'From: ' . $email;
    $body = "Name: $name\nEmail: $email\n\n$message";

    mail($to, $subject, $body, $headers);

    // Запись в Google Sheets
    $credentialsPath = 'credentials/credentials.json'; // Укажите путь к файлу учетных данных JSON
    $spreadsheetId = '18oGAVEpIjIzefQyOdBsoaZQkjhk5NavGPa1-koWVrXw'; // Укажите ID вашего документа Google Sheets
    $range = 'Sheet1!A:C'; // Укажите диапазон для записи данных

    require_once 'google/vendor/autoload.php';

    $client = new Google_Client();
    $client->setAuthConfig($credentialsPath);
    $client->addScope(Google_Service_Sheets::SPREADSHEETS);

    $service = new Google_Service_Sheets($client);

    $values = [
        [$name, $email, $message]
    ];

    $body = new Google_Service_Sheets_ValueRange([
        'values' => $values
    ]);

    $params = [
        'valueInputOption' => 'RAW'
    ];

    $result = $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);

    http_response_code(200);
} else {
    http_response_code(403);
}

// Проверка антиспама
function checkSpamToken($submittedToken) {
    $storedToken = $_COOKIE['spam_token'];

    // Сравнение токенов антиспама
    if ($submittedToken === $storedToken) {
        // Токены совпадают, продолжайте обработку данных
        return true;
    }

    // Неверный токен антиспама
    return false;
}
?>
