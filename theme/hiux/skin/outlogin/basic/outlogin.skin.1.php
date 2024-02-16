<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<!-- 로그인 전 아웃로그인 시작 { -->
<section class="member-box">
    <div class="member-before-box">
        <h2 class="sound_only">회원로그인</h2>
        <form name="foutlogin" action="<?php echo $outlogin_action_url ?>" onsubmit="return fhead_submit(this);" method="post" autocomplete="off">
        <fieldset>
            <div class="ol-wr">
                <input type="hidden" name="url" value="<?php echo $outlogin_url ?>">
                <label for="ol_id" id="ol_idlabel" class="sound_only">회원아이디<strong>필수</strong></label>
                <input type="text" id="ol_id" name="mb_id" class="inp" required maxlength="20" placeholder="아이디" autocomplete="username">
                <label for="ol_pw" id="ol_pwlabel" class="sound_only">비밀번호<strong>필수</strong></label>
                <input type="password" name="mb_password" id="ol_pw"" class="inp" required maxlength="20" placeholder="비밀번호" autocomplete="current-password">
                <input type="submit" id="ol_submit" value="로그인" class="btn_b02 btn_submit">
            </div>
            <div class="ol-auto-wr"> 
                <div class="auto">
                    <label class="checkbox small">
                        <input type="checkbox" name="auto_login" value="1" id="auto_login">
                        <i></i>
                        <span class="lbl">자동로그인</label>
                    </label>
                </div>
                <div class="svc"><a href="<?php echo G5_BBS_URL ?>/register.php">회원가입</a> / <a href="<?php echo G5_BBS_URL ?>/password_lost.php" id="ol_password_lost">정보찾기</a></div>
            </div>
        <?php
        // 소셜로그인 사용시 소셜로그인 버튼
        @include_once(get_social_skin_path().'/social_login.skin.php');
        ?>
        </fieldset>
        </form>
    </div>
    <button type="button" class="btn-close"><i class="fa fa-times" aria-hidden="true"></i><span class="sound_only">닫기</span></button>
</section>

<script>
jQuery(function($) {

    var $omi = $('#ol_id'),
        $omp = $('#ol_pw'),
        $omi_label = $('#ol_idlabel'),
        $omp_label = $('#ol_pwlabel');

    $omi_label.addClass('ol_idlabel');
    $omp_label.addClass('ol_pwlabel');

    $("#auto_login").click(function(){
        if ($(this).is(":checked")) {
            if(!confirm("자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?"))
                return false;
        }
    });
});

function fhead_submit(f)
{
    if( $( document.body ).triggerHandler( 'outlogin1', [f, 'foutlogin'] ) !== false ){
        return true;
    }
    return false;
}
</script>
<!-- } 로그인 전 아웃로그인 끝 -->
