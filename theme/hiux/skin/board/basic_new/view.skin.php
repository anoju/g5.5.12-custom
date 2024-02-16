<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/Style.css">', 0);


if ($html == "1") { echo '<link href="'.G5_EDITOR_URL.'/'.$config['cf_editor'].'/style.css" rel="stylesheet">';}
?>
<script>
var board_skin_url = "<?php echo $board_skin_url?>";
</script>


<script src="<?php echo $board_skin_url?>/javascript.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>


<div id="TEST_DIV"style="position:fixed;left:10px;bottom:10px;z-index:9999;background-color:#FFF;"></div>



<div id="V_ButtonWrap">
	<div id="POPWrap">
		<div class="TitleBar">
			<div class="Title"><?php
			    echo cut_str(get_text($view['wr_subject']), 20); // 글제목 출력
	            ?></div>
			<div class="closeBtn" title="닫기">
				<div id="CloseSpanX"><span class="close1span"></span><span class="close2span"></span></div>
			</div>
		</div>
		<div class="ContentBorder">

	       	<?php if($update_href || $delete_href || $copy_href || $move_href || $search_href) { ?>
			<div class="Title">관리</div>
			<div class="ContentDiv">
				<ul>
					<?php if ($update_href) { ?><li><a href="<?php echo $update_href ?>">수정</a></li><?php } ?>
		            <?php if ($delete_href) { ?><li><a href="<?php echo $delete_href ?>" onclick="del(this.href); return false;">삭제</a></li><?php } ?>
		            <?php if ($copy_href) { ?><li><a href="<?php echo $copy_href ?>" onclick="board_move(this.href); return false;">복사</a></li><?php } ?>
			        <?php if ($move_href) { ?><li><a href="<?php echo $move_href ?>" onclick="board_move(this.href); return false;">이동</a></li><?php } ?>
<!--	            <?php if ($search_href) { ?><li><a href="<?php echo $search_href ?>">검색</a></li><?php } ?>-->
					<?php if ($scrap_href) { ?><li><a href="<?php echo $scrap_href;  ?>" target="_blank" onclick="win_scrap(this.href); return false;">스크랩</a></li><?php } ?>
				</ul>
			</div>
			<?php } ?>

			<div class="Title">글쓰기</div>
			<div class="ContentDiv">
				<?php if($reply_href || $write_href) { ?>
				<ul>
		            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>"><span class="sound_only">글쓰기</span>글쓰기</a></li><?php } ?>
					<?php if ($reply_href) { ?><li><a href="<?php echo $reply_href ?>"><span class="sound_only">답변</span>답변</a></li><?php } ?>
				</ul>
				<?php } else {?>
				<ul>
					<li><a href="javascript:void(0);">권한이 없습니다.</a></li>
				</ul>
				<?php } ?>
			</div>

<!--		<?php if ($board['bo_use_sns']) {?>
		<div class="Title"></div>
		<div class="ContentDiv">
       	<?php // include_once($board_skin_path."/view.sns.skin.php"); ?>
		</div>
		<?php }?>
-->
		</div>

	</div>
</div> <!-- V_ButtonWrap 끝-->





















