<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

global $is_admin;
?>

<aside id="visit">
    <h2>접속자집계</h2>
    <dl>
        <dt>오늘</dt>
        <dd><?php echo number_format($visit[1]) ?></dd>
        <dt>어제</dt>
        <dd><?php echo number_format($visit[2]) ?></dd>
        <dt>최대</dt>
        <dd><?php echo number_format($visit[3]) ?></dd>
        <dt>전체</dt>
        <dd><?php echo number_format($visit[4]) ?></dd>
    </dl>
    <?php if ($is_admin == "super") { ?><a href="<?php echo G5_ADMIN_URL ?>/visit_list.php" class="btn_admin btn"><i class="fa fa-cog fa-spin fa-fw"></i><span class="sound_only">상세보기</span></a></a><?php } ?>
</aside>
