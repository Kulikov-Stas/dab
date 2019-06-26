<?php get_header(); ?>

				<?php

				$arg=array (
					'type' => 'portfolio',
					'taxonomy' => 'portfolio-type'
				);
				$portfolio_root_cat=false;
				if($wp_query->queried_object->parent) {
					$tmp=get_term($wp_query->queried_object->parent,'portfolio-type');
					while($tmp->parent)
						$tmp=get_term($tmp->parent,'portfolio-type');
					$portfolio_root_cat=$tmp->term_id;
					$portfolio_root_cat_slug=$tmp->slug;
					$arg['child_of']=$portfolio_root_cat;
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
							$args = array(
								'post_type' => 'page',
								'posts_per_page' => 1,
								'meta_query' => array(
									array(
										'key' => '_wp_page_template',
										'value' => array('template-portfolio.php', 'template-portfolio-m.php'),
										'compare' => 'IN',
									)
								)
							);
							if($portfolio_root_cat) {
								$args['meta_query'][]=array(
									'key' => OM_THEME_SHORT_PREFIX.'portfolio_categories',
									'value' => $portfolio_root_cat
								);
							}
							$tmp_q = new WP_Query($args);
							if($tmp_q->post_count) {
								$portfolio_root_page_id=$tmp_q->posts[0]->ID;
							} else {
								$portfolio_root_page_id=false;
							}
							wp_reset_postdata();
							if($portfolio_root_page_id) {
								if($portfolio_root_cat) {
									$tmp_q = new WP_Query(array(
										'post_type' => 'portfolio',
										'posts_per_page' => -1,
										'portfolio-type' => $portfolio_root_cat_slug
									));
									$portfolio_count=$tmp_q->post_count;
									wp_reset_postdata();
								} else {
									$portfolio_count=wp_count_posts( 'portfolio');
									$portfolio_count=$portfolio_count->publish;
								}
								?>
								<?php _e('All', 'om_theme'); ?><span class="count"><?php echo $portfolio_count ?>
								</span></a></li><?php
							}
						?>
						<?php
							foreach($categories as $category) {
								if(!$category->count)
									continue;
								echo '<li><a href="'.get_term_link($category, 'portfolio-type').'">'.$category->name.'</a></li>';
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
					<!-- /Categories -->
				<?php } ?>
				
				<?php echo category_description(); ?>
		<section class="content">
		<button class="scroll-up"></button>
		<a href="/" class="close"></a>
		<div class="content-inner">
				<?php
          if ( current_user_can( 'edit_post', $post->ID ) )
      	    edit_post_link( __('edit', 'om_theme'), '<div class="edit-post-link">[', ']</div>' );
    		?>
				<!--<div class="tbl-bottom">
					<div class="tbl-td">
						<h1 class="page-h1"><?php //the_title(); ?></h1>
					</div>
					<?php //if(get_option(OM_THEME_PREFIX . 'show_breadcrumbs') == 'true') { ?>
						<div class="tbl-td">
							<?php //om_breadcrumbs(get_option(OM_THEME_PREFIX . 'breadcrumbs_caption')) ?>
						</div>
					<?php //} ?>
				</div>-->				
				
						<?php echo get_option(OM_THEME_PREFIX . 'code_after_portfolio_h1'); ?>
						
						<?php if( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						
							<!-- Portfolio Item -->
							
								
									<?php the_content(); ?>
	
									<?php //the_terms($post->ID, 'portfolio-type', '<p><b>'.__('Categories:','om_theme').'</b> ', ', ', '</p>'); ?>
								
								<?php
									$type = get_post_meta($post->ID, OM_THEME_SHORT_PREFIX.'portfolio_type', true);
									$size = get_post_meta($post->ID, OM_THEME_SHORT_PREFIX.'portfolio_media_size', true);
									if($type != 'custom') {
										?>
										
											
												<?php
													if($type == 'image') {
														//echo om_get_post_image($post->ID, 'page-full-2');
													} elseif($type == 'slideshow-m') {
														om_slides_gallery_m($post->ID);
													} elseif($type == 'slideshow') {
														om_slides_gallery($post->ID, 'page-full-2');
													} elseif($type == 'audio') {
														om_audio_player($post->ID, false);
													} elseif($type == 'video') {
														if($embed = get_post_meta($post->ID, OM_THEME_SHORT_PREFIX.'video_embed', true))
															echo '<div class="video-embed">'.$embed.'</div>';
														else
															om_video_player($post->ID, false);
													}
												?>
											
										
										<?php
									}
								?>
							
							<!-- /Portfolio Item -->
							
						<?php endwhile; endif; ?>
						
						<?php echo get_option(OM_THEME_PREFIX . 'code_after_portfolio_content'); ?>

						<?php
							$prev_next=get_option(OM_THEME_PREFIX . 'portfolio_prev_next');
							if($prev_next != 'none') {
								$in_same_cat=($prev_next == 'category');
								$sort=get_option(OM_THEME_PREFIX . 'portfolio_sort');
								
								if($sort == 'date_asc' || $sort == 'date_desc')
									$orderby='post_date';
								else
									$orderby='menu_order';

								if($sort == 'date_desc') {
									if( om_get_previous_post($in_same_cat, '', 'portfolio-type', $orderby) || om_get_next_post($in_same_cat, '', 'portfolio-type', $orderby) ) {
										?>
										<div class="navigation-prev-next">
											<div class="navigation-prev"><?php om_next_post_link('%link', '%title', $in_same_cat, '', 'portfolio-type', $orderby) ?></div>
											<div class="navigation-next"><?php om_previous_post_link('%link', '%title', $in_same_cat, '', 'portfolio-type', $orderby) ?></div>
											<div class="clear"></div>
										</div>
										<?php
									}
								} else {
									if( om_get_previous_post($in_same_cat, '', 'portfolio-type', $orderby) || om_get_next_post($in_same_cat, '', 'portfolio-type', $orderby) ) {
										?>
										<div class="navigation-prev-next">
											<?php om_previous_post_link('%link', '', $in_same_cat, '', 'portfolio-type', $orderby) ?>
											<?php om_next_post_link('%link', '', $in_same_cat, '', 'portfolio-type', $orderby) ?>
											<div class="clear"></div>
										</div>
										<?php
									}
								}
							}
						?>							

						<!-- /Content -->

							


		<?php
			$fb_comments=false;
			if(function_exists('om_facebook_comments') && get_option(OM_THEME_PREFIX . 'fb_comments_portfolio') == 'true') {
					if(get_option(OM_THEME_PREFIX . 'fb_comments_position') == 'after')
						$fb_comments='after';
					else
						$fb_comments='before';
			}
		?>
		
		<?php if($fb_comments == 'before') { om_facebook_comments();	} ?>
				
		<?php if(get_option(OM_THEME_PREFIX . 'hide_comments_portfolio') != 'true') : ?>
			<?php comments_template('',true); ?>
		<?php endif; ?>
		
		<?php if($fb_comments == 'after') { om_facebook_comments();	} ?>
		
		<!-- /Content -->
		
		<div class="clear anti-mar">&nbsp;</div>

	<?php
		$random_items=get_option(OM_THEME_PREFIX . 'portfolio_single_show_random');
		$title=get_option(OM_THEME_PREFIX . 'portfolio_random_title');
		if($title===false)
			$title=__('Random Items','om_theme');
	?>
	<?php if($random_items && $title) { ?>
		<!-- Related portfolio items -->
		<div class="block-full bg-color-main">
			<div class="block-inner">
				<div class="widget-header"><?php echo $title ?></div>
			</div>
		</div>
		
		<div class="clear anti-mar">&nbsp;</div>
	<?php } ?>
			
	<?php if($random_items == 'true') { ?>
	
		<div class="portfolio-wrapper">
			<?php 
			$query = new WP_Query( array (
				'post_type' => 'portfolio',
				'orderby' => 'rand',
				'posts_per_page' => 3
			));
			
			while ( $query->have_posts() ) : $query->the_post(); ?>
			
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
			
				<div <?php post_class('portfolio-thumb bg-color-main isotope-item block-3 show-hover-link '.$term_list); ?> id="post-<?php the_ID(); ?>">
					<div class="pic block-h-2">
						<?php if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) { ?>
						<?php the_post_thumbnail('portfolio-thumb'); ?>
						<?php } else { echo '&nbsp'; } ?>
					</div>
					<div class="desc block-h-1">
						<div class="title"><?php the_title(); ?></div>
						<div class="tags"><?php the_terms($post->ID, 'portfolio-type', '', ', ', ''); ?></div>
					</div>
					<a href="<?php echo $link ?>" class="link"><span class="after"></span></a>
				</div>
			<?php endwhile; ?>
			
			<?php wp_reset_postdata(); ?>
			
			<div class="clear"></div>
		</div>
		<!-- /Related portfolio items -->
		
		<div class="clear anti-mar">&nbsp;</div>
				
	<?php } elseif($random_items == '9x') { ?>
	
		<div class="portfolio-wrapper">
			<?php 
			$query = new WP_Query( array (
				'post_type' => 'portfolio',
				'orderby' => 'rand',
				'posts_per_page' => 9
			));
			
			while ( $query->have_posts() ) : $query->the_post(); ?>
			
				<?php
					$link=get_post_meta($post->ID, OM_THEME_SHORT_PREFIX.'portfolio_custom_link', true);
					if(!$link)
						$link=get_permalink();
				?>
			
				<a href="<?php echo $link ?>" class="portfolio-small-thumb bg-color-main block-1 block-h-1 show-hover-link">
				<?php if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) { ?>
				<?php the_post_thumbnail('portfolio-q-thumb'); ?>
				<?php } else { echo '&nbsp'; } ?><span class="after"></span></a>
					
			<?php endwhile; ?>
			
			<?php wp_reset_postdata(); ?>
			
			<div class="clear"></div>
		</div>
		<!-- /Related portfolio items -->
		
		<div class="clear anti-mar">&nbsp;</div>
				
	<?php } ?>
	</div>
<footer>
			<div class="copy">BELARUS, MINSK +375 17 328 04 09, info@banderlog.by</div>
			<img src="<?php echo get_template_directory_uri(); ?>/images/footer-logo.png" alt="">
</footer> 	
<?php get_footer(); ?>