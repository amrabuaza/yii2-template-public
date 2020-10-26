const HIDDEN = "hidden";
$(document).ready(function () {
    $('.language').click(function () {
        const lang = $(this).attr('data-value');
        $.post('site/language?lang=' + lang, function (data) {
            location.reload();
        })
    });
    $(".login-type").click(function () {
        const val = $(this).val();
        $(".login-type-val").val(val);
        if (val === "email") {
            $(".login-phone").addClass(HIDDEN);
            $(".login-email").removeClass(HIDDEN);
        } else {
            $(".login-phone").removeClass(HIDDEN);
            $(".login-email").addClass(HIDDEN);
        }
    })
});