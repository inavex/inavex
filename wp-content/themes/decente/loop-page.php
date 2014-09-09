<?php
/**
 * The default template for displaying page content in page.php
 *
 * @package FrameShift
 * @since 1.0
 */
    	
// Set up post data
the_post();

?>
    		
<div <?php post_class( 'clearfix' ); ?>>
    
    <?php
    	// Action hook before post title
        do_action( 'frameshift_post_title_before' );
    ?>
    
    <h1 class="post-title">
    	<?php
    		// Action hook post title inside
       		do_action( 'frameshift_post_title_inside' );
    		the_title();
    	?>
    </h1>
    
    <?php
        // Action hook after post title
        do_action( 'frameshift_post_title_after' );
        
        // Action hook before post content
        do_action( 'frameshift_post_content_before' );
    ?>
    	
    <div class="post-teaser clearfix">
    	<?php the_content(); ?>
    </div>
    
    <?php
    	// Action hook after post content
    	do_action( 'frameshift_post_content_after' );
    ?>
    <div class="social-container">
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

        <div class="fb-like" style="float: left;margin-right: 30px;margin-top: 3px;" data-href="<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>

        <div class="share42init" style="float: left;"></div>
        <script type="text/javascript" src="/wp-content/themes/inavex/js/share/share42.js"></script>
        <div class="cl" style="clear: both;"></div>
    </div>
    			
</div><!-- .post-<?php the_ID(); ?> -->