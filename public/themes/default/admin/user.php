<?php $this->layout('default');?>
	
<?php $this->start('content'); 
$langs = Config::get('lang.trans');	
$apps = Config::get('lang.app');	
	
?>
 


<?php if($op == "add" || $op == "edit"){?>
<form action="" method='post' class='ajax_form'>
	 
	 
	<div class="form-group">
		<label ><?php echo __('User Name');?></label>
		<input type="input" name="name" class="form-control" value="<?php echo $data->name;?>"  placeholder="">
	</div>   
		
	 
	<?php if($nid>0){?>
		<?php if($uid == $supuser){?>
			<div class="form-group">
				<label ><?php echo __('New Password');?></label>
				<input type="input" name="pwd" class="form-control" value=""  placeholder="">
			</div>
		<?php }else{?>
			<div class="form-group">
				<label ><?php echo __('Old Password');?></label>
				<input type="input" name="pwd" class="form-control" value=""  placeholder="">
			</div>
			<div class="form-group">
		<label ><?php echo __('New Password');?></label>
		<input type="input" name="pwd_new" class="form-control" value=""  placeholder="">
	</div>
		<?php }?>
	<?php }else{?>
		<div class="form-group">
			<label ><?php echo __('Password');?></label>
			<input type="input" name="pwd" class="form-control" value=""  placeholder="">
		</div>
	<?php }?>
	
	<div class="help-block message"></div> 
	<button type="submit" class="btn btn-default"><?php echo __('Save');?></button>
</form>
<?php }else{?>
	<a href="<?php echo url('admin/user/index',['op'=>'add']);?>" ><?php echo __('Add');?></a>
	<table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th><?php echo __('User Name');?></th> 
          <th><?php echo __('Action');?></th>
        </tr>
      </thead>
      <tbody>
    	<?php if($data){ foreach($data as $v){?>
        <tr>
          <th scope="row"><?php echo $v->id;?></th> 
          <td><?php echo $v->name;?></td> 
          <td>
            <a href="<?php echo url('admin/user/index',['op'=>'edit','nid'=>$v->id]);?>" ><?php echo __('Edit');?></a>
            
          </td>
        </tr>
        <?php }}?>
      </tbody>
    </table> 

<?php }?>
<?php $this->end(); ?>
	