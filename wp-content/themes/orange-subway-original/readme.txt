Theme Name: Orange Subway
Theme URI: http://www.wpdesigner.com
Description: Orange Subway Wordpress theme created by Small Potato
Version: 1.0.1
Author: Small Potato
Author URI: http://www.wpdesigner.com/

	Released under Creative Commons Attribution-ShareALike 2.5 License.

===========
INSTALLATION
===========

- Unzip the downloaded file. You'll get a folder named "orange-subway"
- Upload the entire "orange-subway" folder to your 'wp-content/themes/" folder
- Login into WordPress administration
- Click on the 'orange-subway" tab
- Click on the "orange-subway" theme thumbnail/screenshot or title

That's it. Go back to the front page of your blog and hit refresh to see your newly installed theme.

=============
CUSTOMIZATION
=============

Unlocking Author Description and Calendar:
- Use a text editor (i.e: Notepad) to open the sidebar.php file and un-comment the author description and calendar areas.
- Remember to also remove the phrase "This...is...hidden."
- If you don't know how to uncomment in HTML, DON'T!!!

To use Page listing in the sidebar:
- Also in the sidebar.php file, find <!-- 	<?php wp_list_pages('depth=3&title_li=<h2>' . __('Pages') . '</h2>' ); ?> -->
- Remove the arrows around it so you'd end up with: <?php wp_list_pages('depth=3&title_li=<h2>' . __('Pages') . '</h2>' ); ?>
- By this theme's default, wp_list_pages will list up to three levels of Page links (depth=3).

=============
TIP
=============

- Use alignleft or alignright to make your images float left or right. For example: <img src="yourimage.gif" class="alignleft">

======
LICENSE
======

For any use or distribution of this theme, you must link back to my website and credit me for the original version of it. Please do not remove or edit my link within this theme.

Creative Commons Attribution-ShareALike 2.5

Read the Commons Deed:
http://creativecommons.org/licenses/by-sa/2.5/

Read the LegalCode (the full license):
http://creativecommons.org/licenses/by-sa/2.5/legalcode
(a copy of the legal code is included with your download in the license.txt file)