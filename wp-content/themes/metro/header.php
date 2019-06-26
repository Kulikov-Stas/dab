<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title><?php
    if (!defined('WPSEO_VERSION')) {
        wp_title('|', true, 'right');
        bloginfo('name');
    }
    else {
        //IF WordPress SEO by Yoast is activated
        wp_title('');
    }?></title>


	<!-- Pingbacks -->
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/custom.css.php" type="text/css" />
	<?php if(get_option(OM_THEME_PREFIX . 'responsive') == 'true') : ?>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/responsive.css" type="text/css" />
	<?php endif; ?>
	<!--artem-->
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/styles.css" media="screen">
	<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE">
	<!--[if IE 8]><link rel='stylesheet' type='text/css' href='<?php echo get_template_directory_uri(); ?>/css/ie8.css'><![endif]-->
	<!--[if IE 9]><link rel='stylesheet' type='text/css' href='<?php echo get_template_directory_uri(); ?>/css/ie9.css'><![endif]-->
	<!--[if IE]><script src='http://html5shiv.googlecode.com/svn/trunk/html5.js'></script><![endif]-->
	<!--[if (gte IE 6)&(lte IE 8)]><script type='text/javascript' src='<?php echo get_template_directory_uri(); ?>/js/selectivizr-min.js'></script><![endif]-->
	<!--[if lte IE 9]><script src='<?php echo get_template_directory_uri(); ?>/js/placeholder.js'></script><![endif]-->
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/other-crap.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.mousewheel.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/TweenMax.min.js"></script>	
	<!--end artem-->
	<?php
		$custom_css=get_option(OM_THEME_PREFIX . 'code_custom_css');
		if($custom_css)
			echo '<style>'.$custom_css.'</style>';
	?>
	
	<?php echo get_option( OM_THEME_PREFIX . 'code_before_head' ) ?>
	
	<?php wp_head(); ?>
</head>
<?php
	$body_class='';
	if(get_option(OM_THEME_PREFIX.'sidebar_position')=='left')
		$body_class='flip-sidebar';
	if(@$post) {
		$sidebar_post=get_post_meta($post->ID, OM_THEME_SHORT_PREFIX.'sidebar_custom_pos', true);
		if($sidebar_post == 'left')
			$body_class='flip-sidebar';
		elseif($sidebar_post == 'right')
			$body_class='';
	}
	if(get_option(OM_THEME_PREFIX.'content_panes_dark_bg')=='true')
		$body_class.=' dark-panes-bg';
	if (is_front_page () ||  is_tax( 'portfolio-type' )) $body_class.=' index-page ';	
?>
<body <?php body_class( $body_class ); ?>>
<!--[if lt IE 8]><p class="chromeframe"><?php _e('Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.','om_theme'); ?></p><![endif]-->
<div class="fon"></div>
	<div id="preloader"><div id="loading"></div></div>
	<?php $arg=array (
		'post_type' => 'portfolio',
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'posts_per_page' => -1
	);
	$query = new WP_Query($arg);	
	$count_posts = $query->post_count;
	?>
	<script type="text/javascript">
		var width = null;
		
		function hello() {
			var preloader = document.getElementById('loading');
			width +=100/<?php echo $count_posts; ?>;	//100/на кол-во картинок	
			preloader.style.width = width + '%'	
		}
	</script>	

		<!-- Logo & Menu -->		
		
		<?php
			if ( has_nav_menu( 'primary-menu' ) ) {

				function om_nav_menu_classes ($items) {

					function hasSub ($menu_item_id, &$items) {
		        foreach ($items as $item) {
	            if ($item->menu_item_parent && $item->menu_item_parent==$menu_item_id) {
	              return true;
	            }
		        }
		        return false;
					};					
					
					$menu_root_num=0;
					foreach($items as $item) {
						if(!$item->menu_item_parent)
							$menu_root_num++;
							
						if (hasSub($item->ID, $items)) {
							$item->classes[] = 'menu-parent-item';
						}
					}
					if($menu_root_num < 7)
						$size_class='block-h-1';
					else
						$size_class='block-h-half';
					foreach ($items as &$item) {
						if($item->menu_item_parent)
							continue;
						$item->classes[] = 'block-1';
						$item->classes[] = $size_class;
					}
					return $items;    
				}
				add_filter('wp_nav_menu_objects', 'om_nav_menu_classes');	

				$menu = wp_nav_menu( array(
					'theme_location' => 'primary-menu',
					'container' => false,
					'echo' => false,
					'link_before'=>'<span>',
					'link_after'=>'</span>',
					'items_wrap' => '%3$s'
				) );
				
				remove_filter('wp_nav_menu_objects', 'om_nav_menu_classes');	
				
				$root_num=preg_match_all('/class="[^"]*block-1[^"]*"/', $menu, $m);
				echo '<ul class="primary-menu block-6 no-mar'.(get_option(OM_THEME_PREFIX . 'show_dropdown_symbol')=='true'?' show-dropdown-symbol':'').'">'.$menu;
				$blank_num=0;
				$blank_str='';
				if($root_num < 7) {
					$blank_num=6-$root_num;
					$blank_str='<li class="block-1 block-h-1 blank">&nbsp;</li>';
				} elseif($root_num < 13) {
					$blank_num=12-$root_num;
					$blank_str='<li class="block-1 block-h-half blank">&nbsp;</li>';
				}
				echo str_repeat($blank_str,$blank_num);
				echo '</ul>';

		
				echo '<div class="primary-menu-select bg-color-menu">';
				om_select_menu( 'primary-menu' );
				echo '</div>';
			}
		?>		
		
		<!-- /Logo & Menu -->

		<?php if( is_front_page() ) { get_template_part('includes/homepage-slider'); } ?>