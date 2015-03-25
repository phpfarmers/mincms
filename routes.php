<?php 

Route::get('/',"module\home\site@index");
Route::get('admin',"module\admin\site@index");
Route::all('login',"module\admin\site@login");

Route::get('post/<id:\d+>',"module\home\site@view");

Route::get('page/<cate:\d+>',"module\home\site@post");
Route::get('page/<cate:\d+>/<page:\d+>',"module\home\site@post");

Route::post('upload',function(){
	$upload = new Upload("upload_files");
	$upload->openDB = true; 
	$upload->type = Config::get('upload');
	$r = $upload->run();
	if($r){
		echo json_encode($r);
	}
});