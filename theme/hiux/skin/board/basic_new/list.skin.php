<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/Style.css">', 0);


if($page == "" ) {
	$page = "1";
}

?>

<script src="<?php echo $board_skin_url?>/javascript.js"></script>



<div id="L_ButtonWrap">
    <!-- 게시판 검색 시작 { -->

<div id="POPWrap">
	<div class="TitleBar">
		<div class="Title">검색</div>
		<div class="closeBtn" title="닫기">
			<div id="CloseSpanX"><span class="close1span"></span><span class="close2span"></span></div>
		</div>
	</div>
            <form name="fsearch" method="get">
            <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
            <input type="hidden" name="sca" value="<?php echo $sca ?>">
            <input type="hidden" name="sop" value="and">

	<div class="ContentBorder">

		<div class="ContentDiv_L">
            <label for="sfl" class="sound_only">검색대상</label>
            <select name="sfl" id="sfl">
                <?php echo get_board_sfl_select_options($sfl); ?>
            </select>
		</div>



		<div class="ContentDiv_L">

            <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
			<div class="sch_bar">
                <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="sch_input" size="25" maxlength="20" placeholder=" 검색어를 입력해주세요">
                <button type="submit" value="검색" class="sch_btn"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">검색</span></button>
			</div>
		</div>


<!--		<?php if ($board['bo_use_sns']) {?>
		<div class="Title"></div>
		<div class="ContentDiv">
       	<?php // include_once($board_skin_path."/view.sns.skin.php"); ?>
		</div>
		<?php }?>
-->
	</div>
            </form>
</div>




    <!-- } 게시판 검색 끝 --> 
</div>

<div id="ScrollWrap" style="width:<?php echo $width; ?>;">



    <form name="fboardlist" id="fboardlist" action="<?php echo G5_BBS_URL; ?>/board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">




<div id="BotableTitleWrap" class="ClearFix">
	<div class="TitleWrap">
		<span class="TitleLeftBar"></span>
		<span class="Cnt">
			TOTAL <span id="now_article"><?php echo number_format($total_count) ?></span>/<?php echo number_format($total_count) ?>
			. 
			PAGE <span id="now_page"><?php echo $page?></span>
		</span>
	</div>
	<div class="AdminRssWrap">


		<?php if ($admin_href) { ?><span class="B_Icon"><a href="<?php echo $admin_href ?>" data-board-wenk="게시판 관리" data-board-wenk-pos="left" title="관리자"><span class="material-icons-outlined admbutton">settings</span><span class="sound_only">관리자</span></a></span><span class="Bar"></span><?php } ?>
		<?php if ($rss_href) { ?><span class="B_Icon"><a href="<?php echo $rss_href ?>" data-board-wenk="RSS" data-board-wenk-pos="left" title="RSS"><span class="material-icons-outlined admbutton">rss_feed</span><span class="sound_only">RSS</span></a></span><span class="Bar"></span><?php } ?>	


		<?php if ($write_href) { ?>
		<span class="B_Icon">
			<a href="<?php echo $write_href ?>" data-board-wenk="글쓰기" data-board-wenk-pos="left" title="글쓰기"><span class="material-icons-outlined admbutton">edit</span><span class="sound_only">글쓰기</span></a>
		</span>
		<span class="Bar"></span>
		<?php } ?>

		<span class="B_Icon">
			<a href="javascript:void(0);" onclick="Get_AllButton('CLOSE_YES', 'L_ButtonWrap');" data-board-wenk="게시판 검색" data-board-wenk-pos="left" title="게시판 검색"><span class="material-icons-outlined admbutton">manage_search</span><span class="sound_only">게시판 검색</span></a>
		</span>

		<?php if ($is_admin == 'super' || $is_auth) {  ?>
		<span class="Bar"></span>

		<span class="B_Icon" id="CheckBox_Option" data-board-wenk="선택/관리" data-board-wenk-pos="left" title="게시물 선택/관리">
			<span class="material-icons-outlined admbutton">done_all</span>
			<span></span>
			<b class="sound_only">현재 페이지 게시물 선택</b>



		</span>

			<?php if ($is_checkbox) { ?>	
				<ul class="CheckBox_Option_List">
					<li><button type="submit" name="btn_submit" onclick="javascript:void(0);" id="CheckBox_CheckAll"><span class="material-icons-outlined">checklist_rtl</span> 전체선택</span></li>
					<li><button type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value"><span class="material-icons-outlined">delete_sweep</span> 선택삭제</button></li>
					<li><button type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value"><span class="material-icons-outlined">content_copy</span> 선택복사</button></li>
					<li><button type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value"><span class="material-icons-outlined">exit_to_app</span> 선택이동</button></li>
				</ul>
			<?php } ?>
		<?php }  ?>


	</div>


