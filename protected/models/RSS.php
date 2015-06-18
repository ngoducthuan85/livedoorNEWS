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
		$m          = new Mongo('mongodb://ngoducthuan85:ngoducthuan85@ds045242.mongolab.com:45242/livedoor'); // connect
		$db         = $m->selectDB('livedoor');
		$collection = $db->selectCollection('news');
		
		$XML = simplexml_load_file ( $rssPath );
		$XML = $XML->channel;
		$this->title = $XML->title;
		
		$this->listNews = array();
		foreach ( $XML->item as $item ) {
			$link 	= $item->link;
			$id		= $this->getNewsIdFromNewsUrl($link);
			$filter = array(
					'id'=>$id
			);
			$findNews = $db->find($filter);
			var_dump($findNews);
			
			$news				= array();
			$news['title'] 		= $item->title;
			$news['link']		= $item->link;
			$news['shortDesc'] 	= $item->description;
			$news['mobile'] 	= $item->mobile;
			$news['pubDate'] 	= $item->pubDate;
			$news['guid'] 		= $item->guid;
			
			array_push($this->listNews, $news);
		}
	}
	
	/**
	 * The 8-digit number at the end of each news' link is unique and can be considered as the ID of the article
	 * @param string $link
	 * @return ID of the article
	 */
	public function getNewsIdFromNewsUrl($link)
	{
		$id = substr($link, -9, 8);
		return $id;
	}

	public function selectNewsFromDatabase($id)
	{
		$m          = new Mongo('mongodb://ngoducthuan85:ngoducthuan85@ds045242.mongolab.com:45242/livedoor'); // connect
		$db         = $m->selectDB('livedoor');
		$collection = $db->selectCollection('news');
		$filter = array(
				'id'=>$id
		);
		$news     = $db->find($filter);
		return $news;
	}
	
	public function inserNewsToDatabase($array)
	{
		$m          = new Mongo('mongodb://ngoducthuan85:ngoducthuan85@ds045242.mongolab.com:45242/livedoor'); // connect
		$db         = $m->selectDB('livedoor');
		$collection = $db->selectCollection('news');
		$news     = $db->insert($array);
		return $news;
	}
	
	public function getImageUrlFromNewsUrl($link)
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
	
	public function getKeywordsFromNewsUrl($link)
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