<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;
?>
<!-- 게시판 목록 시작 { -->
<!-- 게시판 카테고리 시작 { -->
<?php  if ($is_member) {?>
<?php if ($is_category) { ?>
<nav class="tab_menu">
    <h2 class="blind"><?php echo $board['bo_subject'] ?> 카테고리</h2>
    <ul>
        <?php echo $category_option ?>
    </ul>
</nav>
<?php } ?>
<!-- } 게시판 카테고리 끝 -->
<div class="list_top mb-0">
    <!-- 게시판 페이지 정보 및 버튼 시작 { -->
    <div class="list_total">
        <div class="list_total_cut">Total <strong id="nowArticle" class="t_red"><?php echo number_format($total_count) ?></strong>건 / <span id="nowPage"><?php echo $page?></span> 페이지</div>

        <?php if ($is_checkbox) { ?>
        <label class="checkbox">
            <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
            <i></i>
            <span class="lbl">전체선택</span>
        </label>
        <?php } ?>
    </div>
    <!-- } 게시판 페이지 정보 및 버튼 끝 -->

    <!-- 게시판 검색 시작 { -->
    <div class="list_search">
    <fieldset>
        <legend>게시물 검색</legend>

        <form name="fsearch" onsubmit="return fsearch_submit(this);" method="get">
        <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
        <input type="hidden" name="sca" value="<?php echo $sca ?>">
        <input type="hidden" name="sop" value="and">
        <label for="sfl" class="sound_only">검색대상</label>
        <select name="sfl" id="sfl" class="select">
            <?php echo get_board_sfl_select_options($sfl); ?>
        </select>
        <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
        <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="input" size="25" maxlength="20" placeholder="검색어를 입력해주세요">
        <button type="submit" value="검색" class="button btn_black btn_fa"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">검색</span></button>
        </form>
    </fieldset>
    </div>
    <!-- } 게시판 검색 끝 -->  
</div>
<?php } ?>

<form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="spt" value="<?php echo $spt ?>">
<input type="hidden" name="sca" value="<?php echo $sca ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="sw" value="">

<div class="news-wrap">
    <?php if (count($list) == 0) { echo '<div id="noItem" class="list-none">게시물이 없습니다.</div>'; } else { ?>
    <div class="grid" id="listWrap">
        <?php
        for ($i=0; $i<count($list); $i++) {
        ?>
        <div class="grid-item">
            <a href="<?php echo $list[$i]['href'] ?>" class="news-item">
            
            <?php 
            $thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height'], false, true);

            if($thumb['src']) {
                $img_content = '<span class="img-wrap"><img src="'.$thumb['ori'].'" alt="'.$thumb['alt'].'" ></span>';
            } else {
                $img_content = '<span class="img-wrap"><img src="'.G5_THEME_IMG_URL.'/favicon/icon-512x512.png" class="no-img" alt=""></span>';
            }
            echo $img_content;
            ?>
            <strong class="news-tit"><?php echo $list[$i]['subject'] ?></strong>
            <span class="news-txt"><?php echo $list[$i]['wr_1'] ?></span>
            </a>
            <?php if ($is_checkbox) { ?>
            <label class="checkbox small">
                <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
                <i></i>
                <span class="blind"><?php echo $list[$i]['subject'] ?></span>
            </label>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
    <?php } ?>
</div>

<?php if (count($list) > 0 && $i < $total_count ) { ?>
    <div class="center_btn_wrap" id="btnMoreWrap">
        <button type="button" id="btnMore" class="button line w-200 h60">더보기</button>
    </div>
<?php } ?>

<?php if ($admin_href && ($is_checkbox || $write_href)) { ?>
<div class="list_bottom">
    <?php if ($write_href) { ?>
    <ul class="list_btn left">
        <?php if ($is_checkbox) { ?>
        <li><button type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" class="button"><i class="fa fa-trash-o" aria-hidden="true"></i> 선택삭제</button></li>
        <li><button type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value" class="button"><i class="fa fa-files-o" aria-hidden="true"></i> 선택복사</button></li>
        <li><button type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value" class="button"><i class="fa fa-arrows" aria-hidden="true"></i> 선택이동</button></li>
        <?php } ?>
        <?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="button"><i class="fa fa-rss" aria-hidden="true"></i> RSS</a></li><?php } ?>
        <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="button"><i class="fa fa-user-circle" aria-hidden="true"></i> 관리자</a></li><?php } ?>
    </ul>
    <ul class="list_btn">
        <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="button btn_red"><i class="fa fa-pencil" aria-hidden="true"></i> 글쓰기</a></li><?php } ?>
    </ul>
    <?php } ?>
</div>
<?php } ?>
</form>

