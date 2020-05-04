$(function () {
    formFn.init();
    commonUI.init();
    livemateUI.init();
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
        $('input[type=text], input[type=password]').on('input', function () {
            // console.log($(this).val());
            $(this).addClass('active');
            $(this).siblings('[data-role=form-text-remove]').addClass('active');
        });
        $('[data-role=form-text-remove]').on('click', function () {
            $(this).siblings('input[type=text], input[type=password]').val('').focus();
            $(this).removeClass('active');
        });
        $('.lv-form-input-cover').on('blur', function () {
            $(this).siblings('[data-role=form-text-remove]').removeClass('active');
        });
        $("input:text[numberOnly]").on("keyup", function () {
            if ($(this).hasClass('commas')) {
                $(this).val(addCommas($(this).val().replace(/[^0-9]/g, "")));
            } else {
                $(this).val($(this).val().replace(/[^0-9]/g, ""));
            }
        });
    }
}

var commonUI = {
    init: function () {
        this.aDisabled();
        this.toastToggle();
        this.modalToggle();
        this.collapseToggle();
    },
    aDisabled: function () {
        $('body').on('click', 'a', function () {
            if ($(this).is("[disabled]")) {
                event.preventDefault();
            }
        });
    },
    toastToggle: function () {
        $('[data-toggle=toast]').on('click', function () {
            var $target = $(this).attr('data-target');
            $($target).show();
            setTimeout(function () {
                $($target).fadeOut(100);
            }, 500)
        });
    },
    modalToggle: function () {
        $('[data-toggle=modal]').on('click', function () {
            var $target = $(this).attr('data-target');
            $($target).show();
            $('body').addClass('not-scroll');
        });
        $('[data-dismiss=modal]').on('click', function () {
            $(this).closest('[class*=modal-wrapper]').fadeOut(100);
            $('body').removeClass('not-scroll');
        });
    },
    collapseToggle: function () {
        $('[data-toggle=collapse]').on('click', function () {
            var $target = $(this).attr('data-target');
            $($target).slideToggle(100);
        });
    }
}

var livemateUI = {
    init: function () {
        this.pointList();
    },
    pointList: function () {
        $('#pointList').slick({
            // autoplay: true,
            centerMode: true,
            slidesToShow: 1,
            centerPadding: '24px',
            infinite: false,
            dots: true,
            appendArrows: '',
        });
    },
}

// 3자리 단위마다 콤마 생성
function addCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

// 모든 콤마 제거
function removeCommas(x) {
    if (!x || x.length == 0) return "";
    else return x.split(",").join("");
}