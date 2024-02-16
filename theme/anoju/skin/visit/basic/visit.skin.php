<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

global $is_admin;
?>

<!-- 접속자집계 시작 { -->
<section class="foot_visit">
    <div class="inner">
		<h2>접속자집계 <?php if ($is_admin == "super") {  ?><a href="<?php echo G5_ADMIN_URL ?>/visit_list.php" class="btn_admin">상세보기</a><?php } ?></h2>
	</div>
	<hr>
    <div class="inner">
		<ul>
			<li>
				<p><span class="color_1"></span> 오늘</dt></p>
				<div><strong class="color_1"><?php echo number_format($visit[1]) ?></div>
			</li>
			<li>
				<p><span class="color_2"></span> 어제</p>
				<div><strong class="color_2"><?php echo number_format($visit[2]) ?></strong></div>
			</li>
			<li>
				<p><span class="color_3"></span> 최대</p>
				<div><strong class="color_3"><?php echo number_format($visit[3]) ?></strong></div>
			</li>
			<li>
				<p><span class="color_4"></span> 전체</p>
				<div><strong class="color_4"><?php echo number_format($visit[4]) ?></strong></div>
			</li>
		</ul>
	</div>
</section>
<!-- } 접속자집계 끝 -->