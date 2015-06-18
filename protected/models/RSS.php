<?php
/**
 * Class of list of News and some functions to connect with MongoDB
 * @author ngoducthuan85
 * @final 2015/6/18
 */

require_once 'simple_html_dom.php';

class RSS
{
	public $url;
	public $listNews;
	public $title;
	
	/**
 	* Rename this function to "__construct" to run without using database
 	* @param string $rssPath
 	*/
	function noDBconstruct($rssPath)
	{
		$XML = simplexml_load_file ( $rssPath );
		$XML = $XML->channel;
		$this->title = $XML->title."";
		
		$this->listNews = array();
		foreach ( $XML->item as $item ) {
			$link 	= $item->link."";
			$id		= $this->getNewsIdFromNewsUrl($link);
			$news	= array();
			$news['newsId'] 	= $id;
			$news['title'] 		= $item->title."";
			$news['link']		= $link;
			$news['shortDesc'] 	= $item->description."";
			$news['mobile'] 	= $item->mobile."";
			$news['pubDate'] 	= $item->pubDate."";
			$news['guid'] 		= $item->guid."";

			// Analyze HTML to achieve more information
		
 			$html = file_get_html($link );
 			$news['imageUrl']	= $this->getImageUrlFromHTML($html);
 			$news['keywords']	= $this->getKeywordsFromHTML($html);
 			$news['relatedPosts']= $this->getRelatedPostsFromHTMLandKeywords($html, $news['keywords']);
			array_push($this->listNews, $news);
		}
	}
	
	/**
	 * Rename this function to "__construct" to run using database (MongoDB)
	 * @param string $rssPath
	 */
	function __construct($rssPath)
	{
		$m          = new MongoClient('mongodb://ngoducthuan85:ngoducthuan85@ds045242.mongolab.com:45242/livedoor'); // connect
		$db         = $m->livedoor;
		$collection = $db->news;
	
		$XML = simplexml_load_file ( $rssPath );
		$XML = $XML->channel;
		$this->title = $XML->title."";
	
		$this->listNews = array();
		foreach ( $XML->item as $item ) {
			$link 	= $item->link."";
			$id		= $this->getNewsIdFromNewsUrl($link);
			$findNews = $collection->findOne(array('newsId' => $id), array('_id' => 0));
			$news	= array();
			if ($findNews)
			{
				$news = $findNews;
			}
			else
			{
				$news['newsId'] 	= $id;
				$news['title'] 		= $item->title."";
				$news['link']		= $link;
				$news['shortDesc'] 	= $item->description."";
				$news['mobile'] 	= $item->mobile."";
				$news['pubDate'] 	= $item->pubDate."";
				$news['guid'] 		= $item->guid."";
	
				// Analyze HTML to achieve more information
				$html = file_get_html($link );
				$news['imageUrl']	= $this->getImageUrlFromHTML($html);
				$news['keywords']	= $this->getKeywordsFromHTML($html);
				$news['relatedPosts']= $this->getRelatedPostsFromHTMLandKeywords($html, $news['keywords']);
	
				//var_dump($news);
				$collection->insert($news);
			}
			array_push($this->listNews, $news);
		}
	}
	/**
	 * The 8-digit number at the end of each news' link is unique and can be considered as the ID of the article
	 * @param string $link
	 * @return ID of the article
	 */
	public static function getNewsIdFromNewsUrl($link)
	{
		$id = substr($link, -9, 8);
		return $id;
	}

	/**
	 * 
	 * @param string $html
	 * @return URL of the image in the article
	 */
	public static function getImageUrlFromHTML($html)
	{
		// <meta property="og:image" content="http://image.news.livedoor.com/newsimage/2/e/2ee22_293_9af5057d_a72bfd6f.jpg">
		preg_match('/<meta property="og:image" content="(.*?)">/', $html, $matches);
		if ($matches)
			if (count($matches) > 1)
				return $matches[1];
		return ""; 
	}

	/**
	 *
	 * @param string $html
	 * @return keywords of the news
	 */
	public static function getKeywordsFromHTML($html)
	{
		// <meta name="news_keywords" content="社会,トヨタの女性役員逮捕,密輸,麻薬,厚生労働省,トヨタ自動車,国内の事件・事故,ニュース">
		return "社会,トヨタの女性役員逮捕,密輸,麻薬,厚生労働省,トヨタ自動車,国内の事件・事故,ニュース";
		preg_match('/<meta name="news_keywords" content="(.*?)">/', $html, $matches);
		if ($matches)
			if (count($matches) > 1)
				return $matches[1];
		return ""; 
	}
	
	/**
	 * Find the related post keywords of the articles.
	 * If any article already have some related posts from outside, use them instead of finding in the database
	 * @param unknown $html
	 * @param unknown $keywords
	 * @return multitype:
	 */
	public static function getRelatedPostsFromHTMLandKeywords($html, $keywords)
	{
		return array();
	}

	/**
	 *
	 * @param string $html
	 * @return main content of the article
	 */
	public static function getLongDescFromHTML($html)
	{
		return $html->find('div.articleBody', 0);
	}

	/**
	 *
	 * @param string $html
	 * @return title of the article
	 */
	public static function getTitleFromHTML($html)
	{
		return $html->find('h1', 0)->innertext;
	}
	
	/**
	 * Find title and description of an article
	 * @param string $url
	 * @return title and description of the article
	 */
	public static function getTitleAndDescriptionFromUrl($url)
	{
		$html = file_get_html($url);
		return array(
				'title' => RSS::getTitleFromHTML($html),
				'description' => RSS::getLongDescFromHTML($html)
		);
	}
}