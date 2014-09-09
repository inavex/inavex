<?php
/**
 * Built theme footer with widget area,
 * and wp_footer(). The widget area is called
 * ffooter because 'footer' causes issues.
 *
 * @package FrameShift
 * @since 1.0
 */

// Action hook before footer
do_action( 'frameshift_footer_before' );

// Display footer widget area if active

if( is_active_sidebar( 'ffooter' ) ) {

    // Open layout wrap			
    frameshift_layout_wrap( 'footer-wrap' ); ?>
    
    <div id="footer" class="clearfix">
    	<?php dynamic_sidebar( 'ffooter' ); ?>
    </div><!-- #footer--><?php
    
    // Close layout wrap			
    frameshift_layout_wrap( 'footer-wrap', 'close' );

} // endif is_active_sidebar()

// Action hook after footer
do_action( 'frameshift_footer_after' ); ?>

<div id="subfooter-wrap" class="wrap">
    <div class="container footer-menu">
        <?php wp_nav_menu( array( 'theme_location' => 'footer-menu' ) ); ?>
    </div>
    <div class="container">
        <div class="address-footer span4">
            г. Москва, Ореховый б-р, д.8-23.<br>
            (м.тел.) 8-916-8368793 <br>(тел./факс) 8-495-3929426
        </div>
        <div class="span5 our-specialists" style="margin-left: 60px;">
            <a href="http://minjust.ru/ru/node/2229" target="_blank" rel="nofollow" style="color: #fff;margin-top: -10px;">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/minjust_0.png" alt="" style="float: left;
                                                                                                        height: 90px;
                                                                                                        margin-right: 20px;
                                                                                                        border: 4px solid #4E4E4E;"/>
            Наши специалисты включены в государственный реестр экспертов-техников Министерства юстиции РФ</a>
        </div>
        <div class="social-icons">
            <!--<a href="http://new.inavex.ru/feed/" target="_blank" title="Subscribe to RSS" class="social-icon social-icon-rss"><img src="http://new.inavex.ru/wp-content/themes/decente/images/icons/social/rss.png" alt=""></a>-->
            <a href="http://vk.com/club25703701" target="_blank" title="Наша группа Вконтакте" class="social-icon"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/vkontakte.png" alt="" style="vertical-align: middle;margin: -2px 10px 0 0;"><span>Наша группа Вконтакте</span></a>
        </div><!-- .social-icons -->	</div><!-- .container -->
</div>

</div><!-- #outer -->

<?php
    wp_footer();
?>

</body>
</html>