
    </div>
    <!-- /#wrap -->

    <!-- script -->
    <!-- <script type="text/javascript" src="https://nurifunding.co.kr/static/js/renew/libs/swiper.min.js"></script>
<script type="text/javascript" src="https://nurifunding.co.kr/static/js/renew/libs/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="https://nurifunding.co.kr/static/js/renew/libs/waypoints.min.js"></script>
<script type="text/javascript" src="https://nurifunding.co.kr/static/js/renew/libs/jquery.easing.min.js"></script>
<script type="text/javascript" src="https://nurifunding.co.kr/static/js/renew/libs/jquery.counterup.min.js"></script> -->
    <script src="https://nurifunding.co.kr/static/js/renew/libs/slick.min.js"></script>

    <!-- https://nurifunding.co.kr -->
    <!-- <script type="text/javascript" src="/static/js/livemate/ui.js"></script> -->

	<!-- ui.js 넣으면 agree.php 에서 오류 -->
    <script type="text/javascript" src="https://nurifunding.co.kr/static/js/livemate/ui.js"></script>

    <script>
    //상단 파란색 박스 타이틀 문구 적용
    $(document).ready(function(){
        let getText = $(".nuri-header-title-info");
        $(".nuri-header .nuri-header-title").text(getText.text());
        
        //메뉴관련
        let menu = $('.nav-menu');
        let btnOpen = $('.btn-menu-open')
        let btnClose = $('.btn-menu-close')

        btnOpen.on('click',function(){
            menu.css('display','block');
            $("main").css("display",'none');
        });
        btnClose.on('click',function(){
            menu.css('display','none');
            $("main").css("display",'block');
        });

        //메뉴-누리펀딩소개 팝업 관련
        let btnPopIntroOpen = $('.btn-pop-intro');
        let btnPopIntroClose = $('.btn-popup-close');
        let popIntro = $('.menu-popup-nuri-intro')

        btnPopIntroOpen.on('click',function(){
            popIntro.css('display','block');
            /*not-scroll제거*/
            $("body").removeClass('not-scroll');
        });
        btnPopIntroClose.on('click',function(){
            popIntro.css('display','none');
        });
    
    });
    </script>
    <!--[if lt IE 9]><script type="text/javascript" src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script> <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script> <![endif]-->

</body>

</html>