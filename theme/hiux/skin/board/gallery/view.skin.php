<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<!-- 게시물 읽기 시작 { -->
<div class="cont_in">
	<ul class="list_view">
		<li class="list_tit">
			<h2>
				<?php if ($category_name) { ?>
				<span class="cate"><?php echo $view['ca_name']; // 분류 출력 끝 ?></span> 
				<?php } ?>
				<span class="tit">
				<?php
				echo cut_str(get_text($view['wr_subject']), 70); // 글제목 출력
				?></span>
			</h2>
		</li>

		<li class="list_info">
			<h2 class="blind">페이지 정보</h2>			
			<div class="left">
				<strong><span class="sound_only">댓글</span><a href="#bo_vc"> <i class="fa fa-commenting-o" aria-hidden="true"></i> <?php echo number_format($view['wr_comment']) ?>건</a></strong>
				<strong><span class="sound_only">조회</span><i class="fa fa-eye" aria-hidden="true"></i> <?php echo number_format($view['wr_hit']) ?>회</strong>
			</div>
			<div class="right">
				<strong><span class="sound_only">작성자</span><?php echo $view['name'] ?><?php if ($is_ip_view) { echo "&nbsp;($ip)"; } ?></strong>
				<strong><span class="sound_only">작성일</span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo date("Y-m-d H:i", strtotime($view['wr_datetime'])) ?></strong>
			</div>
		</li>

		<li class="gal_wrap">
			<h2 class="blind">이미지</h2>
			<div class="gallery_top gal_swipe">
				<div class="swiper-container">
				<?php
        // 파일 출력
        $v_img_count = count($view['file']);
        if($v_img_count) {
            echo "<ul class=\"swiper-wrapper\">\n";

            foreach($view['file'] as $view_file) {
							if(get_file_thumbnail($view_file)){
								echo "<li class=\"swiper-slide\">";
								echo get_file_thumbnail($view_file);
								echo "</li>";
							}
            }

            echo "</ul>\n";
        }
        ?>
				</div>
				<div class="swipe_navi">
					<a href="#" class="swipe_prev"><span class="blind">이전</span></a>
					<a href="#" class="swipe_next"><span class="blind">다음</span></a>
				</div>
			</div>
			<div class=" gallery_thumbs gal_swipe">
				<div class="swiper-container">
					<?php
					// 파일 출력
					$v_img_count = count($view['file']);
					if($v_img_count) {
							echo "<ul class=\"swiper-wrapper\">\n";

							foreach($view['file'] as $view_file) {
								if(get_file_thumbnail($view_file)){
									echo "<li class=\"swiper-slide\">";
									echo get_file_thumbnail($view_file);
									echo "</li>";
								}
							}

							echo "</ul>\n";
					}
					?>
				</div>
				<!-- <div class="swipe_navi">
					<a href="#" class="swipe_prev"><span class="blind">이전</span></a>
					<a href="#" class="swipe_next"><span class="blind">다음</span></a>
				</div> -->
			</div>
		</li>
		<li>
			<h2 class="blind">본문</h2>
			<!-- 본문 내용 시작 { -->
			<div><?php echo get_view_thumbnail($view['content']); ?></div>
			<?php //echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>
			<!-- } 본문 내용 끝 -->

			<?php if ($is_signature) { ?><p><?php echo $signature ?></p><?php } ?>
		</li>

		<li class="list_social">
			<div class="list_share">
				<?php if ($scrap_href) { ?><a href="<?php echo $scrap_href;  ?>" target="_blank" class="button btn_blue" onclick="win_scrap(this.href); return false;"><i class="fa fa-thumb-tack" aria-hidden="true"></i> 스크랩</a><?php } ?>

				<?php
				include_once(G5_SNS_PATH."/view.sns.skin.php");
				?>
			</div>
			<!--  추천 비추천 시작 { -->
			<?php if ( $good_href || $nogood_href) { ?>
			<div class="list_like">
				<?php if ($good_href) { ?>
					<a href="<?php echo $good_href.'&amp;'.$qstr ?>" id="good_button" class="button btn_blue"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i><span>좋아요</span><strong><?php echo number_format($view['wr_good']) ?></strong></a>
					<b id="bo_v_act_good" class="blind"></b>
				<?php } ?>
				<?php if ($nogood_href) { ?>
					<a href="<?php echo $nogood_href.'&amp;'.$qstr ?>" id="nogood_button" class="button btn_black"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i><span>싫어요</span><strong><?php echo number_format($view['wr_nogood']) ?></strong></a>
					<b id="bo_v_act_nogood" class="blind"></b>
				<?php } ?>
			</div>
			<?php } else {
				if($board['bo_use_good'] || $board['bo_use_nogood']) {
			?>
			<div class="list_like">
				<?php if($board['bo_use_good']) { ?><span class="ic_txt ic_blue"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i><span>좋아요</span><strong><?php echo number_format($view['wr_good']) ?></strong></span><?php } ?>
				<?php if($board['bo_use_nogood']) { ?><span class="ic_txt ic_gray"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i><span>싫어요</span><strong><?php echo number_format($view['wr_nogood']) ?></strong></span><?php } ?>
			</div>
			<?php
				}
			}
			?>
			<!-- }  추천 비추천 끝 -->
		</li>

		<?php
		$cnt = 0;
		if ($view['file']['count']) {
			for ($i=0; $i<count($view['file']); $i++) {
				if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
					$cnt++;
			}
		}
		 ?>

		<?php if($cnt) { ?>
		<!-- 첨부파일 시작 { -->
		<li class="list_file">
			<h2 class="blind">첨부파일</h2>
			<ul>
			<?php
			// 가변 파일
			for ($i=0; $i<count($view['file']); $i++) {
				if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
			 ?>
				<li>
					<i class="fa fa-download" aria-hidden="true"></i>
					<a href="<?php echo $view['file'][$i]['href'];  ?>" class="view_file_download">
						<strong><?php echo $view['file'][$i]['source'] ?></strong>
					</a>
					<?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)					
					<span class="list_file_cnt"><?php if ($is_admin) {  ?><?php echo $view['file'][$i]['download'] ?>회 다운로드 | <?php }  ?><?php echo $view['file'][$i]['datetime'] ?></span>
				</li>
			<?php
				}
			}
			 ?>
			</ul>
		</li>
		<!-- } 첨부파일 끝 -->
		<?php } ?>

		<?php if(isset($view['link']) && array_filter($view['link'])) { ?>
    <!-- 관련링크 시작 { -->
    <section id="list_link">
        <h2 class="blind">관련링크</h2>
        <ul>
        <?php
        // 링크
        $cnt = 0;
        for ($i=1; $i<=count($view['link']); $i++) {
            if ($view['link'][$i]) {
                $cnt++;
                $link = cut_str($view['link'][$i], 70);
            ?>
            <li>
                <i class="fa fa-link" aria-hidden="true"></i>
                <a href="<?php echo $view['link_href'][$i] ?>" target="_blank">
                    <strong><?php echo $link ?></strong>
                </a>
                <br>
                <span class="list_link_cnt"><?php echo $view['link_hit'][$i] ?>회 연결</span>
            </li>
            <?php
            }
        }
        ?>
        </ul>
    </section>
    <!-- } 관련링크 끝 -->
    <?php } ?>
	</ul>

	<?php if ($prev_href || $next_href) { ?>
	<ul class="list_navi">
		<?php if ($prev_href) { ?>
			<li><a href="<?php echo $prev_href ?>"><strong><i class="fa fa-angle-up" aria-hidden="true"></i>이전글</strong><?php echo $prev_wr_subject; ?></a></li>
		<?php } else { ?>
			<li><span><strong><i class="fa fa-angle-up" aria-hidden="true"></i> 이전글</strong>이전글이 없습니다.</span></li>
		<?php } ?>
		<?php if ($next_href) { ?>
			<li><a href="<?php echo $next_href ?>"><strong><i class="fa fa-angle-down" aria-hidden="true"></i>다음글</strong><?php echo $next_wr_subject; ?></a></li>
		<?php } else { ?>
			<li><span><strong><i class="fa fa-angle-down" aria-hidden="true"></i> 다음글</strong>다음글이 없습니다.</span></li>
		<?php } ?>
	</ul>
	<?php } ?>

    <!-- 게시물 상단 버튼 시작 { -->
    <div class="list_bottom">
        <?php
        ob_start();
        ?>

        <ul class="list_btn left">
            <?php if ($update_href) { ?><li><a href="<?php echo $update_href ?>" class="button btn_gray"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> 수정</a></li><?php } ?>
            <?php if ($delete_href) { ?><li><a href="<?php echo $delete_href ?>" class="button btn_gray" onclick="del(this.href); return false;"><i class="fa fa-trash-o" aria-hidden="true"></i> 삭제</a></li><?php } ?>
            <?php if ($copy_href) { ?><li><a href="<?php echo $copy_href ?>" class="button btn_gray" onclick="board_move(this.href); return false;"><i class="fa fa-files-o" aria-hidden="true"></i> 복사</a></li><?php } ?>
            <?php if ($move_href) { ?><li><a href="<?php echo $move_href ?>" class="button btn_gray" onclick="board_move(this.href); return false;"><i class="fa fa-arrows" aria-hidden="true"></i> 이동</a></li><?php } ?>
            <?php if ($search_href) { ?><li><a href="<?php echo $search_href ?>" class="button btn_black"><i class="fa fa-search" aria-hidden="true"></i> 검색</a></li><?php } ?>
        </ul>

        <ul class="list_btn">
           <li><a href="<?php echo $list_href ?>" class="button btn_black"><i class="fa fa-list" aria-hidden="true"></i> 목록</a></li>
            <?php if ($reply_href) { ?><li><a href="<?php echo $reply_href ?>" class="button btn_black"><i class="fa fa-reply" aria-hidden="true"></i> 답변</a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="button btn_red"><i class="fa fa-pencil" aria-hidden="true"></i> 글쓰기</a></li><?php } ?>
        </ul>
        <?php
        $link_buttons = ob_get_contents();
        ob_end_flush();
         ?>
    </div>
    <!-- } 게시물 상단 버튼 끝 -->

    <?php
    // 코멘트 입출력
    include_once(G5_BBS_PATH.'/view_comment.php');
     ?>
