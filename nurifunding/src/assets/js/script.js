$(function() {
    
    /*함수실행*/
    //popupCen();
    dataFn();
    goAreaFn();

    $(window).resize(function(){
        hdFn();
        tooltip();
    }).resize();
    
    /* 드롭다운 */
    $(".dropdown").on("click", ".btn", function() {
        $(this).next().slideToggle("fast");
    });
    /*텝박스 기능*/
    $(".tab-box li").on("click", function() {
        var thIdx = $(this).index();
        $(this).closest("ul").find("li").removeClass("on");
        $(this).closest("ul").find("li").eq(thIdx).addClass("on");
        $(this).closest("ul").next().find("li").removeClass("on");
        $(this).closest("ul").next().find("li").eq(thIdx).addClass("on");
    });
    
    //팝업 닫기
    $('.pop-close').on('click', function(){
        popupOff('.pop-com');
    });

});

// 페이지 로딩시 적용 
function dataFn() {
    var dialogOpen = false,
        modal = $('.modal'),
        lastFocus;
    $('[data-toggle]').on('click', function() {
            lastFocus = $(this);
        var objNm = $(this).attr('data-target'),
            obj = $('.' + objNm),
            type = $(this).attr('data-toggle');
            
        switch (type) {
            case ('modal'):
                dialogOpen = true;
                modalFn.enter(obj);
                break;
            default:
                break;        
        }
    });
    $('[data-dismiss]').on('click', function() {
        var type = $(this).attr('data-dismiss'),
            obj =$(this).closest('.' + type);
        switch (type) {
            case ('modal'):
                dialogOpen = false;
                modalFn.leave(obj);
                break;
            default:
                break;        
        }
    });
    $(document).on('keydown', function(e) {
        var obj = modal;
        if (dialogOpen && e.keyCode == 27) {
            dialogOpen = false;
            modalFn.leave(obj);
        }
    });
    modal.on('click', function(e) {
        var obj = $(this);
        if ( dialogOpen && !$(e.target).is('.modal-wrapper *') ) {
            dialogOpen = false;
            modalFn.leave(obj);
        }
    });

    // 모달 영역
    var modalFn =  {
        enter: function(obj) {
            obj.addClass('enter');
            obj.focus();
            $("#wrap").attr('aria-hidden', true);
        },
        leave: function(obj) {
            obj.addClass('leave');
            obj.removeClass('enter');
            setTimeout(function() {obj.removeClass('leave');}, 300);
            $("#wrap").attr('aria-hidden', false);
            lastFocus.focus();
        }
    }
}


// Mobile 해더 기능 
function hdFn() {
    var winWidth = $(window).width(),
        winHeight = $(window).height()
        hd = $("#header"),
        el = hd.children(),
        ht_total = 0;
    // 공통
    $(window).on('scroll', function() {
        var scr = $(window).scrollTop();
        if ( scr > 0 ) {
            hd.children('.gnb').addClass('on');
        } else {
            hd.children('.gnb').removeClass('on');
        }
    });
    if ( winWidth >= 992 ) {
        var menu2 = $('.menu2');
        var menu2Bg = $('#menu2Bg');
        var menu2BgHt = 170;
        var menu2HtArray = [];
        var menu2HtMax = 0;
        menu2.each(function(index, item) {
            menu2HtArray.push($(item).outerHeight());
        });
        menu2HtArray.push(menu2BgHt); 
        menu2HtMax = menu2HtArray.reduce(function(prev, current) {
            return prev > current ? prev : current;
        });
        var pdTop = parseInt(menu2Bg.css('padding-top'));
        menu2Bg.css({
            minHeight: menu2HtMax
        });
        setTimeout( function() {
            menu2.css({
                minHeight: menu2HtMax,
                padding: pdTop + 'px ' + 0
            });
            $('[class*=vline-]').height(menu2HtMax - (pdTop*2) );
        }, 100);
        // $('.menu2:not(.big), #menu2Bg').addClass('on');
        hd.find('.navbar-collapse .menu > li').on('mouseenter', function() {
            $('.menu2:not(.big), #menu2Bg').addClass('on');
        });
        $('.navbar-collapse').on('mouseleave', function() {
            $('.menu2, #menu2Bg').removeClass('on');
        });
        hd.find('.navbar-collapse .menu > li.big').hover(function() {
            $('#autoinvBox').removeClass('on');
        }, function() {
            // $('#autoinvBox').show();
            $('#autoinvBox').addClass('on');
        });
    
    } else {
        // 상단 배너 높이 - 배너 있을 시 없을 시 높이 자동 설정
        el.each(function() {
            ht_total += $(this).outerHeight();
        });
        hd.height(ht_total);
        /*모바일 바 클릭시 모바일 네비게이션 등장*/
        $('.header .nav-tab').on('click', function() {
            var ncHeaderHt = $('.nc-header').outerHeight();
            $('#navbar-collapse').addClass('on');
            $('#navbar-collapse').prev().addClass('on');
            $('#navbar-collapse .menu').height( winHeight - ncHeaderHt);
            wheelFn(false);
        });
        /*모바일 네비게이션 닫기 버튼*/
        $('#navbar-collapse .cls-btn').on('click', function() {
            navbarCollapse.close();
            wheelFn(true);
        });
        $('#navbar-collapse').prev('.bg-drop').on('click', function() {
            navbarCollapse.close();
            wheelFn(true);
        });
    }

    var navbarCollapse = {
        close: function() {
            $('#navbar-collapse').removeClass('on');
            $('#navbar-collapse').prev().removeClass('on');
        }
    }
}

