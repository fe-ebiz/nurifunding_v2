$(function () {

    dataFn();
    commonUI();

    if ('#mainPage') {
        mainUI();
    }

    //이미지로드 지연 - 로딩속도 단축
    /*$("img.lazy").lazyload({
      threshold : 300,        
      effect : "fadeIn"       
    });*/

});

/* ---------- *
   공통
 * ---------- */
function commonUI() {
    init();

    function init() {
        hdFn();
        goAreaFn();
    }
    // 해더 기능 
    function hdFn() {
        var winWidth = $(window).width(),
            winHeight = $(window).height()
        hd = $("#header"),
            el = hd.children(),
            ht_total = 0;
        // 공통
        $(window).on('scroll', function () {
            var scr = $(window).scrollTop();
            if (scr > 0) {
                hd.children('.gnb').addClass('on');
            } else {
                hd.children('.gnb').removeClass('on');
            }
        });

        // 모바일 네비게이션 해더
        if (winWidth >= 992) {
            var menu2 = $('.menu2');
            var menu2Bg = $('#menu2Bg');
            var menu2BgHt = 100;
            var menu2HtArray = [];
            var menu2HtMax = 0;

            menu2.each(function (index, item) {
                menu2HtArray.push($(item).outerHeight());
            });
            menu2HtArray.push(menu2BgHt);
            menu2HtMax = menu2HtArray.reduce(function (prev, current) {
                return prev > current ? prev : current;
            });
            var pdTop = parseInt(menu2Bg.css('padding-top'));
            menu2Bg.css({
                minHeight: menu2HtMax + pdTop * 2
            });
            // setTimeout(function () {
            //     menu2.css({
            //         minHeight: menu2HtMax,
            //         padding: pdTop + 'px ' + 0
            //     });
            //     $('[class*=vline-]').height(menu2HtMax - (pdTop * 2));
            // }, 100);
            // $('.menu2:not(.big), #menu2Bg').addClass('on');
            hd.find('.navbar-collapse .menu > li, .navbar-collapse .btn-cover.myinfo').on('mouseenter', function () {
                $('.menu2:not(.big), #menu2Bg').addClass('on');
            });
            $('.navbar-collapse').on('mouseleave', function () {
                $('.menu2, #menu2Bg').removeClass('on');
            });
            hd.find('.navbar-collapse .menu > li.big').hover(function () {
                $('#autoinvBox').removeClass('on');
            }, function () {
                // $('#autoinvBox').show();
                $('#autoinvBox').addClass('on');
            });

        } else {
            // 상단 배너 높이 - 배너 있을 시 없을 시 높이 자동 설정
            el.each(function () {
                ht_total += $(this).outerHeight();
            });
            hd.height(ht_total);
            /*모바일 바 클릭시 모바일 네비게이션 등장*/
            $('.header .nav-tab').on('click', function () {
                var ncHeaderHt = $('.nc-header').outerHeight();
                $('#navbarCollapse').addClass('on');
                $('#navbarCollapse').prev().addClass('on');
                // $('#navbarCollapse .menu').height(winHeight - ncHeaderHt);
                wheelFn(false);
            });
            /*모바일 네비게이션 닫기 버튼*/
            $('#navbarCollapse .cls-btn').on('click', function () {
                navbarCollapseFn.close();
                wheelFn(true);
            });
            $('#navbarCollapse').prev('.bg-drop').on('click', function () {
                navbarCollapseFn.close();
                wheelFn(true);
            });
            $('#navbarCollapse .menu > li').on('click', function (e) {
                $(this).toggleClass('on');
            })
        }

        // 스크롤 높이 자동 설정
        var $navbarCollapse = $('#navbarCollapse');
        var $navbarMenu = $navbarCollapse.find('.menu-wrapper');
        var nchdHeight = $navbarCollapse.find('.nc-header').outerHeight();
        var snsHeight = $navbarCollapse.find('.sns-wrapper').outerHeight();
        var winRsWd = null;
        var winRsHt = null;
        $(window).resize(function () {
            winRsWd = $(window).width();
            winRsHt = $(window).height();
            var scrbarWd = 0;
            // console.log(winRsWd);
            if ($('body').height() > winRsWd) {
                scrbarWd = 17;
            }
            if (winRsWd >= 992 - scrbarWd) {
                // 스크롤 높이 자동 설정 - PC에서 재정의
                $navbarMenu.css('height', '100%');
            } else {
                winRsHt -= nchdHeight + snsHeight;
                $navbarMenu.css('height', winRsHt);
            }
        });

        var navbarCollapseFn = {
            close: function () {
                $('#navbarCollapse').removeClass('on');
                $('#navbarCollapse').prev().removeClass('on');
            }
        }
    }

    // 버튼 클릭시 이동 영역
    function goAreaFn() {
        $('#goTop').on('click', function () {
            $('html, body').animate({
                scrollTop: 0
            }, 400);
        });
    }
}

