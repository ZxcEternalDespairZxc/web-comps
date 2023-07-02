
// Функция для получения значения токена антиспама из cookies
function getSpamToken() {
    var name = 'spam_token=';
    var decodedCookie = decodeURIComponent(document.cookie);
    var cookieArray = decodedCookie.split(';');

    for (var i = 0; i < cookieArray.length; i++) {
        var cookie = cookieArray[i].trim();
        if (cookie.indexOf(name) === 0) {
            return cookie.substring(name.length, cookie.length);
        }
    }

    return '';
}

$(document).ready(function() {
    // маска
    $('#phone').inputmask({
        mask: '+7 (999) 999-9999',
        placeholder: '+7 (___) ___-____'
    });

    // setcookie
    document.cookie = "token=" + getSpamToken() + ';';
    $('#contact-form').submit(function(event) {
        event.preventDefault(); // Отменяем отправку формы по умолчанию

        // Получаем значения полей
        var name = $('#name').val().trim();
        var email = $('#email').val().trim();
        var phone = $('#phone').val().trim();
        var message = $('#message').val().trim();
        var msg = $('#msg');
        // Проверяем валидность полей
        if (name === '' || email === '' || phone === '' || message === '') {
            msg.html('<p>Пожалуйста, заполните все поля формы.</p>');
            return;
        }

        // Дополнительные проверки для email и phone
        if (!validateEmail(email)) {
            msg.html('<p>Пожалуйста, укажите валидный email</p>');
            return;
        }

        if (!validatePhone(phone)) {
            msg.html('<p>Пожалуйста, укажите валидный номер телефона</p>');
            return;
        }

        // Если все поля прошли валидацию, можно отправить данные
        // Ваш код для отправки данных на сервер

        var form = $(this);
        var formData = form.serialize();
        $.ajax({
            type: 'POST',
            url: '../php/submit.php/',
            data: formData,
            xhrFields: {
                withCredentials: true // Включение отправки cookie
            },
            beforeSend: function(xhr) {
                // Показываем прелоадер перед отправкой данных
                $('#loader').show();
                var cookies = document.cookie.split(';');
                for (var i = 0; i < cookies.length; i++) {
                    var cookie = cookies[i].trim();
                    xhr.setRequestHeader('Cookie', cookie);
                }
            },
            success: function(response) {
                showPopupWithFadeIn('successPopup');
                $('#loader').hide();
                form[0].reset();
            },
            error: function() {
                $('#loader').hide();
                showPopupWithFadeIn('errorPopup');
            }
        });
        // Сброс формы
        $(this).trigger('reset');
    });

    // Закрываем всплывающее окно при клике по фону затемнения
    $('#overlay').on('click', function() {
        closePopup('successPopup');
        closePopup('errorPopup');
    });

    // Функция для проверки валидности email
    function validateEmail(email) {
        var re = /\S+@\S+\.\S+/;
        return re.test(email);
    }

    // Функция для проверки валидности phone
    function validatePhone(phone) {
        // Удаляем все нецифровые символы из номера телефона
        var phoneNumber = phone.replace(/\D/g, '');

        // Проверяем длину номера телефона после удаления нецифровых символов
        if (phoneNumber.length !== 11) {
            return false; // Номер телефона имеет неправильную длину
        }

        // Проверяем соответствие номера телефона заданной маске
        var re = /^\+7 \(\d{3}\) \d{3}-\d{4}$/;
        return re.test(phone);
    }

    // Функция для проверки валидности формы и управления состоянием кнопки "Submit"
    function validateForm() {
        // Получаем значения полей
        var name = $('#name').val().trim();
        var email = $('#email').val().trim();
        var phone = $('#phone').val().trim();
        var message = $('#message').val().trim();
        var submitBtn = $('#submitBtn');

        // Проверяем условие некорректных данных
        if (name === '' || email === '' || phone === '' || message === '') {
            // Если данные некорректны, выводим сообщение об ошибке
            $('#msg').html('<p>Please fill in all fields.</p>');
            // Деактивируем кнопку Submit
            submitBtn.prop('disabled', true);
        } else {
            // Если данные корректны, очищаем сообщение об ошибке
            $('#msg').html('');
            // Активируем кнопку Submit
            submitBtn.prop('disabled', false);
        }
    }

    // При изменении значений полей формы вызываем функцию validateForm
    $('#name').on('input', validateForm);
    $('#email').on('input', validateForm);
    $('#phone').on('input', validateForm);
    $('#message').on('input', validateForm);
});

// Функция для отображения всплывающего окна с анимацией fade in
function showPopupWithFadeIn(popupId) {
    var overlay = $('#overlay');
    var popup = $('#' + popupId);

    overlay.fadeIn();
    popup.css('display', 'block').animate({ opacity: 1 }, 300);
    $('body').addClass('lock-scroll');
}

// Функция для закрытия всплывающего окна
function closePopup(popupId) {
    var overlay = $('#overlay');
    var popup = $('#' + popupId);

    overlay.fadeOut();
    popup.animate({ opacity: 0 }, 300, function() {
        popup.css('display', 'none');
        $('body').removeClass('lock-scroll');
    });
}

