<?php $this->layout('default');?>
	
<?php $this->start('content'); 
$langs = Config::get('lang.trans');	
$apps = Config::get('lang.app');	
	
?>
 


<?php if($op == "add" || $op == "edit"){?>
<form action="" method='post' class='ajax_form'>
	<div class="form-group">
		<label  ><?php echo __('Lang');?></label>
		<select name='lang' class="form-control">
			<?php  
			foreach($langs as $k=>$v){?>
			<option value="<?php echo $k;?>" <?php if($data->lang == $k ){?>selected="selected" <?php }?> ><?php echo $v;?></option>
			<?php }?>
		</select>
	</div>
	<div class="form-group">
		<label  ><?php echo __('Slug');?></label>
		<select name='slug' class="form-control">
			<?php  
			foreach($apps as $k=>$v){?>
			<option value="<?php echo $k;?>" <?php if($data->slug == $k ){?>selected="selected" <?php }?> ><?php echo $v;?></option>
			<?php }?>
		</select>
	</div>   
	<div class="form-group">
		<label ><?php echo __('Title');?></label>
		<input type="input" name="name" class="form-control" value="<?php echo $data->name;?>"  placeholder="">
	</div>   
	<div class="form-group">
		<label ><?php echo __('Trans');?></label>
		<input type="input" name="trans" class="form-control" value="<?php echo $data->trans;?>"  placeholder="">
	</div> 
	
	<div class="help-block message"></div> 
	<button type="submit" class="btn btn-default"><?php echo __('Save');?></button>
</form>
<?php }else{?>
	<a href="<?php echo url('admin/lang/index',['op'=>'add']);?>" ><?php echo __('Add');?></a>
	&nbsp;
	<a href="<?php echo url('admin/lang/run');?>" ><?php echo __('Run Trans');?></a>
	<table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th><?php echo __('Title');?></th> 
          <th><?php echo __('Slug');?></th> 
          <th><?php echo __('Trans');?></th>
          <th><?php echo __('Lang');?></th>	
          <th><?php echo __('Created');?></th>
          <th><?php echo __('Action');?></th>
        </tr>
      </thead>
      <tbody>
    	<?php if($data){ foreach($data as $v){?>
        <tr>
          <th scope="row"><?php echo $v->id;?></th> 
          <td><?php echo $v->name;?></td>
          <td><?php echo $apps[$v->slug];?></td>
          <td><?php echo $v->trans;?></td>
          <td><?php echo $langs[$v->lang];?></td>
          <td><?php echo date('Y-m-d H:i',$v->created);?></td>
          <td>
            <a href="<?php echo url('admin/lang/index',['op'=>'edit','nid'=>$v->id]);?>" ><?php echo __('Edit');?></a>
            &nbsp;
            <?php if($v->status == 1){?>
            	<a href="<?php echo url('admin/lang/remove',['nid'=>$v->id]);?>" ><?php echo __('Hidden');?></a> 
            <?php }elseif($v->status == 0){?>
            	<a href="<?php echo url('admin/lang/remove',['nid'=>$v->id]);?>"   class="red"  ><?php echo __('Show');?></a> 
            <?php }?>
          </td>
        </tr>
        <?php }}?>
      </tbody>
    </table> 
<?php echo $pager;?>
<?php }?>
<?php $this->end(); ?>
	