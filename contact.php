<?php
include_once('./common.php');
$g5['title'] = "Contact";
include_once('./head.php');
?>

<p class="sub-slogan">
  우리는 성공적인 비지니스 전략을 제시해 나가는 것을 목표로 합니다.<br />
  함께 할 좋은 파트너를 항상 기다리고 있습니다.
</p>
<div class="flex contact-wrap">
  <a href="mailto:hij@hiuxc.com" class="contact-box contact">
    <p class="contact_txt">
      프로젝트 관련<br />
      문의가 있으세요?
      <strong class="mail_address">hij@hiuxc.com</strong>
    </p>
  </a>
  <a href="mailto:jykim@hiuxc.com" class="contact-box recruit">
    <p class="contact_txt">
      채용 관련<br />
      문의가 있으세요?
      <strong class="mail_address">jykim@hiuxc.com</strong>
    </p>
  </a>
</div>
<div class="offic-wrap">
  <h3 class="office-tit">Office</h3>
  <p class="office-address">
    서울 영등포구 당산로41길 11,<br class="txt-space" />
    SK V1 center E동 605호
  </p>
  <p class="eng-address">6F E-605, SK V1 Center, 11 Dangsan-ro 41-gil, Yeongdeugpo-gu, Seoul</p>
  <div class="num-box">
    <a href="tel:02-2675-3397" class="tel-num"><span class="num-type">TEL</span>02-2675-3397</a>
    <a href="tel:02-2675-3387" class="tel-num"><span class="num-type">FAX</span>02-2675-3387</a>
  </div>
</div>

<div id="companyMap" class="company-map"></div>
<?php
add_javascript('<script src="//dapi.kakao.com/v2/maps/sdk.js?appkey=7aaf489efb791b1c23ef6259164ddf9d"></script>', 0);
?>
<script>
kakakoMapInit('/theme/hiux/img/common/map_marker.png', 110, 128);
</script>
<?php
include_once('./tail.php');
?>