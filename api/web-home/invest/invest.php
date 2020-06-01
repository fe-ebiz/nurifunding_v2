<?php
	include "/home/ebizpub/web-home/nurifunding.co.kr/api/web-home/common/top.php";
	
	if(empty($member_info)) {
		jsMsg('비회원은 투자가 불가능합니다.', './view.php?num='.XORDecode($_GET["num"]).'');
	}

	$goods = mysqli_fetch_array(mysqli_query($dbconn, "select * from goods where num = '".XORDecode($_GET["num"])."'"));
	$info	= mysqli_fetch_array(mysqli_query($dbconn, "select * from goods_info where goods_no = '".$goods["num"]."'"));
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

	//## =========================== 멤버 한도조회 ===========================	
		$limit1			= 0;	// 동일 차업자 한도
		$limit2			= 0;	// 전체금액
		$limit3			= 0;	// 부동산
		$limit4			= 0;	// 동산
        $liiv           = 0;    // 리브메이트

		$mem_chk_qry	= "SELECT SUM(a.price) AS all_price, b.gtype as gtype, b.uid as goods_uid FROM pay AS a LEFT JOIN goods AS b ON a.goodsno = b.num WHERE a.uid = ".$member_info["num"]." AND a.state = 'Y' AND a.type='none' AND a.gubun = '-' GROUP BY a.goodsno";
		$mem_chk_res	= mysqli_query($dbconn, $mem_chk_qry);
		while($mem_all	= @mysqli_fetch_array($mem_chk_res)) {
			switch($mem_all["gtype"]) {
				case '부동산' :
					$limit3 += $mem_all["all_price"];
				break;
				case '동산' :
					$limit4 += $mem_all["all_price"];
				break;
			}

			if($mem_all["goods_uid"] == $goods["uid"]) {
				$limit1	+= $mem_all["all_price"];
			}
			$limit2		+= $mem_all["all_price"];
		}	
	//## =========================== 멤버 한도조회 - 끝 ===========================	

	//## =========================== 멤버 잔역 한도 조회 (투자금 - 회수원금) ===========================	
		$money_qry		= "SELECT SUM(a.price) AS all_price, b.gtype AS gtype, b.uid AS goods_uid FROM pay AS a LEFT JOIN goods AS b ON a.goodsno = b.num WHERE a.uid = ".$member_info["num"]." AND a.state = 'Y' AND a.type2 = 'money' AND a.gubun = '+' GROUP BY a.goodsno";
		$money_res		= mysqli_query($dbconn, $money_qry);
		while($money	= @mysqli_fetch_array($money_res)) {
			switch($money["gtype"]) {
				case '부동산' :
					$limit3 -= $money["all_price"];
				break;
				case '동산' :
					$limit4 -= $money["all_price"];
				break;
			}
			
			//# 2018.09.27 박상현 : 동일 차업자 한도 조회시 상환한 내역 차감
			if($money["goods_uid"] == $goods["uid"]) {
				$limit1 -= $money["all_price"];
			}

			$limit2		= $limit2 - $money["all_price"];
		}
	//## =========================== 멤버 잔역 한도 조회 (투자금 - 회수원금) - 끝 ===========================	

    $lq = "select sum(price) as price from pay where uid = '".$member_info["num"]."' and type='none' AND gubun = '-' and state = 'Y' and flag = 'l'";
    $lr = mysqli_query($dbconn, $lq);
    $lv = mysqli_fetch_array($lr);

    $liiv += $lv["price"];

    $lq2 = "select sum(price) as price from pay where uid = '".$member_info["num"]."' and type2='money' AND gubun = '+' and state = 'Y' and flag = 'l'";
    $lr2 = mysqli_query($dbconn, $lq2);
    $lv2 = mysqli_fetch_array($lr2);

    $liiv -= $lv2["price"];

?>

