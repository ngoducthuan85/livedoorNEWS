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
 				$news['relatedPosts']= $this->getRelatedPostsFrom($html, $news['keywords']);
				
				var_dump($news);
				$collection->insert($news);
				array_push($this->listNews, $news);
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
		preg_match('/<meta property="og:image" content="(.*?)">/', $html, $matches);
		return $matches[1];
	}

	/**
	 *
	 * @param string $html
	 * @return URL of the image in the article
	 */
	public function getKeywordsFromHTML($html)
	{
		// <meta name="keywords" content="社会,トヨタの女性役員逮捕,密輸,麻薬,厚生労働省,トヨタ自動車,国内の事件・事故,ニュース">
		preg_match('/<meta name="news_keywords" content="(.*?)" \/>/', $html, $matches);
		return $matches[1];
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
	 * Get image url from meta tag gotten by parsing HTML
	 * The resulted URLs look like:
	 * <meta property="og:image" content="http://image.news.livedoor.com/newsimage/7/1/7139e_130_2011032304_01.jpg"> <meta property="og:image:width" content="400"/>
	 * 
	 * @param string $url
	 */
	public function getImageUrlFromMetaTag($str)
	{
		$start 	= strpos($str, "content=") + 9;
		$end 	= strpos($str, "> <")-2;
		$url 	= substr($str, $start, $end-$start+1);
		return $url;
	}
}