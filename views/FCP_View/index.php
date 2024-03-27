<?php
$language_dir = 'ltr';
$language_dirs = get_settings('language_dirs');
if($language_dirs){
	$current_language = $this->session->userdata('language');
	$language_dirs_arr = json_decode($language_dirs, true);
	if(array_key_exists($current_language, $language_dirs_arr)){
		$language_dir = $language_dirs_arr[$current_language];
	}
}

?>
<!DOCTYPE html>
<html lang="<?php echo getIsoCode('english'); ?>" dir="<?php echo $language_dir; ?>">
<head>
	<?php if ($page_name == 'FCP_page'):
		$title = $this->FCP_model->get_FCP_by_id($FCP_id)->row_array()?>
		<title><?php echo $title['title'].' | '.get_settings('system_name'); ?></title>
	<?php else: ?>
		<title><?php echo ucwords($page_title).' | '.get_settings('system_name'); ?></title>
	<?php endif; ?>


	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5.0, minimum-scale=0.86">
	<meta name="author" content="<?php echo get_settings('author') ?>" />

	<?php
	$seo_pages = array('FCP_page');
	if (in_array($page_name, $seo_pages)):
		$course_details = $this->FCP_model->get_FCP_by_id($FCP_id)->row_array();?>
		<meta name="keywords" content="<?php echo get_settings('website_keywords'); ?>"/>
		<meta name="description" content="<?php echo get_settings('website_description'); ?>" />
	<?php elseif($page_name == 'blog_details'): ?>
		<meta name="keywords" content="<?php echo $blog_details['keywords']; ?>"/>
		<meta name="description" content="<?php echo ellipsis(strip_tags(htmlspecialchars_decode_($blog_details['description'])), 140); ?>" />
	<?php elseif($page_name == 'blogs'): ?>
		<meta name="keywords" content="<?php echo get_settings('website_keywords'); ?>"/>
		<meta name="description" content="<?php echo get_frontend_settings('blog_page_subtitle'); ?>" />
	<?php else: ?>
		<meta name="keywords" content="<?php echo get_settings('website_keywords'); ?>"/>
		<meta name="description" content="<?php echo get_settings('website_description'); ?>" />
	<?php endif; ?>

	<!--Social sharing content-->
	<?php if($page_name == "FCP_page"): ?>
		<meta property="og:title" content="<?php echo $title['title']; ?>" />
		<meta property="og:image" content="<?php echo $this->FCP_model->get_FCP_thumbnail_url($FCP_id); ?>">
	
	<?php else: ?>
		<meta property="og:title" content="<?php echo $page_title; ?>" />
		<meta property="og:image" content="<?= base_url("uploads/system/".get_current_banner('banner_image')); ?>">
	<?php endif; ?>
	<meta property="og:url" content="<?php echo current_url(); ?>" />
	<meta property="og:type" content="Learning management system" />
	<!--Social sharing content-->

	<link rel="icon" href="<?php echo base_url('uploads/system/'.get_frontend_settings('favicon')); ?>" type="image/x-icon">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url('uploads/system/'.get_frontend_settings('favicon')); ?>">

	<?php include 'includes_top.php';?>

	<style type="text/css">
		<?php echo get_frontend_settings('custom_css'); ?>
	</style>

</head>
<body class="<?php echo $this->session->userdata('theme_mode'); ?>">
	<?php
	
    
	if($this->session->userdata('app_url')):
		include "go_back_to_mobile_app.php";
	endif;
	
	include 'header.php';

	if(get_frontend_settings('cookie_status') == 'active'):
    	include 'eu-cookie.php';
  	endif;
  	
  	if($page_name === null){
  		include $path;
  	}else{
		include $page_name.'.php';
	}
	include 'footer.php';
	include 'includes_bottom.php';
	include 'modal.php';

	?>

	<?php echo get_frontend_settings('embed_code'); ?>
</body>
</html>
