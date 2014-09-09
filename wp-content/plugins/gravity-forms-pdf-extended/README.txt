=== Plugin Name ===
Contributors: blueliquiddesigns
Donate link: http://www.gravityformspdfextended.com
Tags: gravity, forms, pdf, automation, attachment
Requires at least: 3.4
Tested up to: 3.5.2
Stable tag: 3.1.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Gravity Forms PDF Extended allows you to save/view/download a PDF from the front- and back-end, and automate PDF creation on form submission. 

== Description ==

As of Gravity Forms PDF Extended v3.0.0 we have removed the DOMPDF package from our plugin and integrated the more advanced mPDF system. Along with a new HTML to PDF generator, we've rewritten the entire plugin's base code to make it more user friendly to both hobbyists and rock star web developers. Configuration time is cut in half and advanced features like adding security features is now accessible to users who have little experience with PHP.

**Features**

* Save PDF File on user submission of a Gravity Form so it can be attached to a notification
* Customise the PDF template without affecting the core Gravity Form Plugin
* Multiple PDF Templates
* Custom PDF Name
* Output individual form fields in the template - like MERGETAGS.
* View and download a PDF via the administrator interface
* Simple function to output PDF via template / plugin
* Works with Gravity Forms Signature Add-On

**PDF Features**

Along with the above features, the new PDF features include:

* Language Support - almost all languages are supported including RTL (right to left) languages like Arabic and Hebrew and CJK languages - Chinese, Japanese and Korean.
* HTML Page Numbering
* Odd and even paging with mirrored margins (most commonly used in printing).
* Nested Tables
* Text-justification and hyphenation
* Table of Contents
* Index
* Bookmarks
* Watermarks
* Password protection
* UTF-8 encoded HTML
* Better system resource handling

**Server Requirements**

1. PHP 5+
2. MB String
3. GD Library (optional)
4. RAM:	Recommended: 128MB. Minimum: 64MB.

**Software Requirements**

