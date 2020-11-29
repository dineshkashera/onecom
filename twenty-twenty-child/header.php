<?php
/**
 * Header file for the Twenty Twenty WordPress default theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

?><!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

	<head>

		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" >

		<link rel="profile" href="https://gmpg.org/xfn/11">

		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?>>

		<?php
		wp_body_open();
		?>

		<header id="site-header" class="header-footer-group" role="banner">

			<div class="header-inner section-inner">

				<div class="header-titles-wrapper">

					<?php

					// Check whether the header search is activated in the customizer.
					$enable_header_search = get_theme_mod( 'enable_header_search', true );

					if ( true === $enable_header_search ) {

						?>

						<button class="toggle search-toggle mobile-search-toggle" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
							<span class="toggle-inner">
								<span class="toggle-icon">
									<?php twentytwenty_the_theme_svg( 'search' ); ?>
								</span>
								<span class="toggle-text"><?php _e( 'Search', 'twentytwenty' ); ?></span>
							</span>
						</button><!-- .search-toggle -->

					<?php } ?>

					<div class="header-titles">

						<?php
							// Site title or logo.
							twentytwenty_site_logo();

							// Site description.
							twentytwenty_site_description();
						?>

					</div><!-- .header-titles -->

					<button class="toggle nav-toggle mobile-nav-toggle" data-toggle-target=".menu-modal"  data-toggle-body-class="showing-menu-modal" aria-expanded="false" data-set-focus=".close-nav-toggle">
						<span class="toggle-inner">
							<span class="toggle-icon">
								<?php twentytwenty_the_theme_svg( 'ellipsis' ); ?>
							</span>
							<span class="toggle-text"><?php _e( 'Menu', 'twentytwenty' ); ?></span>
						</span>
					</button><!-- .nav-toggle -->

				</div><!-- .header-titles-wrapper -->

				<div class="header-navigation-wrapper">

					<?php
					if ( has_nav_menu( 'primary' ) || ! has_nav_menu( 'expanded' ) ) {
						?>

							<nav class="primary-menu-wrapper" aria-label="<?php esc_attr_e( 'Horizontal', 'twentytwenty' ); ?>" role="navigation">

								<ul class="primary-menu reset-list-style">

								<?php
								if ( has_nav_menu( 'primary' ) ) {

									wp_nav_menu(
										array(
											'container'  => '',
											'items_wrap' => '%3$s',
											'theme_location' => 'primary',
										)
									);

								} elseif ( ! has_nav_menu( 'expanded' ) ) {

									wp_list_pages(
										array(
											'match_menu_classes' => true,
											'show_sub_menu_icons' => true,
											'title_li' => false,
											'walker'   => new TwentyTwenty_Walker_Page(),
										)
									);

								}
								?>

								</ul>

							</nav><!-- .primary-menu-wrapper -->

						<?php
					}

					if ( true === $enable_header_search || has_nav_menu( 'expanded' ) ) {
						?>

						<div class="header-toggles hide-no-js">

						<?php
						if ( has_nav_menu( 'expanded' ) ) {
							?>

							<div class="toggle-wrapper nav-toggle-wrapper has-expanded-menu">

								<button class="toggle nav-toggle desktop-nav-toggle" data-toggle-target=".menu-modal" data-toggle-body-class="showing-menu-modal" aria-expanded="false" data-set-focus=".close-nav-toggle">
									<span class="toggle-inner">
										<span class="toggle-text"><?php _e( 'Menu', 'twentytwenty' ); ?></span>
										<span class="toggle-icon">
											<?php twentytwenty_the_theme_svg( 'ellipsis' ); ?>
										</span>
									</span>
								</button><!-- .nav-toggle -->

							</div><!-- .nav-toggle-wrapper -->

							<?php
						}

						if ( true === $enable_header_search ) {
							?>

							<div class="toggle-wrapper search-toggle-wrapper">

								<button class="toggle search-toggle desktop-search-toggle" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
									<span class="toggle-inner">
										<?php twentytwenty_the_theme_svg( 'search' ); ?>
										<span class="toggle-text"><?php _e( 'Search', 'twentytwenty' ); ?></span>
									</span>
								</button><!-- .search-toggle -->

							</div>

							<?php
						}
						?>

						</div><!-- .header-toggles -->
						<?php
					}
					?>

				</div><!-- .header-navigation-wrapper -->

			</div><!-- .header-inner -->

			
			<?php
			// Output the search modal (if it is activated in the customizer).
			if ( true === $enable_header_search ) {
				get_template_part( 'template-parts/modal-search' );
			}
			?>

		</header><!-- #site-header -->
		<?php 
		if(is_home()){
			$args = array(
					    'post_type'  		=> 'post',
					    'orderby'    		=> 'id',
					    'order'      		=> 'ASC',
					    'posts_per_page' 	=> 5,
					    'meta_query' => array(
					        array(
					            'key'     => 'featured_post',
					            'value'   => 'yes',
					            'compare' => '=',
					        ),
					    ),
					);
			$featured_query = new WP_Query( $args );
			?>
			<div class="featured_list_home">
				<?php 
				// The Loop
				if ( $featured_query->have_posts() ) {
					$i = 1;
				    echo '<div class="fetured_wrap" id="featured_slider">';
				    while ( $featured_query->have_posts() ) {
				        $featured_query->the_post();
				        global $post;
				        $post_id 	=	$post->ID;
				        $title 		= 	get_the_title();
				        $author 	= 	get_the_author();
				        $date 		=	get_the_date();
				        $taxonomy 	= 	'category'; // your taxonomy name
						$termobjs 	= 	wp_get_object_terms( $post_id, $taxonomy );
						$termlist 	= 	array_unique( wp_list_pluck( $termobjs, 'name' ) );
						$featured_img_url = get_the_post_thumbnail_url($post_id,'full'); 
						$viewpost 	=	get_post_meta($post_id,'view_count',true);
						$str_count = ($i < 10) ? 0 . $i : $i;
						?>
						<div class="featured_items" style="background-image: url(<?php echo $featured_img_url;?>)">
						  <div class="inner_wrap">		
							<div class="featured_count">
								<span><?php echo $str_count;?></span> - <span><?php _e( 'Featured', 'twentytwenty' ); ?></span>
							</div>
							<div class="featured_btm">
								<p><?php echo implode(',',$termlist);?></p>
								<p><a href="<?php the_permalink();?>" target="_blank"><?php echo $title;?></a></p>
								
								<ul>
									<li>By <span><?php echo $author ;?></span></li>
									<li><?php echo $date;?></li>
									<li><i class="fa fa-signal"></i><span><?php echo empty($viewpost) ? 0 : $viewpost;?> View</span></li>
								</ul>
								
							</div>
						  </div>
						</div>
					
						<?php
						$i++;
				    }
				    echo '</div>';
				} else {
				    // no posts found
				    echo '<h3 style="height: 350px;padding-top: 110px;"> Featured Post Not Found</h3>';
				}
				/* Restore original Post Data */
				wp_reset_postdata();
				?>
				<div class="hot_post">
					<div class="inner_hot">
						<h3>What's hot!</h3>
					<?php
					$args = array(
							    'post_type'  		=> 'post',
							    'orderby'    		=> 'id',
							    'order'      		=> 'ASC',
							    'posts_per_page' 	=> 5,
							    'meta_query' => array(
							        array(
							            'key'     => 'hot_post',
							            'value'   => 'yes',
							            'compare' => '=',
							        ),
							    ),
							);
					$hot_query = new WP_Query( $args ); 

					if ( $hot_query->have_posts() ) {
						while ( $hot_query->have_posts() ) {
					        $hot_query->the_post();

					        global $post;

					        $post_id 	=	$post->ID;
					        $title 		= 	get_the_title();
					       
					        $date 		=	get_the_date();
					        
							$featured_img_url = get_the_post_thumbnail_url($post_id,'full'); 
							?>
							<div class="hot_items" >
							  <div class="left_sec"><img src="<?php echo $featured_img_url;?>"></div>
							  <div class="right_sec">
							  	<p><a href="<?php the_permalink();?>" target="_blank"><?php echo $title;?></a></p>
							  	<p><?php echo $date;?></p>
							  </div>
							
							</div>
							<?php
						}
				    } else {
					    // no posts found
					    echo '<h3>Hot Post Not Found</h3>';
					}
				/* Restore original Post Data */
				wp_reset_postdata();
							?>
					</div>
				</div>
			</div>
			<!-- featured list home end -->
		<?php
		}
		// Output the menu modal.
		get_template_part( 'template-parts/modal-menu' );
