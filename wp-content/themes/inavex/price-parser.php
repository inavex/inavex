<?php
/**
 * Template Name: Страница - Парсер цен
 */

get_header();

// Get parent page ID
$parent_id = get_the_ID(); ?>

    <div id="main-wrap" class="wrap">

        <?php
        // Action hook to add content before main
        do_action( 'frameshift_main_before' );

        // Open layout wrap
        frameshift_layout_wrap( 'main-middle-wrap' );
        ?>

        <div id="main-middle" class="row">

            <?php
            // Set class of #content div depending on active sidebars
            $content_class = ( is_active_sidebar( 'sidebar-page' ) || is_active_sidebar( 'sidebar' ) ) ? frameshift_get_span( 'big' ) : frameshift_get_span( 'full' );

            // Set class depending on individual page layout
            if( get_post_meta( $parent_id, '_layout', true ) == 'full-width' )
                $content_class = frameshift_get_span( 'full' );
            ?>

            <div id="content" class="<?php echo $content_class; ?>">

            <div <?php post_class( 'clearfix' ); ?>>

                <?php
                // Action hook before post title
                do_action( 'frameshift_post_title_before' );
                ?>

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

            </div><!-- .post-<?php the_ID(); ?> -->


	            <form action="#" method="GET" id="parserForm">
		            <label for="date-now">Артикул</label>
		            <div class="">
			            <input name="artikul" id="artikul" type="text" value="" class="medium span3" tabindex="1">
		            </div>
		            <a href="#" class="btn btn-large" id="submitParser" style="line-height: 1.15em;" />Поиск</a>
	            </form>

	            <div id="parseResult">

	            </div>


	            <script>
		            jQuery(document).ready(function ($) {

			            $("#submitParser").click(function() {

				            var url = "/wp-content/themes/inavex/parser/parser.php";

				            $.ajax({
					            type: "GET",
					            url: url,
					            dataType: 'json',
					            data: $("#parserForm").serialize(), // serializes the form's elements.
					            success: function(data) {

						            $('#parseResult div').remove();

						            $('<div>Exist: '+data.exist+'</div>').appendTo('#parseResult');
						            $('<div>Autopiter: '+data.autopiter+'р.</div>').appendTo('#parseResult');
						            $('<div>Autodoc: '+data.autodoc+'р.</div>').appendTo('#parseResult');

					            }
				            });

				            return false;

			            });

		            });


	            </script>


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