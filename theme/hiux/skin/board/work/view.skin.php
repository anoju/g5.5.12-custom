<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<script>
	const $container = document.querySelector('.container');
	if($container) $container.classList.add('view-page', 'work');
	const $pageTit = document.querySelector('#pageTit');
	if($pageTit) {
		$pageTit.classList.remove('sub-tit');
		$pageTit.classList.add('text-blind');
	}
</script>
<!-- 게시물 읽기 시작 { -->
<div class="view-inner">
	<h2 class="sub-tit"><?php echo conv_content($view['wr_subject'], 0) // 글제목 출력 ?></h2>
	<?php if($view['wr_1']) { ?>
	<div class="sub-txt-box"><?php echo conv_content($view['wr_1'], 0) ?></div>
	<?php } ?>
	<div class="info-box">
		<?php if ($category_name) { ?>
		<dl>
			<dt>Category</dt>
			<dd><?php echo $view['ca_name']; // 분류 출력 끝 ?></dd>
		</dl>
		<?php 
		}
		if($view['wr_3']) { 
		?>
		<dl>
			<dt>Open</dt>
			<dd><?php echo $view['wr_3'] ?></dd>
		</dl>
		<?php 
		}
		if($view['wr_2']) { 
		?>
		<dl>
			<dt>Client</dt>
			<dd><?php echo $view['wr_2'] ?></dd>
		</dl>
		<?php 
		}
		if ($admin_href) { 
		?>
		<dl>
			<dt>Date</dt>
			<dd><?php echo date("Y.m.d", strtotime($view['wr_datetime'])) ?></dd>
		</dl>
		<dl>
			<dt>View</dt>
			<dd><?php echo number_format($view['wr_hit']) ?></dd>
		</dl>
		<dl>
			<dt>Reply</dt>
			<dd><?php echo number_format($view['wr_comment']) ?></dd>
		</dl>
		<dl>
			<dt>Writer</dt>
			<dd><?php echo $view['name'] ?><?php if ($is_ip_view) { echo "&nbsp;($ip)"; } ?></dd>
		</dl>
		<?php } 
		if($view['wr_4']) {
		$tags = explode(' ', $view['wr_4']);
		$tag_box = '';
		for ($i = 0; $i < count($tags); $i++) {
				$tag = trim($tags[$i]);
				if ($tag == '') continue;
				$tag_box .= '<div class="tag">' . $tag . '</div>';
		}
		?>
	</div>
	<div class="tag-box">
		<?php echo $tag_box ?>
	</div>
	<?php } ?>
</div>
<!-- 본문 내용 시작 { -->
<?php 
	if (isset($view['file'][1]['source']) && $view['file'][1]['source']) {
		echo "<div class=\"visual-img-box\">\n";
		echo get_file_thumbnail($view['file'][1]);
		echo "</div>\n";
	} else if (isset($view['file'][0]['source']) && $view['file'][0]['source']) {
		echo "<div class=\"visual-img-box\">\n";
		echo get_file_thumbnail($view['file'][0]);
		echo "</div>\n";
	} 
	conv_content($view['content'], 0)
?>
<div class="detail-area"><?php echo get_view_thumbnail($view['content']); ?></div>
<?php if ($next_href) { 
	$next_thumb = get_list_thumbnail($board['bo_table'], $next['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height'], false, true);
	if($next_thumb['src']) {
	$next_img = '<img src="'.$next_thumb['src'].'" alt="'.$next_thumb['alt'].'" >';
	} else {
	$next_img = '';
	}
?>
<div class="next-page-box">
	<?php echo $next_img; ?>
	<a href="<?php echo $next_href ?>">
		<span class="label">Next</span>
		<strong><?php echo $next_wr_subject; ?></strong>
	</a>
</div>
<?php } ?>
<!-- } 본문 내용 끝 -->
<?php if ($is_member) { ?>
<div class="view-inner">
	<?php //echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>
	<?php if ($is_signature) { ?><p><?php echo $signature ?></p><?php } ?>
	<div class="view_social">
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
			<?php if($board['bo_use_good']) { ?><span class="ic_txt ic_blue"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i><span class="blind">좋아요</span><strong><?php echo number_format($view['wr_good']) ?></strong></span><?php } ?>
			<?php if($board['bo_use_nogood']) { ?><span class="ic_txt ic_gray"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i><span class="blind">싫어요</span><strong><?php echo number_format($view['wr_nogood']) ?></strong></span><?php } ?>
		</div>
		<?php
			}
		}
		?>
		<!-- }  추천 비추천 끝 -->
	</div>

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
	<div class="list_file">
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
	</div>
	<!-- } 첨부파일 끝 -->
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
	if ($is_member) {
	// 코멘트 입출력
	include_once(G5_BBS_PATH.'/view_comment.php');
	}
	?>
</div>
<?php } ?>
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
</script>

<script>
$(function() {
    $("a.view_image").click(function() {
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
    // $("#bo_v_atc").viewimageresize();

    //sns공유
		/*
    $(".btn_share").click(function(){
        $("#bo_v_sns").fadeIn();
   
    });

    $(document).mouseup(function (e) {
        var container = $("#bo_v_sns");
        if (!container.is(e.target) && container.has(e.target).length === 0){
        container.css("display","none");
        }	
    });
		*/

		const $detail = $('.detail-area');
		if($.trim($detail.text()) === '' && !$detail.find('img').length) $detail.hide();
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