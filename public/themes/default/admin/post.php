<?php $this->layout('default');?>
	
<?php $this->start('content');
$langs = Config::get('lang.trans');		
?>
 


<?php if($op == "add" || $op == "edit"){?>
<form action="" method='post' class='ajax_form'>
	<div class="form-group">
		<label ><?php echo __('Title');?></label>
		<input type="input" name="title" class="form-control" value="<?php echo $data->title;?>"  placeholder="">
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
			
	<div class="form-group">
		<label ><?php echo __('Teater');?></label>
		<input type="input" name="teater" class="form-control" value="<?php echo $data->teater;?>" placeholder="">
	</div>
	
	<div class="form-group">
		<label  ><?php echo __('Body');?></label>
		<?php echo widget('Ckeditor',['name'=>'body',"value"=>$data->body]);?>
	</div>
	<div class="form-group">
		<label  ><?php echo __('Cate');?></label>
		<select name='cate[]' id="cate" class="form-control" multiple="multiple" >
			<option value="" ><?php echo __("Please Choice");?></option>
			<?php if($cates){foreach($cates as $v){?>
			<option value="<?php echo $v->id;?>" <?php if(is_array($incates) && in_array($v->id,$incates)){?> selected="selected" <?php }?> ><?php echo $v->title;?></option>
			<?php }}?>
		</select>
	</div>  
	<div class="form-group">
		<label  ><?php echo __('Image');?></label>
		<?php 
			$in = $data->image;
			if($in){
				$image = \Q::from("file")->where('id in ('.DB::in($in).')',$in)->all();
			}
			echo widget('Image',['name'=>'image[]' ,'value'=>$image,'opt'=>['multiple'=>1] ]); 
		?>
	</div>
		
	<div class="form-group">
		<label  ><?php echo __('Attachment');?></label>
		<?php 
			$in = $data->file;
			if($in){
				$image = \Q::from("file")->where('id in ('.DB::in($in).')',$in)->all();
			}
			echo widget('Image',['name'=>'file[]' ,'value'=>$image,'opt'=>['multiple'=>1] ]); 
		?>
		
	</div>
	<div id='fieldAppend'></div>
	<div class="help-block message"></div>
		
			 
	<button type="submit" class="btn btn-default"><?php echo __('Save');?></button>
</form>
<?php }else{?>
	<a href="<?php echo url('admin/post/index',['op'=>'add']);?>" ><?php echo __('Add');?></a>
	&nbsp;
	<a href="<?php echo url('admin/mongosync/index');?>" ><?php echo __('MongoSync');?></a> 
		
		
		
	<table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th><?php echo __('Title');?></th>
          <th><?php echo __('Created');?></th>
          <th><?php echo __('Action');?></th>
        </tr>
      </thead>
      <tbody>
    	<?php if($data){ foreach($data as $v){?>
        <tr>
          <th scope="row"><?php echo $v->id;?></th> 
          <td><?php echo $v->title;?></td>
          <td><?php echo date("Y-m-d",$v->created);?></td>
          <td>
            <a href="<?php echo url('admin/post/index',['op'=>'edit','nid'=>$v->id]);?>" ><?php echo __('Edit');?></a>
            &nbsp;
            <?php if($v->status == 1){?>
            	<a href="<?php echo url('admin/post/remove',['nid'=>$v->id]);?>" ><?php echo __('Hidden');?></a> 
            <?php }elseif($v->status == 0){?>
            	<a href="<?php echo url('admin/post/remove',['nid'=>$v->id]);?>" class="red" ><?php echo __('Show');?></a> 
            <?php }?>
          </td>
        </tr>
        <?php }}?>
      </tbody>
    </table> 

<?php }?>
<?php $this->end(); ?>
<?php $this->start('js'); ?>
<script>
$(function(){
	 var i = 0;
	 function sendAjax(){ 
		 $('#cate option').each(function(){
		 	if($(this).attr('selected')){
		 		i = i+","+$(this).val();
		 	}
		 });
		 $.post("<?php echo url('admin/post/ajax'); ?>",{cate:i},function(data){
		 	$("#fieldAppend").html(data);
		 });
	}
	sendAjax();
	$('#cate').change(function(){
		sendAjax();
	});

	
});
</script>
<?php $this->end(); ?>
	