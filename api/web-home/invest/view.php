
<?php
	include "/home/ebizpub/web-home/nurifunding.co.kr/api/web-home/common/top.php";

	$goods	= mysqli_fetch_array(mysqli_query($dbconn, "select * from goods where num = '".$_GET["num"]."'"));	
	$info	= mysqli_fetch_array(mysqli_query($dbconn, "select * from goods_info where goods_no = '".$goods["num"]."'"));
	$pay	= mysqli_fetch_array(mysqli_query($dbconn, "select count(distinct(uid)) as cnt from pay where goodsno = '".$goods["num"]."' and state='Y' and gubun='-' and type='none'"));
	
	$g_qry	= "select * from grade_total where mapx = '".$info["grade2"]."' and mapy = '".$info["grade1"]."'";
	$g_sql	= mysqli_query($dbconn, $g_qry);
	$g_row	= mysqli_fetch_array($g_sql);


	$img = explode("||", $goods['img2']);

	$sdate = date("m.d H:i", strtotime($goods["sdate"]));
	$edate = date("m.d H:i", strtotime($goods["edate"]));
	
	$state_btn = "";
	if(time() < strtotime($goods["sdate"])) {
		$state_btn = '<span class="lv-btn-flag text-base bor-0 badge-period">예정</span>';
	} else {
		$state_btn = '<span class="lv-btn-flag text-blue border-blue badge-period">모집중</span>';
	}
	
	$goods_price	= number_change($goods["price"]);

	$per = @round(($goods["mprice"]/$goods["price"])*100);
	if($goods["mprice"] > $goods["price"]) {
		$goods["mprice"] = $goods["price"];
		$per = 100;
	}

	$contents_arr	= json_decode($info["collateral_contents"],true);

	$btn_link = "javascript: alert('비회원은 투자가 불가능합니다.');";
	if(!empty($member_info)) {
		$p_chk = "select * from pay where uid = '".$member_info["num"]."' and state = 'Y' and gubun = '-' and goodsno != '' and type = 'none'";
		$p_res = mysqli_query($dbconn, $p_chk);
		$pay_c = mysqli_num_rows($p_res);

		if($pay_c > 0) {
			$btn_link = "./invest.php?num=".XOREncode($goods["num"]);
		} else {
			$btn_link = "./new_invest.php?num=".XOREncode($goods["num"]);
		}
	} else {
		$btn_link = "javascript: alert('비회원은 투자가 불가능합니다.');";
	}
