<?php

/*************************************************************************************
 *	Favicon
 *************************************************************************************/

if ( !function_exists( 'om_favicon' ) ) {
	function om_favicon() {
		if ($tmp = get_option(OM_THEME_PREFIX . 'favicon')) {
			echo '<link rel="shortcut icon" href="'. $tmp .'"/>';
		}
	}
	add_action('wp_head', 'om_favicon');
}

/*************************************************************************************
 *	Audio Player
 *************************************************************************************/

if ( !function_exists( 'om_audio_player' ) ) {
	function om_audio_player($post_id, $trysize='456x300') {
	 
		$mp3 = get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'audio_mp3', true);
		$ogg = get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'audio_ogg', true);
		$poster = get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'audio_poster', true);
		if($poster && $trysize) {
			$uploads = wp_upload_dir();
			
			if(strpos($poster,$uploads['baseurl']) === 0) {
				$name=basename($poster);
				$name_new=explode('.',$name);
				if(count($name_new > 1))
					$name_new[count($name_new)-2].='-'.$trysize;
				$name_new=implode('.',$name_new);
				$poster_new=str_replace($name,$name_new,$poster);
				if(file_exists(str_replace($uploads['baseurl'],$uploads['basedir'],$poster_new)))
					$poster=$poster_new;
			}
		} elseif(!$poster && $trysize=='456x300') {
			$poster=TEMPLATE_DIR_URI.'/img/audio.png';
		}
		
		$supplied=array();
		if($mp3)
			$supplied[]='mp3';
		if($ogg)
			$supplied[]='ogg';
		if(empty($supplied))
			return;
		$supplied=implode(',',$supplied);	
		
		$setmedia=array();
		if($poster)
			$setmedia[]='poster: "'.$poster.'"';
		if($mp3)
			$setmedia[]='mp3: "'.$mp3.'"';
		if($ogg)
			$setmedia[]='oga: "'.$ogg.'"';
		$setmedia=implode(',',$setmedia);
		
    ?>
		<script type="text/javascript">
			jQuery(document).ready(function(){

				if(jQuery().jPlayer) {
					jQuery("#jquery_jplayer_<?php echo $post_id; ?>").jPlayer({
						ready: function () {
							jQuery(this).jPlayer("setMedia", {
						    <?php echo $setmedia; ?>
							});
						},
						<?php if( !empty($poster) ) { ?>
							size: {
        				width: "auto",
        				height: "auto"
        			},
     				<?php } ?>
						swfPath: "<?php echo get_template_directory_uri(); ?>/js",
						cssSelectorAncestor: "#jp_container_<?php echo $post_id; ?>",
						supplied: "<?php echo $supplied ?>"
					});
			
				}
			});
		</script>

		<div id="jquery_jplayer_<?php echo $post_id; ?>" class="jp-jplayer"></div>

		<div id="jp_container_<?php echo $post_id; ?>" class="jp-container jp-audio">
			<div class="jp-type-single">
				<div class="jp-gui jp-interface">
					<div class="jp-controls">
						<a href="javascript:;" class="jp-play" tabindex="1" title="<?php _e('Play', 'om_theme') ?>"></a>
						<a href="javascript:;" class="jp-pause" tabindex="1" title="<?php _e('Pause', 'om_theme') ?>"></a>
						<div class="jp-play-pause-divider"></div>
						<div class="jp-mute-unmute-divider"></div>
						<a href="javascript:;" class="jp-mute" tabindex="1" title="<?php _e('Mute', 'om_theme') ?>"></a>
						<a href="javascript:;" class="jp-unmute" tabindex="1" title="<?php _e('Unmute', 'om_theme') ?>"></a>
					</div>
					<div class="jp-progress">
						<div class="jp-seek-bar">
							<div class="jp-play-bar"></div>
						</div>
					</div>
					<div class="jp-volume-bar">
						<div class="jp-volume-bar-value"></div>
					</div>
				</div>
				<div class="jp-no-solution">
					<span>Update Required</span>
					To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
				</div>
			</div>
		</div>

    <?php 
  }
}

