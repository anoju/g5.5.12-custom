<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/head.php');
    return;
}

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
?>
<div class="loading"></div>
<!-- 상단 시작 { -->
<?php if (defined('_INDEX_')) { ?>
<div id="wrap" class="main">
<?php } else {  ?>
<div id="wrap">
<?php }  ?>
    <?php
    if(defined('_INDEX_')) { // index에서만 실행
        include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
    }
    ?>
	<?php if (defined('_INDEX_')) { ?>
	<div class="visual main_visual">
		<div class="bg"></div>
		<div class="youtube">
			<div id="player"></div>
			<!-- <iframe src="https://www.youtube.com/embed/jQ-AnBA71sE?enablejsapi=1&amp;version=3&amp;playerapiid=ytplayer&amp;rel=0&amp;controls=0&amp;showinfo=0&amp;wmode=opaque&amp;autoplay=1&amp;loop=1&amp;playlist=jQ-AnBA71sE" frameborder="0" allowfullscreen="" title="광고동영상"></iframe> -->
			<i></i>
		</div>
		<script>
		if(isMobile.any()){
			$('.youtube').remove();
		}else{
			var tag = document.createElement('script');
			tag.src = "//www.youtube.com/iframe_api";
			var firstScriptTag = document.getElementsByTagName('script')[0];
			firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

			var player;
			function onYouTubeIframeAPIReady() {
				player = new YT.Player('player', {
					height: '100%',
					width: '100%',
					videoId: 'jQ-AnBA71sE',
					playerVars: {
						autoplay: 1,
						loop: 1,
						rel: 0,
						playlist: 'jQ-AnBA71sE',
						showInfo: 0,
						modestbranding: 1,
						fs: 0,
						controls: 0,
						iv_load_policy: 3,
						playsinline: 1,
					},
					events: {
						'onReady': onPlayerReady,
						// 'onStateChange': onPlayerStateChange
					}
				});
			}
			function onPlayerReady(event) {
				event.target.mute();
				event.target.setPlaybackQuality('hd1080');
				event.target.playVideo();
			}
			var done = false;
			function onPlayerStateChange(event) {
				if (event.data == YT.PlayerState.PLAYING && !done) {
					setTimeout(stopVideo, 6000);
					done = true;
				}
			}
			function stopVideo() {
				player.stopVideo();
			}

			$(window).resize(function(){
				var $youtube = $('.youtube'),
					$wrap = $('.main_visual'),
					$wrapW = $wrap.outerWidth(),
					$wrapH = $wrap.outerHeight();
				if(($wrapW/$wrapH) === (16/9)){
					$youtube.css({
						'width':'100%',
						'height': '100%'
					});
				}else if(($wrapW / $wrapH) > (16/9)){
					$youtube.css({
						'width':'100%',
						'height': ($wrapW/16)*9
					});
				}else{
					$youtube.css({
						'width': ($wrapH/9)*16,
						'height': '100%'
					});
				}
			}).resize();
		}
		</script>
	<?php } else {  ?>
	<div class="visual">
		<div class="bg"></div>
	<?php }  ?>
		<!-- Header -->
		<header id="header">
			<div class="inner">				
				<div class="head_top">
					<?php if ($is_member) {  ?>
					<div class="head_info">
						<p><a href="#" class="btn_member t_red btn_user"><i class="fa fa-user-circle" aria-hidden="true"></i> <?php echo $member['mb_nick'] ?></a>님 안녕하세요</p>						
						<!-- <dl>
							<dt>Total Point</dt>
							<dd><a href="<?php echo G5_BBS_URL ?>/point.php" target="_blank" class="win_point">110 Point</a></dd>
						</dl> -->
					</div>
					<?php }  ?>
					<?php echo outlogin('theme/basic'); // 외부 로그인, 테마의 스킨을 사용하려면 스킨을 theme/basic 과 같이 지정 ?>
					<ul class="head_menu">
						<?php if ($is_member) {  ?>
						<li><a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php"><i class="fa fa-cog" aria-hidden="true"></i> 정보수정</a></li>
						<li><a href="<?php echo G5_BBS_URL ?>/logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> 로그아웃</a></li>
						<?php if ($is_admin) {  ?>
						<li  class="tnb_admin"><a href="<?php echo G5_ADMIN_URL ?>"><b><i class="fa fa-user-circle-o" aria-hidden="true"></i> 관리자접속</b></a></li>
						<?php }  ?>
						<?php } else {  ?>
						<!-- <li><a href="<?php echo G5_BBS_URL ?>/register.php"><i class="fa fa-user-plus" aria-hidden="true"></i> 회원가입</a></li> -->
						<li>
							<a href="#" class="btn_member pc_login"><b><i class="fa fa-sign-in" aria-hidden="true"></i> 로그인</b></a>
							<a href="<?php echo G5_BBS_URL ?>/login.php" class="mo_login"><b><i class="fa fa-sign-in" aria-hidden="true"></i> 로그인</b></a>
						</li>
						<?php }  ?>
					</ul>
				</div>
				<div class="gnb_wrap">
					<h1 id="logo"><a href="<?php echo G5_URL ?>"><?php echo $config['cf_title']; ?></a></h1>
					<button class="btn_gnb"><i></i><span>모바일 GNB열기</span></button>
					<nav id="gnb">
						<ul>
						<?php
								$menu_datas = get_menu_db(0, true);
                $i = 0;
                foreach( $menu_datas as $row ){
                    if( empty($row) ) continue;
                    $add_class = (isset($row['sub']) && $row['sub']) ? 'gnb_al_li_plus' : '';
                ?>
                <li class="gnb_1dli <?php echo $add_class; ?>">
                    <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="gnb_1da"><?php echo $row['me_name'] ?></a>
                    <?php
                    $k = 0;
                    foreach( (array) $row['sub'] as $row2 ){

                        if( empty($row2) ) continue; 

                        if($k == 0)
                            echo '<span class="bg">하위분류</span><div class="gnb_2dul"><ul class="gnb_2dul_box">'.PHP_EOL;
                    ?>
                        <li class="gnb_2dli"><a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>" class="gnb_2da"><?php echo $row2['me_name'] ?></a></li>
                    <?php
                    $k++;
                    }   //end foreach $row2

                    if($k > 0)
                        echo '</ul></div>'.PHP_EOL;
                    ?>
                </li>
                <?php
                $i++;
                }   //end foreach $row

                if ($i == 0) {  ?>
                    <li class="gnb_empty">메뉴 준비 중입니다.<?php if ($is_admin) { ?> <a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php">관리자모드 &gt; 환경설정 &gt; 메뉴설정</a>에서 설정하실 수 있습니다.<?php } ?></li>
                <?php } ?>
						</ul>
					</nav>
				</div>
			</div>
		</header>
		<!-- //Header -->

		<!-- 콘텐츠 시작 { -->
		<?php if (defined('_INDEX_')) { ?>
		<div class="page_top">
			<div class="inner">
				<h2>그누보드 테스팅 사이트</h2>
			</div>
		</div>
		<?php }else{ ?>
		<div class="page_top">
			<div class="inner">
				<h2 id="pageTit"><span><?php echo $g5['title'] ?></span></h2>
				<ul id="location">
					<li><a href="<?php echo G5_URL ?>"><i class="fa fa-home" aria-hidden="true"></i> 홈</a></li>
				</ul>
			</div>
		</div>
		<?php } ?>
	</div>
	   
	<section id="contents">

