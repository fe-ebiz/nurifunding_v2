<?php
	include "/home/ebizpub/web-home/nurifunding.co.kr/api/web-home/common/top.php";

	if(!empty($member_info)) {	
		$p_chk = "select * from pay where uid = '".$member_info["num"]."' and state = 'Y' and gubun = '-' and goodsno != '' and type = 'none'";
		$p_res = mysqli_query($dbconn, $p_chk);
		$pay_c = mysqli_num_rows($p_res);

		if($pay_c > 1) {
			jsMsg('잘못된 접근입니다.', './view.php?num='.XORDecode($_GET["num"]).'');
		} else {
		//################## 자동투자 승인처리 ##################
			$url			= "/v5/transaction/pending/preAuth/register";

			$val			= "_method=POST";
			$val			.= "&reqMemGuid=".$Guid;
			$val			.= "&_lang=ko";
			$val			.= "&srcMemGuid=".$member_info["guid"];
			$val			.= "&dstMemGuid=".$Guid;
			$val			.= "&authType=SMS_API";

			$result			= apiAct($url, $val, "POST", $Guid, $KeyP);

			if($result["data"]["status"] == "PRE_AUTH_REG_TRYING") {
				$qry = "insert into preauth (`tid`, `uid`, `wdate`, `ip`, `state`) values";
				$qry .= " ('".$result["data"]["tid"]."', '".$member_info["num"]."', now(), '".$_SERVER["REMOTE_ADDR"]."', 'T')";
				$res = mysqli_query($dbconn, $qry);
			}
		//################## 자동투자 승인처리 ##################
		}
	} else {
		jsMsg('잘못된 접근입니다.', './view.php?num='.XORDecode($_GET["num"]).'');
	}
?>

<script>
	function auth() {
		var txt = $('input[name="auth_pw"]').val();

		if(txt.length < 4) {
			alert('인증번호가 옳지않습니다.');
			return false;
		} else {
			$.ajax({
				type : "POST",
				data : {"txt": txt},
				url : "/invest/token_chk.php",
				success : function(data) {
					var ret = data.split("^");

					if(ret[0] == "FAIL") {
						alert(ret[1]);
						if(ret[1] == "다시 확인해주세요.") {
							location.reload();
						}
					} else {
						alert("자동투자 설정이 완료되었습니다.");
						location.href = './invest.php?num=<?=$_GET["num"];?>';
					}
				}
			});
		}
	}
</script>

<div class="sr-only nuri-header-title-info">투자하기</div>
<main id="container" class="container" role="main">
	<div class="page-content invest-sms-content">
		<div class="page-body">
			<div class="body-title lv-title-l mt-3">
				휴대폰 인증을 해주세요.
			</div>
			<div class="body-subtitle lv-title-s text-notemphasis mt-1">
				투자를 위해 최초 1회 휴대폰 인증이 필요합니다.
			</div>
			<div class="body-text lv-text">
				지금 고객님의 휴대폰으로 인증번호가 전송되었습 니다.
				세이퍼트에서 보내드린 <span class="text-blue">4자리 번호</span>를 입력창 에 입력하시면 인증이 완료됩니다.
			</div>
			<figure class="safety-picture">
				<img src="https://nurifunding.co.kr/img/livemate/invest/safety.svg" alt="인증안내사진">
			</figure>
			<div class="safety-number">
				<div class="form-group">
					<div class="lv-form-input-cover">
						<input type="text" name="auth_pw" class="lv-form-input lv-title-m" placeholder="인증번호 4자리 입력" numberonly maxlength="4">
						<i class="lv-form-text-remove" data-role="form-text-remove"><img src="https://nurifunding.co.kr/img/livemate/common/form_text_remove.svg" alt="입력텍스트삭제"></i>
					</div>
				</div>
			</div>
		</div>
		<div class="page-footer">
			<div class="lv-btn-float-cover-wrapper">
				<div class="lv-btn-float-cover line">
					<!-- <a href="./invest_01.html" class="lv-btn-primary" disabled>확인</a> -->
					<a href="#" onclick="javascript: auth();" class="lv-btn-primary">확인</a>
				</div>
			</div>
		</div>
	</div>
</main>
<!-- /.container -->


<?php
	include "/home/ebizpub/web-home/nurifunding.co.kr/api/web-home/common/bottom.php";
?>