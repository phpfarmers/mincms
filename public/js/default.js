 $(function(){   
	ajaxForm('.ajax_form');   
});
function ajaxForm(){
	var id = arguments[0] ? arguments[0] : 1;
    var fun = arguments[1] ? arguments[1] : 2; 
	if($(id)[0]){  
		$(id).ajaxForm({ 
				dataType:'json',
				beforeSubmit:function(){
					$('.help-block').each(function(){  
						if(!$(this).find('.delete').attr('class')){
							$(this).html("");	
						} 
					});
					$("input[type='submit']").attr({"disabled":"disabled"});
				},
			    success:function(d){  
			    	$("input[type='submit']").attr({"disabled":false});
			    	if(!d.status){   
			    		var msg = d.msg;
 						var vo = "";
						$.each(msg,function(i,v){  
			    			$('.help-block:last').addClass('text-danger').html(v);
			    			return;
 			    		});   
 			    		return false;
			    	}else{ 
			    		if(d.data){ 
			    			$('.help-block:last').addClass('text-success').html(d.data);
			    		}
			    		if(d.url){
			    			window.location.href = d.url;
			    		}
			    		if(d.go){
			    			window.location.href = d.go;
			    		}
			    		if(typeof(fun)=='function'){
							fun(d);
						} 
  			    		return false; 
			    	}

			    	
			    } 
		});
	}

}
  