/*************************************************************************************
 *	Video Player
 *************************************************************************************/

if ( !function_exists( 'om_video_player' ) ) {
	function om_video_player($post_id, $trysize='456x300') {
	 
		$m4v = get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'video_m4v', true);
		$ogv = get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'video_ogv', true);
		$poster = get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'video_poster', true);

		if($poster && $trysize) {
			$uploads = wp_upload_dir();
			
			if(strpos($poster,$uploads['baseurl']) === 0) {
				$name=basename($poster);
				$name_new=explode('.',$name);
				if(count($name_new > 1))
					$name_new[count($name_new)-2].='-'.$trysize;
				$name_new=implode('.',$name_new);
				$poster_new=str_replace($name,$name_new,$poster);
				if(file_exists(str_replace($uploads['baseurl'],$uploads['basedir'],$poster_new)))
					$poster=$poster_new;
			}
		} elseif(!$poster && $trysize=='456x300') {
			$poster=TEMPLATE_DIR_URI.'/img/video.png';
		}
		
		$supplied=array();
		if($m4v)
			$supplied[]='m4v';
		if($ogv)
			$supplied[]='ogv';
		if(empty($supplied))
			return;
		$supplied=implode(',',$supplied);	
		
		$setmedia=array();
		if($poster)
			$setmedia[]='poster: "'.$poster.'"';
		if($m4v)
			$setmedia[]='m4v: "'.$m4v.'"';
		if($ogv)
			$setmedia[]='ogv: "'.$ogv.'"';
		$setmedia=implode(',',$setmedia);
		
    ?>
		<script type="text/javascript">
			jQuery(document).ready(function(){

				if(jQuery().jPlayer) {
					jQuery("#jquery_jplayer_<?php echo $post_id; ?>").jPlayer({
						ready: function () {
							jQuery(this).jPlayer("setMedia", {
						    <?php echo $setmedia; ?>
							});
						},
						<?php if( !empty($poster) ) { ?>
							size: {
        				width: "100%",
        				height: "100%"
        			},
     				<?php } ?>
						swfPath: "<?php echo get_template_directory_uri(); ?>/js",
						cssSelectorAncestor: "#jp_container_<?php echo $post_id; ?>",
						supplied: "<?php echo $supplied ?>"
					});
			
				}
			});
		</script>

		<div class="video-embed<?php if($poster) echo '-ni';?>"><div id="jquery_jplayer_<?php echo $post_id; ?>" class="jp-jplayer"></div></div>

		<div id="jp_container_<?php echo $post_id; ?>" class="jp-container jp-video">
			<div class="jp-type-single">
				<div class="jp-gui jp-interface">
					<div class="jp-controls">
						<a href="javascript:;" class="jp-play" tabindex="1" title="<?php _e('Play', 'om_theme') ?>"></a>
						<a href="javascript:;" class="jp-pause" tabindex="1" title="<?php _e('Pause', 'om_theme') ?>"></a>
						<div class="jp-play-pause-divider"></div>
						<div class="jp-mute-unmute-divider"></div>
						<a href="javascript:;" class="jp-mute" tabindex="1" title="<?php _e('Mute', 'om_theme') ?>"></a>
						<a href="javascript:;" class="jp-unmute" tabindex="1" title="<?php _e('Unmute', 'om_theme') ?>"></a>
					</div>
					<div class="jp-progress">
						<div class="jp-seek-bar">
							<div class="jp-play-bar"></div>
						</div>
					</div>
					<div class="jp-volume-bar">
						<div class="jp-volume-bar-value"></div>
					</div>
				</div>
				<div class="jp-no-solution">
					<span>Update Required</span>
					To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
				</div>
			</div>
		</div>

    <?php 
  }
}

/*************************************************************************************
 * Slides Gallery
 *************************************************************************************/

