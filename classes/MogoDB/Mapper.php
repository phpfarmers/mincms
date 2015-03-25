<?php
namespace classes\MogoDB;
class Mapper extends \Mawelous\Yamop\Mapper
{
    
    protected function _createPaginator($results, $totalCount,  $perPage, $page, $options )
    { 
    	$paginate = new \Paginate($totalCount,$perPage);
		$paginate->url = $options['url'];
		$limit = $paginate->limit;
		$offset = $paginate->offset;
		$paginate = $paginate->show(); 
        return ['data'=>$results,'pager'=>$paginate,'count'=>$totalCount]; 
    }  
}
 