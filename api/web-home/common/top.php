<?php
	include_once("/home/ebizpub/web-home/nurifunding.co.kr/config/config.php");
    include_once("/home/ebizpub/web-home/nurifunding.co.kr/config/KB_Liiv_lib.php");
    

	$cash	= 0;
    if(!empty($member_info) && $member_info["guid"] != "") {
	//## =========================== 멤버 잔액조회 ===========================
		$url			= "/v5/member/seyfert/inquiry/balance";

		$val			= "reqMemGuid=".$Guid;
		$val			.= "&_method=GET";
		$val			.= "&_lang=ko";
		$val			.= "&dstMemGuid=".$member_info["guid"];
		$val			.= "&crrncy=KRW";

		$result			= apiAct($url, $val, "GET", $Guid, $KeyP);

		if($result["status"] == "SUCCESS") {
			$cash	= $result["data"]["moneyPair"]["amount"];
		} else {
			$cash	= 0;
		}
	//## =========================== 멤버 잔액조회 - 끝 ===========================
    }

    if(!empty($member_info)) {
        $lq = "select cid from liivmate where uid = '".$member_info["num"]."'";
        $lr = mysqli_query($dbconn, $lq);
        $liv = mysqli_fetch_array($lr);


        $kb_param = array("cid"=>$liv["cid"]);
        $kb_param = json_encode($kb_param);
        $liv_param = aes_encode($kb_param, $key);
    }
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
    <link rel="stylesheet" href="https://nurifunding.co.kr/static/css/renew/reset.css?ver=<?=time();?>">
    <link rel="stylesheet" href="https://nurifunding.co.kr/static/css/renew/libs/animate.css">
    <link rel="stylesheet" href="https://nurifunding.co.kr/static/css/renew/libs/slick/slick.css">
    <link rel="stylesheet" href="https://nurifunding.co.kr/static/css/renew/libs/slick/slick-theme.css">

    <!-- https://nurifunding.co.kr -->
    <!-- <link rel="stylesheet" href="/static/css/livemate/common.min.css">
    <link rel="stylesheet" href="/static/css/livemate/contents.min.css"> -->
    <link rel="stylesheet" href="https://nurifunding.co.kr/static/css/livemate/common.min.css?ver=<?=time();?>">
    <link rel="stylesheet" href="https://nurifunding.co.kr/static/css/livemate/contents.min.css?ver=<?=time();?>">

    <script src="https://nurifunding.co.kr/static/js/renew/libs/jquery-1.10.2.min.js"></script>
    <?php    
        if(!empty($member_info) && $member_info["guid"] != "") {
    ?>
    <script>
        function copy() {
            var tmpTextarea = document.createElement('textarea');
            tmpTextarea.value = "<?=$member_info['debank'];?> / <?=$member_info['debank_no'];?>";;
         
            document.body.appendChild(tmpTextarea);
            tmpTextarea.select();
            tmpTextarea.setSelectionRange(0, 9999);  // 셀렉트 범위 설정
         
            document.execCommand('copy');
            document.body.removeChild(tmpTextarea);
        }
    </script>
    <?php
        }    
    ?>
</head>

