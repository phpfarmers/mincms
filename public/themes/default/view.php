<?php if(!$nolayout){?>
	<?php $this->layout('default');?>
		
	<?php $this->start('content'); ?>
<?php }?>
<h1><?php echo $post->title;?></h1>

<?php echo $post->body;?>

<?php if(!$nolayout){?>
	<?php $this->end(); ?>
<?php }?>

	