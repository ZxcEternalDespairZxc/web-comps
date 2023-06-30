$(document).ready(function() {
    $('#contact-form').submit(function(event) {
        event.preventDefault();

        var form = $(this);
        var formData = form.serialize();

        $.ajax({
            type: 'POST',
            url: 'php/submit.php',
            data: formData,
            success: function(response) {
                alert('Message sent successfully!');
                form[0].reset();
            },
            error: function() {
                alert('Error sending message.');
            }
        });
    });
});
