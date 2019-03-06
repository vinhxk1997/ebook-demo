$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

$('div.alert').delay(3000).slideUp();

$(function () {
    function readURL(input, id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(id).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('form').on('change', '#avatar_file', function () {
        readURL(this, '#avatar');
    });

    $('form').on('change', '#cover_image', function () {
        readURL(this, '#cover_image');
    });
});
