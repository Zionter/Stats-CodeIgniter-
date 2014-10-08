   <?php
    // Load the style settings
		 $this -> load -> view('Custom');
		 Customize::generateStyles();
		 
		 Customize::generateFonts();

    ?>
  <style type="text/css">
  .form-horizontal .form-group { margin-left : 0; margin-right : 0}	
  </style>
  
    <div class="container-fluid ">
    <div class="login row-fluid centering col-lg-4 col-md-5 col-sm-6 col-xs-10 row">



	<h1 class="panel-heading row"><?php echo lang('edit_group_heading');?></h1>
	<p class="subheading col-md-12"><?php echo lang('edit_group_subheading');?></p>


	<div class="panel form" style="padding: 10px;">
        	

        <div class="modal-body row">

		<div id="infoMessage"  class="bg-danger"><?php echo $message;?></div>

	<?php echo form_open(current_url());?>

      <div class="form-group col-md-12">
            <?php echo lang('create_group_name_label', 'group_name');?> 
            <?php echo form_input($group_name);?>
      </div>


      <div class="form-group col-md-12">
            <?php echo lang('edit_group_desc_label', 'description');?>
            <?php echo form_input($group_description);?>
      </div>


      <div class="form-group col-md-12">
      	<?php echo form_submit('submit', lang('edit_group_submit_btn'));?>
      </div>


	<?php echo form_close();?>

	</div>
	</div>
	</div>
</div>
</div>
</div>