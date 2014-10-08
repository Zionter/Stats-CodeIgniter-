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

<h1 class="panel-heading row"><?php echo lang('create_group_heading');?></h1>
<p class="subheading col-md-12"><?php echo lang('create_group_subheading');?></p> 

 <div class="panel form" style="padding: 10px;">
        	

        	<div class="modal-body row">

<div id="infoMessage"  class="bg-danger"><?php echo $message;?></div>

<?php echo form_open("auth/create_group");?>

      <div class="form-group col-md-5">
            <?php echo lang('create_group_name_label', 'group_name');?> <br />
            <?php echo form_input(array_merge($group_name, array('class' => 'form-control')));?>
      </div>

      <div class="form-group col-md-5">
            <?php echo lang('create_group_desc_label', 'description');?> <br />
            <?php echo form_input(array_merge($description, array('class' => 'form-control')));?>
      </div>

      
      <div class="form-group col-md-12">
      	<?php echo form_submit('submit', lang('create_group_submit_btn'), "class='btn btn-info'");?>
      </div>	
<?php echo form_close();?>

</div>
</div>
</div>
</div>
</div>