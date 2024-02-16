<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<!-- 로그인 후 아웃로그인 시작 { -->
<section class="member_box after">
    <div class="after_box">
        <header class="after_hd">
            <h2>나의 회원정보</h2>
            <span class="profile_img">
                <?php echo get_member_profile_img($member['mb_id']); ?>
                <a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=register_form.php" id="ol_after_info" title="정보수정"><i class="fa fa-cog" aria-hidden="true"></i><span class="sound_only">정보수정</span></a>
            </span>
            <div class="name">
                <strong><?php echo $nick ?>님</strong>
            </div>
            <a href="<?php echo G5_BBS_URL ?>/logout.php" id="ol_after_logout" class="btn_b04"><i class="fa fa-sign-out" aria-hidden="true"></i> 로그아웃</a>
            <?php if ($is_admin == 'super' || $is_auth) {  ?><a href="<?php echo G5_ADMIN_URL ?>" class="btn_admin btn_04">관리자</a><?php }  ?>
        </header>
        <ul class="after_private">
            <li>
                <a href="<?php echo G5_BBS_URL ?>/point.php" target="_blank" id="ol_after_pt" class="win_point">
                    포인트<br>
                    <strong><i class="fa fa-database" aria-hidden="true"></i><?php echo $point; ?></strong>
                </a>
            </li>
            <li>
                <a href="<?php echo G5_BBS_URL ?>/memo.php" target="_blank" id="ol_after_memo" class="win_memo">
                    <span class="sound_only">안 읽은 </span>쪽지<br>
                    <strong><i class="fa fa-envelope-o" aria-hidden="true"></i><?php echo $memo_not_read; ?></strong>
                </a>
            </li>
            <li>
                <a href="<?php echo G5_BBS_URL ?>/scrap.php" target="_blank" id="ol_after_scrap" class="win_scrap">
                    스크랩<br>
                    <strong class="scrap"><i class="fa fa-thumb-tack" aria-hidden="true"></i><?php echo $mb_scrap_cnt; ?></strong>
                </a>
            </li>
        </ul>
    </div>
    <p class="link">
		<span class="left">
			<a href="/bbs/new.php?mb_id=<?php echo $member['mb_id'] ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> 내가 쓴 글</a>
		</span>
		<span class="right">
			<a href="javascript:member_leave();" class="t_gray">회원탈퇴</a>
		</span>
	</p>
	<a href="#" class="btn_close"><i class="fa fa-times" aria-hidden="true"></i><span class="sound_only">닫기</span></a>
</section>

<script>
// 탈퇴의 경우 아래 코드를 연동하시면 됩니다.
function member_leave()
{
    if (confirm("정말 회원에서 탈퇴 하시겠습니까?"))
        location.href = "<?php echo G5_BBS_URL ?>/member_confirm.php?url=member_leave.php";
}
</script>
<!-- } 로그인 후 아웃로그인 끝 -->
