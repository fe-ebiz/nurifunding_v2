
<?php
	include "/home/ebizpub/web-home/nurifunding.co.kr/api/web-home/common/top.php";

	$pay = mysqli_fetch_array(mysqli_query($dbconn, "select * from pay where ono = '".XORDecode($_GET['ono'])."'"));
	$goods = mysqli_fetch_array(mysqli_query($dbconn, "select * from goods where num = '".$pay["goodsno"]."'"));
	$info	= mysqli_fetch_array(mysqli_query($dbconn, "select grade1 from goods_info where goods_no = '".$goods["num"]."'"));

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

?>

<div class="sr-only nuri-header-title-info">투자하기</div>
<main id="container" class="container" role="main">
	<div class="page-content invest-product-content">
		<div class="page-body">
			<div class="body-title lv-title-l mt-3">
				투자신청이 완료되었습니다.<br>
			</div>
			<div class="product-card mt-2">
				<div class="lv-text">투자상품 정보</div>
				<div class="item-title lv-title-m mt-1"><?=$goods["name"];?></div>
				<div class="item-info d-flex align-items-center justify-content-space-around mt-2">
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
				</div>
				<hr class="line my-2">
				<div class="item-price">
					<div class="el d-flex align-items-center justify-content-space-between">
						<div class="lv-title-m">나의 투자금</div>
						<div class="lv-title-m text-blue"><?=@number_format($pay["price"]);?>원</div>
					</div>
					<div class="el d-flex align-items-center justify-content-space-between mt-1">
						<div class="lv-text">예치금 잔액</div>
						<div class="lv-text"><?=@number_format($cash);?>원</div>
					</div>
				</div>
			</div>
			<div class="subtext-wrapper mt-4">
				<p class="lv-text text-support dot">
					투자 상세내역은 상단 우측메뉴 > 투자 상세내역 에서 확인하실 수 있습니다.
				</p>
			</div>
		</div>
		<div class="page-footer mt-4">
			<div class="lv-btn-float-cover-wrapper">
				<div class="lv-btn-float-cover line">
					<!-- 누리펀딩 연결 -->
					<a href="#" class="lv-btn-support-half">투자내역 확인</a>
					<a href="./list.php" class="lv-btn-primary-half">투자상품 목록</a>
				</div>
			</div>
		</div>
	</div>
</main>
<!-- /.container -->

<?php
	include "/home/ebizpub/web-home/nurifunding.co.kr/api/web-home/common/bottom.php";
?>