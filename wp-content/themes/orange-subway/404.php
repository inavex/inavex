<?php get_header(); ?>

<div id="page">

	<div id="syndication"><div class="feeds">
<a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Подписаться на этот сайт через RSS'); ?>" class="feed"><?php _e('Записи <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a> &#124; <a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('Подписаться на комментарии через RSS'); ?>">Комментарии RSS</a>
	</div></div>

	<div class="maincol">

		<div class="post">

			<h2><?php _e('Не найдено'); ?></h2>
			<div class="entry">
<p class="notfound"><?php _e('Извините, этого здесь нет.'); ?></p>
			</div>

		</div>

	</div>

</div>

<?php get_footer(); ?>
