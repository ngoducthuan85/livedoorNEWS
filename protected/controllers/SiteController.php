<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		//$category=null;
		$rssPath = Yii::app()->params['RSSroot'] . Yii::app()->params['main'] . ".xml";
		
		if(isset($_GET['category']))
		{
			$rssPath = Yii::app()->params['RSSroot'] . $_GET['category'] . ".xml";
			if ($_GET['category'] == Yii::app()->params['movie'])
				$rssPath = Yii::app()->params['RSSsummary'] . $_GET['category'] . ".xml";
		}
		$RSS = new RSS($rssPath);
		$this->render('index', array('title' => $RSS->title, 'listNews' => $RSS->listNews));
	}

	/**
	 * This is the action to choose topic
	 */
	public function actionTopics()
	{
		$this->actionIndex();
	}
	
	/**
	 * This is the action to select list of movie news
	 */
	public function actionMovie()
	{
		if(isset($_GET['category']))
		{
			if ($_GET['category'] == Yii::app()->params['movie'])
			{
				$rssPath = Yii::app()->params['RSSsummary'] . $_GET['category'] . ".xml";
				$RSS = new RSS($rssPath);
				$this->render('movie', array('title' => $RSS->title, 'listNews' => $RSS->listNews));
				return;
			}
		}
		$this->actionIndex();
	}
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * This is the action to view the detail of an article
	 */
	public function actionArticle()
	{
		if(isset($_GET['detail']))
		{

		}
		$this->render('article', array('title' => $RSS->title, 'listNews' => $RSS->listNews));
	}
}