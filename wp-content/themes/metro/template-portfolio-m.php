<?php
/*
Template Name: Portfolio Masonry
*/

get_header(); ?>

<?php

	$arg=array (
		'post_type' => 'portfolio',
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'posts_per_page' => -1
	);
	
	$sort=get_option(OM_THEME_PREFIX . 'portfolio_sort');
	if($sort == 'date_asc') {
		$arg['orderby'] = 'date';
		$arg['order'] = 'ASC';
	} elseif($sort == 'date_desc') {
		$arg['orderby'] = 'date';
		$arg['order'] = 'DESC';
	}
	
	
	
	$pagination=intval(get_option(OM_THEME_PREFIX . 'portfolio_per_page'));
	if($pagination) {
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$arg['posts_per_page']=$pagination;
		$arg['paged']=$paged;
	}
	
	$portfolio_category=intval(get_post_meta($post->ID, OM_THEME_SHORT_PREFIX.'portfolio_categories', true));
	if($portfolio_category) {
		$arg['tax_query']=array(
			array('taxonomy'=>'portfolio-type', 'terms' => $portfolio_category),
		);
	}
		
	$query = new WP_Query($arg);
	//var_dump($arg);
	
	$count_posts = $query->post_count;
	$row_posts = (int)ceil($count_posts/3);
	//var_dump( $row_posts );
	$max_num_pages=$query->max_num_pages;
	
