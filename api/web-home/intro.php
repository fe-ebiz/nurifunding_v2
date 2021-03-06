<?php
    $m = 'menu';

	include "/home/ebizpub/web-home/nurifunding.co.kr/api/web-home/common/top.php";
?>
	<script>
		function isubmit() {
			$('form[name="iData"]').submit();
		}
	</script>

	<form name="iData" method="POST" action="./member/agree.php" />
		<?php
			foreach($_POST as $key => $val) {
		?>
		<input type="hidden" name="<?=$key;?>" value="<?=$val;?>" />
		<?php
			}
		?>
    </form>
    <div class="sr-only nuri-header-title-info">누리펀딩, 이커머스 선정산 투자</div>
        <main id="container" class="container" role="main">
            <div class="page-content intro-content">
                <div class="page-body">
                    <div class="intro-visual ta-center">
                        <div class="visual-logo ta-left"><img src="https://nurifunding.co.kr/img/logo.png" alt="누리펀딩"></div>
                        <div class="visual-text">
                            <p class="lv-title-l fw-b">
                                연 10% 고수익 재테크<br>1만원부터 시작하세요!
                            </p>
                            <p class="lv-title-m mt-1">
                                누리펀딩 이커머스 선정산 투자
                            </p>
                        </div>
                        <div class="visual-img"><img src="https://nurifunding.co.kr/img/livemate/intro/piggybank.png" alt="저금통"></div>
                    </div>
                    <div class="intro-card-wrapper mt-3">
                        <div class="intro-card">
                            <div class="item-info d-flex align-items-center justify-content-space-around">
                                <div class="el ta-center">
                                    <div class="lv-text text-base">누적상환액</div>
                                    <div class="lv-title-l fw-b">
                                        <span class="text-blue">300억</b>
                                    </div>
                                </div>
                                <div class="el ta-center">
                                    <div class="lv-text text-base">투자건수</div>
                                    <div class="lv-title-l text-blue fw-b">1,500건</div>
                                </div>
                                <div class="el ta-center">
                                    <div class="lv-text text-base">연체율</div>
                                    <div class="lv-title-l text-blue fw-b">0%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="advantage-list-wrapper mt-7">
                        <div class="advantage-list">
                            <div class="advantage-item d-flex align-items-center justify-content-space-between mt-3">
                                <div class="el item-picture"><img src="https://nurifunding.co.kr/img/livemate/intro/icon_revenue.png" alt="높은 수익률"></div>
                                <div class="el item-text">
                                    <div class="lv-title-m fw-m title">연 10% 높은 수익률</div><br>
                                    <div class="lv-text text-support text mt-0-5">
                                        평균 연 10%의 고수익 투자상품<br>
                                        1만원부터 부담없이 소액투자 가능
                                    </div>
                                </div>
                            </div>
                            <div class="advantage-item d-flex align-items-center justify-content-space-between mt-3">
                                <div class="el item-picture"><img src="https://nurifunding.co.kr/img/livemate/intro/icon_security.png" alt="높은 수익률"></div>
                                <div class="el item-text">
                                    <div class="lv-title-m fw-m title">안정성 높은 SCF 상품</div><br>
                                    <div class="lv-text text-support text mt-0-5">
                                        쇼핑몰 구매자가 카드 결제한 현금을<br>
                                        담보로 지급예정일에 상환 받는 상품
                                    </div>
                                </div>
                            </div>
                            <div class="advantage-item d-flex align-items-center justify-content-space-between mt-3">
                                <div class="el item-picture"><img src="https://nurifunding.co.kr/img/livemate/intro/icon_days.png" alt="높은 수익률"></div>
                                <div class="el item-text">
                                    <div class="lv-title-m fw-m title">단기투자 &amp; 자동투자</div><br>
                                    <div class="lv-text text-support text mt-0-5">
                                        60일 이내 상환받은 여유자금을<br>
                                        소액분산 자동투자로 운영
                                    </div>
                                </div>
                            </div>
                            <div class="advantage-item d-flex align-items-center justify-content-space-between mt-3">
                                <div class="el item-picture"><img src="https://nurifunding.co.kr/img/livemate/intro/icon_weal.png" alt="높은 수익률"></div>
                                <div class="el item-text">
                                    <div class="lv-title-m fw-m title">복리혜택</div><br>
                                    <div class="lv-text text-support text mt-0-5">
                                        빠른 회전율로 쉬지 않고 원금에<br>
                                        이자를 더해 복리로 자동투자 가능
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="protect-wrapper mt-7">
                        <div class="protect-title lv-title-l ta-center fw-m">투자자 보호시스템</div>
                        <div class="protect-card mt-4">
                            <div class="item-title lv-title-s"><span class="in">3중 투자자 보호장치 가동</span></div>
                            <div class="item-text">
                                <p class="lv-text fw-m check mt-1">담보물 변동사항 모니터링 시스템</p>
                                <p class="lv-text fw-m check mt-1">부실채권 사후관리 시스템</p>
                            </div>
                        </div>
                    </div>

                    <div class="page-content product-list-content">
                        <div class="product-list-wrapper lv-group-1">
                            <ul class="product-list">
                                <?php
                                    //$qry = "select * from goods where state = 'Y' and  and liiv = 'Y' order by num desc";
                                    $qry = "select * from goods where state = 'Y' and liiv = 'Y' order by num desc";
                                    $res = @mysqli_query($dbconn, $qry);
                                    while($row = @mysqli_fetch_array($res)) {
                                        if (mb_strlen($row["name"] > 20)) {
                                            $name = mb_substr($row["name"], 0, 20);
                                            $name = $name."...";
                                        } else {
                                            $name = $row["name"];
                                        }

                                        $sdate = date("m.d H:i", strtotime($row["sdate"]));
                                        $edate = date("m.d H:i", strtotime($row["edate"]));

                                        $state_btn = "";
                                        if(time() < strtotime($row["sdate"])) {
                                            $state_btn = '<span class="lv-btn-flag text-base bor-0 badge-period">예정</span>';
                                        } else {
                                            $state_btn = '<span class="lv-btn-flag text-blue border-blue badge-period">모집중</span>';
                                        }
                                ?>
                                <li class="product-item">
                                    <a href="#">
                                        <div class="item-title lv-text"><?=$name;?></div>
                                        <div class="item-text lv-title-l d-flex align-items-center justify-content-space-between">
                                            <div class="">
                                                <span class="text-blue"><b>연 <?=$row["profit"];?>%</b></span> <b><?=$row["end_turn"];?>개월</b>
                                            </div>
                                        </div>
                                        <div class="item-period">
                                            <?=$state_btn;?><span class="lv-text text-support"><?=$sdate;?> ~ <?=$edate;?></span>
                                        </div>
                                    </a>
                                </li>
                                <?php
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>

                    <div class="definition-wrapper  mt-7">
                        <div class="lv-text text-base fw-b">1. P2P 금융이란?</div>
                        <div class="lv-text text-support mt-0-5">사람과 사람을 연결하는 온라인 금융으로 대출자가 낸 이자가 투자자의 수익이 되는 직거래 금융 방식 입니다.</div>
                        <div class="lv-text text-base fw-b mt-2">2. 이커머스 선정산이란?</div>
                        <div class="lv-text text-support mt-0-5">소상공인이 쇼핑몰에 입점 후 물건을 판매하고 60일 후 받을 돈을 즉시 대신 지급해 주고 정산 예정일에 회수하는 금융상품 입니다.</div>
                        <div class="lv-text text-base fw-b mt-2">3. 자동투자란?</div>
                        <div class="lv-text text-support mt-0-5">내가 설정한 금액으로 자동, 분산투자 되는 기능으 로 신규 선정산 상품이 나올 때 마다 쉽고 빠르게 자동으로 척척 투자</div>
                    </div>
                </div>
                <div class="page-footer">
                    <div class="lv-btn-float-cover-wrapper">
                        <div class="lv-btn-float-cover">
                            <a class="lv-btn-primary" href="#" onclick="javascript: isubmit();">
                                투자 시작하기
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!-- /.container -->

<?php
	include "/home/ebizpub/web-home/nurifunding.co.kr/api/web-home/common/bottom.php";
?>