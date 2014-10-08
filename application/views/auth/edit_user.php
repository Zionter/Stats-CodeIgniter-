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



<h1 class="panel-heading row"><?php echo lang('edit_user_heading');?></h1>
<p class="subheading col-md-12"><?php echo lang('edit_user_subheading');?></p>

<div class="panel form" style="padding: 10px;">
        	

        	<div class="modal-body row">


<div id="infoMessage"  class="bg-danger"><?php echo $message;?></div>

<?php echo form_open(uri_string());?>

      <div class="form-group col-md-12">
            <?php echo lang('edit_user_fname_label', 'first_name');?> <br />
            <?php echo form_input(array_merge($first_name, array('class' => 'form-control')));?>
      </div>

      <div class="form-group col-md-12">
            <?php echo lang('edit_user_lname_label', 'last_name');?> <br />
            <?php echo form_input(array_merge($last_name, array('class' => 'form-control')));?>
      </div>

      <div class="form-group col-md-12">
            <?php echo lang('edit_user_company_label', 'company');?> <br />
            <?php echo form_input(array_merge($company, array('class' => 'form-control')));?>
      </div>

      <div class="form-group col-md-12">
            <?php echo lang('edit_user_phone_label', 'phone');?> <br />
            <?php echo form_input(array_merge($phone, array('class' => 'form-control')));?>
      </div>

      <div class="form-group col-md-12">
            <?php echo lang('edit_user_password_label', 'password');?> <br />
            <?php echo form_input(array_merge($password, array('class' => 'form-control')));?>
      </div>

      <div class="form-group col-md-12">
            <?php echo lang('edit_user_password_confirm_label', 'password_confirm');?><br />
            <?php echo form_input(array_merge($password_confirm, array('class' => 'form-control')));?>
      </div>
<div class="form-group col-md-12">
	 <h3><?php echo lang('edit_user_groups_heading');?></h3>
	<?php foreach ($groups as $group):?>
	<label class="checkbox col-md-12" >
	<?php
		$gID=$group['id'];
		$checked = null;
		$item = null;
		foreach($currentGroups as $grp) {
			if ($gID == $grp->id) {
				$checked= ' checked="checked"';
			break;
			}
		}
	?>
	<input type="checkbox" class="form-control" style="height:13px;padding-top:5px" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
	<?php echo $group['name'];?>
	</label>
	<?php endforeach?>

      <?php echo form_hidden('id', $user->id);?>
      <?php echo form_hidden($csrf); ?>
 </div>
      <div class="form-group col-md-12"><?php echo form_submit('submit', lang('edit_user_submit_btn'), "class='btn btn-info'");?></div>

<?php echo form_close();?>


</div>
</div>
</div>
</div>
</div>