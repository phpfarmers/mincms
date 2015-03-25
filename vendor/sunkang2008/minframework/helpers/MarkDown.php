<?php   namespace Helper;
/**
* https://github.com/cebe/markdown
*/
class MarkDown{
		static $obj;
		static $mark;
		function __construct(){
		 	if(!static::$obj){
			 	$autoload = Config::get('loader');
			 	if($autoload){
			 		$autoload->addPrefix('cebe\markdown',SYS."/resource/markdown"); 
			 	}
			 	static::$obj = true;
		 	}
		 	return $this;
		 }
		 
		 function index($markdown){
		 	if(!static::$mark['default']){
		 		$parser = new \cebe\markdown\Markdown();
		 		static::$mark['default'] = $parser;
		 	}else{
		 		$parser = static::$mark['default'];
		 	} 
			return $parser->parse($markdown);
		 }
		 
		 function index($markdown){
		 	if(!static::$mark['default']){
		 		$parser = new \cebe\markdown\Markdown();
		 		static::$mark['default'] = $parser;
		 	}else{
		 		$parser = static::$mark['default'];
		 	} 
			return $parser->parse($markdown);
		 }
		 
		 function github($markdown){
		 	if(!static::$mark['github']){
		 		$parser = new \cebe\markdown\GithubMarkdown();
		 		static::$mark['github'] = $parser;
		 	}else{
		 		$parser = static::$mark['github'];
		 	} 
			return $parser->parse($markdown);
		 }
		 
		 function extra($markdown){
		 	if(!static::$mark['extra']){
		 		$parser = new \cebe\markdown\MarkdownExtra();
		 		static::$mark['extra'] = $parser;
		 	}else{
		 		$parser = static::$mark['extra'];
		 	} 
			return $parser->parse($markdown);
		 }
		
		// parse only inline elements (useful for one-line descriptions)
 		function github2($markdown){
		 	if(!static::$mark['extra']){
		 		$parser = new \cebe\markdown\GithubMarkdown();
		 		static::$mark['extra'] = $parser;
		 	}else{
		 		$parser = static::$mark['extra'];
		 	} 
			return $parser->parseParagraph($markdown);
		 }


		 
		 
	 

}


profile_logs(__FILE__." LINE:".__LINE__ );
profile_logm(__FILE__." LINE:".__LINE__ );