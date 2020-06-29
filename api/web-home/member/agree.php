<?php
    $m = "menu";

	include "/home/ebizpub/web-home/nurifunding.co.kr/api/web-home/common/top.php";
?>		
	<script>

		$(function() {
			$('.check-item').on('change', function() {
				$('input[name="all_chk"]').prop('checked', false);
				$('#nx_btn').attr('disabled', true);
				
				if($("#chk-2").is(":checked") == true && $("#chk-3").is(":checked") == true && $("#chk-4").is(":checked") == true) {
					$('#nx_btn').attr('disabled', false);
				}

				if($('input[type="checkbox"]:checked').length == 4) {
					$('input[name="all_chk"]').prop('checked', true);
				}
			});
		});

		function policy_all_chk() {
			if($('input[name="all_chk"]').is(":checked") == true) {
				$("#chk-1").prop('checked', true);
				$("#chk-2").prop('checked', true);
				$("#chk-3").prop('checked', true);
				$("#chk-4").prop('checked', true);

				$('#nx_btn').attr('disabled', false);
			} else {
				$("#chk-1").prop('checked', false);
				$("#chk-2").prop('checked', false);
				$("#chk-3").prop('checked', false);
				$("#chk-4").prop('checked', false);

				$('#nx_btn').attr('disabled', true);
			}
		}

		function agree_chk() {
			if($("#chk-2").is(":checked") == false) {
				alert("투자이용약관 동의 후 투자하실 수 있습니다");
				return false;
			}
			if($("#chk-3").is(":checked") == false) {
				alert("개인정보취급방침 동의 후 투자하실 수 있습니다");
				return false;
			}
			if($("#chk-4").is(":checked") == false) {
				alert("대부거래기본약관 동의 후 투자하실 수 있습니다");
				return false;
			}	

			alert("서비스 이용을 위해 '본인인증'을 진행합니다.");

			$('form[name="jform"]').attr('action', 'http://verify.nurifunding.co.kr/chk/cert2.php');
			$('form[name="jform"]').submit();
		}
	</script>
		<div class="sr-only nuri-header-title-info">이커머스 선정산 투자</div>
        <main id="container" class="container" role="main">
            <div class="page-content verify-content">
                <div class="page-body">
                    <div class="body-title lv-title-l">
                        <!-- 김리브님,  -->이커머스 투자서비스<br>이용에 동의해주세요.
                    </div>
                    <div class="agree-form-list">
                        <div class="title">
                            <label class="lv-checkbox-cover">
                                <input type="checkbox" class="check-all" name="all_chk" onclick="javascript: policy_all_chk();" data-check-name="agree-check">
                                <span class="lv-checkbox"></span>
                                <span class="lv-title-m">전체동의</span>
                            </label>
                        </div>
						<form name="jform" method="post">
							<?php
								foreach($_POST as $key => $val) {
							?>
							<input type="hidden" name="<?=$key;?>" value="<?=$val;?>" />
							<?php
								}
							?>
							<div class="text">
								
								<div class="form-group d-flex align-items-center justify-content-space-between">
									<label class="lv-checkbox-cover">
										<input type="checkbox" class="check-item" name="chk_1" id="chk-1" data-check-name="agree-check">
										<span class="lv-checkbox"></span>
										<span class="lv-title-s">제휴사 약관(선택)</span>
									</label>
									<a href="javascript:;" data-toggle="modal" data-target="#termsUseModal"><img src="https://nurifunding.co.kr/img/livemate/common/arr_right.svg" alt="이동"></a>
								</div>
								<div class="form-group d-flex align-items-center justify-content-space-between">
									<label class="lv-checkbox-cover">
										<input type="checkbox" class="check-item" name="chk_2" id="chk-2" data-check-name="agree-check">
										<span class="lv-checkbox"></span>
										<span class="lv-title-s">투자이용약관(필수)</span>
									</label>
									<a href="javascript:;" data-toggle="modal" data-target="#termsInvestModal"><img src="https://nurifunding.co.kr/img/livemate/common/arr_right.svg" alt="이동"></a>
								</div>
								<div class="form-group d-flex align-items-center justify-content-space-between">
									<label class="lv-checkbox-cover">
										<input type="checkbox" class="check-item" name="chk_3" id="chk-3" data-check-name="agree-check">
										<span class="lv-checkbox"></span>
										<span class="lv-title-s">개인정보취급방침(필수)</span>
									</label>
									<a href="javascript:;" data-toggle="modal" data-target="#termsPrivacyModal"><img src="https://nurifunding.co.kr/img/livemate/common/arr_right.svg" alt="이동"></a>
								</div>
								<div class="form-group d-flex align-items-center justify-content-space-between">
									<label class="lv-checkbox-cover">
										<input type="checkbox" class="check-item" name="chk_4" id="chk-4" data-check-name="agree-check">
										<span class="lv-checkbox"></span>
										<span class="lv-title-s">대부거래기본약관(필수)</span>
									</label>
									<a href="javascript:;" data-toggle="modal" data-target="#termsLoanModal"><img src="https://nurifunding.co.kr/img/livemate/common/arr_right.svg" alt="이동"></a>
								</div>

							</div>
						</form>
                    </div>
                </div>
                <div class="page-footer">
					<div class="lv-btn-float-cover-wrapper">
						<div class="lv-btn-float-cover">
							<!-- 필수 체크 됐을 경우 disabled 제거 -->
							<a href="javascript: agree_chk();" id="nx_btn" class="lv-btn-primary" disabled>다음</a>
							<!-- <a href="./verify_01.html" class="lv-btn-primary">다음</a> -->
						</div>
					</div>
                </div>
            </div>
        </main>
        <!-- /.container -->

		<?php
			include "/home/ebizpub/web-home/nurifunding.co.kr/api/web-home/member/policy.php";
		?>

<?php
	include "/home/ebizpub/web-home/nurifunding.co.kr/api/web-home/common/bottom.php";
?>