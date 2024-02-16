	<?php
	if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

	if (G5_IS_MOBILE) {
		include_once(G5_THEME_MOBILE_PATH.'/tail.php');
		return;
	}
	?>

	</section>
	<!-- } 콘텐츠 끝 -->

	<!-- Footer -->
	<footer id="footer">
		<?php
		//공지사항
		// 이 함수가 바로 최신글을 추출하는 역할을 합니다.
		// 사용방법 : latest(스킨, 게시판아이디, 출력라인, 글자수);
		// 테마의 스킨을 사용하려면 theme/basic 과 같이 지정
		echo latest('theme/notice', 'notice', 5, 30);
		?>
		<div class="foot_navi">
			<div class="inner">
				
			</div>
		</div>
		<div class="foot_info">			
			<?php if ($is_admin) {  ?>
			<?php echo visit('theme/basic'); // 접속자집계, 테마의 스킨을 사용하려면 스킨을 theme/basic 과 같이 지정 ?>
			<?php }  ?>
			<div class="inner">
				<!-- <ul class="foot_link">
					<li><a href="http://www.yonhapnews.co.kr/" target="_blank"><img src="<?php echo G5_THEME_IMG_URL ?>/common/foot_link_ic1.png" alt=""> 연합뉴스</a></li>
					<li><a href="http://nodong.org/" target="_blank"><img src="<?php echo G5_THEME_IMG_URL ?>/common/foot_link_ic2.png" alt=""> 전국민주노동조합총연맹</a></li>
					<li><a href="http://inochong.org/" target="_blank"><img src="<?php echo G5_THEME_IMG_URL ?>/common/foot_link_ic3.png" alt=""> 한국노동조합총연맹</a></li>
					<li><a href="http://www.fsc.go.kr/" target="_blank"><img src="<?php echo G5_THEME_IMG_URL ?>/common/foot_link_ic4.png" alt=""> 금융위원회</a></li>
					<li><a href="http://www.moel.go.kr/" target="_blank"><img src="<?php echo G5_THEME_IMG_URL ?>/common/foot_link_ic4.png" alt=""> 고용노동부</a></li>
					<li><a href="http://kfiu.org/main/main.php" target="_blank"><img src="<?php echo G5_THEME_IMG_URL ?>/common/foot_link_ic5.png" alt=""> 전국금융산업노동조합</a></li>
					<li><a href="http://www.vop.co.kr/index.html" target="_blank"><img src="<?php echo G5_THEME_IMG_URL ?>/common/foot_link_img.png" alt="민중의 소리"></a></li>
				</ul>
				<ul class="foot_menu">
					<li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=provision">이용약관</a></li>
					<li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=privacy"><strong class="t_red">개인정보 처리방침</strong></a></li>
				</ul>
				<ul class="foot_address">
					<li>서울특별시 영등포구 은행로 14 (여의도동 16-3)</li>
					<li>T. 02-787-7059</li>
					<li>F. 02-787-7091</li>
				</ul> -->
				<br><br>
				<p class="foot_copy">Copyright ⓒ 2017 anoju.com All Rights Reserved.</p>
				<br><br>
			</div>
		</div>
	</footer>
	<!-- //Footer -->

	<!-- popup -->
	<div id="popBarcode" class="pop_bg">
		<article class="pop_wrap">
			<h1><span>회원 바코드 상세</span></h1>
			<div class="pop_cont">
				<div class="barcode_wrap">
					<span><svg id="barcode"></svg></span>
				</div>
			</div>
			<button class="btn_close pop_close">닫기</button>
		</article>
	</div>

	<!-- //popup -->

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
<?php if (defined("_INDEX_")) { ?>
<script>
(function() {
	var snowEf = function(){
		var pointerEventsSupported = (function() {
			var element = document.createElement('x'),
				documentElement = document.documentElement,
				getComputedStyle = window.getComputedStyle,
				supports;
			if (!('pointerEvents' in element.style)) {
				return false;
			}
			element.style.pointerEvents = 'auto';
			element.style.pointerEvents = 'x';
			documentElement.appendChild(element);
			supports = getComputedStyle &&
				getComputedStyle(element, '').pointerEvents === 'auto';
			documentElement.removeChild(element);
			return !!supports;
		})();

		if (pointerEventsSupported) {
			$('<canvas id="snowFx"></canvas>').appendTo('body').attr('style', 'position:fixed;top:0;left:0;right:0;bottom:0;z-index:9999;width:100%;height:100%;pointer-events:none;');

			var c = document.getElementById('snowFx'),
				context = c.getContext("2d");
			var w = c.width = window.innerWidth,
				h = c.height = window.innerHeight;

			Snowy();

			function Snowy() {
				var snow, arr = [];
				var num = 600,
					tsc = 1,
					sp = 1;
				var sc = 1.3,
					t = 0,
					mv = 20,
					min = 1;
				for (var i = 0; i < num; ++i) {
					snow = new Flake();
					snow.y = Math.random() * (h + 50);
					snow.x = Math.random() * w;
					snow.t = Math.random() * (Math.PI * 2);
					snow.sz = (100 / (10 + (Math.random() * 100))) * sc;
					snow.sp = (Math.pow(snow.sz * .8, 2) * .15) * sp;
					snow.sp = snow.sp < min ? min : snow.sp;
					snow.sp *= .25;
					arr.push(snow);
				}
				go();

				function go() {
					window.requestAnimationFrame(go);
					context.clearRect(0, 0, w, h);
					//context.fillStyle = 'hsla(242, 95%, 3%, 1)';
					//context.fillRect(0, 0, w, h);
					context.fill();
					for (var i = 0; i < arr.length; ++i) {
						f = arr[i];
						f.t += .05;
						f.t = f.t >= Math.PI * 2 ? 0 : f.t;
						f.y += f.sp;
						f.x += Math.sin(f.t * tsc) * (f.sz * .3);
						if (f.y > h + 50) f.y = -10 - Math.random() * mv;
						if (f.x > w + mv) f.x = -mv;
						if (f.x < -mv) f.x = w + mv;
						f.draw();
					}
				}

				function Flake() {
					this.draw = function() {
						this.g = context.createRadialGradient(this.x, this.y, 0, this.x, this.y, this.sz);
						this.g.addColorStop(0, 'hsla(255,255%,255%,1)');
						this.g.addColorStop(1, 'hsla(255,255%,255%,0)');
						context.moveTo(this.x, this.y);
						context.fillStyle = this.g;
						context.beginPath();
						context.arc(this.x, this.y, this.sz, 0, Math.PI * 2, true);
						context.fill();
					}
				}
			}
			/*________________________________________*/
			window.addEventListener('resize', function() {
				c.width = w = window.innerWidth;
				c.height = h = window.innerHeight;
			}, false);

		}
	}
	// snowEf();
})();
</script>
<?php } ?>
<?php
include_once(G5_THEME_PATH."/tail.sub.php");
?>