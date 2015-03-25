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
		
 