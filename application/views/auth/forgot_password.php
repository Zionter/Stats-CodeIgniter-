    <?php
    // Load the style settings
		 $this -> load -> view('Custom');
		 Customize::generateStyles();
		 
		 Customize::generateFonts();

    ?>
<div class="container-fluid ">
    <div class="login row-fluid centering col-lg-4 col-md-5 col-sm-6 col-xs-10 row">
        <div class="panel form" style="padding: 10px;">

		<h1><?php echo lang('forgot_password_heading');?>?</h1>
		<p><em><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></em></p>

		<div id="infoMessage" class="bg-danger"><?php echo $message;?></div>

		<?php echo form_open("auth/forgot_password");?>

 	     <div class="form-group">
   		   	<label for="email"><?php echo sprintf(lang('forgot_password_email_label'), $identity_label);?></label> <br />
   		   	<?php echo form_input(array_merge( $email, array('class' => 'form-control', 'placeholder' => 'Введіть пошту...', 'type' => 'email')));?>
   	   		</div>

   	   <p><?php echo form_submit('submit', lang('forgot_password_submit_btn'), "class='btn btn-default'");?></p>

	<?php echo form_close();?>
</div>
</div>
</div>