?>
        <div class="sr-only nuri-header-title-info">이커머스 선정산 투자</div>
		<main id="container" class="container" role="main">
            <div class="page-content product-detail-content">
                <div class="page-body">
                    <div class="product-intro-wrapper lv-group-1 mt-1">
                        <div class="product-intro">
                            <div class="item-thumbnail"><img src="<?=$img[0];?>" alt="상품이미지"></div>
                            <div class="item-period d-flex align-items-center justify-content-space-between mt-1">
                                <?=$state_btn;?><span class="lv-text text-support"><?=$sdate;?> ~ <?=$edate;?></span>
                            </div>
                            <div class="item-title lv-title-l mt-0-5"><?=$goods["name"];?></div>
                            <div class="item-info type-2 d-flex align-items-center justify-content-space-between mt-2 lv-group-1">
                                <div class="el ta-center">
                                    <div class="lv-text text-support">연 수익률</div>
                                    <div class="lv-title-m">
                                        <span class="text-blue"><b><?=$goods["profit"];?>%</b></b>
                                    </div>
                                </div>
                                <div class="el ta-center">
                                    <div class="lv-text text-support">투자기간</div>
                                    <div class="lv-title-m"><?=$goods["end_turn"];?>개월</div>
                                </div>
                                <div class="el ta-center">
                                    <div class="lv-text text-support">등급</div>
                                    <div class="lv-title-m"><?=$info["grade1"];?></div>
                                </div>
                                <div class="el ta-center">
                                    <div class="lv-text text-support">모집금액</div>
                                    <div class="lv-title-m"><?=$goods_price;?>원</div>
                                </div>
                            </div>
                            <div class="item-progress px-0-5 mt-8">
                                <div class="progressbar">
                                    <div class="percentbar" style="width: <?=$per;?>%">
                                        <div class="percent-text lv-text">
                                            <?=$per;?>%
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-space-between mt-1">
                                    <span class="lv-text text-blue"><?=$goods_price;?>원 모집중</span>
                                    <span class="lv-text"><?=@number_format($pay["cnt"]);?>명 투자완료</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="invest-point-wrapper lv-bg-1 mt-5 wrapper-pd-1">
                        <div class="lv-title-m fw-b lv-group-1">투자 포인트</div>
                        <div class="point-list-wrapper mt-3">
                            <ul class="point-list" id="pointList">
                                <li class="point-item lv-title-m ta-center">
                                    <div class="in">
                                        누적상환액 300억<br>
                                        연체율 0%
                                    </div>
                                </li>
                                <li class="point-item">
                                    <div class="in">
                                        안정성 높은 SCF<br>
                                        (선정산) 상품
                                    </div>
                                </li>
                                <li class="point-item">
                                    <div class="in">
                                        투자자금 손실 보전<br>
                                        프로그램 가동
                                    </div>
                                </li>
                                <li class="point-item">
                                    <div class="in">
                                        1만원부터 가능한<br>
                                        고수익 소액투자
                                    </div>
                                </li>
                            </ul>
                        </div>

						<?php
						
						$money	= 1000000;	// 투자원금

						$sdate	= date("Y-m-d");
						$s_date_chk	= explode("-", $sdate);
						
						if(date("d") > 24) {
							$month_plus	= 2;
						} else {
							$month_plus	= 1;
						}


						if($goods["end_turn"] < 2) {
							$edate = date("Y-m-d", mktime(0, 0, 0, $s_date_chk[1] + 1, $s_date_chk[2] - 1, $s_date_chk[0]));	// 만기상환일
							
							$date_arr = array();
							$date_arr[] = $edate;
						} else {
							$edate = date("Y-m-d", mktime(0, 0, 0, $s_date_chk[1] + $goods["end_turn"], $s_date_chk[2]-1, $s_date_chk[0]));	// 만기상환일
							
							//# 첫 이자 상환일 구하기
							$repay_first = date("Y-m-01", strtotime("+".$month_plus." month", time()));

							$date1 = $repay_first;
							$date2 = $edate;
							$new_date = $date1;

							$date_arr = array();

							while(true) {
								if(strtotime($new_date) >= strtotime($date2)) {
									$date_arr[] = $date2;
									break;
								}

								$date_arr[] = $new_date;
								$new_date = date("Y-m-d", strtotime("+1 month", strtotime($new_date)));
							}
						}

						$num = 0; // 지급회차

						$all_profit	= 0;
						$all_tax1	= 0;
						$all_tax2	= 0;
						$all_tax	= 0;
						$all_fprice	= 0;

						$table_row	= array();

						//# 2019.04.02 박상현 : 이사님요청으로 198호 이후로 미리페이 상품은 월별수익금 지급표에서 만기일때만 표시
						if($goods["num"] >= "198" && $goods["miri"] == "Y") {
							array_splice($date_arr, 0, (count($date_arr)-1));
						}


						for($i=0; $i<count($date_arr); $i++) {
							$num	= $i+1;				// 지급회차
							$date	= $date_arr[$i];	// 지급일자

							if($goods["end_turn"] < 2) {
								$prev_date = $sdate;
							} else {
								$prev_date = ($i > 0) ? $date_arr[$i-1] : $sdate;
							}

							// 이용일수
							$date_chk = ceil((strtotime($date) - strtotime($prev_date)) / 86400);

							// 세전이자
							$profit = floor($money * ($goods["profit"]/100) * ($date_chk/365));
							$all_profit += $profit;

							$per = 25;
							if(!empty($member_info) && ($member_info["mtype"] == "5" || $member_info["mtype"] == "6")) {
								$per = 0;
							}

							// 이자소득세
							$tax1	= $profit * ($per / 100);
							$tax1	= floor($tax1 * 0.1) * 10;

							// 주민세
							$tax2	= $tax1 * (10 / 100);
							$tax2	= floor($tax2 * 0.1) * 10;

							$tax	= $tax1 + $tax2;
							$all_tax += $tax;
							
							// 수익금
							$fprice	= $profit - $tax;
							$all_fprice += $fprice;
						}

						?>
                        <div class="expect-wrapper lv-group-2 mt-7">
                            <div class="lv-title-l fw-m">
                                <span class="fw-b text-under">100만원 투자시</span> 예상 수익금은
                                <?=$goods["end_turn"];?>개월동안 <span class="fw-b text-under text-blue"><?=@number_format($all_fprice);?>원</span> 입니다.
                            </div>
                            <div class="expect-text mt-3 px-1">
                                <p class="lv-text d-flex align-items-end justify-content-space-between">
                                    <span>수익금 지급예상일</span>
                                    <span><b><?=$date;?></b>(<?=$goods["end_turn"];?>개월)</span>
                                </p>
                                <p class="lv-text d-flex align-items-center justify-content-space-between">
                                    <span>세전 수익금</span>
                                    <span><b><?=@number_format($all_profit);?>원</b></span>
                                </p>
                                <p class="lv-text d-flex align-items-center justify-content-space-between">
                                    <span>소득세 및 주민세</span>
                                    <span><b><?=@number_format($all_tax);?>원</b></span>
                                </p>
                                <p class="lv-text d-flex align-items-center justify-content-space-between">
                                    <span>세후 수익금 총액</span>
                                    <span class="lv-title-m text-under text-blue"><b><?=@number_format($all_fprice);?>원</b></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="invest-highlight-wrapper wrapper-pd-1"> -->
                    <div class="invest-highlight-wrapper mt-5">
                        <div class="lv-title-m fw-b lv-group-1">투자 하이라이트</div>
                        <div class="highlight-text-list lv-text mt-3 lv-group-1">
						
                            <?php
                                $c_arr = explode("\r\n", $contents_arr[0]);
                                for($i=0; $i<count($c_arr); $i++) {
                                    $adCl = "";
                                    if($i>0) {
                                        $adCl = "mt-1";
                                    }
                            ?>
                            <p class="d-flex align-items-top <?=$adCl?>">
                                <i class="dot">·</i>
                                <?=nl2br($c_arr[$i]);?>
                            </p>
                            <?php
                                }
                            ?>

                            <p class="d-flex align-items-top mt-1">
                                <i class="dot">·</i>
                                <?=nl2br($contents_arr[2]);?>
                            </p>
                        </div>
                    </div>
                    <div class="safety-wrapper mt-7 lv-group-1">
                        <div class="lv-title-m fw-b d-flex align-items-center justify-content-space-between">
                            안전 설정담보
                            <a href="javascript:;" data-toggle="modal" data-target="#productWordModal" role="button" class="lv-text text-base d-flex align-items-center">
                                용어안내 <img src="https://nurifunding.co.kr/img/livemate/common/arr_right.svg" alt="이동" class="mg-l-1">
                            </a>
                        </div>
                        <div class="safety-chart">
                            <div class="d-flex align-items-center justify-content-space-between mt-3">								
								<?php			
									$collateral	= $info["collateral"];
									$col_val	= $info["val"] / 100;									// 감정비율
									$chk_price	= ($collateral * $col_val);								// 감정가

									$ord_price	= ($info["first_ord"] + $info["second_ord"]);			// 선순위금
									$nuri_price	= $goods["price"];										// 누리펀딩 대출금

									$free_price	= $chk_price - $ord_price - $nuri_price;				// 잔여 여유금

									$ord_per = @round($ord_price/$chk_price*100);
									$nuri_per = @round($nuri_price/$chk_price*100);
									$free_per = @round($free_price/$chk_price*100);
								?>

                                <div class="el">
                                    <div class="pie-chart" style="background: conic-gradient(#3fcfe1 0% <?=$ord_per;?>%, #fe8f01 <?=$ord_per;?>% <?=$nuri_per+$ord_per;?>%, #e9e9e9 <?=$nuri_per+$ord_per;?>% 100%);">
                                        <span class="center"></span>
                                    </div>
                                </div>

                                <div class="el">
                                    <div class="chart-info">
                                        <div class="title lv-text">담보감정가 <b><?=number_change($chk_price)?>원</b></div>
                                        <div class="list lv-flag mt-2">
                                            <p><span class="dot ago"></span> 선순위금 <b><?=number_change($ord_price)?>원 (<?=$ord_per;?>%)</b></p>
                                            <p class="mt-0-5"><span class="dot loan"></span> 누리펀딩 대출금 <b><?=number_change($nuri_price)?>원 (<?=$nuri_per;?>%)</b></p>
                                            <p class="mt-0-5"><span class="dot rest"></span> 잔여 여유금 <b><?=number_change($free_price)?>원 (<?=$free_per;?>%)</b></p>
                                        </div>
                                    </div>
                                </div>

								

                            </div>
                        </div>
                        <div class="safety-text-list lv-text mt-3">
                            <div class="text-item d-flex align-items-top justify-content-space-between">
                                <div class="el">
                                    <img class="icon-system-img" src="https://nurifunding.co.kr/img/livemate/product/icon_system.png" alt="아이콘">
                                </div>
                                <div class="el mt-0-5">
                                    <div class="title fw-m">담보물 변동사항 모니터링 시스템</div>
                                    <div class="text">누리펀딩의 리스크관리 시스템에 의해 해당 담보물의 가치변동 및 권리침해 여부가 매일 모니터링 되고 있습니다.</div>
                                </div>
                            </div>
                            <div class="text-item d-flex align-items-top justify-content-space-between mt-2">
                                <div class="el">
                                    <img class="icon-system-img" src="https://nurifunding.co.kr/img/livemate/product/icon_system.png" alt="아이콘">
                                </div>
                                <div class="el mt-0-5">
                                    <div class="title fw-m">부실채권 사후처리 시스템</div>
                                    <div class="text">
                                        대출기간이 지나거나 이자를 2회 이상 지체 시 누리펀딩은 적절한 절차에 의하여 다음과 같은 자체 추심을 진행합니다.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="evaluation-wrapper mt-7 lv-group-1">
                        <div class="lv-title-m fw-b d-flex align-items-center justify-content-space-between">
                            여신평가 등급
                        </div>
                        <p class="lv-text mt-2">
                            기업(개인)의 신용등급과 담보가치를
                            <br>결합한 여신평가 등급입니다.
                        </p>
                        <div class="evaluation-chart mt-2">
                            <div class="grade">
                                <p class="g-th c-blue fw-b ta-center"><?=$info["grade1"]?></p>
                                <div class="g-chart">
								<?php
									//<!--등급에 따른 클래스추가로 따른 위치 이동-->
									switch($g_row["total"]) {
										case "C":
											echo "<span id=\"g-chart-dot\" class=\"n4\"></span>";
										break;
										case "B":
											echo "<span id=\"g-chart-dot\" class=\"n3\"></span>";
										break;
										case "A":
											echo "<span id=\"g-chart-dot\" class=\"n2\"></span>";
										break;
										case "S":
											echo "<span id=\"g-chart-dot\" class=\"n1\"></span>";
										default:
										break;
									}
								?>
                                </div>
                                <div class="g-label">
                                    <span class="nth-1">SAFTY ZONE<br>안전존</span>
                                    <span class="nth-2">THINK ZONE<br>고려존</span>
                                    <span class="nth-3">AGREE ZONE<br>고려존</span>
                                    <span class="nth-4">REJECT ZONE<br>거절존</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="scf-wrapper mt-7 lv-group-1">
                        <div class="lv-title-m fw-b d-flex align-items-center justify-content-space-between">
                            SCF(선정산 서비스, 공급망 금융)란?
                        </div>
                        <p class="lv-text mt-2">
                            SCF는 Supply Chain Finance의 약자로, 공급망 금융, 선정산 서비스 등으로 불리는 선진 핀테크 서비스로, 선정산 서비스 기업은 판매업체의 매출채권을 확인한 후에 선정산 금액을 지급하며 후에 해당 매출채권에 대한 정산을 구매 기업으로부터 직접 받게 됩니다. (누리펀딩에서는 차주 명의의 계좌를 점유 보관, 관리를 통해 정산자금을 지급 받고 만기일에 대출금을 상환하게 됩니다)
                        </p>
                        <div class="scf-img mt-3">
                            <img src="https://nurifunding.co.kr/img/livemate/product/scf.png" alt="선정산서비스">
                        </div>
                        <div class="scf-more mt-3">
                            <a href="javascript:;" data-toggle="modal" data-target="#productScfModal" role="button" class="lv-btn-tiny w-100 bor bx">SCF(선정산 서비스) 자세히 보기</a>
                        </div>
                    </div>
                    <hr class="line mt-7">
                    <div class="collapse-btn-cover product-guidance mt-3 lv-group-2 lv-title-m d-flex align-items-center justify-content-space-between">
                        <div class="lv-title-m">상품안내</div>
                        <div class="collapse-btn active" data-toggle="collapse" data-target="#productGuidance">
                            <img src="https://nurifunding.co.kr/img/livemate/common/arr_down.svg" alt="펼치기" class="down">
                            <img src="https://nurifunding.co.kr/img/livemate/common/arr_up.svg" alt="접기" class="up">
                        </div>
                    </div>
                    <div class="collapse product-guidance mt-5" id="productGuidance">
                        <div class="guidance-invest-wrapper lv-group-1">
                            <div class="lv-title-m fw-b d-flex align-items-center justify-content-space-between">
                                투자개요
                            </div>
                            <div class="lv-text mt-2">
                                <table class="guidance-invest-tbl ta-left">
                                    <colgroup>
                                        <col style="width: 100px">
                                    </colgroup>
                                    <tbody>
                                        <tr>
                                            <th>상품</th>
                                            <td><?=$info['product_type']?></td>
                                        </tr>
                                        <tr>
                                            <th>대출금</th>
                                            <td><?=number_change($goods['price'])?> 원</td>
                                        </tr>
                                        <tr>
											<th><?=$info['txt2']?></th>
											<td><?=number_change($info['set_price'])?>원</td>	
                                        </tr>
                                        <tr>
                                            <th>상품종류</th>
                                            <td><?=$goods['goods_type']?></td>
                                        </tr>
                                        <tr>
                                            <th>담보이용</th>
                                            <td><?=$info['collateral_use']?></td>
                                        </tr>
                                        <tr>
											<th><?=$info['txt1'];?></th>
											<td><?=number_change($info['collateral'])?>원</td>
                                        </tr>
                                        <tr>
                                            <th>자금용도</th>
                                            <td><?=$info['use']?></td>
                                        </tr>
                                        <tr>
                                            <th>안정장치</th>
                                            <td>
                                                <?=nl2br($info["safety"]);?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="guidance-product-wrapper mt-7 lv-group-1">
                            <div class="lv-title-m fw-b d-flex align-items-center justify-content-space-between">
                                상품개요
                            </div>
                            <div class="scf-more mt-3">
                                <a href="javascript:;" data-toggle="modal" data-target="#productOverviewModal" role="button" class="lv-btn-tiny w-100 bor bx">상품개요 상세보기</a>
                            </div>
                        </div>
                    </div>
                    <hr class="line mt-7">
                    <div class="collapse-btn-cover mustread mt-3 lv-group-2 lv-title-m d-flex align-items-center justify-content-space-between">
                        <div class="lv-title-m">꼭 확인하세요</div>
                        <div class="collapse-btn active" data-toggle="collapse" data-target="#mustread">
                            <img src="https://nurifunding.co.kr/img/livemate/common/arr_down.svg" alt="펼치기" class="down">
                            <img src="https://nurifunding.co.kr/img/livemate/common/arr_up.svg" alt="접기" class="up">
                        </div>
                    </div>
                    <div class="collapse mustread mt-3" id="mustread">
                        <div class="mustread-wrapper lv-group-2">
                            <div class="lv-text text-notemphasis mustread-text-list">
                                <p class="d-flex align-items-top justify-content-space-between">
                                    <i class="dot">·</i>
                                    온라인을 통한 금융투자상품의 투자는 회사의 권유 없이 고객님의 판단에 의해 이루어지며,대출의 특성상 상환예정일 이전에 중도 상환될 수 있습니다.
                                </p>

                                <p class="d-flex align-items-top justify-content-space-between mt-2">
                                    <i class="dot">·</i>
                                    투자이용약관 제11조와 12조 내용에 따라 상환지연 등에 해당되는 경우 채권추심과 환가절차 과정에서 원금의 일부 손실이 발생할 수 있으며 채권추심 등을 통해 투자금 회수에 상당기간 소요될 수 있습니다.
                                </p>

                                <p class="d-flex align-items-top justify-content-space-between mt-2">
                                    <i class="dot">·</i>
                                    당사는 원금 및 수익률을 보장하지 않으므로 투자 시 신중한 결정 바랍니다.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="offer-wrapper mt-5 lv-group-2">
                        <div class="logo-cover">
                            <img src="https://nurifunding.co.kr/img/livemate/common/logo_mark.png" alt="로고마크">
                            <span class="logo-text lv-text fw-m">누리펀딩</span>
                        </div>
                        <div class="lv-flag text-notemphasis mt-2">
                            이 투자상품은 누리펀딩에서 제공합니다.<br>
                            사업자등록번호 677-81-00871<br>
                            고객센터 <span class="text-blue">1666-4570</span><br>
                        </div>
                    </div>
                </div>
                <div class="page-footer">
                    <div class="lv-btn-float-cover-wrapper">
                        <div class="lv-btn-float-cover line">
                            <a href="<?=$btn_link;?>" class="lv-btn-primary">투자 시작하기</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!-- /.container -->

        <div class="lv-modal-layer">
            <div class="lv-modal-wrapper product-modal-wrapper" id="productWordModal" style="display: none">
                <div class="lv-modal-container-scroll">
                    <div class="lv-modal-container w-100 h-100">
                        <div class="lv-modal-header">
                            <div class="close-btn-wrapper ta-right">
                                <a href="javascript:;" data-dismiss="modal"><img src="https://nurifunding.co.kr/img/livemate/common/btn_close.svg" alt="닫기"></a>
                            </div>
                        </div>
                        <div class="lv-modal-body lv-group-1">
                            <div class="lv-title-l mt-1"><b>설정담보 용어 안내</b></div>
                            <div class="terms-text lv-text mt-2">
                                '선순위금'이란? <br>
                                누리펀딩 대출금액보다 선순위의 권리로 타금융 기관대출금 또는 임대보증금 등 모든선순위 권리금액을 말합니다. <br>
                                <br>
                                '담보여유'이란? <br>
                                누리펀딩 대출 후에도 남아있는 담보의 잔존가치로 이 비율이 높을수록 채무불이행이 발생해도 원금 손실 가능성이 작아집니다. <br>
                                <br>
                                '근질권'이란? <br>
                                담보에 대한 채권자의 권리금액으로 채무불이행 시 연체이자, 채권회수 비용 등을 감안하여 대출금의 120% 이상 설정합니다.<br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lv-modal-wrapper product-modal-wrapper" id="productScfModal" style="display: none">
                <div class="lv-modal-container-scroll">
                    <div class="lv-modal-container w-100 h-100">
                        <div class="lv-modal-header">
                            <div class="close-btn-wrapper ta-right">
                                <a href="javascript:;" data-dismiss="modal"><img src="https://nurifunding.co.kr/img/livemate/common/btn_close.svg" alt="닫기"></a>
                            </div>
                        </div>
                        <div class="lv-modal-body lv-group-1">
                            <div class="lv-title-l mt-2">
                                <b>SCF란?</b>
                                <p class="lv-title-m">
                                    (선정산 서비스, 공급망 금융)
                                </p>
                            </div>
                            <div class="terms-text lv-text mt-2">
                                SCF는 Supply Chain Finance의 약자로, 공급망 금융, 선정산 서비스 등으로 불리는 선진 핀테크 서비스로, 선정산 서비스 기업은 판매업체의 매출채권을 확인한 후에 선정산 금액을 지급하며 후에 해당 매출채권에 대한 정산을 구매 기업으로부터 직접 받게 됩니다. (누리펀딩에서는 차주 명의의 계좌를 점유 보관, 관리를 통해 정산자금을 지급 받고 만기일에 대출금을 상환하게 됩니다)<br>
                                <br>
                                SCF는 원재료 매입금액, 인건비, 배송비 등 즉시 지급해야 할 지출이 많은 판매기업 에게 고금리 대부업, 무리한 신용 대출 등의 무리한 자금 조달 문제를 해결할 수 있는 혁신적인 수단이며, 이미 해외에서는 Marketinvoice, Taulia 등의 기업들을 통해 수십조원의 시장규모가 형성되어 있는 대중적인 금융 서비스입니다.<br>
                                <br>
                                <div class="scf-img mt-2">
                                    <img src="https://nurifunding.co.kr/img/livemate/product/scf.png" alt="선정산서비스">
                                </div>
                                <br>
                                선행조건 은행계좌를 개설하여 소셜/오픈 마켓 결제계좌로 등록 또는 변경 신고합니다.<br>
                                <br>
                                업무절차: <br>
                                ① 미정산금채권을(주)누리펀딩대부에게 양도하며, 파트너사의 출금계좌와 은행출금표를 포함하여 제출합니다. <br>
                                ② 미정산대금을 지급합니다. <br>
                                ③ 정산금을 지급 받아 대출금을 상환합니다. <br>
                                ④ 대출금 상환 후 차액을 지급합니다.<br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lv-modal-wrapper product-modal-wrapper" id="productOverviewModal" style="display: none">
                <div class="lv-modal-container-scroll">
                    <div class="lv-modal-container w-100 h-100">
                        <div class="lv-modal-header">
                            <div class="close-btn-wrapper ta-right">
                                <a href="javascript:;" data-dismiss="modal"><img src="https://nurifunding.co.kr/img/livemate/common/btn_close.svg" alt="닫기"></a>
                            </div>
                        </div>
                        <div class="lv-modal-body lv-group-1">
                            <div class="lv-title-l mt-2"><b>상품개요</b></div>
                            <div class="terms-text lv-text mt-2">
								<?php
									$g_txt = explode('투자상품 개요', $goods["goods_text"]);

									if(!empty($g_txt[1]) && $g_txt[1] != "") {
										echo "1. 투자상품 개요<br>";
										echo @nl2br($g_txt[1]);
									} else {
										echo @nl2br($g_txt[0]);
									}

								?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php
	include "/home/ebizpub/web-home/nurifunding.co.kr/api/web-home/common/bottom.php";
?>