?>

				<?php
          if ( current_user_can( 'edit_post', $post->ID ) )
      	    edit_post_link( __('edit', 'om_theme'), '<div class="edit-post-link">[', ']</div>' );
    		?>				

	<?php wp_reset_postdata(); ?>
	
				<?php
				$arg = array (
					'type' => 'portfolio',
					'taxonomy' => 'portfolio-type'
				);
				if($portfolio_category) {
					$arg['child_of']=$portfolio_category;
				}
				$categories=get_categories( $arg );
				if(!empty($categories)) {
				?>
					<!-- Categories -->
	<header class="floated">
		<a href="/" class="logo"></a>
		<div class="nav">
					<ul>
						<?php
							foreach($categories as $category) {
								if(!$category->count)
									continue;
								echo '<li><a href="'.get_term_link($category, 'portfolio-type').'" >'.$category->name.'</a></li>';
							}
						?>
					<li><a href="http://bannermaker.by" target="_blank" >Banners</a></li>
					</ul>
		</div>
		<div class="contacts">
			BELARUS, MINSK <br>
			+375 17 328 04 09, <a href="mailto:info@banderlog.by">info@banderlog.by</a>
		</div>
	</header>
	<section class="content">
					<!-- /Categories -->
				<?php } ?>
		
		

		<div class="scrolling-tape floated">
			<!-- Portfolio items 1 row-->
			
	<?php		
	$arg=array (
		'post_type' => 'portfolio',
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'posts_per_page' => $row_posts		
	);
	
	$query = new WP_Query($arg);
	
	?>				
			
			<?php
			
			while ( $query->have_posts() ) : $query->the_post(); ?>

				<?php
					$size = get_post_meta($post->ID, OM_THEME_SHORT_PREFIX.'portfolio_size', true);
					$size=intval($size);
					if(!$size)
						$size=1;
					elseif($size > 3)
						$size=3;
				?>

				<?php
				$terms =  get_the_terms( $post->ID, 'portfolio-type' ); 
				$term_list = array();
				if( is_array($terms) ) {
					foreach( $terms as $term ) {
						$term_list[]=urldecode($term->slug);
					}
				}
				$term_list=implode(' ',$term_list);
				
				$link=get_post_meta($post->ID, OM_THEME_SHORT_PREFIX.'portfolio_custom_link', true);
				if(!$link)
					$link=get_permalink();
					
				?>
				
				<div <?php post_class('pic block-h-'.$size.' img-holder '); ?> id="post-<?php the_ID(); ?>">

					<a href="<?php echo $link ?>" >
					<!--<div class="pic block-h-<?php //echo $size ?> " >-->
						<?php if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) { ?>
						<?php the_post_thumbnail('portfolio-q-thumb', array('onload'=>'hello()')); ?>
						<?php } else { echo '&nbsp'; } ?>
					<!--</div><span class="after"></span>-->
					</a>
				</div>
			<?php endwhile; ?>
			
			<?php wp_reset_postdata(); ?>
			
		</div>
		<div class="scrolling-tape floated">
			<!-- Portfolio items 2 row-->
	<?php		
	$arg=array (
		'post_type' => 'portfolio',
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'posts_per_page' => $row_posts,
		'offset' => $row_posts
	);
	
	$query = new WP_Query($arg);
	
	?>		
			
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>

				<?php
					$size = get_post_meta($post->ID, OM_THEME_SHORT_PREFIX.'portfolio_size', true);
					$size=intval($size);
					if(!$size)
						$size=1;
					elseif($size > 3)
						$size=3;
				?>

				<?php
				$terms =  get_the_terms( $post->ID, 'portfolio-type' ); 
				$term_list = array();
				if( is_array($terms) ) {
					foreach( $terms as $term ) {
						$term_list[]=urldecode($term->slug);
					}
				}
				$term_list=implode(' ',$term_list);
				
				$link=get_post_meta($post->ID, OM_THEME_SHORT_PREFIX.'portfolio_custom_link', true);
				if(!$link)
					$link=get_permalink();
					
				?>
				
				<div <?php post_class('pic block-h-'.$size.' img-holder '); ?> id="post-<?php the_ID(); ?>">

					<a href="<?php echo $link ?>" >
					<!--<div class="pic block-h-<?php //echo $size ?> " >-->
						<?php if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) { ?>
						<?php the_post_thumbnail('portfolio-q-thumb', array('onload'=>'hello()')); ?>
						<?php } else { echo '&nbsp'; } ?>
					<!--</div><span class="after"></span>-->
					</a>
				</div>
			<?php endwhile;
			
			wp_reset_postdata(); ?>

			<!-- /Portfolio items -->
		</div>	
											
		<div class="scrolling-tape floated">
			<!-- Portfolio items 3 row-->
	<?php		
	$arg=array (
		'post_type' => 'portfolio',
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'posts_per_page' => $row_posts,
		'offset' => $row_posts*2
	);
	
	$query = new WP_Query($arg);
	//var_dump($query);
	?>		
			
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>

				<?php
					$size = get_post_meta($post->ID, OM_THEME_SHORT_PREFIX.'portfolio_size', true);
					$size=intval($size);
					if(!$size)
						$size=1;
					elseif($size > 3)
						$size=3;
				?>

				<?php
				$terms =  get_the_terms( $post->ID, 'portfolio-type' ); 
				$term_list = array();
				if( is_array($terms) ) {
					foreach( $terms as $term ) {
						$term_list[]=urldecode($term->slug);
					}
				}
				$term_list=implode(' ',$term_list);
				
				$link=get_post_meta($post->ID, OM_THEME_SHORT_PREFIX.'portfolio_custom_link', true);
				if(!$link)
					$link=get_permalink();
					
				?>
				
				<div <?php post_class('pic block-h-'.$size.' img-holder '); ?> id="post-<?php the_ID(); ?>">

					<a href="<?php echo $link ?>" >
					<!--<div class="pic block-h-<?php //echo $size ?> " >-->
						<?php if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) { ?>
						<?php the_post_thumbnail('portfolio-q-thumb', array('onload'=>'hello()')); ?>
						<?php } else { echo '&nbsp'; } ?>
					<!--</div><span class="after"></span>-->
					</a>
				</div>
			<?php endwhile;
			
			wp_reset_postdata(); ?>

			<!-- /Portfolio items -->
		</div>	
		

		<?php
			if($pagination) {
				$links=paginate_links( array(
					'base' => str_replace( '999999999', '%#%', esc_url( get_pagenum_link( '999999999' ) ) ),
					'format' => '?paged=%#%',
					'current' => $paged,
					'total' => $max_num_pages,
					'type' => 'array',
					'prev_text' => __('Previous', 'om_theme'),
					'next_text' => __('Next', 'om_theme'),
				) );
				if(!empty($links)) {
					echo '<div class="block-full bg-color-main"><div class="block-inner">';
					echo om_wrap_paginate_links($links);
					echo '</div></div><div class="clear anti-mar">&nbsp;</div>';
				}
			}
		?>
		
<?php get_footer(); ?>