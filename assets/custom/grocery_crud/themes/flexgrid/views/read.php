<?php

	$this->set_css($this->default_theme_path.'/flexigrid/css/flexigrid.css');
	$this->set_js_lib($this->default_theme_path.'/flexigrid/js/jquery.form.js');
	$this->set_js_config($this->default_theme_path.'/flexigrid/js/flexigrid-edit.js');

	$this->set_js_lib($this->default_javascript_path.'/jquery_plugins/jquery.noty.js');
	$this->set_js_lib($this->default_javascript_path.'/jquery_plugins/config/jquery.noty.config.js');
?>
 <style type="text/css">
  .form-horizontal .form-group { margin-left : 0; margin-right : 0}	
  </style>
  
    <div class="flexigrid crud-form container-fluid " data-unique-hash="<?php echo $unique_hash; ?>">
    <div class="login row-fluid centering col-lg-4 col-md-4 col-sm-11 col-xs-12 row">
    	
    	<h1 class="panel-heading row">	<?php echo $this->l('list_record'); ?> <?php echo $subject?></h1>

	<div class="panel form" style="padding: 10px;">
        	

        <div class="modal-body row">

	<?php echo form_open( $read_url, 'method="post" id="crudForm" autocomplete="off" enctype="multipart/form-data"'); ?>
	<div class='form-div'>
		<?php
		$counter = 0;
			foreach($fields as $field)
			{
				$even_odd = $counter % 2 == 0 ? 'odd' : 'even';
				$counter++;
		?>
			<div class='form-field-box <?php echo $even_odd?>' id="<?php echo $field->field_name; ?>_field_box" style="margin:5px 0; background: #f5f5f5">
				<div style=" background: #afafaf;color:#fff; padding: 5px" class='form-display-as-box' id="<?php echo $field->field_name; ?>_display_as_box">
					<strong style="margin-top:10px"><?php echo $input_fields[$field->field_name]->display_as?><?php echo ($input_fields[$field->field_name]->required)? "<span class='required'>*</span> " : ""?> :</strong>
				</div>
				<div class='form-input-box' id="<?php echo $field->field_name; ?>_input_box">
					<?php echo $input_fields[$field->field_name]->input?>
				</div>
				<div class='clear'></div>
			</div>
		<?php }?>
		<?php if(!empty($hidden_fields)){?>
		<!-- Start of hidden inputs -->
			<?php
				foreach($hidden_fields as $hidden_field){
					echo $hidden_field->input;
				}
			?>
		<!-- End of hidden inputs -->
		<?php }?>
		<?php if ($is_ajax) { ?><input type="hidden" name="is_ajax" value="true" /><?php }?>
		<div id='report-error' class='report-div error'></div>
		<div id='report-success' class='report-div success'></div>
	</div>
	<div class="pDiv" style="margin-top: 50px">
		<div class='form-button-box'>
			<input type='button' value='<?php echo $this->l('form_back_to_list'); ?>' class="btn btn-large btn-success back-to-list" id="cancel-button" />
		</div>
		<div class='form-button-box'>
			<div class='small-loading' id='FormLoading'><?php echo $this->l('form_update_loading'); ?></div>
		</div>
		<div class='clear'></div>
	</div>
	<?php echo form_close(); ?>
</div>
</div>
</div>
</div>
<script>
	var validation_url = '<?php echo $validation_url?>';
	var list_url = '<?php echo $list_url?>';

	var message_alert_edit_form = "<?php echo $this->l('alert_edit_form')?>";
	var message_update_error = "<?php echo $this->l('update_error')?>";
</script>
