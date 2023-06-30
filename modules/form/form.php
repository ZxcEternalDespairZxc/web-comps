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
<section id="form">
    <form id="contact-form" method="post">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea>
        </div>
        <button type="submit">Submit</button>
    </form>
</section>



<!-- Подключение скриптов jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/form.js" defer="defer"></script>
</body>