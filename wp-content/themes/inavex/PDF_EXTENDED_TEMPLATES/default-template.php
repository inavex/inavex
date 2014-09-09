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
 
 global $gfpdf;
 $configuration_data = $gfpdf->get_config_data($form_id);
 
 $show_html_fields = ($configuration_data['default-show-html'] == 1) ? true : false;
 $show_empty_fields = ($configuration_data['default-show-empty']  == 1) ? true : false; 
 $show_page_names = ($configuration_data['default-show-page-names']  == 1) ? true : false;  

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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel='stylesheet' href='<?php echo GFCommon::get_base_url(); ?>/css/print.css' type='text/css' />
    <link rel='stylesheet' href='<?php echo $stylesheet_location; ?>' type='text/css' />
</head>
<body>

<table width="100%">
    <tr>
        <td width="40%"></td>
        <td width="60%" style="font-size: 13px; line-height: 20px !important; text-align: right;">
            Руководителю Автоэкспертизы и оценки «ИНАВЭКС»<br>
            индивидуальному предпринимателю (оценщику)<br>
            Куркович Алексею Александровичу
        </td>
    </tr>
</table>
<br>

<div id="view-container">
    <h2>Заявка на проведение оценки и автоэкспертизы ТС</h2>
    <?php
    /* Add image and copy above here to show before the entry details */

    require_once(ABSPATH. "wp-content/plugins/gravity-forms-pdf-extended/pdf-entry-detail.php");

    foreach($lead_ids as $lead_id) {

        $lead = RGFormsModel::get_lead($lead_id);

        do_action("gform_print_entry_header", $form, $lead);
        ?><table><?php
        GFPDFEntryDetail::lead_detail_grid($form, $lead);
        ?></table><?php
        if(rgget('notes')){
            $notes = RGFormsModel::get_lead_notes($lead["id"]);
            if(!empty($notes))
                GFPDFEntryDetail::notes_grid($notes, false);
        }

        // output entry divider/page break
        if(array_search($lead_id, $lead_ids) < count($lead_ids) - 1)
        {
            echo '<div class="print-hr ' . $page_break . '"></div>';
        }

        do_action("gform_print_entry_footer", $form, $lead);
    }

    ?>

    <?php  ?>
    <br><br>
    <div style="text-align: center">Заказчик&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color: #333">________________________________________________________________________________________</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>(____________)</span></div>
</div>
</body>
</html>