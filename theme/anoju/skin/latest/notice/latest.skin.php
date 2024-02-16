<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


add_javascript('<script src="'.G5_JS_URL.'/jquery.bxslider.js"></script>', 10);
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>

<div class="foot_notice">
    <div class="inner">
        <div class="cont">
            <h2><a href="<?php echo get_pretty_url($bo_table); ?>"><?php echo $bo_subject ?></a></h2>
            <div>
                <ul>
                <?php for ($i=0; $i<$list_count; $i++) {  ?>
                    <li>
                        <?php
                        if ($list[$i]['icon_secret']) echo "<span class=\"lock_icon\"><i class=\"fa fa-lock\" aria-hidden=\"true\"></i></span> ";
                        if ($list[$i]['icon_new']) echo "<span class=\"new_icon\">N<span class=\"sound_only\">새글</span></span>";
                        //echo $list[$i]['icon_reply']." ";
                        echo "<a href=\"".get_pretty_url($bo_table, $list[$i]['wr_id'])."\">";
                        if ($list[$i]['is_notice'])
                            echo "<strong>".$list[$i]['subject']."</strong>";
                        else
                            echo $list[$i]['subject'];

                        if ($list[$i]['comment_cnt'])
                            echo $list[$i]['comment_cnt'];

                        echo "</a>";

                        // if ($list[$i]['link']['count']) { echo "[{$list[$i]['link']['count']}]"; }
                        // if ($list[$i]['file']['count']) { echo "<{$list[$i]['file']['count']}>"; }

                        //if ($list[$i]['icon_file']) echo " <i class=\"fa fa-download\" aria-hidden=\"true\"></i>" ;
                        //if ($list[$i]['icon_link']) echo " <i class=\"fa fa-link\" aria-hidden=\"true\"></i>" ;
                        //if ($list[$i]['icon_hot']) echo " <i class=\"fa fa-heart\" aria-hidden=\"true\"></i>";
                        ?>
                    </li>
                <?php }  ?>
                <?php if ($list_count == 0) { //게시물이 없을 때  ?>
                <li class="empty_li">게시물이 없습니다.</li>
                <?php }  ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php if (count($list)) { //게시물이 있다면 ?>
<script>
    $('.foot_notice ul').bxSlider({
        //hideControlOnEnd: true,
		mode:'vertical',
		auto:true,
        pager:false,
        nextText: '<i class="fa fa-angle-right" aria-hidden="true"></i>',
        prevText: '<i class="fa fa-angle-left" aria-hidden="true"></i>'
    });
</script>
<?php } ?>