<!-- 게시물 읽기 시작 { -->
<article id="bo_v" style="width:<?php echo $width; ?>;padding:10px;">



	<div id="View_TopDiv" class="ClearFix">
        <div class="TitleWrap">

            <div class="bo_v_tit">
			    <?php if ($category_name) { ?>
		        <span class="bo_v_cate"><?php echo $view['ca_name']; // 분류 출력 끝 ?></span> 
	            <?php } ?>
			<?php
            echo cut_str(get_text($view['wr_subject']), 70); // 글제목 출력
            ?></div>
        </div>

		<div class="AdminButtonWrap">
			<span class="B_Icon">
				<a href="javascript:void(0);" onclick="Get_AllButton('CLOSE_YES', 'V_ButtonWrap');"><span class="material-icons-outlined">edit_note</span></a>
			</span>
			<span class="bar"></span>
			<span class="B_Icon">
				<a href="<?php echo $list_href ?>" title="목록"><span class="material-icons-outlined">grid_view</span></a>
			</span>
			<?php if ($search_href) { ?>
			<span class="bar"></span>
			<span class="B_Icon">
				<a href="<?php echo $search_href ?>" title="검색목록"><span class="material-icons-outlined">widgets</span></a>
			</span>
			<?php } ?>
		
		</div>

    </div>

    <section id="bo_v_info">
        <h2>페이지 정보</h2>
        <div class="profile_info">
        	<div class="pf_img"><?php echo get_member_profile_img($view['mb_id']) ?></div>
        	<div class="profile_info_ct">
        		<span class="sound_only">작성자</span> <strong><?php echo $view['name'] ?></strong>
       		 	<span class="sound_only">댓글</span><strong><a href="#V_COMMENT"> 댓글 <?php echo number_format($view['wr_comment']) ?>건</a></strong>
        		<span class="sound_only">조회</span><strong>조회 <?php echo number_format($view['wr_hit']) ?>회</strong>
        		<strong class="if_date" data-board-wenk="<?php if ($is_ip_view) { echo "$ip"; } ?>" data-board-wenk-pos="right"><span class="sound_only">작성일</span><?php echo date("y-m-d H:i", strtotime($view['wr_datetime'])) ?></strong>
    		</div>
    	</div>
    </section>

    <section id="bo_v_atc">
        <h2 id="bo_v_atc_title">본문</h2>
        <?php
        // 파일 출력
        $v_img_count = count($view['file']);
        if($v_img_count) {
            echo "<div id=\"bo_v_img\">\n";

            for ($i=0; $i<=count($view['file']); $i++) {
                echo get_file_thumbnail($view['file'][$i]);
            }

            echo "</div>\n";
        }
         ?>

        <!-- 본문 내용 시작 { -->
        <div id="bo_v_con" class="video-container ck-content"><?php echo get_view_thumbnail($view['content']); ?></div>
        <?php //echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>
        <!-- } 본문 내용 끝 -->

        <?php if ($is_signature) { ?><p><?php echo $signature ?></p><?php } ?>


        <!--  추천 비추천 시작 { -->
        <?php if ( $good_href || $nogood_href) { ?>
        <div id="bo_v_act">
            <?php if ($good_href) { ?>
            <span class="bo_v_act_gng">
                <a href="<?php echo $good_href.'&amp;'.$qstr ?>" id="good_button" class="bo_v_good"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i><span class="sound_only">추천</span><strong><?php echo number_format($view['wr_good']) ?></strong></a>
                <b id="bo_v_act_good"></b>
            </span>
            <?php } ?>
            <?php if ($nogood_href) { ?>
            <span class="bo_v_act_gng">
                <a href="<?php echo $nogood_href.'&amp;'.$qstr ?>" id="nogood_button" class="bo_v_nogood"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i><span class="sound_only">비추천</span><strong><?php echo number_format($view['wr_nogood']) ?></strong></a>
                <b id="bo_v_act_nogood"></b>
            </span>
            <?php } ?>
        </div>
        <?php } else {
            if($board['bo_use_good'] || $board['bo_use_nogood']) {
        ?>
        <div id="bo_v_act">
            <?php if($board['bo_use_good']) { ?><span class="bo_v_good"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i><span class="sound_only">추천</span><strong><?php echo number_format($view['wr_good']) ?></strong></span><?php } ?>
            <?php if($board['bo_use_nogood']) { ?><span class="bo_v_nogood"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i><span class="sound_only">비추천</span><strong><?php echo number_format($view['wr_nogood']) ?></strong></span><?php } ?>
        </div>
        <?php
            }
        }
        ?>
        <!-- }  추천 비추천 끝 -->

    </section>

    <?php if ($prev_href || $next_href) { ?>
    <ul class="bo_v_nb">
        <li class="btn_prv"><span class="nb_tit"><span class="material-icons-outlined">keyboard_double_arrow_left</span></span><?php if ($prev_href) { ?><a href="<?php echo $prev_href ?>"><?php echo $prev_wr_subject;?></a><?php } else {?><a href="javascript:void(0);">이전 게시물 없음</a><?php } ?></li>
        <li class="btn_next"><span class="nb_tit"><span class="material-icons-outlined">keyboard_double_arrow_right</span></span><?php if ($next_href) { ?><a href="<?php echo $next_href ?>"><?php echo $next_wr_subject;?></a><?php } else {?><a href="javascript:void(0);">이후 게시물 없음</a><?php } ?></li>
    </ul>
	<?php } ?>




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
	<section id="V_ITEM">
			<div class="ItemTitle">
				<span class="material-icons-outlined" data-board-wenk="FILE LIST" data-board-wenk-pos="right">file_download</span>
			</div>
			<div class="ItemList">
			<ul>
        <?php
        // 가변 파일
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
         ?>
			 <li>
                <a href="<?php echo $view['file'][$i]['href'];  ?>" class="view_file_download" data-board-wenk="<?php echo $view['file'][$i]['download'] ?> / DATE : <?php echo $view['file'][$i]['datetime'] ?>" data-board-wenk-pos="right">
                    <?php echo $view['file'][$i]['source'] ?> <?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
                </a>
			</li>
	        <?php } ?>
        <?php } ?>
			</ul>

			</div>
    </section>
    <!-- } 첨부파일 끝 -->
    <?php } ?>

    <?php if(isset($view['link'][1]) && $view['link'][1]) { ?>
    <!-- 관련링크 시작 { -->

	<section id="V_ITEM">
			<div class="ItemTitle">
				<span class="material-icons-outlined" data-board-wenk="LINK LIST" data-board-wenk-pos="right">link</span>
			</div>
			<div class="ItemList">
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
                <a href="<?php echo $view['link_href'][$i] ?>" target="_blank" data-board-wenk="CLICK : <?php echo $view['link_hit'][$i] ?>회" data-board-wenk-pos="up">
                    <?php echo $link ?>
                </a>
				</li>
	        <?php } ?>
        <?php } ?>
			</ul>
			</div>
    </section>

    <!-- } 관련링크 끝 -->
    <?php } ?>
    






    <?php
    // 코멘트 입출력
    include_once(G5_BBS_PATH.'/view_comment.php');
	?>
