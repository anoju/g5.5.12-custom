	<?php
	if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

	if (G5_IS_MOBILE) {
		include_once(G5_THEME_MOBILE_PATH.'/tail.php');
		return;
	}
	?>

	<?php if (!defined('_INDEX_')) { ?>
			</div>
		</div>
	<!-- } 콘텐츠 끝 -->
	<?php } ?>

		<footer id="footer" class="footer">
			<div class="inner">
				<div class="logo" role="img" aria-label="하이유엑스컨설팅"></div>
				<div class="f-menu-list">
				</div>
				<div class="f-info-grp">
					<div class="info-box">
						<div class="tit">Office</div>
						<div class="txt">
							6F E-605, SK V1 Center,<br />
							11 Dangsan-ro 41-gil,<br />
							Yeongdeugpo-gu, Seoul
						</div>
					</div>
					<div class="info-box">
						<div class="tit">Contact</div>
						<div class="txt">
							<a href="tel:0226753397">T 02-2675-3397</a>
							<a href="tel:0226753387">F 02-2675-3387</a>
							<a href="mailto:jykim@hiuxc.com">E jykim@hiuxc.com</a>
						</div>
					</div>
				</div>
				<span class="copyright">&copy; 2024 HiUX Consulting. All Rights Reserved.</span>
			</div>
		</footer>
		<div class="hidden-menu-btn"><button type="button"><i class="fa fa-user" aria-hidden="true"></i></button></div>
		<div class="scroll-top"><button type="button" class="btn-scroll-top" aria-label="페이지 상단으로 이동"></button></div>

		<?php if (defined("_INDEX_")) { ?>
				</div>
			</div>
		</div>
		<!-- contents end -->
		<?php } ?>
	</div>
</div>
<div class="hidden-menu-wrap">
	<div class="inner">
		<?php echo outlogin('theme/basic'); ?>

		<?php if ($is_admin) {  ?>
		<?php echo visit('theme/basic'); ?>
		<?php }  ?>
	</div>
</div>

	<?php
	if(G5_DEVICE_BUTTON_DISPLAY && !G5_IS_MOBILE) { ?>
	<?php
	}

	if ($config['cf_analytics']) {
		echo $config['cf_analytics'];
	}
	?>

	<!-- } 하단 끝 -->
</div>
<script>
$(function() {
    // 폰트 리사이즈 쿠키있으면 실행
    font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
});
</script>
<?php
include_once(G5_THEME_PATH."/tail.sub.php");
?>