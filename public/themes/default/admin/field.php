<?php $this->layout('default');?>
	
<?php $this->start('content'); 
$langs = Config::get('lang.trans');	
$apps = Config::get('lang.app');	
	
?>
 


<?php if($op == "add" || $op == "edit"){?> 
 
<form action="" method='post' class='ajax_form'>
	  
	<div class="form-group">
		<label ><?php echo __('Label');?></label>
		<input type="input" name="label" class="form-control" value="<?php echo $data->name;?>"  placeholder="">
	</div>

	<div class="form-group">
		<label ><?php echo __('Field Name');?></label>
		<input type="input" name="name" class="form-control" value="<?php echo $data->trans;?>"  placeholder="">
	</div> 
	
	<div class="form-group">
		<label  ><?php echo __('Cate');?></label>
		<select name='cate[]' class="form-control" multiple="multiple" >
			<option value="" ><?php echo __("Please Choice");?></option>
			<?php if($cates){foreach($cates as $v){?>
			<option value="<?php echo $v->id;?>" <?php if(is_array($incates) && in_array($v->id,$incates)){?> selected="selected" <?php }?> ><?php echo $v->title;?></option>
			<?php }}?>
		</select>
	</div> 

	<div class="form-group">
		<label  ><?php echo __('Field');?></label>
		<select id='choice' class="form-control"  name="field[name]" >
			<option value="" ><?php echo __("Please Choice");?></option>
			<?php if($ext){foreach($ext as $k=>$v){?>
			<option value="<?php echo $v;?>" <?php if(is_array($incates) && in_array($v->id,$incates)){?> selected="selected" <?php }?> ><?php echo $k;?></option>
			<?php }}?>
		</select>
	</div> 

	<div class="form-group">
		<label ><?php echo __('Field Settings Yaml');?></label>
		<TEXTAREA name="field[ext]" class="form-control"> <?php echo $ext; ?> </TEXTAREA>
	</div> 

	<div class="help-block message"></div> 
	<button type="submit" class="btn btn-default"><?php echo __('Save');?></button>
</form>
<?php }else{?>
	 
	<a href="<?php echo url('admin/field/index',['op'=>'add']);?>" ><?php echo __('Add');?></a>
	<table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th><?php echo __('Label');?></th> 
          <th><?php echo __('Name');?></th> 
          <th><?php echo __('Cate');?></th>
          <th><?php echo __('Created');?></th>
          <th><?php echo __('Action');?></th>
        </tr>
      </thead>
      <tbody>
    	<?php if($data){ foreach($data as $v){?>
        <tr>
          <th scope="row"><?php echo $v->id;?></th> 
          <td><?php echo $v->label;?></td>
          <td><?php echo $v->name;?></td>
          <td><?php echo $v->cate;?></td>
          <td><?php echo date('Y-m-d H:i',$v->created);?></td>
          <td>
            <a href="<?php echo url('admin/field/index',['op'=>'edit','nid'=>$v->id]);?>" ><?php echo __('Edit');?></a>
            &nbsp;
            <?php if($v->status == 1){?>
            	<a href="<?php echo url('admin/field/remove',['nid'=>$v->id]);?>" ><?php echo __('Hidden');?></a> 
            <?php }elseif($v->status == 0){?>
            	<a href="<?php echo url('admin/field/remove',['nid'=>$v->id]);?>"   class="red"  ><?php echo __('Show');?></a> 
            <?php }?>
          </td>
        </tr>
        <?php }}?>
      </tbody>
    </table> 

<?php }?>
<?php $this->end(); ?>
	