</div>
<!-- } 게시판 읽기 끝 -->

<script>
<?php if ($board['bo_download_point'] < 0) { ?>
$(function() {
    $("a.view_file_download").click(function() {
        if(!g5_is_member) {
            alert("다운로드 권한이 없습니다.\n회원이시라면 로그인 후 이용해 보십시오.");
            return false;
        }

        var msg = "파일을 다운로드 하시면 포인트가 차감(<?php echo number_format($board['bo_download_point']) ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?";

        if(confirm(msg)) {
            var href = $(this).attr("href")+"&js=on";
            $(this).attr("href", href);

            return true;
        } else {
            return false;
        }
    });
});
<?php } ?>

function board_move(href)
{
    window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
}

$(function() {
    $(document).on('click','.view_image',function() {
		//var $img = $(this).siblings('img'),
		//	$width = $img.get(0).naturalWidth+100,
		//	$height = $img.get(0).naturalHeight+100;

		window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });

    // 추천, 비추천
    $("#good_button, #nogood_button").click(function() {
        var $tx;
        if(this.id == "good_button")
            $tx = $("#bo_v_act_good");
        else
            $tx = $("#bo_v_act_nogood");

        excute_good(this.href, $(this), $tx);
        return false;
    });

    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();

    //sns공유
    $(".btn_share").click(function(){
        $("#bo_v_sns").fadeIn();
   
    });

    $(document).mouseup(function (e) {
        var container = $("#bo_v_sns");
        if (!container.is(e.target) && container.has(e.target).length === 0){
        container.css("display","none");
        }	
    });

	//갤러리 뷰
	$('.gallery_top li').each(function(){
		var $a = $(this).children('a'),
			$clone = $a.clone()

		$a.find('img').unwrap('a').wrap('<span class="img"></span>');

		var $img = $(this).find('.img');
		$img.append($clone.empty().html('<i class="fa fa-search-plus" aria-hidden="true"></i>'));
	})
	if($('.gallery_top .swiper-slide').length > 1){
		var galleryTop = new Swiper('.gallery_top > div', {
			calculateHeight:true
		});
	}else{
		$('.gallery_top li').removeClass('swiper-slide');
		$('.swipe_prev, .swipe_next').hide();
	}
	$('.gallery_top .swipe_navi a').click(function(e){
		e.preventDefault();
		var $on = $('.gallery_thumbs .on').index();
		
		console.log($on,$length)
		if($(this).hasClass('swipe_prev')){
			if($on == 0){
				$('.gallery_thumbs li').eq($length-1).find('a').trigger('click');
			}else{
				$('.gallery_thumbs li').eq($on).prev().find('a').trigger('click');
			}
		}else if($(this).hasClass('swipe_next')){
			if($on == ($length-1)){
				$('.gallery_thumbs li').first().find('a').trigger('click');
			}else{
				$('.gallery_thumbs li').eq($on).next().find('a').trigger('click');
			}
		}
	})

	var $thumb = $('.gallery_thumbs > div'),
		$length = $thumb.find('.swiper-slide').length,
		$btnPrev = $('.gallery_thumbs .swipe_prev'),
		$btnNext = $('.gallery_thumbs .swipe_next');
	if($length > 1){
		$('.gallery_thumbs .swiper-slide').first().addClass('on');
		var galleryThumbs = new Swiper('.gallery_thumbs > div', {
			slidesPerView:'auto',
			calculateHeight:true,
			resizeReInit:true,
			freeMode:true,
			onInit:function(swiper){
				//console.log('onInit')
				$(swiper.container).find('.swiper-wrapper').css('width','+=1');
			},
			onFirstInit:function(swiper){
				//console.log('onFirstInit')
				$(swiper.container).find('.swiper-wrapper').css('width','+=1');
			},
			onSlideChangeStart: function(swiper){
				$(swiper.container).find('.swiper-wrapper').css('width','+=1');
			}
		});
		$btnPrev.click(function(e){
			e.preventDefault();
			galleryThumbs.swipePrev();
		})
		$btnNext.click(function(e){
			e.preventDefault();
			galleryThumbs.swipeNext();
		})
	}else{
		$('.gallery_thumbs').hide();
	}

	$('.gallery_thumbs li a').click(function(e){
		e.preventDefault();
		var $idx = $(this).parent().index();
		$(this).parent().addClass('on').siblings().removeClass('on');
		galleryTop.swipeTo($idx);
		galleryThumbs.swipeTo($idx);
	})
});

function excute_good(href, $el, $tx)
{
    $.post(
        href,
        { js: "on" },
        function(data) {
            if(data.error) {
                alert(data.error);
                return false;
            }

            if(data.count) {
                $el.find("strong").text(number_format(String(data.count)));
                if($tx.attr("id").search("nogood") > -1) {
                    $tx.text("이 글을 비추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                } else {
                    $tx.text("이 글을 추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                }
            }
        }, "json"
    );
}
</script>
<!-- } 게시글 읽기 끝 -->