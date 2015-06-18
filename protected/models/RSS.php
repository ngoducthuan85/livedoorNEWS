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
 	* 
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
			$filter = array(
					'id' => $id
			);
			$findNews = $collection->findOne($filter);
			if ($findNews)
			{
				$news				= $findNews;
				array_push($this->listNews, $news);
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
// 				$news['keywords']	= $this->getKeywordsFromNewsUrl($link);
 				$news['relatedPosts']= $this->getRelatedPostsFrom($html, $news['keywords']);
				
				var_dump($news);
				$collection->insert($news);
				break;
			}
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

	/**
	 * 
	 * @param string $html
	 * @return URL of the image in the article
	 */
	public function getImageUrlFromHTML($html)
	{
		preg_match('/<meta property="og:image" content="(.*?)" \/>/', $html, $matches);
		foreach ($matches as $url)
		{
			if (strlen($url) > 10)
				return $this->standardizeddUrl($url);
		}
		return null;
	}
	
	/**
	 * 
	 * @param string $link
	 * @return List of keywords
	 */
	public function getKeywordsFromNewsUrl($link)
	{
		$tags = get_meta_tags($link);
		$keywords = $tags['news_keywords'];
		return $keywords;
	}
	
	public function getRelatedPostsFrom($html, $keywords)
	{
		return array();
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