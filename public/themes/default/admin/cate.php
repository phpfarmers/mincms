<?php $this->layout('default');?>
	
<?php $this->start('content'); 
$is = [
		0=>__('No'),
		1=>__('Yes'),
];	
$langs = Config::get('lang.trans');		
?>
 


<?php if($op == "add" || $op == "edit"){?>
<form action="" method='post' class='ajax_form'>
	<div class="form-group">
		<label ><?php echo __('Title');?></label>
		<input type="input" name="title" class="form-control" value="<?php echo $data->title;?>"  placeholder="">
	</div>   
	<div class="form-group">
		<label  ><?php echo __('IS Menu');?></label>
		<select name='menu' class="form-control">
			<?php  
			foreach($is as $k=>$v){?>
			<option value="<?php echo $k;?>" <?php if($data->menu == $k ){?>selected="selected" <?php }?> ><?php echo $v;?></option>
			<?php }?>
		</select>
	</div>  
	<div class="form-group">
		<label  ><?php echo __('Lang');?></label>
		<select name='lang' class="form-control">
			<?php  
			foreach($langs as $k=>$v){?>
			<option value="<?php echo $k;?>" <?php if($data->lang == $k ){?>selected="selected" <?php }?> ><?php echo $v;?></option>
			<?php }?>
		</select>
	</div>
	<div class="help-block message"></div> 
	<button type="submit" class="btn btn-default"><?php echo __('Save');?></button>
</form>
<?php }else{?>
	<a href="<?php echo url('admin/cate/index',['op'=>'add']);?>" ><?php echo __('Add');?></a>
	<table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th><?php echo __('Title');?></th>
          <th><?php echo __('IS Menu');?></th>
          <th><?php echo __('Created');?></th>
          <th><?php echo __('Action');?></th>
        </tr>
      </thead>
      <tbody>
    	<?php if($data){ foreach($data as $v){?>
        <tr>
          <th scope="row"><?php echo $v->id;?></th> 
          <td><?php echo $v->title;?></td>
          <td><?php echo $is[$v->menu];?></td>
          <td><?php echo date('Y-m-d H:i',$v->created);?></td>
          <td>
            <a href="<?php echo url('admin/cate/index',['op'=>'edit','nid'=>$v->id]);?>" ><?php echo __('Edit');?></a>
            &nbsp;
            <?php if($v->status == 1){?>
            	<a href="<?php echo url('admin/cate/remove',['nid'=>$v->id]);?>" ><?php echo __('Hidden');?></a> 
            <?php }elseif($v->status == 0){?>
            	<a href="<?php echo url('admin/cate/remove',['nid'=>$v->id]);?>"   class="red"  ><?php echo __('Show');?></a> 
            <?php }?>
          </td>
        </tr>
        <?php }}?>
      </tbody>
    </table> 

<?php }?>
<?php $this->end(); ?>
	