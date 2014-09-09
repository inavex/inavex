<div id="sidebar">
<ul>

<!-- The author description is hidden. Uncomment to use it.

	<li><h2><?php _e('Автор'); ?></h2>
		<ul>
			<li>A little bit about yourself</li>
		</ul>
	</li>

 -->

<!-- The calendar is hidden. Uncomment to use it.
	<li><h2><?php _e('Календарь'); ?></h2>
		<ul>
			<li><?php get_calendar(); ?></li>
		</ul>
	</li>
 -->

	<li><h2><?php _e('Поиск'); ?></h2>
	<ul>
		<li class="bulletless"><?php include (TEMPLATEPATH . '/searchform.php'); ?></li>
	</ul>
	</li>

<!-- 	<?php wp_list_pages('depth=3&title_li=<h2>' . __('Страницы') . '</h2>' ); ?> -->

	<li><h2><?php _e('Категории'); ?></h2>
		<ul>
			<?php wp_list_cats('sort_column=name&optioncount=1&hierarchical=0'); ?>
		</ul>
	</li>

	<li><h2><?php _e('Архивы'); ?></h2>
		<ul>
			<?php wp_get_archives('type=monthly'); ?>
		</ul>
	</li>

	<?php get_links_list(); ?>

	<li><h2><?php _e('Мета'); ?></h2>
		<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
			<li><a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional"><?php _e('Валидный'); ?> <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li>

			<?php wp_meta(); ?>
		</ul>
	</li>

</ul>
</div>