/* ---------- *
   mainPage
 * ---------- */
// slider 영역
function mainUI() {
    init();

    function init() {
        sliderFn();
        firstStep();
        wayP();
        quicknoticeFn();
        rateCountFn();
        primaryBnrFn();
        ingProductFn();
        $(window).resize(function () {
            var winWidth = $(window).width();
            // console.log(winWidth)
            if (winWidth <= 991) {
                benefitChart("#per-chart", "11");
            }
            if (winWidth >= 992) {
                benefitChart("#per-chart", "19");
            }
        }).resize();
    }

    function sliderFn() {
        $('#main-slider').bxSlider({
            adaptiveHeight: true,
            mode: 'fade',
            auto: true,
            speed: 100,
            pause: 8000,
            // autoDelay: 1000,
        });
    }
    // 진행중인 상품 영역 - 모바일
    function ingProductFn() {
        var ipSwiper = new Swiper('.ip-container', {
            slidesPerView: 3,
            pagination: {
                el: '.swiper-pagination',
                type: 'fraction',
            },
            breakpoints: {
                992: {
                    autoplay: {
                        delay: 8000,
                    },
                    slidesPerView: 'auto',
                    spaceBetween: 15,
                    centeredSlides: true,
                    pagination: {
                        el: '.swiper-pagination',
                        type: 'fraction',
                    },
                }
            }
        });
        // var ipSwiper = null;
        // $(window).resize(function () {
        //     var winWidth = $(window).width();
        //     if (winWidth <= 992) {
        //         if (ipSwiper = null) {
        //             ipSwiper = new Swiper('.ip-container', {
        //                 autoplay: {
        //                     delay: 8000,
        //                 },
        //                 slidesPerView: 'auto',
        //                 spaceBetween: 15,
        //                 centeredSlides: true,
        //                 pagination: {
        //                     el: '.swiper-pagination',
        //                     type: 'fraction',
        //                 },
        //             });
        //         }
        //     }
        //     if (winWidth >= 992) {
        //         if (ipSwiper != null) {
        //             ipSwiper.destroy();
        //             ipSwiper = null;
        //         }
        //     }
        // });

    }
    // 퀵바 공지
    function quicknoticeFn() {
        var mySwiper = new Swiper('#quicknoticeContainer', {
            autoplay: true,
            direction: 'vertical',
            loop: 'true'
        });
        $(window).resize(function () {
            var winWidth = $(window).width();
            if (winWidth >= 992) {
                mySwiper.destroy();
            }
        });
    }
    // 주요 기능 배너 
    function primaryBnrFn() {
        var mySwiper = new Swiper('#primaryBnrContainer', {
            autoplay: {
                delay: 8000,
            },
            loop: true,
            // slidesPerView: 'auto',
            // spaceBetween: 15,
            // centeredSlides: true,
            navigation: {
                nextEl: '#primaryBnrContainer .btn-next',
                prevEl: '#primaryBnrContainer .btn-prev',
            },
            pagination: {
                el: '',
                type: ''
            },
            breakpoints: {
                768: {
                    navigation: {
                        nextEl: '',
                        prevEl: '',
                    },
                    pagination: {
                        el: '#primaryBnrContainer .bnr-pagination',
                        type: 'bullets',
                        clickable: true
                    },
                }
            }
        });
    }

    // 카운트 업
    function rateCountFn() {
        var rateTop = 0;
        var scrTop = 0;
        var mg = 250;
        var flag = true;
        $('#rate .count').addClass("blind");
        $(window).on('scroll', function () {
            rateTop = $('#rate .row').offset().top - $(window).height() + mg;
            scrTop = $(this).scrollTop();
            if (rateTop <= scrTop) {
                $('#rate .count').addClass("animated fadeIn");
                if (flag) {
                    count();
                }
            }
        })

        function count() {
            $('#rate .count').counterUp({
                delay: 10,
                time: 1000
            });
            return flag = false;
        }
    }
    // 처음 방문하셨나요?
    function firstStep() {
        var main = $('#main');
        main.find('.quick-bar .box-1').on('click', function () {
            // console.log('work');
            $(this).toggleClass('on');
            $(this).closest('.quick-bar').find('.box-1-2').toggleClass('on');
        });
    }

    //애니메이션 함수 호출  영역
    function wayP() {
        // 진행중인 투자상품
        $(".ip-outer").each(function (idx, item) {
            $(item).addClass("blind");
            $(item).waypoint(function () {
                $(item).addClass('animated fadeInUp');
            }, {
                offset: '70%'
            });
        });
        // 쉬운 대출
        $("#easy .split-2").each(function (idx, item) {
            $(item).addClass("blind");
            $(item).waypoint(function () {
                $(item).addClass('animated fadeInUp');
            }, {
                offset: '75%'
            });
        });
        // 자주하는 질문
        $("#faq .fq-outer").each(function (idx, item) {
            $(item).addClass("blind");
            $(item).waypoint(function () {
                $(item).addClass('animated fadeInUp');
            }, {
                offset: '75%'
            });
        });
    }

    // 차트
    function benefitChart(itm, ht) {
        var perHeightArray = [];
        var htMax = 200;
        // 차트
        $(itm).children('div').each(function (index, item) {
            var perData = $(item).find('.p-per > span').text(),
                perHeight = perData * ht;
            perHeightArray.push(perHeight);

            $(itm).waypoint(function () {
                $(item).children('.p-chart').height(perHeight);
                $(item).addClass('on');
                $(itm).children('.tooltip').addClass('on');

            }, {
                offset: '75%'
            });
        });
        // console.log(perHeightArray);
        htMax = Math.max.apply(null, perHeightArray);
        // console.log(htMax);
        $(itm).height(htMax + 70);
    }
}

