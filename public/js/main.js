$(document).ready(function () {
    $('#search').on('keyup', function (query, result) {
        $.ajax({
            method: 'POST',
            url: searchurl,
            data: {
                token: $('#search').val(),
                _token: token
            },
            success: function (data) {

                var element=document.getElementById("livesearch");
                element.innerHTML=data['results'];
            },
            error: function (data) {
                if (data.status === 422) {
                    var errors = data.responseJSON;
                    $.each(errors, function (key, value) {
                        alert(value);
                    });
                }
            }
        });

    });

    $('.toggle-button').on('click',function () {
        $('.toggle-class').fadeToggle();
    });
});
