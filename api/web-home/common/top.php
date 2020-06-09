<?php
	include_once("/home/ebizpub/web-home/nurifunding.co.kr/config/config.php");
?>

<!DOCTYPE html>
<html lang="ko-KR">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <meta name="viewport" content="width=360, initial-scale=1.0"> -->
    <meta name="format-detection" content="telephone=no">
    <title>누리펀딩</title>

    <meta name="title" content="누리펀딩">
    <meta name="author" content="누리펀딩">
    <meta name="subject" content="후순위담보대출, 판매대금 선정산, 영업수입, 임대료, 미래 수익 담보대출 등">
    <meta name="description" content="후순위담보대출, 판매대금 선정산, 영업수입, 임대료, 미래 수익 담보대출 등">
    <meta name="keywords" content="후순위담보대출, 판매대금 선정산, 영업수입, 임대료, 미래 수익 담보대출 등">
    <meta name="classification" content="누리펀딩">

    <!-- 오픈그래프 -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="누리펀딩">
    <meta property="og:description" content="후순위담보대출, 판매대금 선정산, 영업수입, 임대료, 미래 수익 담보대출 등">
    <meta property="og:url" content="https://www.nurifunding.co.kr">
    <meta property="og:site_name" content="누리펀딩">
    <meta property="og:image" content="https://www.nurifunding.co.kr/img/og_img.png">

    <link rel="canonical" href="www.nurifunding.co.kr">

    <link rel="shortcut icon" href="https://www.nurifunding.co.kr/img/32x32.ico">
    <!-- Android icon -->
    <!-- <link rel="shortcut icon" href="https://www.nurifunding.co.kr/img/128x128.png"> -->
    <!-- iPhone icon -->
    <link rel="apple-touch-icon" sizes="57x57" href="https://www.nurifunding.co.kr/img/57x57.png">
    <!-- iPad icon -->
    <link rel="apple-touch-icon" sizes="72x72" href="https://www.nurifunding.co.kr/img/72x72.png">
    <!-- iPhone icon(Retina) -->
    <link rel="apple-touch-icon" sizes="114x114" href="https://www.nurifunding.co.kr/img/114x114.png">
    <!-- iPad icon(Retina) -->
    <link rel="apple-touch-icon" sizes="144x144" href="https://www.nurifunding.co.kr/img/144x144.png">

    <!-- fonts -->
    <link rel="stylesheet" href="https://nurifunding.co.kr/static/fonts/notosanskr/notosanskr.css">
    <link rel="stylesheet" href="https://nurifunding.co.kr/static/fonts/nanumgothic/nanumgothic.css">
    <!-- css -->
    <link rel="stylesheet" href="https://nurifunding.co.kr/static/css/renew/reset.css">
    <link rel="stylesheet" href="https://nurifunding.co.kr/static/css/renew/libs/animate.css">
    <link rel="stylesheet" href="https://nurifunding.co.kr/static/css/renew/libs/slick/slick.css">
    <link rel="stylesheet" href="https://nurifunding.co.kr/static/css/renew/libs/slick/slick-theme.css">

    <!-- https://nurifunding.co.kr -->
    <!-- <link rel="stylesheet" href="/static/css/livemate/common.min.css">
    <link rel="stylesheet" href="/static/css/livemate/contents.min.css"> -->
    <link rel="stylesheet" href="https://nurifunding.co.kr/static/css/livemate/common.min.css?ver="<?=time();?>>
    <link rel="stylesheet" href="https://nurifunding.co.kr/static/css/livemate/contents.min.css?ver="<?=time();?>>

    <script src="https://nurifunding.co.kr/static/js/renew/libs/jquery-1.10.2.min.js"></script>

</head>

<body id="lv-mainPage" class="lv-main-page">
    <h1 class="sr-only">누리펀딩</h1>
    <div class="wrapper" id="wrapper">

        <div class="app-header">
            <a href="javascript: history.back()">
                <img src="https://nurifunding.co.kr/img/livemate/common/btn_arr_left_black.png" alt="이전">
            </a>
        </div>
        <div class="nuri-header">
            <a href="javascript: history.back()">
                <img src="https://nurifunding.co.kr/img/livemate/common/btn_arr_left_white.png" alt="이전">
            </a>
            <p class="nuri-header-title">문구 타이틀</p>
            <button type="button" class="btn-menu-open">
                <img src="https://nurifunding.co.kr/img/livemate/common/btn_menu_open.png" alt="메뉴버튼 이미지">
            </button>
        </div>
        <!--메뉴부분-->
        <nav class="nav-menu">
            <div class="menu-top">
                <div class="menu-close-box">
                    <button type="button" class="btn-menu-close">
                        <img src="https://nurifunding.co.kr/img/livemate/common/btn_menu_close.png" alt="메뉴버튼 이미지">
                    </button>
                </div>
                <div class="menu-title-box">
                    <p class="sub-title">연10% 고수익 투자습관</p>
                    <h4 class="main-title">누리펀딩</h4>
                </div>
                <div class="menu-info-box">
                    <a href="#회원가입">
                        <p>나의 예치금 계좌정보</p>
                        <div class="icon-box">
                            <img src="https://nurifunding.co.kr/img/livemate/common/icon_arr_right_small_whiet.png" alt="작은 오른쪽 화살표">
                        </div>
                    </a>
                </div>
            </div>
            <ul class="menu-ul">
                <li><a href="#"><p>상품목록<span class="span-sub-txt"> 연10%</span></p></a></li>
                <li><a href="#"><p>예치금 조회</p></a></li>
                <li><a href="#"><p>투자 상세내역</p></a></li>
                <li><a href="#"><p>누리펀딩 소개</p></a></li>
            </ul>
            <div class="menu-bottom">
                <div class="menu-bottom-logo">
                    <img class="img-logo" src="https://nurifunding.co.kr/img/livemate/common/logo_mark.png" alt="로고">
                    <h5 class="logo-name">누리펀딩</h5>
                </div>
                <div class="menu-bottom-service">
                    <p>고객센터 <span class="phon-num">1666-4570</span></p>
                    <p>ㆍ평일 : 09시~18시 | 점심휴무 : 13시~14시</p>
                    <p>ㆍ토/일/공휴일 휴무</p>
                </div>
            </div>
        </nav>
        
