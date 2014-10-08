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
    	<h1 class="panel-heading row"><?php echo lang('create_user_heading');?></h1>
<p class="subheading col-md-12"><?php echo lang('create_user_subheading');?></p>
        <div class="panel form" style="padding: 10px;">
        	

        	<div class="modal-body row">


<div id="infoMessage" class="bg-danger"><?php echo $message;?></div>

<?php echo form_open("auth/create_user", array('class'=>'form-horizontal'));?>

      <div class="form-group col-md-5">
            <?php echo lang('create_user_fname_label', 'first_name');?> <br />
            <?php echo form_input(array_merge($first_name, array('class' => 'form-control')));?>
      </div>

      <div class="form-group col-md-5">
            <?php echo lang('create_user_lname_label', 'last_name');?> <br />
            <?php echo form_input(array_merge($last_name, array('class' => 'form-control')));?>
      </div>

      <div class="form-group col-md-5">
            <?php echo lang('create_user_company_label', 'company');?> <br />
            <?php echo form_input(array_merge($company, array('class' => 'form-control')));?>
      </div>

      <div class="form-group col-md-5">
            <?php echo lang('create_user_email_label', 'email');?> <br />
            <?php echo form_input(array_merge($email, array('class' => 'form-control')));?>
      </div>

      <div class="form-group col-md-5">
            <?php echo lang('create_user_phone_label', 'phone');?> <br />
            <?php echo form_input(array_merge($phone, array('class' => 'form-control')));?>
      </div>

      <div class="form-group col-md-5">
            <?php echo lang('create_user_password_label', 'password');?> <br />
            <?php echo form_input(array_merge($password, array('class' => 'form-control')));?>
      </div>

      <div class="form-group col-md-5">
            <?php echo lang('create_user_password_confirm_label', 'password_confirm');?> <br />
            <?php echo form_input(array_merge($password_confirm, array('class' => 'form-control')));?>
      </div>


      <div class="form-group col-md-12">
      	<?php echo form_submit('submit', lang('create_user_submit_btn'), "class='btn btn-info'");?>
      </div>

<?php echo form_close();?>

</div>
</div>
</div>
</div>