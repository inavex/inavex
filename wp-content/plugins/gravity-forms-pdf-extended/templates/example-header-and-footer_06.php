<?php

/**
 * Debugging can be done by adding &html=1 to the end of the URL when viewing the PDF
 * We no longer need to access the file directly.
 */ 
if(!class_exists('RGForms') ) {
	/* Accessed directly */
    exit;
}

/** 
 * Set up the form ID and lead ID, as well as we want page breaks displayed. 
 * Form ID and Lead ID can be set by passing it to the URL - ?fid=1&lid=10
 */
 PDF_Common::setup_ids();

/**
 * Load the form data, including the custom style sheet which looks in the plugin's theme folder before defaulting back to the plugin's file.
 */
$form = RGFormsModel::get_form_meta($form_id);
$stylesheet_location = (file_exists(PDF_TEMPLATE_LOCATION.'template.css')) ? PDF_TEMPLATE_URL_LOCATION.'template.css' : PDF_PLUGIN_URL .'styles/template.css' ;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
   
    <title>Gravity Forms PDF Extended</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
	<body>
        <?php	

        foreach($lead_ids as $lead_id) {

            $lead = RGFormsModel::get_lead($lead_id);
            do_action("gform_print_entry_header", $form, $lead);
            $form_data = GFPDFEntryDetail::lead_detail_grid_array($form, $lead);
			/*
			 * Add &data=1 when viewing the PDF via the admin area to view the $form_data array
			 */
			PDF_Common::view_data($form_data);			
						
			/* get all the form values */
			/*$date_created		= $form_data['date_created'];
			
			$first_name 		= $form_data['1.Name']['first'];
			$last_name 			= $form_data['1.Name']['last'];*/			
		
			/* format the template */						
			?>                   
           
    <!-- defines the headers/footers - this must occur before the headers/footers are set -->

<!--mpdf

<htmlpageheader name="myHTMLHeader1">
<table width="100%" style="border-bottom: 1px solid #000000; vertical-align: bottom; font-family: serif; font-size: 9pt; color: #000088;"><tr>
<td width="50%">Left header p <span style="font-size:14pt;">{PAGENO}</span></td>
<td width="50%" style="text-align: right;"><span style="font-weight: bold;">myHTMLHeader1</span></td>
</tr></table>
</htmlpageheader>

<htmlpagefooter name="myFooter1">
<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;
    color: #000000; font-weight: bold; font-style: italic;"><tr>
    <td width="33%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td>
    <td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td>
    <td width="33%" style="text-align: right; ">My document</td>
    </tr></table>
</htmlpagefooter>

mpdf-->

<!-- set the headers/footers - they will occur from here on in the document -->
<!--mpdf
<sethtmlpageheader name="myHTMLHeader1" value="on" show-this-page="1" />
<sethtmlpagefooter name="myFooter1" value="on" show-this-page="1" />
mpdf-->

           
<div>
	<img src="<?php echo PDF_PLUGIN_DIR; ?>/images/gravityformspdfextended.jpg" width="311" height="110"  />
    <h2>Basic Headers</h2>
        
    <p>Nulla felis erat, imperdiet eu, ullamcorper non, nonummy quis, elit. Suspendisse potenti. Ut a eros at ligula vehicula pretium. Maecenas feugiat pede vel risus. Nulla et lectus. Fusce eleifend neque sit amet erat. Integer consectetuer nulla non orci. Morbi feugiat pulvinar dolor. Cras odio. Donec mattis, nisi id euismod auctor, neque metus pellentesque risus, at eleifend lacus sapien et risus. Phasellus metus. Phasellus feugiat, lectus ac aliquam molestie, leo lacus tincidunt turpis, vel aliquam quam odio et sapien. Mauris ante pede, auctor ac, suscipit quis, malesuada sed, nulla. Integer sit amet odio sit amet lectus luctus euismod. Donec et nulla. Sed quis orci. </p>
    <pagebreak />
    
    <h2>Basic Headers</h2>
    <p>Nulla felis erat, imperdiet eu, ullamcorper non, nonummy quis, elit. Suspendisse potenti. Ut a eros at ligula vehicula pretium. Maecenas feugiat pede vel risus. Nulla et lectus. Fusce eleifend neque sit amet erat. Integer consectetuer nulla non orci. Morbi feugiat pulvinar dolor. Cras odio. Donec mattis, nisi id euismod auctor, neque metus pellentesque risus, at eleifend lacus sapien et risus. Phasellus metus. Phasellus feugiat, lectus ac aliquam molestie, leo lacus tincidunt turpis, vel aliquam quam odio et sapien. Mauris ante pede, auctor ac, suscipit quis, malesuada sed, nulla. Integer sit amet odio sit amet lectus luctus euismod. Donec et nulla. Sed quis orci. </p>
    
    <!-- Note the html_ prefix when referencing an HTML header using one of the pagebreaks -->
    <pagebreak />
    
    <h2>Basic Headers</h2>
    <p>Nulla felis erat, imperdiet eu, ullamcorper non, nonummy quis, elit. Suspendisse potenti. Ut a eros at ligula vehicula pretium. Maecenas feugiat pede vel risus. Nulla et lectus. Fusce eleifend neque sit amet erat. Integer consectetuer nulla non orci. Morbi feugiat pulvinar dolor. Cras odio. Donec mattis, nisi id euismod auctor, neque metus pellentesque risus, at eleifend lacus sapien et risus. Phasellus metus. Phasellus feugiat, lectus ac aliquam molestie, leo lacus tincidunt turpis, vel aliquam quam odio et sapien. Mauris ante pede, auctor ac, suscipit quis, malesuada sed, nulla. Integer sit amet odio sit amet lectus luctus euismod. Donec et nulla. Sed quis orci. </p>
</div>
            <?php
        }

        ?>
	</body>
</html>