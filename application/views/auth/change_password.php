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

        	
<h1 class="panel-heading row"><?php echo lang('change_password_heading');?></h1>

	<div class="panel form" style="padding: 10px;">
        	

        <div class="modal-body row">

<div id="infoMessage" class="bg-danger"><?php echo $message;?></div>

<?php echo form_open("auth/change_password");?>

      <div class="form-group col-md-12">
            <?php echo lang('change_password_old_password_label', 'old_password');?> <br />
            <?php echo form_input(array_merge($old_password, array('class' => 'form-control', 'placeholder' => 'Введіть старий пароль...')));?>
      </div>

      <div class="form-group col-md-12">
            <label for="new_password"><?php echo sprintf(lang('change_password_new_password_label'), $min_password_length);?></label> <br />
            <?php echo form_input(array_merge($new_password, array('class' => 'form-control', 'placeholder' => 'Введіть новий пароль...')));?>
      </div>

      <div class="form-group col-md-12">
            <?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm');?> <br />
            <?php echo form_input(array_merge($new_password_confirm, array('class' => 'form-control', 'placeholder' => 'Введіть новий знову...')));?>
      </div>

      <?php echo form_input($user_id);?>
      <div class="form-group col-md-12"><?php echo form_submit('submit', lang('change_password_submit_btn'), "class='btn btn-default'");?><</div>

<?php echo form_close();?>

</div>

</div>

</div>

</div>

</div>

</div>