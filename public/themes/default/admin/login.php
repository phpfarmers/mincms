<?php $this->layout('default');?>
	
<?php $this->start('content'); ?>
 
<form action="" method='post' class='ajax_form'>
	<div class="form-group">
		<label ><?php echo __('User Name');?></label>
		<input type="input" name="name" class="form-control"  placeholder="">
	</div>
	<div class="form-group">
		<label  ><?php echo __('Password');?></label>
		<input type="password" name="pwd" class="form-control"  placeholder=" ">
	</div>
	<div class="form-group">
		<label  ><?php echo __('Verify');?></label>
		<input type="input" name="verify" class="form-control"  placeholder=" ">
		<img src="<?php echo url("admin/comm/verify"); ?>" onclick="javascript:$(this).attr('src','<?php echo url("admin/comm/verify",['rand'=>Str::rand2()]); ?>');"/>
	</div>  
	<div class="help-block message"></div> 
	<button type="submit" class="btn btn-default"><?php echo __('Login');?></button>
</form>

<?php $this->end(); ?>
	