function om_slides_gallery($post_id, $image_size = 'page-full-2') { 
	
	echo om_get_slides_gallery($post_id, $image_size);
	
}

function om_get_slides_gallery($post_id, $image_size = 'page-full-2') { 

	$attachments = get_posts(array(
		'orderby' => 'menu_order',
		'post_type' => 'attachment',
		'post_parent' => $post_id,
		'post_mime_type' => 'image',
		'post_status' => null,
		'numberposts' => -1
	));
	
	if(get_option(OM_THEME_PREFIX.'exclude_featured_image') == 'true') {
		if( has_post_thumbnail($post_id) ) {
			$thumbid = get_post_thumbnail_id($post_id);

			$attachments_new=array();
			foreach( $attachments as $attachment ) {
				if( $attachment->ID != $thumbid )
					$attachments_new[]=$attachment;
			}
			$attachments=$attachments_new;
		}
	}
	
	$out = '';
	
	if( !empty($attachments) ) {
		$out .= '<div class="custom-gallery"><div class="items">';
		foreach( $attachments as $attachment ) {
	    $src = wp_get_attachment_image_src( $attachment->ID, $image_size );
	    $src_full = wp_get_attachment_image_src( $attachment->ID, 'full' );
	    $alt = ( empty($attachment->post_content) ) ? $attachment->post_title : $attachment->post_content;
	    $out .= '<div class="item" rel="slide-'.$attachment->ID.'"><a href="'.$src_full[0].'" rel="prettyPhoto[postgal_'.$post_id.']"><img height="'.$src[2].'" width="'.$src[1].'" src="'.$src[0].'" alt="'.htmlspecialchars($alt).'" /></a></div>';
		}
		$out .= '</div></div>';
	}
	
	return $out;
}


/*************************************************************************************
 * Slides Gallery Masonry
 *************************************************************************************/

function om_slides_gallery_m($post_id, $image_size = 'portfolio-q-thumb') {
	
	echo om_get_slides_gallery_m($post_id, $image_size);
	
}

function om_get_slides_gallery_m($post_id, $image_size = 'portfolio-q-thumb') { 

	$attachments = get_posts(array(
		'orderby' => 'menu_order',
		'post_type' => 'attachment',
		'post_parent' => $post_id,
		'post_mime_type' => 'image',
		'post_status' => null,
		'numberposts' => -1
	));

	if(get_option(OM_THEME_PREFIX.'exclude_featured_image') == 'true') {
		if( has_post_thumbnail($post_id) ) {
			$thumbid = get_post_thumbnail_id($post_id);

			$attachments_new=array();
			foreach( $attachments as $attachment ) {
				if( $attachment->ID != $thumbid )
					$attachments_new[]=$attachment;
			}
			$attachments=$attachments_new;
		}
	}
		
	$out = '';
	
	if( !empty($attachments) ) {
		$out .= '<div class="thumbs-masonry isotope">';
		$sizes=array();
		$n=count($attachments);
		if($n <= 3) {
			for($i=0;$i<$n;$i++)
				$sizes[]=2;
		} elseif ($n >=4 && $n <= 6) {
			$sizes[]=2;
			$sizes[]=2;
			for($i=0;$i<$n-2;$i++)
				$sizes[]=1;
		} else {
			for($i=0;$i<$n;$i++)
				$sizes[]=(($i%3)==0?'2':'1');
		}
		$i=0;
		foreach( $attachments as $attachment ) {
	    $src = wp_get_attachment_image_src( $attachment->ID, $image_size );
	    $src_full = wp_get_attachment_image_src( $attachment->ID, 'full' );
	    $alt = ( empty($attachment->post_content) ) ? $attachment->post_title : $attachment->post_content;
	    $out .= '<div class="isotope-item block-'.$sizes[$i].' block-h-'.$sizes[$i].'"><a href="'.$src_full[0].'" rel="prettyPhoto[postgal_'.$post_id.']" class="show-hover-link block-h-'.$sizes[$i].'""><img src="'.$src[0].'" alt="'.htmlspecialchars($alt).'"/><span class="before"></span><span class="after"></span></a></div>';
	    
	    $i++;
		}
		$out .= '</div>';
	}
	
	return $out;
}


