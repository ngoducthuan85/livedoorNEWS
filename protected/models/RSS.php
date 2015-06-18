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
	
	/**
	 * The 8-digit number at the end of each news' link is unique and can be considered as the ID of the article
	 * @param string $link
	 * @return ID of the article
	 */
	public function getId($link)
	{
		$id = substr($link, -9, 8);
		return $id;
	}
	
	public function getImageUrl($link)
	{
		$html = file_get_html($link );
		preg_match('/<meta property="og:image" content="(.*?)" \/>/', $html, $matches);
		foreach ($matches as $url)
		{
			if (strlen($url) > 10)
				return $this->standardizeddUrl($url);
		}
		return null;
	}
	
	public function getKeywords($link)
	{
		$tags = get_meta_tags($link);
		$keywords = $tags['news_keywords'];
		return $keywords;
	}
	
	/**
	 * Standardize the URLs gotten by parsing HTML
	 * Almost all resulted URLs look like:
	 * http://image.news.livedoor.com/newsimage/1/8/180ed_103_f14303a72a392b4cd8ba34d4ba5c780a.jpg">
	 * The last 2 characters are redundant
	 * @param unknown $url
	 */
	public function standardizeddUrl($url)
	{
		if (substr($url, -2) == '">')
			return substr($ur, 0, -2);
	}
}