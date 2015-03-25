<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">  
    <title><?php echo __($site_title);?></title> 
    
    <link rel="stylesheet" href="<?php echo base_url();?>css/animate.min.css" type="text/css" /> 
    <link rel="stylesheet" href="<?php echo $this->themeUrl();?>/style.css" type="text/css" /> 
    <link rel="stylesheet" href="<?php echo $this->themeUrl();?>/app.css" type="text/css" /> 
    
    <meta name="keywords" content="<?php echo __($keywords);?>" />
    <meta name="description" content="<?php echo __($description);?>" />
    <?php echo $this->view['top'];?>
    
  </head>
  <body id="<?php echo $page_id;;?>" >
  		   <header id="header">
		<div class="inner clearfix">
		
			<h1><a href="/"><?php echo __($site_title);?></a></h1>
			<ul class="nav">
				<?php if($menu){foreach($menu as $v){?>
				<li  <?php if($active && strpos($v['url'] , $active) !==false ){echo "class='active'";} ?>><a href="<?php echo $v['url'];?>"><?php echo __($v['title']);?></a></li>
				<?php }}?>
			</ul>
		</div>
	</header>

	<section id="content">
		<div class="inner">
			<?php if(Session::has_flash("success")){?><div class="message bg-success"><?php echo Session::flash('success');?></div><?php }?>
			<?php echo $this->view['content'];?>   
		</div>
	</section>
	
	<footer id="footer">
		<div class="inner">
			<a href="http://www.jointaichi.com/"> </a>  
		</div>
	</footer>
  
   
<script src="<?php echo base_url();?>js/jquery.js"></script> 
<script src="<?php echo base_url();?>js/jquery.form.js"></script>
<script src="<?php echo base_url();?>js/default.js"></script>
<?php 
	echo html_output();	 
?>
<?php echo $this->view['js'];?>
</body>
</html>
  