function wheelFn(flag) {
    if (flag == false) {
        $('html').css({
            overflow: 'hidden'
        });
    }
    if (flag == true) {
        $('html').css({
            overflow: 'auto'
        });
    }

}

function bgDrop(flag) {
    if (flag == true) {
        $('#bg-drop').addClass('on')
    } else {
        $('#bg-drop').removeClass('on')
    }
}

function tooltip() {
    var winW = $(window).width();
    /* 툴팁 */
    if (winW <= 768) {
        $(".btn-tooltip").on("click", function() {
            $(".tooltip-detail").fadeIn();
        });

        $(".tooltip-detail").on("click", function() {
            $(".tooltip-detail").fadeOut();
        });
    } else {
        $(".btn-tooltip").hover(function(){
            $(".tooltip-detail").fadeIn();
        }, function(){
            $(".tooltip-detail").fadeOut();
        });
    }
}

/* 팝업 오픈  */
function popupOn(openitem){
    var oitm = $(openitem);
    
    oitm.show();
    
    $('html').css({'overflow': 'hidden', 'height': '100%'});
    
    popupCen(oitm);
}

/* 팝업 고정해제 */
function popupOff(closeitem){
    var citm = $(closeitem);
    
    citm.hide();
    $('html').css({'overflow': 'auto', 'height': '100%'});

    citm.off('scroll touchmove mousewheel');
    
}

/* 팝업 가운데 정렬 */
function popupCen(itm){
    var winW2 = $(window).width();
    var popWrap = itm.find('.pop-wrap');
    var popCen = popWrap.width();
    var popMid = popWrap.height();

    if (winW2 <= 768) {
        popWrap.css({'margin-top':'-'+(popMid/2)+'px'});
    }else{
        popWrap.css({'margin-left':'-'+(popCen/2)+'px'});
    }
}

//# 자동투자 금액선택
function auto_price(pri) {
	$('input[name="at_price"]').val(pri);
}

// 버튼 클릭시 이동 영역
function goAreaFn() {
	$('#goTop').on('click', function() {
		$('html, body').animate({ scrollTop: 0 }, 400);
	});
}

//# 자동투자 인증문자 회신여부 체크
function at_tid_chk(tid) {	
	var tid_timer = setInterval(function() {
		$.ajax({
			type	:	"POST",
			data	:	{"mode":"SAofVzdCAUAoFQ==","tid":tid},
			url		:	"/inc/state.php",
			success	:	function(data) {
				if(data == "Y") {
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
	if(n == 1) {
		if(at_chk.is(":checked") !== true) {
			alert("자동투자 이용동의에 체크해주세요.");
			return;
		}
		var at_price = $('input[name="at_price"]').val();
	} else {
		var at_price = $('input[name="at_price2"]').val();
	}

	if(at_price < 1) {
		alert("상품별 투자금액을 선택해주세요.");
		return;
	}

	$.ajax({
		type	:	"POST",
		data	:	{"price":at_price},
		url		:	"/member/auto/autopay.php",
		success	:	function(data) {
			var ret = data.split("^");

			if(ret[0] == "FAIL") {
				alert(ret[1]);
			} else {
				at_tid_chk(ret[1]);
				$('#autopay_pop').css('display','block');
			}
		}
	});
}

//# 자동투자 해지
function auto_cancel() {
	$.ajax({
		type	:	"POST",
		url		:	"/member/auto/autopay_cancel.php",
		success	:	function(data) {
			if(data == "FAIL") {
				alert("해지에 실패하였습니다.");
			} else {
				alert("해지가 완료되었습니다.");
				location.reload();
			}
		}
	});
}