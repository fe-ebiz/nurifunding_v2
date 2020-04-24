$(function () {
    formFn.init();
});

var formFn = {
    init: function () {
        this.toggleOn();
        this.formTextFn();
    },
    toggleOn: function () {
        $('.check-all').click(function () {
            var checkName = $(this).attr('data-check-name');
            $('.check-item[data-check-name="' + checkName + '"]').prop('checked', this.checked);
        });
    },
    formTextFn: function () {
        $('input[type=text]').on('input', function () {
            console.log($(this).val());
            $(this).css('color', '#000');
            $(this).siblings('[data-role=form-text-remove]').addClass('active');
        });
        $('[data-role=form-text-remove]').on('click', function () {
            $(this).siblings('input[type=text]').val('').focus();
            $(this).removeClass('active');
        });
        $('.lv-form-input-cover').on('blur', function () {
            $(this).siblings('[data-role=form-text-remove]').removeClass('active');
        });
    }
}