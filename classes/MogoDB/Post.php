<?php
namespace classes\MogoDB;
class Post extends \Mawelous\Yamop\Model 
{
    protected static $_collectionName = 'post';  
    
    protected static $_mapperClassName = '\classes\MogoDB\Mapper';
}
 