</div>



<div id="CategoryWrap">
    <!-- 게시판 카테고리 시작 { -->
    <?php if ($is_category) { ?>
	<ul class="ClearFix">
            <?php echo $category_option ?>
	</ul>
    <?php } ?>
    <!-- } 게시판 카테고리 끝 -->
</div>



<div id="ListWrap" class="ClearFix">
        <?php
        for ($i=0; $i<count($list); $i++) {
        	if ($i%2==0) {
				$lt_class = "even";
			} else {
				$lt_class = "";
			}

			if ($list[$i]['is_notice']) { // 공지사항
				$ListIngClass = 'ListNotice';
			} else if ($wr_id == $list[$i]['wr_id']) { // 현재 읽고 있는 글
				$ListIngClass = "ListView";
			} else {
				$ListIngClass = "";
			}
		?>
<div class="ListItemWrap <?php echo $ListIngClass; ?>">

	<div class="ListItem <?php echo $ListIngClass; ?>">
		<div class="is_checkbox">
			<?php if ($is_checkbox) { ?>

			<span class="material-icons List_Check_icon" data-no="<?php echo $list[$i]['wr_id'] ?>">done</span>
			<input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $list[$i]['wr_id'] ?>" class="selec_chk">
			<?php } ?>
		</div>
		<div class="ing">
			<?php
            if ($wr_id == $list[$i]['wr_id'])
                echo '<span class="material-icons-outlined">visibility</span>';
            else if ($list[$i]['is_notice']) // 공지사항
                echo '<span class="material-icons-outlined">volume_up</span>';
            else
//                echo $list[$i]['num'];
             ?>
		</div>

		<div class="ContentWrap">
			<div class="DateWrap"><?php echo $list[$i]['datetime'] ?><?php if ($is_category && $list[$i]['ca_name']) { ?><a href="<?php echo $list[$i]['ca_name_href'] ?>" class="cate_link"><?php echo $list[$i]['ca_name'] ?></a><?php } ?></div>
			<div class="SubjectWrap"><a href="<?php echo $list[$i]['href'] ?>"><?php echo $list[$i]['subject'] ?></a></div>
		</div>

		<div class="ArticleING">
			<span <?php if ($list[$i]['icon_new']) echo "class=\"New\" data-board-wenk=\"새글입니다.\" data-board-wenk-pos=\"up\""; ?>></span>
		</div>

		<?php if ($list[$i]['is_notice'] == "") {?>
		<div class="InfoWrap">
			<div class="WrInfo">
				<i class="fa fa-user"></i> <?php echo $list[$i]['name'] ?>
				<i class="fa fa-eye"></i> <?php echo $list[$i]['wr_hit'] ?>
			</div>
			<div class="ContentInfo">

				<?php if ($list[$i]['comment_cnt']) { ?><span class="material-icons-outlined cnt_cmt <?php if ($list[$i]['wr_comment']) echo "NoOn"; ?>" <?php if ($list[$i]['wr_comment']) {?>data-board-wenk="댓글 : <?php echo $list[$i]['wr_comment']; ?>" data-board-wenk-pos="left"<?php } ?>>textsms</span><span class="sound_only">댓글</span><span class="sound_only">개</span><?php } ?>

				<?php if (strstr($list[$i]['wr_option'], 'secret')) {?><span class="material-icons-outlined NoOn" data-board-wenk="비밀글입니다." data-board-wenk-pos="left">lock</span><?php } ?>

				<?php if ($list[$i]['icon_hot']) {?><span class="material-icons-outlined NoOn" data-board-wenk="많이 본 게시물입니다." data-board-wenk-pos="left">whatshot</span><?php } ?>


				<?php if ($list[$i]['wr_1']) {?><span class="material-icons-outlined NoOn" data-board-wenk="TAG가 존재합니다." data-board-wenk-pos="left">tag</span><?php } ?>

				<?php if ($list[$i]['icon_file']) {?><span class="material-icons-outlined NoOn" data-board-wenk="첨부파일이 존재합니다." data-board-wenk-pos="left">file_download</span><?php } ?>

				<?php if ($list[$i]['icon_link']) {?><span class="material-icons-outlined NoOn" data-board-wenk="링크가 존재합니다." data-board-wenk-pos="left">link</span><?php } ?>

				<?php if ($is_good) { ?><span class="material-icons-outlined <?php if ($list[$i]['wr_good']) echo "NoOn"; ?>" <?php if ($list[$i]['wr_good']) {?>data-board-wenk="추천 : <?php echo $list[$i]['wr_good']?>" data-board-wenk-pos="left"<?php } ?>>thumb_up_off_alt</span><?php } ?>

				<?php if ($is_nogood) { ?><span class="material-icons-outlined <?php if ($list[$i]['wr_nogood']) echo "NoOn"; ?>" <?php if ($list[$i]['wr_nogood']) {?>data-board-wenk="비추천 : <?php echo $list[$i]['wr_nogood']?>" data-board-wenk-pos="left"<?php } ?>>thumb_down_off_alt</span><?php } ?>

			</div>

		</div>
		<?php } ?>

	</div>
</div>
        <?php } ?>

        <?php if (count($list) == 0) { echo '<div class="NoArticle" datano="no">게시물이 없습니다.</div>'; } ?>

