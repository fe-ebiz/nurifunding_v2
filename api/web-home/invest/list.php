<?php
	include "/home/ebizpub/web-home/nurifunding.co.kr/api/web-home/common/top.php";

    if(empty($member_info)) {
        jsMsg("로그인이 필요합니다", "/intro.php");
    }
?>

        <div class="sr-only nuri-header-title-info">이커머스 선정산 투자 </div>
        <main id="container" class="container" role="main">
            <div class="page-content product-list-content">
                <div class="page-body">
                    <div class="body-title lv-title-l lv-group-1 mt-3">
                        <?=$member_info["name"];?>님이 투자하기 좋은<br>
                        고수익 이커머스 상품
                    </div>
                    <div class="body-subtitle lv-title-s text-notemphasis lv-group-1 mt-1">
                        1만원부터 투자가능한 연 10% 고수익 상품!
                    </div>
                    <!--"i"버튼-인트로로 가기-->
                    <!-- <a class="product-list-btn-intro" href="http://api.nurifunding.co.kr/intro.php">
                        <img src="https://nurifunding.co.kr/img/livemate/common/btn_back_intro.png" alt="인트로 버튼">
                    </a> -->
                    <div class="product-list-wrapper lv-group-1 product-list-min-height">
                        <p class="product-list-notice"><span class="span-dot">ㆍ</span>투자상품은 매일 10시부터 수시 오픈됩니다.</p>
                        <ul class="product-list">
							<?php
        						$qry = "select * from goods where state = 'Y' and  liiv = 'Y' order by num desc";
                                //$qry = "select * from goods where liiv = 'Y' order by num desc";
								$res = @mysqli_query($dbconn, $qry);

                                $num = @mysqli_num_rows($res);

                                if($num > 0) {
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
                                <a href="./view.php?num=<?=$row["num"];?>">
                                    <div class="item-title lv-text"><?=$name;?></div>
                                    <div class="item-text lv-title-l d-flex align-items-center justify-content-space-between">
                                        <div class="">
                                            <span class="text-blue"><b>연 <?=$row["profit"];?>%</b></span> <b><?=$row["end_turn"];?>개월</b>
                                        </div>
                                        <img src="https://nurifunding.co.kr/img/livemate/common/arr_right_black.svg" alt="이동" class="init">
                                    </div>
                                    <div class="item-period">
                                        <?=$state_btn;?><span class="lv-text text-support"><?=$sdate;?> ~ <?=$edate;?></span>
                                    </div>
                                </a>
                            </li>
							<?php
								}
                                } else {
                            ?>
                            <li class="product-item">
                                <br>
                                <div class="item-title lv-text" style="text-align:center;">투자상품이 준비중입니다.</div>
                                <br>
                            </li>
                            <?php
                                }
							?>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
        <!-- /.container -->

<?php
	include "/home/ebizpub/web-home/nurifunding.co.kr/api/web-home/common/bottom.php";
?>