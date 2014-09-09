<?php // Do not delete these lines

	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) die ('Пожалуйста, не загружайте эту страницу напрямую.');
	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
?>

			<h2><?php _e('Защищено паролем'); ?></h2>
			<p><?php _e('Введите пароль для просмотра комментариев.'); ?></p>

			<?php return;
	        }
        }

	/* This variable is for alternating comment background */

$oddcomment = 'alt';

?>

<!-- You can start editing here. -->


