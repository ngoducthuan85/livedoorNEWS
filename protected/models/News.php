<?php
/**
 * Class of News and some functions to connect with MongoDB
 * @author ngoducthuan85
 * @final 2015/6/18
 */
require_once 'simple_html_dom.php';

class News
{
	// Information can be achieved from RSS XML file
	public $title;
	public $link;
	public $shortDesc;
	public $mobile;
	public $pubDate;
	public $guid;
	
	// Information needs to be retrieved by analyzing the full article
	public $id;
	public $longDesc;
	public $imageUrl;
	public $keywords;
	public $relatedPosts;
	/**
	 * 
	 * @param string $title
	 * @param string $link
	 * @param string $description
	 * @param int $mobile
	 * @param string $pubDate
	 * @param string $guid
	 */
	function __construct($title, $link, $description, $mobile, $pubDate, $guid)
	{
		// Update information based on the input
		$this->title 		= $title;
		$this->link 		= $link;
		$this->shortDesc 	= $description;
		$this->mobile 		= $mobile;
		$this->pubDate 		= $pubDate;
		$this->guid			= $guid;
		
		// Analyze input to get further information
		//$this->id			= $this->getId($link);
		
		// Analyze input to get further information
		//$this->imageUrl	= $this->getImageUrl($link);
		//$this->keywords		= $this->getKeywords($link);
	}
}