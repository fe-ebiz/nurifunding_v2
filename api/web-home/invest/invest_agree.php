<?php
	include "/home/ebizpub/web-home/nurifunding.co.kr/api/web-home/common/top.php";
	
	if(empty($member_info)) {
		jsMsg('비회원은 투자가 불가능합니다.', './view.php?num='.XORDecode($_POST["goods"]).'');
	}

?>

<script>
	function tid_chk(tid, ono) {	
		var tid_timer = setInterval(function() {
			$.ajax({
				type	:	"POST",
				data	:	{"mode":"<?=XOREncode('tid_chk')?>","tid":tid},
				url		:	"./state.php",
				success	:	function(data) {
					if(data == "Y") {
						clearInterval(tid_timer);
						location.href='./invest_complete.php?ono='+ono;
					} else if(data == "C") {
						alert("상품모집금액을 초과하여 투자할 수 없습니다.");
						clearInterval(tid_timer);
						location.reload();
					}

				}
			});
		}, 1000);
	}

	function agree_pay() {
		var agree_chk	= $('input[name="agree"]').val();

		if(agree_chk != "동의함") {
			alert("동의함을 입력해주세요");
			$('input[name="agree"]').focus();
			return false;
		}

		$.ajax({
			type	:	"POST",
			data	:	$("form[name='order']").serialize(),
			url		:	"./pay.php",
			success	:	function(data) {				
				var ret = data.split("^");

				if(ret[0] == "FAIL") {
					alert(ret[1]);
					if(ret[1] == "투자가 진행중입니다.\n잠시후에 다시 시도해주세요.") {
						location.reload();
					}
				} else {
					tid_chk(ret[1], ret[2]);
					$('#ldsMask').show();
				}
				
			}
		});
	}
</script>

<div class="sr-only nuri-header-title-info">투자하기</div>
<main id="container" class="container" role="main">
	<form method="post" name="order">
		<input type="hidden" name="goodsno" value="<?=$_POST["goods"];?>" />
		<input type="hidden" name="use_cash" value="<?=$_POST["use_cash"];?>" />


		<div class="page-content invest-notice-content">
			<div class="page-body">
				<div class="body-title lv-title-l mt-3">
					투자 유의사항
				</div>
				<div class="notice-card lv-text text-notemphasis mt-2">
					온라인을 통한 금융투자상품의 투자는 회사의 권유 없이 고객님의 판단에 의해 이루어지며,
					대출의 특성상 상환예정일 이전에 중도 상환될 수 있습니다.<br>
					투자이용약관 제11조와 12조 내용에 따라 상환지연 등에 해당되는 경우 채권추심과 환가절차 과정에서 원금의
					일부 손실이 발생할 수 있으며 채권추심 등을 통해 투자금 회수에 상당기간 소요될 수 있습니다.<br>
					당사는 원금 및 수익률을 보장하지 않으므로 투자 시 신중한 결정 바랍니다.<br>
				</div>
				<div class="notice-agree-wrapper">
					<div class="notice-subtext lv-text mt-2">
						<?=$member_info["name"];?>는 투자위험에 대한 내용을 확인 했으며 그 내용에 동의합니다
					</div>
					<div class="form-group d-flex align-items-center justify-content-space-between child-flex-1 mt-2 mb-0-5">
						<div class="lv-form-input-cover w-auto">
							<input type="text" name="agree" class="lv-form-input lv-title-m active-text-blue ta-center" placeholder="동의함">
						</div>
					</div>
					<div class="lv-text text-support">동의함을 직접 입력해주세요</div>
				</div>
			</div>
			<div class="page-footer mt-4">
				<div class="lv-btn-float-cover-wrapper">
					<div class="lv-btn-float-cover line">
						<!-- <a href="./invest_03.html" class="lv-btn-primary" disabled>동의하고 투자하기</a> -->
						<a href="#" onclick="javascript: agree_pay();" class="lv-btn-primary">동의하고 투자하기</a>
					</div>
				</div>
			</div>
		</div>
	</form>
</main>

<!-- loading -->
<!-- <div class="lds-mask" id="ldsMask" style="display: none"> -->
<div id="ldsMask" class="lds-mask" style="display:none">
	<div class="lds-wrapper">
		<div class="lds-container">
			<div class="lds-roller">
				<div></div>
				<div></div>
				<div></div>
				<div></div>
				<div></div>
				<div></div>
				<div></div>
				<div></div>
			</div>
		</div>
	</div>
</div>

<script>
	$(window).on('load', function() {
		//$('#ldsMask').show();
		//$('#ldsMask').fadeOut('fast');
	});
</script>


<!-- /.container -->

<?php
	include "/home/ebizpub/web-home/nurifunding.co.kr/api/web-home/common/bottom.php";
?>