<?php
/**
 * The default template for displaying main content.
 *
 * @package FrameShift
 * @since 1.0
 */
 
global $counter, $parent_id;
		
/**
 * Create post classes for different layouts.
 * Find frameshift_archive_post_class() in
 * /lib/functions/general.php
 */

$post_class = frameshift_archive_post_class( $counter, $parent_id );

?>

<div <?php post_class( $post_class ); ?>>
    
    <?php
    	// Action hook before post title
        do_action( 'frameshift_post_title_before' );
    ?>
    
    <h2 class="post-title">
    	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
    		<?php
    			// Action hook post title inside
        		do_action( 'frameshift_post_title_inside' );
    			the_title();
    		?>
    	</a>
    </h2>
    
    <?php
        // Action hook after post title
        do_action( 'frameshift_post_title_after' );
        
        // Action hook before post content
        do_action( 'frameshift_post_content_before' );
    ?>
    	
    <div class="post-teaser clearfix">
    	<?php frameshift_the_excerpt(); ?>
    </div>
    
    <?php
    	// Action hook after post content
    	do_action( 'frameshift_post_content_after' );
    ?>
    <div class="share-container">
        <!-- Put this script tag to the <head> of your page -->
        <script type="text/javascript" src="//vk.com/js/api/openapi.js?105"></script>

        <script type="text/javascript">
            VK.init({apiId: 4037111, onlyWidgets: true});
        </script>

        <!-- Put this div tag to the place, where the Like block will be -->
        <div id="vk_like" style="float: left;"></div>
        <script type="text/javascript">
            VK.Widgets.Like("vk_like", {type: "button", height: 24});
        </script>

        <div id="fb-root"></div>
        <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=251889331631087";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>

        <div class="fb-like" style="float: left;margin-right: 30px;margin-top: 3px;" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>

        <span></span>
    <div class="share42init" style="float: left;"></div>
    <script type="text/javascript" src="/wp-content/themes/inavex/js/share/share42.js"></script>
        <div class="cl" style="clear: both;"></div>
    </div>
</div><!-- .post-<?php the_ID(); ?> -->
