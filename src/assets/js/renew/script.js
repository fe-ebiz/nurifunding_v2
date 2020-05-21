$(function () {


});

//# 자동투자 금액선택
function auto_price(pri) {
    $('input[name="at_price"]').val(pri);
}

//# 자동투자 인증문자 회신여부 체크
function at_tid_chk(tid) {
    var tid_timer = setInterval(function () {
        $.ajax({
            type: "POST",
            data: {
                "mode": "SAofVzdCAUAoFQ==",
                "tid": tid
            },
            url: "/inc/state.php",
            success: function (data) {
                if (data == "Y") {
                    clearInterval(tid_timer);
                    location.reload();
                }
            }
        });
    }, 1000);
}

//# 자동투자 신청
function auto_ask(n) {
    var at_chk = $('input[name="autopay_chk"]');

    // 1: 신규신청 / 2: 연장하기
    if (n == 1) {
        if (at_chk.is(":checked") !== true) {
            alert("자동투자 이용동의에 체크해주세요.");
            return;
        }
        var at_price = $('input[name="at_price"]').val();
    } else {
        var at_price = $('input[name="at_price2"]').val();
    }

    if (at_price < 1) {
        alert("상품별 투자금액을 선택해주세요.");
        return;
    }

    $.ajax({
        type: "POST",
        data: {
            "price": at_price
        },
        url: "/member/auto/autopay.php",
        success: function (data) {
            var ret = data.split("^");

            if (ret[0] == "FAIL") {
                alert(ret[1]);
            } else {
                at_tid_chk(ret[1]);
                $('#autopay_pop').css('display', 'block');
            }
        }
    });
}

//# 자동투자 해지
function auto_cancel() {
    $.ajax({
        type: "POST",
        url: "/member/auto/autopay_cancel.php",
        success: function (data) {
            if (data == "FAIL") {
                alert("해지에 실패하였습니다.");
            } else {
                alert("해지가 완료되었습니다.");
                location.reload();
            }
        }
    });
}