<script>
	function copy() {
        /*
		var txt = "<?=$member_info['debank'];?> / <?=$member_info['debank_no'];?>";
		var $temp = $("<input>");

		$("body").append($temp);
		$temp.val(txt).select();
		document.execCommand("copy");
		$temp.remove();
		alert("계좌번호 복사가 완료되었습니다.");
        */

        var tmpTextarea = document.createElement('textarea');
        tmpTextarea.value = "<?=$member_info['debank'];?> / <?=$member_info['debank_no'];?>";;
     
        document.body.appendChild(tmpTextarea);
        tmpTextarea.select();
        tmpTextarea.setSelectionRange(0, 9999);  // 셀렉트 범위 설정
     
        document.execCommand('copy');
        document.body.removeChild(tmpTextarea);
        //alert("계좌번호 복사가 완료되었습니다."); 
	}

	function selectMoney(money) {
		$('input[name="use_cash"]').val(money);
		$('input[name="use_cash"]').addClass('active');
	}
	
	
	function app_submit() {
		if($("input[name='use_cash']").val() <= 0) {
			alert("투자금액을 확인해주세요");
			return false;
		}

		if($("input[name='use_cash']").val()*10000 < 10000) {
			alert("투자금액은 최소 1만원 입니다.");
			return false;
		}

		// 투자실행금
		var use_cash = Number($("input[name='use_cash']").val()) * 10000;

		if(use_cash > Number($("input[name='info_cash']").val())) {
			alert("투자금액이 보유하신 예치금보다 많습니다.");
			return false;
		}

		var this_price	= use_cash + (Number($("input[name='mem_chk_1']").val()));
		var this_limit	= (Number($("input[name='limit1']").val()));
		
		var all_price	= use_cash + (Number($("input[name='mem_chk_2']").val()));
		var all_limit	= (Number($("input[name='limit2']").val()));
        
		var lv_price	= use_cash + (Number($("input[name='mem_chk_5']").val()));
		var lv_limit	= (Number($("input[name='limit5']").val()));

		var gtype		= $('input[name="gtype"]').val();

		if(this_price > this_limit) {
			var calc_price = (Number($("input[name='limit1']").val())) - (Number($("input[name='mem_chk_1']").val()));

			alert("회원님의 현재 상품(차주)에 투자 가능한 금액은 "+(calc_price/10000)+"만원 입니다.");
			return false;
		}

		if(gtype == "부동산") {
			var limit_pri	= use_cash + (Number($("input[name='mem_chk_3']").val()));
			var mtype_limit	= (Number($("input[name='limit3']").val()));
		} else {
			var limit_pri	= use_cash + (Number($("input[name='mem_chk_4']").val()));
			var mtype_limit	= (Number($("input[name='limit4']").val()));
		}

		if(limit_pri > mtype_limit) {
			alert(gtype+" 상품에 대한 투자한도가 초과되었습니다.");
			return false;
		}
		
		if(all_price > all_limit) {
			alert("플랫폼 투자한도가 초과되었습니다.");
			return false;
		}
		
		if(lv_price > lv_limit) {
			alert("리브메이트 투자한도가 초과되었습니다.");
			return false;
		}

		$('#investForm').submit();
	}
</script>