// 페이지 로딩시 적용 
function dataFn() {
    var dialogOpen = false,
        modal = $('.modal'),
        lastFocus;
    $('[data-toggle]').on('click', function () {
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
    $('[data-dismiss]').on('click', function () {
        var type = $(this).attr('data-dismiss'),
            obj = $(this).closest('.' + type);
        switch (type) {
            case ('modal'):
                dialogOpen = false;
                modalFn.leave(obj);
                break;
            default:
                break;
        }
    });
    $(document).on('keydown', function (e) {
        var obj = modal;
        if (dialogOpen && e.keyCode == 27) {
            dialogOpen = false;
            modalFn.leave(obj);
        }
    });
    modal.on('click', function (e) {
        var obj = $(this);
        if (dialogOpen && !$(e.target).is('.modal-wrapper *')) {
            dialogOpen = false;
            modalFn.leave(obj);
        }
    });

    // 모달 영역
    var modalFn = {
        enter: function (obj) {
            obj.addClass('enter');
            obj.focus();
            $("#wrap").attr('aria-hidden', true);
        },
        leave: function (obj) {
            obj.addClass('leave');
            obj.removeClass('enter');
            setTimeout(function () {
                obj.removeClass('leave');
            }, 300);
            $("#wrap").attr('aria-hidden', false);
            lastFocus.focus();
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

// 팝업 오픈 
function popupOn(openitem) {
    var oitm = $(openitem);

    oitm.show();

    $('html').css({
        'overflow': 'hidden',
        'height': '100%'
    });

    popupCen(oitm);
}

// 팝업 고정해제
function popupOff(closeitem) {
    var citm = $(closeitem);

    citm.hide();
    $('html').css({
        'overflow': 'auto',
        'height': '100%'
    });

    citm.off('scroll touchmove mousewheel');

}

// 팝업 가운데 정렬
function popupCen(itm) {
    var winW2 = $(window).width();
    var popWrap = itm.find('.pop-wrap');
    var popCen = popWrap.width();
    var popMid = popWrap.height();

    if (winW2 <= 768) {
        popWrap.css({
            'margin-top': '-' + (popMid / 2) + 'px'
        });
    } else {
        popWrap.css({
            'margin-left': '-' + (popCen / 2) + 'px'
        });
    }
}

// 튤팁
function tooltip() {
    var winW = $(window).width();
    /* 툴팁 */
    if (winW <= 768) {
        $(".btn-tooltip").on("click", function () {
            $(".tooltip-detail").fadeIn();
        });

        $(".tooltip-detail").on("click", function () {
            $(".tooltip-detail").fadeOut();
        });
    } else {
        $(".btn-tooltip").hover(function () {
            $(".tooltip-detail").fadeIn();
        }, function () {
            $(".tooltip-detail").fadeOut();
        });
    }
}