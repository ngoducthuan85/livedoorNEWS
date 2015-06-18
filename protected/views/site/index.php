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
              <div class="parent"><a href="<?php echo Yii::app()->request->baseUrl; ?>/site/movie/category/<?php echo Yii::app()->params['movie'] ?>/">映画</a></div>
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
			  <a href="<?php echo Yii::app()->request->baseUrl . "/site/article/detail/" . $news['newsId']; ?>">
			      <p class="articleListImg">
			      	<img src="<?php echo $news->imageUrl; ?>" alt="" onmousedown="return false;" onselectstart="return false;" oncontextmenu="return false;" galleryimg="no">
			      </p>
			    <div class="articleListBody">
			      <h3 class="articleListTtl"><?php echo $news['title'];?></h3>
			        <p class="articleListSummary"><?php echo $news['shortDesc'];?></p>
			      <time datetime="<?php echo $news->pubDate;?>" class="articleListDate"><?php echo $news['pubDate'];?></time>
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