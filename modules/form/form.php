<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form</title>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Link base CSS styles -->
    <link rel="stylesheet" href="../css/spec.css">
    <!-- Link slider CSS -->
    <link rel="stylesheet" href="css/form.css">


</head>
<body>
<!-- Затемнение фона -->
<div id="overlay" class="overlay"></div>
<section id="form">
    <form id="contact-form" method="post">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Alex" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="example@gmail.com" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" placeholder="+7 (___) ___-____" required>
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message" name="message" placeholder="..." required></textarea>
        </div>
        <div class="form-group">
            <div id="msg"></div>
        </div>
        <div class="loader-container">
            <button id="submit" type="submit">Submit</button>
            <div id="loader" class="loader"></div>
        </div>
        <input type="hidden" name="spam_token" value="<?php echo $spamToken; ?>">
    </form>
</section>
<!-- Всплывающее окно для отображения успешной отправки данных -->
<div id="successPopup" class="popup">
    <h2>Success!</h2>
    <p>Your message has been sent successfully!</p>
    <button onclick="closePopup('successPopup')">Close</button>
</div>

<!-- Всплывающее окно для отображения ошибки отправки данных -->
<div id="errorPopup" class="popup">
    <h2>Error!</h2>
    <p>Error sending message.</p>
    <button onclick="closePopup('errorPopup')">Close</button>
</div>



<!-- Подключение скриптов jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
<script src="js/form.js" defer="defer"></script>
</body>