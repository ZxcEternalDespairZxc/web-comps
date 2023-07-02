<?php
 //link bd
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "testmyform";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $phone = $_POST['phone'];
    // Генерация токена антиспама

    $token = $_COOKIE['token'];
    $timestamp = time();

    // Проверка антиспама
    if ($token == "") {
        // Ошибка антиспама, выполните соответствующие действия
        // Например, отклоните запрос или отправьте сообщение об ошибке
        http_response_code(403);
        exit();
    }


    // Значение токена
    $tokenValue = $token;

    // SQL-запрос для получения последних 5 записей с указанным токеном
    $sql = "SELECT * FROM cookies WHERE token = '$tokenValue' ORDER BY timestamp DESC LIMIT 5";

    // Выполнение запроса
    $result = $conn->query($sql);

    // Проверяем наличие результатов
    if ($result->num_rows > 0) {
        $firstRow = $result->fetch_assoc();

        // Получаем значения полей
        $token = $firstRow["token"];
        $time = $firstRow["timestamp"];
        // Если разница во времени между отправкой первой из пяти последних записей составляет менее одной минуты, то это спам
        if ($timestamp - $time < 60000) {
            http_response_code(403);
            exit();
        }
    }

    // Все проверки пройдены, можно отправить данные
    // Вставка данных в таблицу
    $stmt = $conn->prepare("INSERT INTO cookies (token, timestamp) VALUES (:token, :timestamp)");
    $stmt->bindParam(':token', $token);
    $stmt->bindParam(':timestamp', $timestamp);
    $stmt->execute();
    // Отправка на email
    $to = 'example@gmail.com';
    $subject = 'New message from contact form';
    $headers = 'From: ' . $email;
    $body = "Name: $name\nEmail: $email\n\n$message";

    mail($to, $subject, $body, $headers);

    // Запись в Google Sheets
    $credentialsPath = '../credentials/credentials.json'; // Укажите путь к файлу учетных данных JSON
    $spreadsheetId = '18oGAVEpIjIzefQyOdBsoaZQkjhk5NavGPa1-koWVrXw'; // Укажите ID вашего документа Google Sheets
    $range = 'Sheet1!A:C'; // Укажите диапазон для записи данных

    require_once '../google/vendor/autoload.php';

    $client = new Google_Client();
    $client->setAuthConfig($credentialsPath);
    $client->addScope(Google_Service_Sheets::SPREADSHEETS);

    $service = new Google_Service_Sheets($client);

    $values = [
        [$name, $email, $phone, $message]
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
// Закрытие соединения с базой данных
$conn = null;
?>