<div class="sr-only nuri-header-title-info">투자하기</div>
<main id="container" class="container" role="main">
	<div class="page-content invest-product-content">

		<?php
			$limit_t	= $member_limit["limit1"];	// 동일 차업자 한도
			$limit_a	= $member_limit["limit2"];	// 플랫폼 투자한도
			$limit_3	= $member_limit["limit3"];	// 부동산 한도
			$limit_4	= $member_limit["limit4"];	// 동산 한도
		?>
		<input type="hidden" name="limit1" value="<?=$limit_t;?>" />
		<input type="hidden" name="limit2" value="<?=$limit_a;?>" />
		<input type="hidden" name="limit3" value="<?=$limit_3;?>" />
		<input type="hidden" name="limit4" value="<?=$limit_4;?>" />
		<input type="hidden" name="limit5" value="1000000" />
		
		<input type="hidden" name="mem_chk_1" value="<?=$limit1;?>" />
		<input type="hidden" name="mem_chk_2" value="<?=$limit2;?>" />
		<input type="hidden" name="mem_chk_3" value="<?=$limit3;?>" />
		<input type="hidden" name="mem_chk_4" value="<?=$limit4;?>" />
		<input type="hidden" name="mem_chk_5" value="<?=$liiv;?>" />

		<input type="hidden" name="info_cash" value="<?=$cash;?>" />

		<input type="hidden" name="gtype" value="<?=$goods["gtype"];?>" />


		<form id="investForm" method="POST" action="./invest_agree.php">

			<input type="hidden" name="goods" value="<?=XOREncode($goods["num"]);?>" />

			<div class="page-body">
				<div class="body-title lv-title-l mt-3">
					얼마를 투자할까요?<br>
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
				</div>
				<div class="deposit-wrapper mt-3">
					<div class="d-flex align-items-center justify-content-space-between">
						<div class="deposit-price">
							<span class="lv-text text-support mg-r-1">보유 예치금</span>
							<span class="lv-price"><?=@number_format($cash);?>원</span>
						</div>
						<a href="javascript:;" data-toggle="modal" data-target="#depositModal" role="button" class="lv-text text-support d-flex align-items-center">
							예치금 계좌 <img src="https://nurifunding.co.kr/img/livemate/common/arr_right.svg" alt="이동" class="mg-l-1">
						</a>
					</div>
				</div>
				<div class="invest-price-wrapper mt-2">
					<div class="form-group d-flex align-items-center justify-content-space-between child-flex-1 mb-0-5">
						<div class="lv-form-input-cover w-auto">
							<input type="text" name="use_cash" class="lv-form-input lv-title-l active-text-blue won-container commas" placeholder="투자금액" numberonly>
							<span class="lv-form-won lv-title-l">만원</span>
						</div>
					</div>
					<div class="lv-text text-support">1만원부터 투자가 가능합니다.</div>
					<div class="btn-area d-flex align-items-center justify-content-space-between mt-1">
						<button type="button" onclick="javascript: selectMoney(50);" class="lv-btn-tiny lv-price bg-line price-btn">50만원</button>
						<span class="space"></span>
						<button type="button" onclick="javascript: selectMoney(10);" class="lv-btn-tiny lv-price bg-line price-btn">10만원</button>
						<span class="space"></span>
						<button type="button" onclick="javascript: selectMoney(1);" class="lv-btn-tiny lv-price bg-line price-btn">1만원</button>
					</div>
				</div>
			</div>
		</form>

		<div class="page-footer mt-4">
			<div class="lv-btn-float-cover-wrapper">
				<div class="lv-btn-float-cover line">
					<!-- <a href="./invest_02.html" class="lv-btn-primary" disabled>다음</a> -->
					<a href="#" onclick="javascript: app_submit();" class="lv-btn-primary">다음</a>
				</div>
			</div>
		</div>
	</div>
</main>
<!-- /.container -->
<div class="lv-modal-layer">
	<!-- 예치금이 없을 경우 -->
	<!-- $('#deposit0Modal').show() -->
	<?php
		if($cash < 10000) {
	?>
	<div class="lv-modal-wrapper deposit-modal-wrapper" id="deposit0Modal">
		<!-- <div class="lv-modal-wrapper deposit-modal-wrapper" id="deposit0Modal"> -->
		<div class="lv-modal-container">
			<div class="lv-modal-header">
				<div class="close-btn-wrapper ta-right">
					<a href="javascript:;" data-dismiss="modal"><img src="https://nurifunding.co.kr/img/livemate/common/btn_close.svg" alt="닫기"></a>
				</div>
				<div class="lv-title-l ta-center">투자 예치금을 입금해주세요</div>
			</div>
			<div class="lv-modal-body">
				<div class="lv-title-s text-support mt-1">
					1만원부터 투자가 가능합니다.<br/>고객님의 가상계좌로 투자 예치금을 입금해주세요.
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
	<?php
		}
	?>

	<!-- 예치금이 있을 경우 -->
	<div class="lv-modal-wrapper deposit-modal-wrapper" id="depositModal" style="display: none;">
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
</div>

    <div class="lv-toast-layer">
        <div class="lv-toast-wrapper" id="lvToastWrapper" style="display: none">
            <div class="lv-toast-container">
                <p class="lv-text text-support">복사가 완료되었습니다.</p>
            </div>
        </div>
    </div>


<?php
	include "/home/ebizpub/web-home/nurifunding.co.kr/api/web-home/common/bottom.php";
?>