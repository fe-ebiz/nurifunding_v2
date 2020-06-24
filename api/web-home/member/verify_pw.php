<?php
    $m = "menu";

	include "/home/ebizpub/web-home/nurifunding.co.kr/api/web-home/common/top.php";
	include_once(INC_DIR."/config/KISA_SEED_ECB.php");

	$g_bszUser_key = "2b,7e,15,71,28,ae,d2,a6,cd,f7,15,11,09,aa,7f,3c";
	function encrypt($bszUser_key, $str) {
		$planBytes = explode(",",$str);
		$keyBytes = explode(",",$bszUser_key);
		
		for($i = 0; $i < 16; $i++)
		{
			$keyBytes[$i] = hexdec($keyBytes[$i]);
		}
		for ($i = 0; $i < count($planBytes); $i++) {
			$planBytes[$i] = hexdec($planBytes[$i]);
		}

		if (count($planBytes) == 0) {
			return $str;
		}
		$ret = null;
		$bszChiperText = null;
		$pdwRoundKey = array_pad(array(),32,0);

		//방법 1
		$bszChiperText = KISA_SEED_ECB::SEED_ECB_Encrypt($keyBytes, $planBytes, 0, count($planBytes));

		for($i=0;$i< sizeof($bszChiperText);$i++) {
				$ret .=  sprintf("%02X", $bszChiperText[$i]).",";
		}

		return substr($ret,0,strlen($ret)-1);
	}

if($_SERVER["REMOTE_ADDR"] != "61.74.233.194" && $_SERVER["REMOTE_ADDR"] != "61.74.233.196") {
	$qry = "select * from member where phone = '".$_POST["phone"]."' || ci = '".$_POST["ci"]."'";
	
	$res = mysqli_query($dbconn, $qry);
	$num = mysqli_num_rows($res);
	if($num > 0) {
        $mem = mysqli_fetch_array($res);
        $mnum = $mem["num"];

        $liv_q = "insert into liivmate (cid, uid, wdate) values ('".$_POST["cid"]."', '".$mnum."', now())";
        mysqli_query($dbconn, $liv_q);

        $phone = $mem["phone"];
        $ci = $mem["ci"];
        //# 리브메이트 데이터 전송
        include "/home/ebizpub/web-home/nurifunding.co.kr/api/web-home/_member_success.php";

        if($rs_code != "0000") {
           jsMsg(' [ '.$rs_code.' ] 누리펀딩에 가입이 실패하였습니다.', '../intro.php');
           exit;
        }
        
        setcookie(XOREncode("userid"), XOREncode($mem['userid']), 0, "/", base_cookie);

        jsMsg('누리펀딩에 가입되어있는 회원입니다.', '../invest/list.php');
        
	}
}
?>

		
		<script>
		
			function pw1_chk(nuc) {
				$('#nx_btn').attr('disabled', true);

				var nuc2 = $('input[name="pw2"]').val().length;

				if(nuc.length >= 1 && nuc2 >= 1) {
					$('#nx_btn').attr('disabled', false);
				}
			}

			function pw2_chk(nuc) {
				$('#nx_btn').attr('disabled', true);

				var nuc2 = $('input[name="pw1"]').val().length;

				if(nuc.length >= 1 && nuc2 >= 1) {
					$('#nx_btn').attr('disabled', false);
				}
			}

			function verifyPw() {
				var pw1 = $('input[name="pw1"]').val();
				var pw2 = $('input[name="pw2"]').val();

				if(pw1 == "") {
					alert('비밀번호를 입력해주세요.');
					return false;
				}
				if(pw2 == "") {
					alert('비밀번호를 다시 한번 확인해주세요.');
					return false;
				}

				if(pw1 != pw2) {
					alert('입력하신 비밀번호가 일치하지 않습니다.');
					return false;
				}

				$('#verify_pw').submit();
			}
		</script>
		<div class="sr-only nuri-header-title-info">투자 계좌개설</div>
        <main id="container" class="container" role="main">
            <div class="page-content verify-content">
                <div class="page-body">
                    <div class="body-title lv-title-l">
                        안전한 투자를 위해<br>
                        비밀번호를 설정해주세요.
                    </div>
					<form name="verify_pw" id="verify_pw" method="post" action="./state.php">
						<input type="hidden" name="mode" value="<?=XOREncode("join");?>" />
						<?php
							foreach($_POST as $key => $val) {
								if($key == "jumin2") {
									$rj1 = ($_POST["gender"] == "M") ? 1 : 2;
									$r_jumin = $_POST["jumin1"].$rj1.$val;
									$jumin_lenth = strlen($r_jumin);
									$char = "";
									for($i=0; $i<$jumin_lenth; $i++) {
										$char .= ($char == "") ? "" : ", ";

										$j_i = substr($r_jumin, $i, 1);
										$char .= $j_i;
									}

									$enc = encrypt($g_bszUser_key, $char);

									echo "<input type=\"hidden\" name=\"jumin\" value=\"".$enc."\"/>";
								} else {
									if($key != "jumin1") {
										echo "<input type=\"hidden\" name=\"".$key."\" value=\"".$val."\"/>";
									}
								}
							}
						?>
						<div class="verify-form-list mt-type-2">
							<div class="text">
								<div class="form-group d-flex align-items-center justify-space-between mb-2">
									<div class="lv-form-input-cover">
										<input name="pw1" type="password" onKeyup="javascript: pw1_chk(this.value);" class="lv-form-input lv-title-m" placeholder="비밀번호 입력">
										<i class="lv-form-text-remove" data-role="form-text-remove"><img src="https://nurifunding.co.kr/img/livemate/common/form_text_remove.svg" alt="입력텍스트삭제"></i>
									</div>
								</div>
								<div class="form-group d-flex align-items-center justify-space-between mb-2">
									<div class="lv-form-input-cover">
										<input name="pw2" type="password" onKeyup="javascript: pw2_chk(this.value);" class="lv-form-input lv-title-m" placeholder="비밀번호 확인">
										<i class="lv-form-text-remove" data-role="form-text-remove"><img src="https://nurifunding.co.kr/img/livemate/common/form_text_remove.svg" alt="입력텍스트삭제"></i>
									</div>
								</div>
							</div>
						</div>
					</form>
                </div>
                <div class="page-footer">
					<div class="lv-btn-float-cover-wrapper">
						<div class="lv-btn-float-cover">
							<!-- 필수 체크 됐을 경우 disabled 제거 -->
							<a href="#" onclick="javascript: verifyPw();" id="nx_btn" class="lv-btn-primary" disabled>확인</a>
							<!-- <a href="./verify_complete.html" class="lv-btn-primary">확인</a> -->
						</div>
					</div>
                </div>
            </div>
        </main>
		<!-- /.container -->
		
		<script>
			//키패드 화면가림 방지
    		$(document).ready(function(){
        		$(window).resize(function(){
            		let topPos = $(document).height();
            	$('html, body').scrollTop(topPos);
				});
				//아이폰용
				$('input').focus(function(){
					let topPos = $(document).height();
				$('html, body').scrollTop(topPos);
			});
			});
        
		</script>
<?php
	include "/home/ebizpub/web-home/nurifunding.co.kr/api/web-home/common/bottom.php";
?>