<?php
    $m = "menu";

	include "/home/ebizpub/web-home/nurifunding.co.kr/api/web-home/common/top.php";

?>

		<script>
			document.domain = 'nurifunding.co.kr';

			function btn_chk(nuc) {
				$('#nx_btn').attr('disabled', true);
				if(nuc.length == 6) {
					$('#nx_btn').attr('disabled', false);
				}
			}

			function verify02() {
				var ci = $('input[name="ci"]').val();
				var di = $('input[name="di"]').val();
				var jumin2 = $('input[name="jumin2"]').val();

				if(ci == "" || di == "") {
					alert('본인인증을 진행해주세요.');
					return false;
				}

				if(jumin2 == "") {
					alert("주민등록번호가 올바르지 않습니다.");
					return false;
				}

				if(jumin2.length < 6) {
					alert("주민등록번호가 올바르지 않습니다.");
					return false;
				}

				$('#verify_form').attr('action', './verify_pw.php');
				$('#verify_form').submit();
			}
		</script>

		<?php
			$jumin2_f = 2;
			if($_POST["gender"] == "M") {
				$jumin2_f = 1;
			}

			$jumin1 = substr($_POST["birthday"], 2, 6);
		?>
		<div class="sr-only nuri-header-title-info">투자 계좌개설</div>
        <main id="container" class="container" role="main">
            <div class="page-content verify-content">
                <div class="page-body">
                    <div class="body-title lv-title-l">
                        본인인증을 진행해주세요.
                    </div>
                    <div class="verify-form-list mt-type-1">
                        <div class="text">
							<form name="verify_form" id="verify_form" method="post">

								<input type="hidden" name="ci" id="ci" value="<?=$_POST["ci"];?>" />
								<input type="hidden" name="di" id="di" value="<?=$_POST["di"];?>" />
								<input type="hidden" name="gender" id="gender" value="<?=$_POST["gender"];?>" />

								<input type="hidden" name="cid" value="<?=$_POST["cid"];?>" />
								<input type="hidden" name="tracking_cd" value="<?=$_POST["tracking_cd"];?>" />
								<input type="hidden" name="tm" value="<?=$_POST["tm"];?>" />
						
								<div class="form-group bor-b-1 d-flex align-items-center justify-space-between child-flex-1">
									<span class="lv-title-s text-notemphasis">이름</span>
									<div class="lv-form-input-cover w-auto">
										<input type="text" name="name" onclick="javascript: verify_chk();" class="lv-form-input lv-title-m bor-0 ta-right text-base" value="<?=$_POST["name"];?>"  readonly>
									</div>
								</div>
								<div class="form-group bor-b-1 d-flex align-items-center justify-space-between child-flex-1">
									<span class="lv-title-s text-notemphasis">휴대폰번호</span>
									<div class="lv-form-input-cover w-auto">
										<input type="text" name="phone" onclick="javascript: verify_chk();" class="lv-form-input lv-title-m bor-0 ta-right text-base" value="<?=$_POST["tel_no"];?>" readonly>
									</div>
								</div>
								<div class="form-group-wrapper d-flex align-items-center justify-space-between resident-number">
									<div class="form-group bor-b-1 d-in-flex align-items-center justify-space-between front-number child-flex-1">
										<span class="lv-title-s text-notemphasis">주민등록번호</span>
										<div class="lv-form-input-cover w-auto">
											<input type="text" name="jumin1" onclick="javascript: verify_chk();" class="lv-form-input lv-title-m bor-0 ta-right text-base" value="<?=$jumin1;?>" readonly>
										</div>
									</div>
									<div class="space">-</div>
									<div class="form-group bor-b-1 d-in-flex align-items-center justify-space-between back-number">
										<div class="lv-form-input-cover d-flex align-items-center justify-space-between">
											<span class="lv-title-m" id="jumin2_f"><?=$jumin2_f;?></span>
											<input type="text" name="jumin2" onKeyup="javascript: btn_chk(this.value);"; class="lv-form-input lv-title-m bor-0 remove-container text-blue" maxlength="6" numberonly>
											<i class="lv-form-text-remove" data-role="form-text-remove"><img src="https://nurifunding.co.kr/img/livemate/common/form_text_remove.svg" alt="입력텍스트삭제"></i>
										</div>
									</div>
								</div>
							</form>
                        </div>
                    </div>
                </div>
                <div class="page-footer">
					<div class="lv-btn-float-cover-wrapper">
						<div class="lv-btn-float-cover">
							<!-- 필수 체크 됐을 경우 disabled 제거 -->
							<a href="#" onclick="javascript: verify02();" id="nx_btn" class="lv-btn-primary" disabled>다음</a>
							<!-- <a href="./verify_02.html" class="lv-btn-primary">다음</a> -->
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
			});
		</script>

<?php
	include "/home/ebizpub/web-home/nurifunding.co.kr/api/web-home/common/bottom.php";
?>