<body id="lv-mainPage" class="lv-main-page">
    <h1 class="sr-only">누리펀딩</h1>
    <div class="wrapper" id="wrapper">

        <div class="app-header">
            <a href="javascript: history.back()">
                <img src="https://nurifunding.co.kr/img/livemate/common/btn_arr_left_black.png" alt="이전">
            </a>
        </div>

        <!--누리펀딩 헤더-->
        <div class="nuri-header">
            <a class="btn-prev" href="javascript: history.back()">
                <img src="https://nurifunding.co.kr/img/livemate/common/btn_arr_left_white.png" alt="이전">
            </a>
            <p class="nuri-header-title">문구 타이틀</p>
            <?php            
                if (empty($m) || $m != "menu") {
            ?>
            <button type="button" class="btn-menu-open">
                <img src="https://nurifunding.co.kr/img/livemate/common/btn_menu_open.png" alt="메뉴버튼 이미지">
            </button>
            <?php
                }    
            ?>
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
                    <?php    
                        if(!empty($member_info) && $member_info["guid"] != "") {
                    ?>
                    <a href="#회원가입" data-toggle="modal" data-target="#menuDepositPop" role="button">
                        <p>나의 예치금 계좌정보</p>
                        <div class="icon-box">
                            <img src="https://nurifunding.co.kr/img/livemate/common/icon_arr_right_small_whiet.png" alt="작은 오른쪽 화살표">
                        </div>
                    </a>
                    <?php    
                        }
                    ?>
                </div>
            </div>
            <ul class="menu-ul">
                <li><a href="/invest/list.php"><p>상품목록<span class="span-sub-txt"> 연10%</span></p></a></li>
                <!-- <li><a href="#"><p>예치금 조회</p></a></li> -->
                <li><a href='https://api.nurifunding.co.kr/ilist.php?kblm_param=<?=$liv_param;?>'><p>투자 상세내역</p></a></li>
                <li><a class="btn-pop-intro" href="#" data-toggle="modal" data-target="#companyPop" role="button"><p>누리펀딩 소개</p></a></li>
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
            <!--누리펀딩 소개버튼 팝업부분-->
            <div class="menu-popup-nuri-intro">
                <div class="popup-close-box">
                    <button type="button" class="btn-popup-close">
                        <img src="https://nurifunding.co.kr/img/livemate/popup/intro/btn_popup_close.png" alt="메뉴버튼 이미지">
                    </button>
                </div>
                <section class="popup-intro01">
                    <div class="intro-logo-box">
                        <img class="img-logo" src="https://nurifunding.co.kr/img/livemate/common/logo_mark.png" alt="로고">
                        <h5 class="logo-name">누리펀딩</h5>
                    </div>
                    <div class="intro-sub-title">30년 경력 탄탄한 금융 전문가와 <br>IT 전문 기업이 만듭니다.</div>
                    <ul class="intro-point-ul">
                        <li>
                            <div class="point-img-box"><img src="https://nurifunding.co.kr/img/livemate/popup/intro/icon_intro01.png" alt="이미지"></div>
                            <div class="point-txt-box">
                                <h6>강력한 보안과 쉬운 투자</h6>
                                <p class="txt-content">개인정보 유출 방지 시스템을 도입해 안전하고, 복잡하지 않은 절차로 간편하게 투자할 수 있습니다.</p>
                            </div>
                        </li>
                        <li>
                            <div class="point-img-box"><img src="https://nurifunding.co.kr/img/livemate/popup/intro/icon_intro02.png" alt="이미지"></div>
                            <div class="point-txt-box">
                                <h6>보기 쉬운 투자정보와 리스크 관리</h6>
                                <p class="txt-content">내가 투자하는 상품에 대한 모든 정보를 간편하게 한눈에 확인하고 투자상품의 리스크를 직접 관리할 수 있습니다.</p>
                            </div>
                        </li>
                        <li>
                            <div class="point-img-box"><img src="https://nurifunding.co.kr/img/livemate/popup/intro/icon_intro03.png" alt="이미지"></div>
                            <div class="point-txt-box">
                                <h6>30년 금융 전문가의 금융 분석</h6>
                                <p class="txt-content">STAR Loan Rating 심사 알고리즘을 적 용해 믿을 수 있는 신용평가 시스템, 전 문가의 철두철미한 분석과 쉬운 설명으 로 투자 상품에 대한 이해를 높여줍니다.</p>
                            </div>
                        </li>
                    </ul>
                    <ul class="intro-table-ul">
                        <li class="table-top">
                            <p class="table-name">평균금리</p>
                            <p class="table-content">10.4%</p>
                        </li>
                        <li class="table-top">
                            <p class="table-name">부실률</p>
                            <p class="table-content">0%</p>
                        </li>
                        <li>
                            <p class="table-name">누적 상환액</p>
                            <p class="table-content"> 346억 6,720만원</p>
                        </li>
                        <li>
                            <p class="table-name">누적 상환액</p>
                            <p class="table-content"> 346억 6,720만원</p>
                        </li>
                        <li>
                            <p class="table-name">대출잔액</p>
                            <p class="table-content">35억 9,696만원</p>
                        </li>
                        <li>
                            <p class="table-name">누적대출 취급액</p>
                            <p class="table-content">382억 6,416만원</p>
                        </li>
                    </ul>
                </section>
                <section class="popup-intro02">
                    <h5>웹 보안 + 금융 노하우 + 법률 자문<br> P2P 금융의 최고의 인력</h5>
                    <p class="sub-title">누리펀딩의 30년의 금융 전문 노하우와<br> 웹보안 기술력으로 안전한 정보관리와 <br>안심거래가 가능합니다.</p>
                    <img src="https://nurifunding.co.kr/img/livemate/popup/intro/popup_intro01.png" alt="이미지">
                </section>
                <section class="popup-intro03">
                    <h5>고금리 혜택과 리스크 관리</h5>
                    <p class="sub-title">P2P 투자는 수익률이 먼저? NO!<br> 누리펀딩은 고금리 혜택은 물론 <br>원금을 지키는 리스크 관리도 소중하게 생각합니다.</p>
                    <img src="https://nurifunding.co.kr/img/livemate/popup/intro/popup_intro02.png" alt="이미지">
                </section>
                <div class="popup-bottom">
                    <div class="popup-bottom-logo">
                        <img class="img-logo" src="https://nurifunding.co.kr/img/livemate/common/logo_mark.png" alt="로고">
                        <h5 class="logo-name">누리펀딩</h5>
                    </div>
                    <div class="popup-bottom-service">
                        <p>사업자등록번호 677-81-00871 </p>
                        <p>NURIFUNDING.CO.KR</p>
                    </div>
                </div>
            </div>
            <!--./누리펀딩 소개버튼 팝업부분 끝-->
        </nav>

        <!-- 예치금 계좌정보 -->
        <div class="lv-modal-wrapper deposit-modal-wrapper" id="menuDepositPop" style="display: none; z-index:101;">
            <div class="lv-modal-container">
                <div class="lv-modal-header">
                    <div class="close-btn-wrapper ta-right">
                        <a href="javascript:;" data-dismiss="modal"><img src="https://nurifunding.co.kr/img/livemate/common/btn_close.svg" alt="닫기"></a>
                    </div>
                    <div class="lv-title-l ta-center">나의 예치금 계좌정보</div>
                </div>
                <div class="lv-modal-body">
                    <div class="lv-title-s text-support mt-1">
                        고객님의 예치금 가상계좌에 정보입니다.<br> 예치금 입금 후 투자를 진행해주세요.
                    </div>
                    <div class="terms-text mt-2">
                        ·
                        <span class="lv-text text-support">보유 예치금</span>
                        <span class="lv-price"><?=@number_format($cash);?>원</span>
                    </div>
                    <div class="terms-text lv-text">
                        <p class="text-support mt-0-5">· 나의 예치금 계좌</p>
                        <p class="text-base mt-0-5">
                            <span class="mx-1 fw-m"><?=$member_info["debank"];?> / <?=$member_info["debank_no"];?></span>
                            <a href="javascript: copy();" class="lv-flag lv-btn-flag copy-btn" data-toggle="toast" data-target="#lvToastWrapper">복사</a>
                        </p>
                    </div>
                </div>
                <div class="lv-modal-footer ta-center mt-1">
                    <button type="button" class="lv-btn-module-support" data-dismiss="modal">확인</button>
                </div>
            </div>
        </div>
        <!-- 
        <div class="lv-modal-wrapper" id="companyPop" style="display:none; z-index:101; overflow:scroll">
            <div class="lv-modal-container">
                <a href="javascript:;" data-dismiss="modal"><img src="https://nurifunding.co.kr/img/livemate/common/btn_close.svg" alt="닫기">X</a>
                <img src="https://www.nurifunding.co.kr/img/livemate/common/company_pop.png" alt="intro" height="300" />
            </div>
        </div> -->
        