<!-- 페이지 -->
<?php echo $write_pages; ?>

<?php 
add_javascript('<script src="'.G5_THEME_JS_URL.'/lib/isotope.pkgd-3.0.6.min.js"></script>', 0);
add_javascript('<script src="'.G5_THEME_JS_URL.'/lib/packery-mode.pkgd-2.0.1.min.js"></script>', 0);
if($is_checkbox) { 
?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
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
        f.action = "./board_list_update.php";
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
    f.action = "./move.php";
    f.submit();
}
</script>
<?php } ?>
<script>
// 페이징 숨기기
$('.pg_wrap').addClass('blind');

function nowItenCnt() {
    const $total = '<?php echo number_format($total_count) ?>';
	const $itemLength = $('.grid-item').length;
	// $('#nowArticle').html($itemLength);
    if(parseInt($total) === $itemLength) $('#btnMoreWrap').hide();
}

function itemPageLoad(now_page, isHistory) {
    let $nowPage = now_page;
	if(!$nowPage || $nowPage === undefined) $nowPage = $('input[name=page]').val();
	$.get( "<?=$bo_table?>?ajax_ck=1&sca=<?php echo urlencode($sca) ?>&stx=<?php echo $stx?>&sop=<?=$sop?>&sfl=<?=$sfl?>&page="+$nowPage, function( data ) {
		const $items = $(data).find('#listWrap').find('.grid-item').clone();
		const noItem = $(data).find('#noItem');
		if(!noItem.length){
            if($newsGrid){
                $newsGrid.append($items).isotope('appended',$items);
                const grid = document.querySelector('.news-wrap .grid');
                imageLoadIsotope($newsGrid, grid);
            }else{
                $('#listWrap').append($items);
            }

            if(isHistory){
                //현재 주소를 가져온다.
                var renewURL = location.href;
                //현재 주소 중 NO 부분이 있다면 날려버린다.
                if(renewURL.indexOf('?page') > 0){
                    renewURL = renewURL.replace(/\?page=([0-9]+)/ig, "");
                    //	doc = doc.replace(/lang=.?[^" >]*/ig, "");
                    //새로 부여될 페이지 번호를 할당한다.
                    // page는 ajax에서 넘기는 page 번호를 변수로 할당해주거나 할당된 변수로 변경
                    renewURL += '?page='+ $nowPage;
                }else{
                    renewURL = renewURL.replace(/\&page=([0-9]+)/ig, "");
                    renewURL += '&page='+ $nowPage;
                }
                //페이지 갱신 실행!
                history.pushState(null, null,renewURL);
            }
		} else {
			alert('더 이상 게시물이 존재하지 않습니다.');
			$('#btnMoreWrap').hide();
		}

		nowItenCnt(); // 현재 게시물 수 업데이트
        buttonLoading('#btnMore', false);
	});
}
$(document).on('click','#btnMore',function() {
    buttonLoading(this);
    const now_page = $('input[name=page]').val();
    const next_page = parseInt(now_page)+1;

    if($('#nowPage').length) $('#nowPage').html(next_page);
    $('input[name=page]').val(next_page);

    itemPageLoad(null, true);
});

function scrollMoreClick(){
    var loadMoreButton = document.querySelector('#btnMore');
    if(!loadMoreButton) return;
    var observer = new IntersectionObserver(function(entries, observer) {
        entries.forEach(entry => {
            if(entry.isIntersecting) {
                var style = window.getComputedStyle(entry.target.parentNode);
                if(style.display === 'none' || style.visibility === 'hidden') {
                    // 요소가 보이지 않으면 관찰을 멈춥니다.
                    observer.unobserve(entry.target);
                } else {
                    // 요소가 보이면 클릭 이벤트를 발생시킵니다.
                    loadMoreButton.click();
                }
            }
        });
    }, {threshold: 0.01});

    observer.observe(loadMoreButton);
}
scrollMoreClick();

$(window).on('load',function(){
	const nPage = '<?php echo $page ?>';
	if(parseInt(nPage) > 1) {
		$("#listWrap").html('');
		for (let np = 1; np <= parseInt(nPage); np+=1) {
            setTimeout(function(){
                if(np === parseInt(nPage)) {
                    itemPageLoad(np, true);
                    setTimeout(newsUI, 200);
                }else{
                    itemPageLoad(np);
                }
            }, (np - 1) * 10);
		}
	}else{
        newsUI();
    }
});
</script>
<!-- } 게시판 목록 끝 -->
