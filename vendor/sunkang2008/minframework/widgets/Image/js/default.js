 $(function(){   
	ajaxUploadFramwork();
	ajaxUploadFramworkDel();
});
function ajaxUploadFramworkDel(){
	$('.drupal_image_delete .delete').css('cursor','pointer');
	$('.drupal_image_delete .delete').click(function(){
		$(this).parent('.drupal_image_delete').remove();
	});
}
//ajax 上传文件　
function ajaxUploadFramwork(){
	if(!$('.ajaxUpload')[0])return false;
	$('.ajaxUpload').each(function(){
		var id = "#"+$(this).attr('id');
		var name = $(this).attr('name');
		var nid = 1;
		$(id).AjaxFileUpload({
			onSubmit:function(){  
				var max = parseInt($(this).attr('max')); 
				if(max>0){
					var len = $(this).parent().find('.help-block').find('div').length;
					if(len>max-1){
						alert("上传文件数量已达最大");
						return false;
					}
				}
			},
			action:'/upload',
			onComplete: function(fileName, data) {  
				$(id).parent().find('.ajaxFiles').remove();
				if(name.indexOf('[]')>-1){
					for(key in data){
						var d = data[key];
						$(id).next('.help-block').append("<div class='drupal_image_delete'><input type='hidden' name='"+name+"' value='"+d.id+"' ><img src='"+d.url+"' style='max-width:100px;max-height:100px;' /><span class='delete'>删除</span>");
					}
				}else{ 
					$(id).next('.help-block').html("");
					$(id).next('.help-block').append("<div class='drupal_image_delete'><input type='hidden' name='"+name+"[]' value='"+data.id+"' ><img src='"+data.url+"' style='max-width:100px;max-height:100px;' /><span class='delete'>删除</span>");
				}
				ajaxUploadFramworkDel();
				
 			}
		});
		
	});
		
	 
}
  
  
  