</div>




	<!-- 페이지 -->
        <?php if (count($list) > 0 && $i < $total_count ) { ?><div class="more_button" style="cursor:pointer;">더보기</div><?php } ?>
	<!-- 페이지 -->


</div>

</form>













<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>





<script type="text/javascript">




$(window).on("load resize",function(){ // 처음에 페이지 읽어올때와 화면 리사이즈시
	var div_css_width = $( '#ScrollWrap' ).width();

	if(div_css_width <= 900){
		if($("#toggle_Max900").length > 0){
		} else {
			$('.toggle_css').remove();
			$('head').append('<link id="toggle_Max900" class="toggle_css" rel="stylesheet" href="<?php echo $board_skin_url?>/Style_Max900.css">');
		}
	} else if(div_css_width <= 1200){
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

	// 스크롤시 코멘트 목록이 상단에 닿으면 실시
	var Listscrodiv_top = $(this).scrollTop();

	if( Listscrodiv_top > "5") {

		$("#BotableTitleWrap").addClass("ScrollOn");
 	} else {
		$("#BotableTitleWrap").removeClass("ScrollOn");
	}
	//div01 에서 스크롤변화가 발생할때 호출
});


function NowItenCnt() {
	var disp_li_length = parseInt($( ".ListItemWrap" ).length);
	$('#now_article').html(disp_li_length);
}


function Item_Page_Load(now_page) {
	if(now_page == "") {
		var now_page = $('#now_page').html();
		var next_page = parseInt(now_page)+1;
	} else {
		var next_page = parseInt(now_page);
	}

	var total_n = '<?php echo number_format($total_count) ?>';

	$.get( "board.php?bo_table=<?=$bo_table?>&ajax_ck=1&sca=<?php echo urlencode($sca) ?>&stx=<?php echo $stx?>&sop=<?=$sop?>&sfl=<?=$sfl?>&page="+now_page, function( data ) {
		var append_data = $( data ).find('#ListWrap').html();
		var cking = $( data ).find('.NoArticle').attr("datano");

		if(cking != "no"){
//			$('#page_txt').html('');
			$('#ListWrap').append(append_data);

			//현재 주소를 가져온다.
			var renewURL = location.href;
			//현재 주소 중 NO 부분이 있다면 날려버린다.
			renewURL = renewURL.replace(/\&page=([0-9]+)/ig, "");
			//	doc = doc.replace(/lang=.?[^" >]*/ig, "");
			//새로 부여될 페이지 번호를 할당한다.
			// page는 ajax에서 넘기는 page 번호를 변수로 할당해주거나 할당된 변수로 변경
			renewURL += '&page='+ $('#now_page').html();
			//페이지 갱신 실행!
			history.pushState(null, null,renewURL);

			$( ".more_button" ).html( '더보기' );
		} else {
			alert( '더 이상 게시물이 존재하지 않습니다.' );
			$( ".more_button" ).html( '끝' );
		}

		NowItenCnt(); // 현재 게시물 수 업데이트

		var disp_li_length = parseInt($( ".ListItemWrap" ).length);
		if(total_n == disp_li_length) { // 글을 모두 갖고 왔으니 더보기 사라지게
			$( ".more_button" ).css( {"display":"none"} );
		}


	});
}



$(document).on("click",".more_button",function() {

	$( this ).html( '<i class="fa fa-spinner fa-spin"></i>' );
	var now_page = $('#now_page').html();

	var next_page = parseInt(now_page)+1;

	$('#now_page').html(next_page);
	$('input[name=page]').val(next_page);

	Item_Page_Load('');

});


$(window).on("load",function(){ // 처음에 페이지 읽어올때와 화면 리사이즈시
	var nPage = '<?php echo $page ?>'; //
	if(nPage > 1) {
		$("#ListWrap").html("");
		for (var np=1; np <= nPage; np++) {
//			setTimeout(function() { 
				Item_Page_Load(np);
//			}, 100); /*-------1000 이 1초-------*/
			
		}
	}
});


</script>

<?php if ($is_checkbox) { ?>
<script>
$(document).ready(function() {
    $("#CheckBox_Option").on("click", function(e) {

        e.stopPropagation();
        $(".CheckBox_Option_List").toggle();

	});


    $(document).on("click", ".List_Check_icon", function (e) {

		var data_no = $(this).attr("data-no");

		if( $(this).hasClass("list_checked") === false) {

			var CheckItems = $('.list_checked').length
			if(CheckItems == "<?php echo $board['bo_page_rows']?>") {
				alert("게시물 선택은 최대 <?php echo $board['bo_page_rows']?>까지만 선택 가능합니다.");
				return false;
			}

			$("#chk_wr_id_"+data_no).prop("checked", true);
			$(this).addClass("list_checked");
			$(this).parent().parent().addClass("Item_list_checked");
		} else {
			$("#chk_wr_id_"+data_no).prop("checked", false);
			$(this).removeClass("list_checked");
			$(this).parent().parent().removeClass("Item_list_checked");
		}

		return false;
	});


	$("#CheckBox_CheckAll").click(function() {

		if( $(this).hasClass("checked_selected") === false) {
			$(".selec_chk").prop("checked", true);
			$(this).addClass("checked_selected");
			$(".List_Check_icon").addClass("list_checked");
			$(".List_Check_icon").parent().parent().addClass("Item_list_checked");
		} else {
			$(".selec_chk").prop("checked", false);
			$(this).removeClass("checked_selected");
			$(".List_Check_icon").removeClass("list_checked");
			$(".List_Check_icon").parent().parent().removeClass("Item_list_checked");
		}
		return false;
	});


    $(document).on("click", function (e) {
        if(!$(e.target).closest('.CheckBox_Option_List').length) {
            $(".CheckBox_Option_List").hide();
        }
    });

});


function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

	if(chk_count > "<?php echo $board['bo_page_rows']?>") {
		alert(chk_count+"선택삭제는 <?php echo $board['bo_page_rows']?>개 까지만 삭제 가능합니다.");
		return false;
	}

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택복사") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        return;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = g5_bbs_url+"/board_list_update.php";
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == "copy")
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = g5_bbs_url+"/move.php";
    f.submit();
}
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->
