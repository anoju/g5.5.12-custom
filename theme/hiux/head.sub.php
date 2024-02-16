<?php
// 이 파일은 새로운 파일 생성시 반드시 포함되어야 함
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$g5_debug['php']['begin_time'] = $begin_time = get_microtime();

if (!isset($g5['title'])) {
    $g5['title'] = $config['cf_title'];
    $g5_head_title = $g5['title'];
}
else {
    // 상태바에 표시될 제목
    $g5_head_title = implode(' | ', array_filter(array($g5['title'], $config['cf_title'])));
}

$g5['title'] = strip_tags($g5['title']);
$g5_head_title = strip_tags($g5_head_title);

// 현재 접속자
// 게시판 제목에 ' 포함되면 오류 발생
$g5['lo_location'] = addslashes($g5['title']);
if (!$g5['lo_location'])
    $g5['lo_location'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
$g5['lo_url'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
if (strstr($g5['lo_url'], '/'.G5_ADMIN_DIR.'/') || $is_admin == 'super') $g5['lo_url'] = '';

/*
// 만료된 페이지로 사용하시는 경우
header("Cache-Control: no-cache"); // HTTP/1.1
header("Expires: 0"); // rfc2616 - Section 14.21
header("Pragma: no-cache"); // HTTP/1.0
*/
?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no,viewport-fit=cover">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta http-equiv="imagetoolbar" content="no">
<meta name="format-detection" content="telephone=no">
<meta name="HandheldFriendly" content="true">

<?php
// if (G5_IS_MOBILE) {
//     echo '<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10,user-scalable=yes">'.PHP_EOL;
//     echo '<meta name="HandheldFriendly" content="true">'.PHP_EOL;
//     echo '<meta name="format-detection" content="telephone=no">'.PHP_EOL;
// } else {
//     echo '<meta http-equiv="imagetoolbar" content="no">'.PHP_EOL;
//     echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">'.PHP_EOL;
// }

if($config['cf_add_meta'])
    echo $config['cf_add_meta'].PHP_EOL;
?>
<title><?php echo $g5_head_title; ?></title>

<meta name="description" content="<?php echo $config['cf_title']; ?> - HI UX. 우리는 성공적인 비지니스 전략을 제시해 나가는 것을 목표로 합니다." />
<link rel="canonical" href="<?php echo G5_URL ?>" />
<meta property="og:locale" content="ko_KR" />
<meta property="og:type" content="website" />
<meta property="og:title" content="<?php echo $g5_head_title; ?>" />
<meta property="og:description" content="<?php echo $config['cf_title']; ?> - HI UX. 우리는 성공적인 비지니스 전략을 제시해 나가는 것을 목표로 합니다." />
<meta property="og:url" content="<?php echo G5_URL ?>" />
<meta property="og:site_name" content="<?php echo $config['cf_title']; ?>" />
<meta property="og:image" content="<?php echo G5_THEME_IMG_URL ?>/ogp_image.png" />

<link rel="shortcut icon" type="image/x-icon" href="<?php echo G5_THEME_IMG_URL ?>/favicon/favicon.png" />
<link rel="icon" type="image/x-icon" href="<?php echo G5_THEME_IMG_URL ?>/favicon/favicon.png" />

<meta name="apple-mobile-web-app-title" content="<?php echo $config['cf_title']; ?>" />
<link rel="apple-touch-icon" href="<?php echo G5_THEME_IMG_URL ?>/favicon/touch-icon-iphone.png" />
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo G5_THEME_IMG_URL ?>/favicon/touch-icon-ipad.png" />
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo G5_THEME_IMG_URL ?>/favicon/touch-icon-iphone-retina.png" />
<link rel="apple-touch-icon" sizes="167x167" href="<?php echo G5_THEME_IMG_URL ?>/favicon/touch-icon-ipad-retina.png" />
<link rel="manifest" href="<?php echo G5_THEME_CSS_URL; ?>/manifest.json">

<link rel="stylesheet" href="<?php echo G5_THEME_CSS_URL; ?>/front.min.css?ver=<?php echo G5_CSS_VER; ?>">
<link rel="stylesheet" href="<?php echo G5_THEME_CSS_URL; ?>/default.min.css?ver=<?php echo G5_CSS_VER; ?>">
<link rel="stylesheet" href="<?php echo G5_THEME_CSS_URL; ?>/custom.min.css?ver=<?php echo G5_CSS_VER; ?>">
<!--[if lte IE 8]>
<script src="<?php echo G5_JS_URL ?>/html5.js"></script>
<![endif]-->
<script>
// 자바스크립트에서 사용하는 전역변수 선언
var g5_url       = "<?php echo G5_URL ?>";
var g5_bbs_url   = "<?php echo G5_BBS_URL ?>";
var g5_is_member = "<?php echo isset($is_member)?$is_member:''; ?>";
var g5_is_admin  = "<?php echo isset($is_admin)?$is_admin:''; ?>";
var g5_bo_table  = "<?php echo isset($bo_table)?$bo_table:''; ?>";
var g5_sca       = "<?php echo isset($sca)?$sca:''; ?>";
var g5_editor    = "<?php echo ($config['cf_editor'] && $board['bo_use_dhtml_editor'])?$config['cf_editor']:''; ?>";
var g5_cookie_domain = "<?php echo G5_COOKIE_DOMAIN ?>";
</script>
<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_JS_URL.'/font-awesome/css/font-awesome.min.css">', 0);
add_javascript('<script src="'.G5_THEME_JS_URL.'/lib/jquery-3.7.1.min.js"></script>', 0);
add_javascript('<script src="'.G5_THEME_JS_URL.'/lib/jquery-migrate-3.4.0.min.js"></script>', 0);
add_javascript('<script src="'.G5_THEME_JS_URL.'/lib/swiper-bundle.11.0.5.min.js"></script>', 0);
add_javascript('<script src="'.G5_THEME_JS_URL.'/ui-common.js?ver='.G5_JS_VER.'"></script>', 0);
add_javascript('<script src="'.G5_JS_URL.'/common.js?ver='.G5_JS_VER.'"></script>', 0);
add_javascript('<script src="'.G5_JS_URL.'/wrest.js?ver='.G5_JS_VER.'"></script>', 0);
add_javascript('<script src="'.G5_JS_URL.'/placeholders.min.js"></script>', 0);

if(!defined('G5_IS_ADMIN'))
    echo $config['cf_add_script'];
?>
</head>
<body<?php echo isset($g5['body_script']) ? $g5['body_script'] : ''; ?>>

