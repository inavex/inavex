<?php get_header(); ?>
        <div id="page">
          <div id="syndication">
            <!--<div class="feeds">
               <a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Подписаться на этот сайт через RSS'); ?>" class="feed"><?php _e('Записи <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a> &#124; <a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('Подписаться на комментарии через RSS'); ?>">Комментарии RSS</a>
	    </div> -->
          </div>

	<div class="maincol">

		<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
                      	<h2><a href="#top" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<div class="entry" align="justify">

			<?php the_content('Читать далее...'); ?>

			<!--<p class="postinfo">
                               <?php _e('Опубликовано'); ?> <?php the_time('F jS, Y') ?> <?php _e(', '); ?> <?php the_author() ?><br />
                               <?php _e('Написано в рубрике&#58;'); ?> <?php the_category(', ') ?> &#124; <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?> <?php edit_post_link('Редактировать', ' &#124; ', ''); ?>
			</p>-->

			<!--
			<?php trackback_rdf(); ?>
			-->

			</div>
		</div>
		<!--<?php endwhile; ?>

		<?php include (TEMPLATEPATH . '/browse.php'); ?>

		<?php else : ?>

		<div class="post">

			<h2><?php _e('Не найдено'); ?></h2>
			<div class="entry">
                           <p class="notfound"><?php _e('Извините, этого здесь нет.'); ?></p>
			</div>

		</div> 

		<?php endif; ?>-->

	</div>

</div>

<?php get_footer(); ?>
