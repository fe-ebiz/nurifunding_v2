<?php
	include "/home/ebizpub/web-home/nurifunding.co.kr/api/web-home/common/top.php";
?>

		<script>
			function copy() {
                var tmpTextarea = document.createElement('textarea');
                tmpTextarea.value = "<?=$member_info['debank_no'];?>";
             
                document.body.appendChild(tmpTextarea);
                tmpTextarea.select();
                tmpTextarea.setSelectionRange(0, 9999);  // 셀렉트 범위 설정
             
                document.execCommand('copy');
                document.body.removeChild(tmpTextarea);
				//alert("계좌번호 복사가 완료되었습니다.");
			}
		</script>

<div class="sr-only nuri-header-title-info">투자 계좌개설</div>
        <main id="container" class="container" role="main">
            <div class="page-content verify-content">
                <div class="page-body">
                    <div class="body-title lv-title-l">
                        투자 준비가 완료되었어요!<br>
                    </div>
                    <div class="body-subtitle lv-title-s text-notemphasis mt-1">
                        생성된 가상계좌에 예치금 입금 후<br>
                        원하시는 상품에 투자를 진행해주세요.
                    </div>
                    <div class="verify-form-list mt-type-3">
                        <div class="text">
                            <div class="form-group bor-b-1 d-flex align-items-center justify-space-between child-flex-1 mb-2">
                                <span class="lv-title-s text-notemphasis">가상계좌 은행명</span>
                                <div class="lv-form-input-cover w-auto">
                                    <input type="text" class="lv-form-input lv-title-m bor-0 ta-right text-base" value="<?=$member_info["debank"];?>" readonly>
                                </div>
                            </div>
                            <div class="form-group-wrapper bor-b-1 d-flex align-items-center justify-space-between mb-1">
                                <span class="lv-title-s text-notemphasis bank-account">계좌번호</span>
                                <div class="form-group d-in-flex align-items-center justify-space-between bank-account-number mb-0">
                                    <div class="lv-form-input-cover d-flex align-items-center justify-space-between w-auto">
                                        <input type="text" class="lv-form-input lv-title-m bor-0 text-base" value="<?=$member_info["debank_no"];?>" readonly>
                                    </div>
                                    <a href="javascript: copy();" class="lv-flag lv-btn-flag copy-btn" data-toggle="toast" data-target="#lvToastWrapper">복사</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="subtext-wrapper">
                        <p class="lv-text text-support dot">고객님의 가상계좌로 예치금을 입금해주세요.</p>
                        <p class="lv-text text-support dot">본인인증한 휴대폰번호화 비밀번호로 누리펀딩 로그인이 가능합니다.</p>
                    </div>
                </div>
                <div class="page-footer">
                    <div class="lv-btn-float-cover">
                        <!-- 필수 체크 됐을 경우 disabled 제거 -->
                        <a href="../invest/list.php" class="lv-btn-primary">투자상품 보기</a>
                        <!-- <a href="./verify_complete.html" class="lv-btn-primary">투자상품 보기</a> -->
                    </div>
                </div>
            </div>
        </main>
        <!-- /.container -->

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