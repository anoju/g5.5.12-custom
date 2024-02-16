<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<!-- 회원가입약관 동의 시작 { -->
<div class="register">

    <form  name="fregister" id="fregister" action="<?php echo $register_action_url ?>" onsubmit="return fregister_submit(this);" method="POST" autocomplete="off">

    <p><i class="fa fa-check-circle" aria-hidden="true"></i> 회원가입약관 및 개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.</p>
    
    <?php
    // 소셜로그인 사용시 소셜로그인 버튼
    @include_once(get_social_skin_path().'/social_register.skin.php');
    ?>
    <section class="fregister_term">
        <h2>회원가입약관</h2>
        <textarea readonly class="textarea"><?php echo get_text($config['cf_stipulation']) ?></textarea>
        <fieldset class="fregister_agree">
            <label class="checkbox">
                <input type="checkbox" name="agree" value="1" id="agree11">
                <i></i>
                <span class="lbl">회원가입약관의 내용에 동의합니다.</span>
            </label>
        </fieldset>
    </section>

    <section class="fregister_private">
        <h2>개인정보처리방침안내</h2>
        <div class="text">
            <table>
                <caption>개인정보처리방침안내</caption>
                <thead>
                <tr>
                    <th>목적</th>
                    <th>항목</th>
                    <th>보유기간</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>이용자 식별 및 본인여부 확인</td>
                    <td>아이디, 이름, 비밀번호</td>
                    <td>회원 탈퇴 시까지</td>
                </tr>
                <tr>
                    <td>고객서비스 이용에 관한 통지,<br>CS대응을 위한 이용자 식별</td>
                    <td>연락처 (이메일, 휴대전화번호)</td>
                    <td>회원 탈퇴 시까지</td>
                </tr>
                </tbody>
            </table>
        </div>

        <fieldset class="fregister_agree">
            <label class="checkbox">
                <input type="checkbox" name="agree2" value="1" id="agree21">
                <i></i>
                <span class="lbl">개인정보처리방침안내의 내용에 동의합니다.</span>
            </label>
        </fieldset>
    </section>
	
	<div id="fregister_chkall" class="chk_all fregister_agree">
        <label class="checkbox">
            <input type="checkbox" name="chk_all" id="chk_all">
            <i></i>
            <span class="lbl">회원가입 약관에 모두 동의합니다</span>
        </label>
    </div>
	    
    <div class="btn_wrap">
    	<a href="<?php echo G5_URL ?>" class="button h60 w-150 btn_gray">취소</a>
        <button type="submit" class="button h60 w-150 btn_blue">회원가입</button>
    </div>

    </form>

    <script>
    function fregister_submit(f)
    {
        if (!f.agree.checked) {
            alert("회원가입약관의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
            f.agree.focus();
            return false;
        }

        if (!f.agree2.checked) {
            alert("개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
            f.agree2.focus();
            return false;
        }

        return true;
    }
    
    jQuery(function($){
        // 모두선택
        $("input[name=chk_all]").click(function() {
            if ($(this).prop('checked')) {
                $("input[name^=agree]").prop('checked', true);
            } else {
                $("input[name^=agree]").prop("checked", false);
            }
        });
    });

    </script>
</div>
<!-- } 회원가입 약관 동의 끝 -->
