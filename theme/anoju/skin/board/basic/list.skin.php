<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;
?>
<div class="cont_in">
<!-- 게시판 목록 시작 { -->
	<!-- 게시판 카테고리 시작 { -->
	<?php if ($is_category) { ?>
	<nav class="tabmenu">
		<h2 class="blind"><?php echo $board['bo_subject'] ?> 카테고리</h2>
		<ul>
			<?php echo $category_option ?>
		</ul>
	</nav>
	<?php } ?>
	<!-- } 게시판 카테고리 끝 -->
    <div class="list_top">
		<!-- 게시판 페이지 정보 및 버튼 시작 { -->
        <div class="list_total">
            Total <strong class="t_red"><?php echo number_format($total_count) ?></strong>건 / <?php echo $page ?> 페이지
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

    <div class="tbl_wrap">
        <table class="table tbl_hover">
        <caption><?php echo $board['bo_subject'] ?> 목록</caption>
        <thead>
        <tr>
            <?php if ($is_checkbox) { ?>
            <th scope="col">
               <label class="checkbox only">
					<input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
					<i></i>
					<span class="blind">현재 페이지 게시물 전체</span>
				</label>
            </th>
            <?php } ?>
            <th scope="col">번호</th>
            <th scope="col">제목</th>
            <th scope="col">글쓴이</th>
            <th scope="col"><?php echo subject_sort_link('wr_hit', $qstr2, 1) ?>조회 
				<?php if ($sst == 'wr_hit') {  ?>
					<?php if ($sod == 'desc') {  ?>
					<i class="fa fa-sort-desc" aria-hidden="true"></i>
					<?php } else if ($sod == 'asc') { ?>
					<i class="fa fa-sort-asc" aria-hidden="true"></i>
					<?php }  ?>
				<?php } else { ?>
					<i class="fa fa-sort" aria-hidden="true"></i>
				<?php }  ?>
				</a>
			</th>
            <?php if ($is_good) { ?>
			<th scope="col"><?php echo subject_sort_link('wr_good', $qstr2, 1) ?>좋아요
				<?php if ($sst == 'wr_good') {  ?>
					<?php if ($sod == 'desc') {  ?>
					<i class="fa fa-sort-desc" aria-hidden="true"></i>
					<?php } else if ($sod == 'asc') { ?>
					<i class="fa fa-sort-asc" aria-hidden="true"></i>
					<?php }  ?>
				<?php } else { ?>
					<i class="fa fa-sort" aria-hidden="true"></i>
				<?php }  ?>
				</a>
			</th>
			<?php } ?>
            <?php if ($is_nogood) { ?>
			<th scope="col"><?php echo subject_sort_link('wr_nogood', $qstr2, 1) ?>싫어요
				<?php if ($sst == 'wr_nogood') {  ?>
					<?php if ($sod == 'desc') {  ?>
					<i class="fa fa-sort-desc" aria-hidden="true"></i>
					<?php } else if ($sod == 'asc') { ?>
					<i class="fa fa-sort-asc" aria-hidden="true"></i>
					<?php }  ?>
				<?php } else { ?>
					<i class="fa fa-sort" aria-hidden="true"></i>
				<?php }  ?>
				</a>
			</th>
			<?php } ?>
            <th scope="col"><?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>날짜
				<?php if ($sst == 'wr_datetime') {  ?>
					<?php if ($sod == 'desc') {  ?>
					<i class="fa fa-sort-desc" aria-hidden="true"></i>
					<?php } else if ($sod == 'asc') { ?>
					<i class="fa fa-sort-asc" aria-hidden="true"></i>
					<?php }  ?>
				<?php } else { ?>
					<i class="fa fa-sort" aria-hidden="true"></i>
				<?php }  ?>
				</a>
			</th>
        </tr>
        </thead>
        <tbody>
        <?php
        for ($i=0; $i<count($list); $i++) {
         ?>
        <tr class="<?php if ($list[$i]['is_notice']) echo "bo_notice"; ?>">
            <?php if ($is_checkbox) { ?>
            <td class="td_chk">
                <label class="checkbox only">
					<input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
					<i></i>
					<span class="blind"><?php echo $list[$i]['subject'] ?></span>
				</label>
            </td>
            <?php } ?>
            <td class="td_num2">
            <?php
            if ($list[$i]['is_notice']) // 공지사항
                echo '<strong class="notice_icon"><i class="fa fa-bullhorn" aria-hidden="true"></i><span class="sound_only">공지</span></strong>';
            else if ($wr_id == $list[$i]['wr_id'])
                echo "<span class=\"bo_current\">열람중</span>";
            else
                echo $list[$i]['num'];
             ?>
            </td>

            <td class="td_subject" style="padding-left:<?php echo $list[$i]['reply'] ? (strlen($list[$i]['wr_reply'])*10) : '0'; ?>px">
                <?php
                if ($is_category && $list[$i]['ca_name']) {
                 ?>
                <a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link"><?php echo $list[$i]['ca_name'] ?></a>
                <?php } ?>
                <div class="bo_tit">
                    
                    <a href="<?php echo $list[$i]['href'] ?>">
                        <?php echo $list[$i]['icon_reply'] ?>
                        <?php
                            if (isset($list[$i]['icon_secret'])) echo rtrim($list[$i]['icon_secret']);
                         ?>
                        <?php echo $list[$i]['subject'] ?>
                       
                    </a>
                    <?php
                    // if ($list[$i]['link']['count']) { echo '['.$list[$i]['link']['count']}.']'; }
                    // if ($list[$i]['file']['count']) { echo '<'.$list[$i]['file']['count'].'>'; }
                    if (isset($list[$i]['icon_file'])) echo rtrim($list[$i]['icon_file']);
                    if (isset($list[$i]['icon_link'])) echo rtrim($list[$i]['icon_link']);
                    if (isset($list[$i]['icon_new'])) echo rtrim($list[$i]['icon_new']);
                    if (isset($list[$i]['icon_hot'])) echo rtrim($list[$i]['icon_hot']);
                    ?>
                    <?php if ($list[$i]['comment_cnt']) { ?><span class="sound_only">댓글</span><span class="cnt_cmt">+ <?php echo $list[$i]['wr_comment']; ?></span><span class="sound_only">개</span><?php } ?>
                </div>
            </td>
            <td class="td_name sv_use"><?php echo $list[$i]['name'] ?></td>
            <td class="td_num"><?php echo $list[$i]['wr_hit'] ?></td>
            <?php if ($is_good) { ?><td class="td_num"><?php echo $list[$i]['wr_good'] ?></td><?php } ?>
            <?php if ($is_nogood) { ?><td class="td_num"><?php echo $list[$i]['wr_nogood'] ?></td><?php } ?>
            <td class="td_datetime"><?php echo $list[$i]['datetime2'] ?></td>

        </tr>
        <?php } ?>
        <?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table">게시물이 없습니다.</td></tr>'; } ?>
        </tbody>
        </table>
    </div>

    <?php if ($list_href || $is_checkbox || $write_href) { ?>
    <div class="list_bottom">
        <?php if ($list_href || $write_href) { ?>
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
            <?php if ($list_href) { ?><li><a href="<?php echo $list_href ?>" class="button btn_gray"><i class="fa fa-list" aria-hidden="true"></i> 목록</a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="button btn_red"><i class="fa fa-pencil" aria-hidden="true"></i> 글쓰기</a></li><?php } ?>
        </ul>
        <?php } ?>
    </div>
    <?php } ?>
    </form>
     <!-- 페이지 -->
	<?php echo $write_pages;  ?>
</div>

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<?php if ($is_checkbox) { ?>
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
<!-- } 게시판 목록 끝 -->