/*************************************************************************************
 * Get Post Image
 *************************************************************************************/

if ( !function_exists( 'om_get_post_image' ) ) {
	function om_get_post_image($post_id, $image_size = 'thumbnail-post-single') { 
	
		$attachments = get_posts(array(
			'orderby' => 'menu_order',
			'post_type' => 'attachment',
			'post_parent' => $post_id,
			'post_mime_type' => 'image',
			'post_status' => null,
			'numberposts' => 1
		));
		
		/*
		$thumbid = false;
		if( has_post_thumbnail($post_id) ) {
			$thumbid = get_post_thumbnail_id($post_id);
		}
		*/
		
		if( !empty($attachments) ) {
			foreach( $attachments as $attachment ) {
				//if( $attachment->ID == $thumbid )
				//	continue;
		    $src = wp_get_attachment_image_src( $attachment->ID, $image_size );
		    $alt = ( empty($attachment->post_content) ) ? $attachment->post_title : $attachment->post_content;
		    return '<img height="'.$src[2].'" width="'.$src[1].'" src="'.$src[0].'" alt="'.htmlspecialchars($alt).'" />';
			}
		}
		
		return false;
	}
}

/*************************************************************************************
 * Select menu
 *************************************************************************************/
 
function om_select_menu($id, $select_id='primary-menu-select') {
	$out='';
	$out.='<select id="'.$select_id.'" onchange="if(this.value!=\'\'){document.location.href=this.value}"><option value="">'.__('Menu:','om_theme').'</option>';
	
 	if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $id ] ) ) {
 		
		$menu = wp_get_nav_menu_object( $locations[ $id ] );
	
		$sel_menu=wp_get_nav_menu_items($menu->term_id);

		if(is_array($sel_menu)) {
			
			$items=array();
		
			foreach($sel_menu as $item)
				$items[$item->ID]=array('parent'=>$item->menu_item_parent);
				
			foreach($items as $k=>$v) {
				$items[$k]['depth']=0;
				if($v['parent']) {
					$tmp=$v;
					while($tmp['parent']) {
						$items[$k]['depth']++;
						$tmp=$items[$tmp['parent']];
					}
				}
			}
			foreach($sel_menu as $item)
				$out.= '<option value="'.($item->url).'"'.((strcasecmp('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],$item->url)==0)?' selected="selected"':'').'>'.str_repeat('- ',$items[$item->ID]['depth']).($item->title).'</option>';
		}
	}
	
	$out.= '</select>';
	
	echo $out;
	
	return true;
}

/*************************************************************************************
 * Archive Page Title
 *************************************************************************************/
 
function om_get_archive_page_title() {
	
	$out='';
	
	if (is_category()) { 
		$out = sprintf(__('All posts in %s', 'om_theme'), single_cat_title('',false));
	} elseif( is_tag() ) {
		$out = sprintf(__('All posts tagged %s', 'om_theme'), single_tag_title('',false));
	} elseif (is_day()) { 
		$out = __('Archive for', 'om_theme'); $out .= ' '.get_the_time('F jS, Y'); 
	} elseif (is_month()) { 
		$out = __('Archive for', 'om_theme'); $out .= ' '.get_the_time('F, Y'); 
	} elseif (is_year()) { 
		$out = __('Archive for', 'om_theme'); $out .= ' '.get_the_time('Y');
	} elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
		$out = __('Blog Archives', 'om_theme');
	} else { 
		$blog = get_post(get_option('page_for_posts'));
		$out = $blog->post_title;
	}
 	
 	return $out;
}

/*************************************************************************************
 * Wrap paginate_links
 *************************************************************************************/
 
function om_wrap_paginate_links($links) {

	if(!is_array($links))
		return '';

	$out='';
	$out.= '<div class="navigation-pages navigation-prev-next">';
		foreach($links as $v) {
			$v=str_replace(' current',' item current',$v);
			$v=preg_replace('#(<a[^>]*>)([0-9]+)(</a>)#','$1<span class="item">$2</span>$3',$v);
			$v=preg_replace('#(<a[^>]*class="[^"]*prev[^"]*"[^>]*>)([\s\S]*?)(</a>)#','<span class="navigation-prev" style="float:none;display:inline-block;margin-right:6px">$1$2$3</span>',$v);
			$v=preg_replace('#(<a[^>]*class="[^"]*next[^"]*"[^>]*>)([\s\S]*?)(</a>)#','<span class="navigation-next" style="float:none;display:inline-block">$1$2$3</span>',$v);
			$out.= $v;
		}
	$out.= '</div>';

	return $out;
}

/*************************************************************************************
 * Adjacent Custom Post
 *************************************************************************************/

function om_get_previous_post($in_same_cat = false, $excluded_categories = '', $taxonomy='category', $orderby='post_date') {
	if((!$in_same_cat || $taxonomy=='category')  && $orderby == 'post_date')
		// use standard function for standard parameters - safer
		return get_previous_post($in_same_cat, $excluded_categories);
	else
		return om_get_adjacent_post($in_same_cat, $excluded_categories, true, $taxonomy, $orderby);
}

function om_get_next_post($in_same_cat = false, $excluded_categories = '', $taxonomy='category', $orderby='post_date') {
	if((!$in_same_cat || $taxonomy=='category') && $orderby == 'post_date')
		// use standard function for standard parameters - safer
		return get_next_post($in_same_cat, $excluded_categories);
	else
		return om_get_adjacent_post($in_same_cat, $excluded_categories, false, $taxonomy, $orderby);
}

function om_get_adjacent_post( $in_same_cat = false, $excluded_categories = '', $previous = true, $taxonomy='category', $orderby='post_date' ) {
	global $wpdb, $post;

	if ( ! $post )
		return null;

	$current_post_order_val = $post->$orderby;

	$join = '';
	$posts_in_ex_cats_sql = '';
	if ( $in_same_cat || ! empty( $excluded_categories ) ) {
		$join = " INNER JOIN $wpdb->term_relationships AS tr ON p.ID = tr.object_id INNER JOIN $wpdb->term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id";

		if ( $in_same_cat ) {
			if ( ! is_object_in_taxonomy( $post->post_type, $taxonomy ) )
				return '';
			$cat_array = wp_get_object_terms($post->ID, $taxonomy, array('fields' => 'ids'));
			if ( ! $cat_array || is_wp_error( $cat_array ) )
				return '';
			$join .= " AND tt.taxonomy = '".$taxonomy."' AND tt.term_id IN (" . implode(',', $cat_array) . ")";
		}

		$posts_in_ex_cats_sql = "AND tt.taxonomy = '".$taxonomy."'";
		if ( ! empty( $excluded_categories ) ) {
			if ( ! is_array( $excluded_categories ) ) {
				// back-compat, $excluded_categories used to be IDs separated by " and "
				if ( strpos( $excluded_categories, ' and ' ) !== false ) {
					_deprecated_argument( __FUNCTION__, '3.3', sprintf( __( 'Use commas instead of %s to separate excluded categories.' ), "'and'" ) );
					$excluded_categories = explode( ' and ', $excluded_categories );
				} else {
					$excluded_categories = explode( ',', $excluded_categories );
				}
			}

			$excluded_categories = array_map( 'intval', $excluded_categories );

			if ( ! empty( $cat_array ) ) {
				$excluded_categories = array_diff($excluded_categories, $cat_array);
				$posts_in_ex_cats_sql = '';
			}

			if ( !empty($excluded_categories) ) {
				$posts_in_ex_cats_sql = " AND tt.taxonomy = '".$taxonomy."' AND tt.term_id NOT IN (" . implode($excluded_categories, ',') . ')';
			}
		}
	}

	$adjacent = $previous ? 'previous' : 'next';
	$op = $previous ? '<' : '>';
	$order = $previous ? 'DESC' : 'ASC';

	$join  = apply_filters( "get_{$adjacent}_post_join", $join, $in_same_cat, $excluded_categories );
	$where = apply_filters( "get_{$adjacent}_post_where", $wpdb->prepare("WHERE p.".$orderby." $op %s AND p.post_type = %s AND p.post_status = 'publish' $posts_in_ex_cats_sql", $current_post_order_val, $post->post_type), $in_same_cat, $excluded_categories );
	$sort  = apply_filters( "get_{$adjacent}_post_sort", "ORDER BY p.".$orderby." $order LIMIT 1" );

	$query = "SELECT p.id FROM $wpdb->posts AS p $join $where $sort";
	$query_key = 'adjacent_post_' . md5($query);
	$result = wp_cache_get($query_key, 'counts');
	if ( false !== $result ) {
		if ( $result )
			$result = get_post( $result );
		return $result;
	}

	$result = $wpdb->get_var( $query );
	if ( null === $result )
		$result = '';

	wp_cache_set($query_key, $result, 'counts');

	if ( $result )
		$result = get_post( $result );

	return $result;
}

/*************************************************************************************
 * Adjacent Custom Post Link
 *************************************************************************************/

function om_previous_post_link($format='&laquo; %link', $link='%title', $in_same_cat = false, $excluded_categories = '', $taxonomy='category', $orderby='post_date') {
	if((!$in_same_cat || $taxonomy=='category') && $orderby == 'post_date')
		// use standard function for standard parameters - safer
		previous_post_link($format, $link, $in_same_cat, $excluded_categories);
	else
		om_adjacent_post_link($format, $link, $in_same_cat, $excluded_categories, true, $taxonomy, $orderby);
}

function om_next_post_link($format='%link &raquo;', $link='%title', $in_same_cat = false, $excluded_categories = '', $taxonomy='category', $orderby='post_date') {
	if((!$in_same_cat || $taxonomy=='category') && $orderby == 'post_date')
		// use standard function for standard parameters - safer
		next_post_link($format, $link, $in_same_cat, $excluded_categories);
	else
		om_adjacent_post_link($format, $link, $in_same_cat, $excluded_categories, false, $taxonomy, $orderby);
}

function om_adjacent_post_link( $format, $link, $in_same_cat = false, $excluded_categories = '', $previous = true, $taxonomy='category', $orderby='post_date' ) {
	
	if(!isset($GLOBALS['post']))
		return null;
		
	$g_post=$GLOBALS['post'];	

	if ( $previous && is_attachment() )
		$post = get_post( $g_post->post_parent );
	else
		$post = om_get_adjacent_post( $in_same_cat, $excluded_categories, $previous, $taxonomy, $orderby );

	if ( ! $post ) {
		$output = '';
	} else {
		$title = $post->post_title;

		if ( empty( $post->post_title ) )
			$title = $previous ? __( 'Previous Post' ) : __( 'Next Post' );

		$title = apply_filters( 'the_title', $title, $post->ID );
		$date = mysql2date( get_option( 'date_format' ), $post->post_date );
		$rel = $previous ? 'prev' : 'next';
		if ($previous == true) $string = '<a href="' . get_permalink( $post ) . '" class="left" rel="'.$rel.'">'; else
		$string = '<a href="' . get_permalink( $post ) . '" class="right" rel="'.$rel.'">';
		$inlink = str_replace( '%title', $title, $link );
		$inlink = str_replace( '%date', $date, $inlink );
		$inlink = $string . $inlink . '</a>';

		$output = str_replace( '%link', $inlink, $format );
	}

	$adjacent = $previous ? 'previous' : 'next';

	echo apply_filters( "{$adjacent}_post_link", $output, $format, $link, $post );
}