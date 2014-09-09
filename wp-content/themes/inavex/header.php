<?php
/**
 * Built theme head with doctype, title
 * custom head, favicon and meta info.
 * 
 * Built header output with top bar,
 * main header section with logo and header right area
 * and main and sub menu.
 *
 * @package FrameShift
 * @since 1.0
 */
 
do_action( 'frameshift_head' );
wp_head();

?>
<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <meta name = "viewport" content = "initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width">
    <script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/fancybox/jquery.fancybox.js?v=2.1.4"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/js/fancybox/jquery.fancybox.css?v=2.1.4" media="screen">
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            jQuery("a[rel='fancybox']").fancybox();
            jQuery('#menu-item-1733').click(function() {
                jQuery.fancybox.open({
                    href : '/okno-obratnoy-svyazi/',
                    type : 'ajax',
                    width : '620px',
                    height : '350px',
                    autoScale : false,
                    autoDimensions : false,
                    modal : false,
                    centerOnScroll : true
                });
            });
        })
    </script>
    <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-29009434-1']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

    </script>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function() {
                try {
                    w.yaCounter21602692 = new Ya.Metrika({id:21602692,
                        webvisor:true,
                        clickmap:true,
                        trackLinks:true,
                        accurateTrackBounce:true});
                } catch(e) { }
            });

            var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () { n.parentNode.insertBefore(s, n); };
            s.type = "text/javascript";
            s.async = true;
            s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else { f(); }
        })(document, window, "yandex_metrika_callbacks");
    </script>
    <noscript><div><img src="//mc.yandex.ru/watch/21602692" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
</head>

<body <?php body_class(); ?>>

<?php do_action( 'frameshift_before' ); ?>

<div class="before-head container">
    <a class="logo" href="/"><strong>Автоэкспертиза и оценка "ИНАВЭКС"</strong> - видим все!!!
        <span style="display: block; font-size: 18px;margin-bottom: -20px;color: #3D3D3D;">
            <?php
            $homePost = get_post('1928');
            echo apply_filters( 'the_content', $homePost->post_content );
            ?></span>
    </a>
    <div class="buttons">
        <?php wp_nav_menu( array( 'theme_location' => 'header-top-menu' ) ); ?>
    </div>
</div>

<div id="outer">

<?php
	// Action hook before header
	do_action( 'frameshift_header_before' );
	
	// Open layout wrap		
    frameshift_layout_wrap( 'header-wrap' ); ?>
        		
    <div id="header" class="clearfix">

        <div id="header-menu">
            <?php wp_nav_menu( array( 'theme_location' => 'header-side-menu' ) ); ?>
        </div>
    
    	<div id="header-left">
    	
    		<?php
    			// Action hook for logo output
    			do_action( 'frameshift_logo' );
    		?>
    		
    	</div><!-- #header-left -->
    	
    	<div id="header-right">
    	
    		<?php
    			// Action hook for header right section
    			do_action( 'frameshift_header_right' );
    		?>
    		
    	</div><!-- #header-right -->
    	
    </div><!-- #header -->

<?php if (is_home()) : ?>
    <div id="main-top-wrap" class="wrap">
        <div class="container">

            <div id="main-top" class="clearfix">

                <ul><?php if ( ! dynamic_sidebar( 'home-widget-area' ) ) : ?><?php endif; ?></ul>

            </div>

        </div>
    </div>
    <div id="author-wrap" class="wrap">
        <div class="container">
            <?php
            $homePost = get_post('1747');
            echo apply_filters( 'the_content', $homePost->post_content );
            ?>
        </div>
    </div>
    <div id="main-gallery" class="wrap">
        <div class="container">
            <div class="span7 primeri">
                <h3>Примеры работ</h3>
                <?php /*echo nggShowGallery(3,'300','250'); */?>
                <a class="prim-link" title="Образец отчета об оценке рыночной стоимости услуг по восстановительному ремонту автомобиля Hyundai Elantra" href="http://inavex.ru/otchet-ob-otsenke/#s20"><img src="http://inavex.ru/wp-content/gallery/otchet-o-svr/otchet-o-svr-01.jpg" alt=""/></a>
                <a class="prim-link" title="Образец отчета об оценке рыночной стоимости автомобиля Тойота Рав 4 для нотариуса." href="http://inavex.ru/otchet-ob-otsenke/#s21"><img src="http://inavex.ru/wp-content/gallery/otchet-ob-otsenke-rs-avtomobilya-dlya-notariusa/otchet-ob-otsenke-rs-avtomobilya-dlya-notariusa-01.jpg" alt=""/></a>
                <a class="prim-link" title="Образец заключения эксперта по судебной автотехнической экспертизе по определению объемов повреждений и стоимости восстановительного ремонта." href="http://inavex.ru/otchet-ob-otsenke/#s22"><img src="http://inavex.ru/wp-content/gallery/zaklyuchenie-sudebnoy-avtotehnicheskoy-ekspertizyi/zaklyuchenie-po-sudebnoy-avtotehnicheskoy-ekspertize-01.jpg" alt=""/></a>
            </div>
            <div id="main-partners" class="span7">
                <h3>Партнеры</h3>
                <?php
                $homePost = get_post('1751');
                echo apply_filters( 'the_content', $homePost->post_content );
                ?>
            </div>
        </div>
    </div>
    <div id="main-reviews" class="wrap">
        <div class="container">
            <h3>Отзывы о нас</h3>
            <div class="b-testimonials">
            <?php

            $reviewShuffle = getRandomReviews();

            foreach ($reviewShuffle as $review):
            ?>

                    <div class="b-testimonial">
                        <div class="b-testimonial__content">
                            <?php echo $review['content']; ?>
                            <span class="b-testimonial__arrow"></span>
                        </div>
                        <div class="b-testimonial__name">
                            <?php echo $review['reviewer_name']; ?>
                        </div>
                    </div>

            <?php endforeach; ?>
                </div>
            <span style="font-size: 12px;color: #777;text-align: right;clear:both; overflow: hidden; float: left;margin: 0 20px;">(Отзывы предоставлены сервисом <a href="http://maps.yandex.ru/org/1130154775/" target="_blank">Яндекс.Отзывы</a> и нашим разделом <a href="/obratnaya-svyaz/">Отзывы о нас</a>)</span>
        </div>
    </div>
<?php endif; ?>
<?php
    
    // Close layout wrap		
    frameshift_layout_wrap( 'header-wrap', 'close' );
	
	// Action hook after header
	do_action( 'frameshift_header_after' );
?>