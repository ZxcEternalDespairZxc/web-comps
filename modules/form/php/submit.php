<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

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
?>