</article>
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

$(window).on("load resize",function(){ // 처음에 페이지 읽어올때와 화면 리사이즈시

	var View_div_css_width = $( '#bo_v' ).width();

	if(View_div_css_width <= 900){
		if($("#toggle_Max900").length > 0){
		} else {
			$('.toggle_css').remove();
			$('head').append('<link id="toggle_Max900" class="toggle_css" rel="stylesheet" href="<?php echo $board_skin_url?>/Style_Max900.css">');
		}
	} else if(View_div_css_width <= 1200){
		if($("#toggle_Max1200").length > 0){
		} else {
			$('.toggle_css').remove();
			$('head').append('<link id="toggle_Max1200" class="toggle_css" rel="stylesheet" href="<?php echo $board_skin_url?>/Style_Max1200.css">');
		}
	} else {
		if($("#toggle_Max4000").length > 0){
		} else {
			$('.toggle_css').remove();
			$('head').append('<link id="toggle_Max4000" class="toggle_css" rel="stylesheet" href="<?php echo $board_skin_url?>/Style_Max4000.css">');
		}
	}
});



$(window).on("scroll", function(){

	var V_AllButtonWrap = $("#View_TopDiv"); //스크롤바의 상단위치
	// 스크롤시 코멘트 목록이 상단에 닿으면 실시
	var ViewListscrodiv_top = $(this).scrollTop();
	if( ViewListscrodiv_top > "5") {
		V_AllButtonWrap.addClass("ScrollOn");
 	} else {
		V_AllButtonWrap.removeClass("ScrollOn");
	}

	// 스크롤시 코멘트 목록이 상단에 닿으면 실시
	var cmt_top = $('#V_COMMENT').offset().top - 70,
		scrodiv_top = $(this).scrollTop();

//$("#TEST_DIV").html(cmt_top +" / "+ scrodiv_top);

	if(cmt_top <= scrodiv_top){
		V_AllButtonWrap.css({"display":"none"});
    } else {
		V_AllButtonWrap.css({"display":""});
	}

});

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
    $("#bo_v_atc").viewimageresize();
});

function excute_good(href, $el, $tx) {
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
