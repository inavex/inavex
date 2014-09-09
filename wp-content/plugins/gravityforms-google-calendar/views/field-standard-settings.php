<li class="gc_desc_template_setting field_setting">
	<input type="checkbox" id="gfield_gc_desc_template_enabled" onclick="ToggleGCDescTemplate();"/>
	<label for="gfield_gc_desc_template_enabled" class="inline">
		<?php _e("Create content template", "gravityforms"); ?>
		<?php gform_tooltip("form_field_gc_desc_template_enable") ?>
	</label>

	<div id="gfield_gc_desc_content_container">
		<div>
			<?php GFCommon::insert_post_content_variables($form["fields"], "field_gc_desc_content_template", '', 25); ?>
		</div>

		<textarea id="field_gc_desc_content_template" class="fieldwidth-3 fieldheight-1"></textarea>
	</div>
</li>
