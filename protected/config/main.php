<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Web Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		*/
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		//'adminEmail'=>'webmaster@example.com',
		/*
		主要：http://news.livedoor.com/topics/rss/top.xml 
		国内：http://news.livedoor.com/topics/rss/dom.xml 
		海外：http://news.livedoor.com/topics/rss/int.xml 
		IT 経済：http://news.livedoor.com/topics/rss/eco.xml 
		芸能：http://news.livedoor.com/topics/rss/ent.xml 
		スポーツ：http://news.livedoor.com/topics/rss/spo.xml 
		映画：http://news.livedoor.com/rss/summary/52.xml 
		グルメ：http://news.livedoor.com/topics/rss/gourmet.xml 
		女子：http://news.livedoor.com/topics/rss/love.xml 
		トレンド：http://news.livedoor.com/topics/rss/trend.xml 
		*/
		'top'=>'http://news.livedoor.com/topics/rss/top.xml',
		'domestic'=>'http://news.livedoor.com/topics/rss/dom.xml',
		'world'=>'http://news.livedoor.com/topics/rss/int.xml',
		'economics'=>'http://news.livedoor.com/topics/rss/.xml',
		'entertainment'=>'http://news.livedoor.com/topics/rss/.xml',
		'sports'=>'http://news.livedoor.com/topics/rss/.xml',
		'movie'=>'http://news.livedoor.com/topics/rss/.xml',
		'gourmet'=>'http://news.livedoor.com/topics/rss/.xml',
		'women'=>'http://news.livedoor.com/topics/rss/love.xml',
		'trend'=>'http://news.livedoor.com/topics/rss/trend.xml',
		),
);