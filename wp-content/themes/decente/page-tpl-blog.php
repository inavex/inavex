<?php

/**
 * Template Name: Blog (latest posts)
 * This page template shows the latest posts.
 *
 * @package FrameShift
 * @since 1.0
 */
 
get_header();

// Set up post data
the_post();

// Save parent page ID
$parent_id = get_the_ID(); ?>

<div id="main-wrap" class="wrap">	

	<?php	
	    // Action hook to add content before main
	    do_action( 'frameshift_main_before' );
	    
	    // Open layout wrap
	    frameshift_layout_wrap( 'main-middle-wrap' );	    
	?>
	
	<div id="main-middle" class="row">
	
		<div id="main-middle-title" class="<?php echo frameshift_get_span( 'full' ); ?>">	
		
			<?php
            	// Action hook before archive title
                do_action( 'frameshift_archive_title_before' );
            ?>		
    
			<h1 class="post-title">
				<?php
                    // Action hook portfolio title inside
			   		do_action( 'frameshift_post_title_inside' );
					echo get_the_title( $parent_id );
                ?>
			</h1>
			
			<?php
				// Get post content
				$post = get_post( $parent_id );
			
				// Display post content like category description
				if( ! empty( $post->post_content ) )
				    echo '<div class="category-description clearfix">' . apply_filters( 'the_content', $post->post_content ) . '</div>';
				    
				// Action hook after archive title
				do_action( 'frameshift_archive_title_after' );
			?>
			
		</div><!-- #main-middle-title -->
	
		<?php
	    	// Set class of #content div depending on active sidebars
	    	$content_class = ( is_active_sidebar( 'sidebar-archive' ) || is_active_sidebar( 'sidebar' ) ) ? frameshift_get_span( 'big' ) : frameshift_get_span( 'full' );
	    	
	    	// Set class depending on individual page layout
	    	if( get_post_meta( $parent_id, '_layout', true ) == 'full-width' )
	    		$content_class = frameshift_get_span( 'full' );
		?>
	
	    <div id="content" class="<?php echo $content_class; ?>">
	    
	    	<?php
	    		// Make sure paging works
				
				if ( get_query_var( 'paged' ) ) {
                        $paged = get_query_var( 'paged' );
                } elseif ( get_query_var( 'page' ) ) {
                        $paged = get_query_var( 'page' );
                } else {
                        $paged = 1;
                }
				
				// Set args for blog custom query
	    		$args = array(
	    			'cat'			 => -0,
				    'posts_per_page' => get_option( 'posts_per_page' ),
				    'paged'			 => $paged
				);
				
				$args = apply_filters( 'frameshift_blog_query_args', $args );
				
				$blog_query = new WP_Query( $args );
	    	
	    		if ( $blog_query->have_posts() ) { ?>
				
					<div class="row">
	    			
	    			    <?php
	    			    	// Create loop counter
					    	$counter = 0;
	    			    	
	    			    	while ( $blog_query->have_posts() ) {
							
								// Increase loop counter
	    						$counter++;
	    			    	
	    			    		$blog_query->the_post();
	    			    				
	    			        	/* Include the Post-Format-specific template for the content.
					    		 * If you want to overload this in a child theme then include a file
					    		 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					    		 */
					    		get_template_part( 'loop', get_post_format() );
					    	
					    	} // endwhile have_posts()
	    			    ?>
	    			
	    			</div><!-- .row --><?php
	    			
	    			frameshift_pagination( $blog_query->max_num_pages );
	    			    		
	    		} else { 
	    		
	    			get_template_part( 'loop', 'no' );
	    		
	    		} // endif have_posts() ?>
	    
	    </div><!-- #content -->
	    
	    <?php get_sidebar(); ?>
	
	</div><!-- #main-middle -->
	
	<?php	    
	    // Close layout wrap
	    frameshift_layout_wrap( 'main-middle-wrap', 'close' );
	    
	    // Action hook to add content after main
	    do_action( 'frameshift_main_after' );	
	?>	

</div><!-- #main-wrap -->

<?php get_footer(); ?>