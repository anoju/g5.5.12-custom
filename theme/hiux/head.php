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
<!-- 상단 시작 { -->
<?php if (defined('_INDEX_')) { ?>
<div id="wrapper" class="main">
<?php } else {  ?>
<div id="wrapper">
<?php }  ?>
	<div class="contents-area" id="container">
		<!-- Header -->
		<header id="header" class="header">
			<div class="inner">
				<h1 class="h1"><a href="<?php echo G5_URL ?>"><?php echo $config['cf_title']; ?></a></a></h1>
				<div class="right">
					<button type="button" aria-label="메뉴 열기" class="btn-menu">
						<strong>MENU</strong>
						<span aria-hidden="true" class="gnb-icon"></span>
					</button>
					<nav class="commonGnb">
						<ol>
							<!-- <li class="menu-li"><a href="about.html">About</a></li>
							<li class="menu-li"><a href="work.html">Work</a></li>
							<li class="menu-li"><a href="news.html">News</a></li>
							<li class="menu-li"><a href="contact.html">Contact</a></li> -->
							<?php
								$menu_datas = get_menu_db(0, true);
								$i = 0;
								foreach( $menu_datas as $row ){
										if( empty($row) ) continue;
										$add_class = (isset($row['sub']) && $row['sub']) ? 'menu-add' : '';
								?>
								<li class="menu-li <?php echo $add_class; ?>">
										<a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="menu-item"><?php echo $row['me_name'] ?></a>
										<?php
										$k = 0;
										foreach( (array) $row['sub'] as $row2 ){

												if( empty($row2) ) continue; 

												if($k == 0)
														echo '<span class="blind">하위분류</span><div class="gnb-menu2"><ul>'.PHP_EOL;
										?>
												<li class="menu2-li"><a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>" class="menu2-item"><?php echo $row2['me_name'] ?></a></li>
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
						</ol>
						<a href="/COMPANY%20BRIEF_HIUX.pdf" target="_blank" aria-label="본사소개서 다운로드" class="btn-download">Company Brief</a>
					</nav>
				</div>
			</div>
		</header>
		<!-- //Header -->

		<!-- 콘텐츠 시작 { -->
		<?php if (defined('_INDEX_')) { ?>
		<!-- main slide -->
		<div class="main-slide-wrap">
			<div class="swiper main-swiper visual-box">
				<div class="swiper-wrapper">
					<div class="swiper-slide visual-cell">
						<a href="#none" role="button">
							<img src="<?php echo G5_THEME_IMG_URL ?>/main/img-ex-mainScroll.png" />
							<div class="context-box">
								<div class="tag">i - AWARDS KOREA 2023</div>
								<div class="headtit">스마트앱어워드<br />최고대상</div>
								<div class="subtit">KB스타뱅킹 자산관리</div>
								<i class="ico-app-award"></i>
							</div>
						</a>
					</div>
					<div class="swiper-slide visual-cell">
						<a href="#none" role="button">
							<img src="<?php echo G5_THEME_IMG_URL ?>/main/img-ex-mainScroll2.png" />
							<div class="context-box">
								<div class="tag">i - AWARDS KOREA 2023</div>
								<div class="headtit">스마트앱어워드<br />금융연계분야 대상</div>
								<div class="subtit">교보증권 마이데이터 끌</div>
								<i class="ico-app-award"></i>
							</div>
						</a>
					</div>
				</div>
				<div class="swiper-pagination"></div>
			</div>
		</div>
		<!-- main slide end -->
		<!-- contents -->
		<div class="contents-group-box">
			<button type="button" class="btn-open-career" aria-label="작업물 리스트로 이동"></button>
			<div class="inner">
				<div class="title-box"><h2>WORK +</h2></div>
				<div class="contents-box">
		<?php }else{ ?>
		<div class="container">
			<div class="inner">
				<h2 class="sub-tit" id="pageTit"><?php echo $g5['title'] ?></h2>
		<?php } ?>

