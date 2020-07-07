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
                                <p class="txt-content">STAR Loan Rating 심사 알고리즘을 적 용해 믿을 수 있는 신용평가 시스템, 전 문가의 철두철미한 분석과 쉬운 설명으로 투자 상품에 대한 이해를 높여줍니다.</p>
                            </div>
                        </li>
                    </ul>
                    <?php      
                        $qry	= "SELECT COUNT(num) AS cnt, SUM(price) AS price, SUM(profit) AS profit FROM goods WHERE state = 'Y'";
                        $sql	= mysqli_query($dbconn, $qry);
                        $row	= mysqli_fetch_array($sql);

                        $profit3	= ($row["profit"] / $row["cnt"]);
                        $profit2	= number_format($profit3, 2);

    				    $main_qry	= mysqli_fetch_array(mysqli_query($dbconn, "select * from main_price order by num desc limit 1"));
                    ?>
                    <ul class="intro-table-ul">
                        <li class="table-top">
                            <p class="table-name">평균금리</p>
                            <p class="table-content"><?=$profit2;?>%</p>
                        </li>
                        <li class="table-top">
                            <p class="table-name">부실률</p>
                            <p class="table-content">0%</p>
                        </li>
                        <li>
                            <p class="table-name">누적 상환액</p>
                            <p class="table-content"><?=number_change($main_qry["price1"]);?>원</p>
                        </li>
                        <li>
                            <p class="table-name">연체율</p>
                            <p class="table-content">0%</p>
                        </li>
                        <li>
                            <p class="table-name">대출잔액</p>
                            <p class="table-content"><?=number_change($main_qry["price2"]);?>원</p>
                        </li>
                        <li>
                            <p class="table-name">누적대출 취급액</p>
                            <p class="table-content"><?=number_change($main_qry["price3"]);?>원</p>
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