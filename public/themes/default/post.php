<?php $this->layout('default');?>
	
<?php $this->start('content');
$n =  count($data)?:0;
?>
<?php if($n>1){?>
<h1><?php echo __('Post');?></h1>
<?php foreach($data as $v){?>
<div><a href="<?php echo url('home/site/view',['id'=>$v->nid]);?>"><?php echo $v->title;?></a></div>
<?php }}else{
	echo $this->extend('view',[ 'post'=>Arr::first($data) ,'nolayout'=>1 ]);
		
}?>

	
<?php ?>
<?php echo $pager;?>
	
<?php $this->end(); ?>
	