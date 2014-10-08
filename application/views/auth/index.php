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
    <div class="login row-fluid centering col-lg-8 col-md-9 col-sm-12 col-xs-12 row">



<h1 class="panel-heading row"><?php echo lang('index_heading');?></h1>
<p class="subheading col-md-12"><?php echo lang('index_subheading');?></p>


<div class="panel form" style="padding: 10px;">
        	

        	<div class="modal-body row">


<div id="infoMessage"  class="bg-danger"><?php echo $message;?></div>

<table class="table statst" cellpadding=0 cellspacing=10>
	<tr>
		<th><?php echo lang('index_fname_th');?></th>
		<th><?php echo lang('index_lname_th');?></th>
		<th><?php echo lang('index_email_th');?></th>
		<th><?php echo lang('index_groups_th');?></th>
		<th><?php echo lang('index_status_th');?></th>
		<th><?php echo lang('index_action_th');?></th>
	</tr>
	<?php foreach ($users as $user):?>
		<tr>
			<td><?php echo $user->first_name;?></td>
			<td><?php echo $user->last_name;?></td>
			<td><?php echo $user->email;?></td>
			<td>
				<?php foreach ($user->groups as $group):?>
					<?php echo anchor("auth/edit_group/".$group->id, $group->name) ;?><br />
                <?php endforeach?>
			</td>
			<td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link')) : anchor("auth/activate/". $user->id, lang('index_inactive_link'));?></td>
			<td><?php echo anchor("auth/edit_user/".$user->id, 'Edit') ;?></td>
		</tr>
	<?php endforeach;?>
</table>

<div class="col-md-12" style="background:#f5f5f5">
	<div class="col-md-12 "><?php echo anchor('auth/create_user', lang('index_create_user_link'), "class='btn btn-default'")?> </div>
	<br><br>
	<div class="col-md-12"><?php echo anchor('auth/create_group', lang('index_create_group_link'), "class='btn btn-default'")?></div>
</div>