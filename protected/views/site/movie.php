<div id="content">
  <div class="contentInner">
    <div id="nav">
      <div class="navInner">
        <nav style="position: static; top: auto; bottom: auto; left: auto;" id="globalNav">
          <ul>
            <li class="selected">
              <div class="parent"><a href="<?php echo Yii::app()->request->baseUrl; ?>/site/topics/category/<?php echo Yii::app()->params['main'] ?>/">主要</a></div>
            </li>
            <li>
              <div class="parent"><a href="<?php echo Yii::app()->request->baseUrl; ?>/site/topics/category/<?php echo Yii::app()->params['domestic'] ?>/">国内</a></div>
            </li>
            <li>
              <div class="parent"><a href="<?php echo Yii::app()->request->baseUrl; ?>/site/topics/category/<?php echo Yii::app()->params['world'] ?>/">海外</a></div>
            </li>
            <li>
              <div class="parent"><a href="<?php echo Yii::app()->request->baseUrl; ?>/site/topics/category/<?php echo Yii::app()->params['economics'] ?>/">IT 経済</a></div>
            </li>
            <li>
              <div class="parent"><a href="<?php echo Yii::app()->request->baseUrl; ?>/site/topics/category/<?php echo Yii::app()->params['entertainment'] ?>/">芸能</a></div>
            </li>
            <li>
              <div class="parent"><a href="<?php echo Yii::app()->request->baseUrl; ?>/site/topics/category/<?php echo Yii::app()->params['sports'] ?>/">スポーツ</a></div>
            </li>
            <li>
              <div class="parent"><a href="<?php echo Yii::app()->request->baseUrl; ?>/site/topics/category/<?php echo Yii::app()->params['movie'] ?>/">映画</a></div>
            </li>
            <li>
              <div class="parent"><a href="<?php echo Yii::app()->request->baseUrl; ?>/site/topics/category/<?php echo Yii::app()->params['gourmet'] ?>/">グルメ</a></div>
            </li>
            <li>
              <div class="parent"><a href="<?php echo Yii::app()->request->baseUrl; ?>/site/topics/category/<?php echo Yii::app()->params['women'] ?>/">女子</a></div>
            </li>
            <li>
              <div class="parent"><a href="<?php echo Yii::app()->request->baseUrl; ?>/site/topics/category/<?php echo Yii::app()->params['trend'] ?>/">トレンド</a></div>
            </li>
          </ul>
        </nav>
      </div><!-- /.navInner -->
    </div><!-- /#nav -->

  <div id="main">
    <div class="mainInner">
      <section class="mainSec">
        <header class="mainHeader">
          <h1 class="mainTtl"><?php echo $title;?></h1>
        </header>
        <div class="mainBody">
          <ul class="articleList">
          	<?php foreach ($listNews as $news):?>
			<li class="hasImg">
			  <a href="<?php echo $news->link; ?>"">
			  	<!-- 
			      <p class="articleListImg">
			      	<img src="http://sl.news.livedoor.com/3690877e12efc5edf49ddfc3b9774ea76b8c01e3/small_light(p=S80,dx=0,dy=0)/http://image.news.livedoor.com/newsimage/0/e/0ecc2_648_08f96503-cm.jpg" alt="　開会予定時刻を過ぎても始まらない衆院平和安全法制特別委＝１７日午前" onmousedown="return false;" onselectstart="return false;" oncontextmenu="return false;" galleryimg="no">
			      </p>
			     -->
			    <div class="articleListBody">
			      <h3 class="articleListTtl"><?php echo $news->title;?></h3>
			        <p class="articleListSummary"><?php echo $news->shortDesc;?></p>
			      <time datetime="<?php echo $news->pubDate;?>" class="articleListDate"><?php echo $news->pubDate;?></time>
			    </div>
			  </a>
			</li>
			<?php endforeach;?>
          </ul>
        </div>
        </section>
      </div><!-- /subInner -->
    </div><!-- /#sub -->

  </div><!-- /.contentInner -->
</div>