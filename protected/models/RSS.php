<?php
/**
 * Class of list of News and some functions to connect with MongoDB
 * @author ngoducthuan85
 * @final 2015/6/18
 */

require_once 'News.php';

class RSS
{
	public $url;
	public $listNews;
	public $title;
	
	/**
 	* 
 	* @param string $rssPath
 	*/
	function __construct($rssPath)
	{
		$XML = simplexml_load_file ( $rssPath );
		$XML = $XML->channel;
		$this->title = $XML->title;
		
		$this->listNews = array();
		foreach ( $XML->item as $news ) {
			$title 			= $news->title;
			$link 			= $news->link;
			$description 	= $news->description;
			$mobile 		= $news->mobile;
			$pubDate 		= $news->pubDate;
			$guid 			= $news->guid;
			array_push($this->listNews, new News($title, $link, $description, $mobile, $pubDate, $guid));
		}
	}
}