1. [Purchase and install Gravity Forms](https://www.e-junkie.com/ecom/gb.php?cl=54585&c=ib&aff=235154)
2. Wordpress 3.4+
3. Gravity Forms 1.6.9+

**Documentation and Support**

To view the Development Documentation head to [http://www.gravityformspdfextended.com/documentation/](http://www.gravityformspdfextended.com/documentation/). If you need support with the plugin please post a topic in our [support forums](http://gravityformspdfextended.com/support/gravity-forms-pdf-extended/).

== Installation ==

1. Upload this plugin to your website and activate it
2. Create a form in Gravity Forms and configure notifications
3. Get the Form ID and follow the steps below in [the configuration section](http://gravityformspdfextended.com/documentation-v3-x-x/installation-and-configuration/)
4. Modify the PDF template file ([see the advanced templating section in the documentation](http://gravityformspdfextended.com/documentation-v3-x-x/templates/)) inside your active theme's PDF_EXTENDED_TEMPLATES/ folder.


== Frequently Asked Questions ==

All FAQs can be [viewed on the Gravity Forms PDF Extended website](http://gravityformspdfextended.com/faq/category/developers/).  

== Screenshots ==

1. View PDF from the Gravity Forms entries list.
2. View or download the PDF from a Gravity Forms entry.

== Changelog ==

= 3.1.4 =
* Bug - Fixed issue with plugin breaking website's when the Gravity Forms plugin wasn't activated.
* Housekeeping - The plugin now only supports Gravity Forms 1.7 or higher and Wordpress 3.5 or higher.
* Housekeeping - PDF template files can no longer be accessed directly. Instead, add &amp;html=1 to the end of your URL when viewing a PDF.
* Extension - Added additional filters to allow the lead ID and notifications to be overridden.

= 3.1.3 =
* Feature - Added signature_details_id to $form_data array which maps a signatures field ID to the array.
* Extension - Added pre-PDF generator filter for use with extensions.
* Bug - Fixed issue with quotes in entry data breaking custom templates.
* Bug - Fixed issue with the plugin not correctly using the new default configuration template, if set.
* Bug - Fixed issue with signature not being removed correctly when only testing with file_exists(). Added second is_dir() test.
* Bug - Fixed issue with empty signature field not displaying when option 'default-show-empty' is set.
* Bug - Fixed initialisation prompt issue when the MPDF package wasn't unpacked.

= 3.1.2 =
* Feature - Added list array, file path, form ID and lead ID to $form_data array in custom templates
* Bug - Fixed initialisation prompt issue when updating plugin
* Bug - Fixed window.open issue which prevented a new window from opening when viewing a PDF in the admin area
* Bug - Fixed issue with product dropdown and radio button data showing the value instead of the name field.
* Bug - Fixed incorrect URL pointing to signature in $form_data

= 3.1.1 =
* Bug - Users whose server only supports FTP file manipulation using the WP_Filesystem API moved the files into the wrong directory due to FTP usually being rooted to the Wordpress home directory. To fix this the plugin attempts to determine the FTP directory, otherwise assumes it is the WP base directory. 
* Bug - Initialisation error message was being called but the success message was also showing. 

= 3.1.0 =
* Feature - Added defaults to configuration.php which allows users to define the default PDF settings for all Gravity Forms. See the [installation and configuration documentation](http://gravityformspdfextended.com/documentation-v3-x-x/installation-and-configuration/#default-configuration-options) for more details. 
* Feature - Added three new configuration options 'default-show-html', 'default-show-empty' and 'default-show-page-names' which allow different display options to the three default templates. See the [installation and configuration documentation](http://gravityformspdfextended.com/documentation-v3-x-x/installation-and-configuration/#default-template-only) for more details.
* Feature - Added filter hooks 'gfpdfe_pdf_name' and 'gfpdfe_template' which allows developers to further modify a PDF name and template file, respectively, outside of the configuration.php. This is useful if you have a special case naming convention based on user input. See [http://gravityformspdfextended.com/filters-and-hooks/](http://gravityformspdfextended.com/filters-and-hooks/) for more details about using these filters.
* Feature - Custom font support. Any .ttf font file added to the PDF_EXTENDED_TEMPLATE/fonts/ folder will be automatically installed once the plugin has been initialised. Users also have the option to just initialise the fonts via the settings page. See the [font/language documentation ](http://gravityformspdfextended.com/documentation-v3-x-x/language-support/#installing-fonts) for details.
* Compatability - Use Gravity Forms get_upload_root() and get_upload_url_root() instead of hard coding the signature upload directory in pdf-entry-detail.php
* Compatability - Changed depreciated functions get_themes() and get_theme() to wp_get_theme() (added in Wordpress v3.4). 
* Compatability - The plugin now needs to be initialised on fresh installation and upgrade. This allows us to use the WP_Filesystem API for file manipulation.
* Compatability - Automatic copying of PDF_EXTENDED_TEMPLATE folder on a theme change was removed in favour of a user prompt. This allows us to take advantage of the WP_Filesystem API.
* Compatability - Added Wordpress compatibility checker (minimum now 3.4 or higher).
* Bug - Removed ZipArchive in favour of Wordpress's WP_Filesystem API unzip_file() command. Some users reported the plugin would stop their entire website working if this extension wasn't installed.
* Bug - Fixed Gravity Forms compatibility checker which wouldn't return the correct response.
* Bug - Fixed minor bug in pdf.php when using static call 'self' in add_filter hook. Changed to class name.
* Bug - Removed PHP notice about $even variable not being defined in pdf-entry-detail.php
* Bug - Prevent code from continuing to excecute after sending header redirect.

= 3.0.2 =
* Backwards Compatibility - While PHP 5.3 has was released a number of years ago it seems a number of hosts do not currently offer this version to their clients. In the interest of backwards compatibility we've re-written the plugin to again work with PHP 5+.
* Signature / Image Display Bug - All URLs have been converted to a path so images should now display correctly in PDF.

= 3.0.1 =
* Bug - Fixed issue that caused website to become unresponsive when Gravity Forms was disabled or upgraded
* Bug - New HTML fields weren't being displayed in $form_data array
* Feature - Options for default templates to disable HTML fields or empty fields (or both)

= 3.0.0 =
As of Gravity Forms PDF Extended v3.0.0 we have removed the DOMPDF package from our plugin and integrated the more advanced mPDF system. Along with a new HTML to PDF generator, we've rewritten the entire plugin's base code to make it more user friendly to both hobbyists and rock star web developers. Configuration time is cut in half and advanced features like adding security features is now accessible to users who have little experience with PHP.

New Features include:

* Language Support - almost all languages are supported including RTL (right to left) languages like Arabic and Hebrew and CJK languages - Chinese, Japanese and Korean.
* HTML Page Numbering
* Odd and even paging with mirrored margins (most commonly used in printing).
* Nested Tables
* Text-justification and hyphenation
* Table of Contents
* Index
* Bookmarks
* Watermarks
* Password protection
* UTF-8 encoded HTML
* Better system resource handling

A new HTML to PDF package wasn't the only change to this edition of the software. We have rewritten the entire configuration system and made it super easy to get the software up and running.

Users will no longer place code in their active theme's functions.php file. Instead, configuration will happen in a new file called configuration.php, inside the PDF_EXTENDED_TEMPLATES folder (in your active theme).

Other changes include
* Improved security - further restrictions were placed on non-administrators viewing template files.
* $form_data array tidied up - images won't be wrapped in anchor tags. 

For more details [view the 3.x.x online documentation](http://gravityformspdfextended.com/documentation-v3-x-x/introduction/).

= 2.2.3 =
* Bug - Fixed mb_string error in the updated DOMPDF package.

= 2.2.2 =
* DOMPDF - We updated to the latest version of DOMPDF - DOMPDF 0.6.0 beta 3.
* DOMPDF - We've enabled font subsetting by default which should help limit the increased PDF size when using DejaVu Sans (or any other font). 

= 2.2.1 =
* Bug - Fixed HTML error which caused list items to distort on PDF

= 2.2.0 =
* Compatibility - Ensure compatibility with Gravity Forms 1.7. We've updated the functions.php code and remove gform_user_notification_attachments and gform_admin_notification_attachments hooks which are now depreciated. Functions gform_pdf_create and gform_add_attachment have been removed and replaced with gfpdfe_create_and_attach_pdf(). See upgrade documentation for details.
* Enhancement - Added deployment code switch so the template redeployment feature can be turned on and off. This release doesn't require redeployment.
* Enhancement - PDF_Generator() variables were getting long and complex so the third variable is now an array which will pass all the optional arguments. The new 1.7 compatible functions.php code includes this method by default. For backwards compatibility the function will still work with the variable structure prior to 2.2.0.
* Bug - Fixed error generated by legacy code in the function PDF_processing() which is located in render_to_pdf.php.
* Bug - Images and stylesheets will now try and be accessed with a local path instead of a URL. It fixes problem where some hosts were preventing read access from a URL. No template changes are required.

= 2.1.1 =
* Bug - Signatures stopped displaying after 2.1.0 update. Fixed issue. 
* Bug - First time install code now won't execute if already have configuration variables in database

= 2.1.0 =

* Feature - Product table can now be accessed directly through custom templates by running GFPDFEntryDetail::product_table($form, $lead);. See documentation for more details.
* Feature - Update screen will ask you if you want to deploy new template files, instead of overriding your modified versions.
* Feature - Product subtotal, shipping and total have been added to $form_data['field'] array to make it easier to work with product details in the custom template.
* Feature - Added two new default template files. One displays field and name in two rows (like you see when viewing an entry in the admin area) and the other removes all styling. See documentation on use.
* Security - Tightened PDF template security so that custom templates couldn't be automatically generated by just anyone. Now only logged in users with the correct privileges and the user who submitted the form (matched against IP) can auto generate a PDF. See documentation on usage.
* Depreciated - Removed form data that was added directly to the $form_data array instead of $form_data['field'] array. Users upgrading will need to update their custom templates if not using field data from the $form_data[�field'] array. If using $form_data['field'] in your custom template this won't affect you.
* Bug - Fixed problem with default template not showing and displaying a timeout error. Removed table tags and replaced with divs that are styled appropriately.
* Bug - The new plugin theme folder will successfully create when upgrading. You won't have to deactivate and reactivate to get it working.
* Bug - some installs had plugins that included the function mb_string which is also included in DOMPDF. DOMPDF will now check if the function exists before creating it.
* Bug - Remove empty signature field from the default template.
* Bug - fixed problem with redirecting to login screen even when logged in while accessing template file through the browser window directly.
* Bug - fixed error where sample template would reimport itself automatically even after deleting it. Will now only reimport if any important changes to template need to be viewed straight after an update.
* Bug - Moved render_to_pdf.php constants to pdf.php so we can use the constants in the core files. Was previously generating an error.
* Housekeeping - Cleaned up core template files, moved functions into classes and added more in-file documentation.
* Housekeeping - moved install/upgrade code from pdf.php to installation-update-manager.php
* Housekeeping - changed pdf-entry-detail.php class name from GFEntryDetail to GFPDFEntryDetail to remove compatibility problems with Gravity Forms.
* Housekeeping - created pdf-settings.php file to house the settings page code.

= 2.0.1 =
* Fixed Signature bug when checking if image file exists using URL instead of filesystem path
* Fixed PHP Constants Notice 

= 2.0.0 =
* Moved templates to active theme folder to prevent custom themes being removed on upgrade
* Allow PDFs to be saved using a custom name
* Fixed WP_Error bug when image/css file cannot be found
* Upgraded to latest version of DOMPDF
* Removed auto-load form bug which would see multiple instances of the example form loaded
* Created a number of constants to allow easier developer modification
* Plugin/Support moved to dedicated website.
* Pro/Business package offers the ability to write fields on an existing PDF.

= 1.2.3 =
* Fixed $wpdb->prepare error

= 1.2.2 =
* Fixed bug with tempalte shipping method MERGETAGS
* Fixed bug where attachment wasn't being sent
* Fixed problem when all_url_fopen was turned off on server and failed to retreive remote images. Now uses WP_HTTP class.

= 1.2.1 =
* Fixed path to custom css file included in PDF template 

= 1.2.0 =
* Template files moved to the plugin's template folder
* Sample Form installed so developers have a working example to modify
* Fixed bug when using WordPress in another directory to the site

= 1.1.0 =
* Now compatible with Gravity Forms Signature Add-On
* Moved the field data functions out side of the Gravity Forms core so users can freely style their form information (located in pdf-entry-detail.php)
* Simplified the field data output
* Fixed bug when using product information

= 1.0.0 =
* First release. 

== Upgrade Notice ==

= 3.1.4 =
Gravity Forms PDF Extended now only supports Gravity Forms 1.7.x and Wordpress 3.5+. 
