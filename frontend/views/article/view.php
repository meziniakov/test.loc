<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
use common\assets\Highlight;
use metalguardian\fotorama\Fotorama;

/* @var $this yii\web\View */
/* @var $model common\models\Article */

Highlight::register($this);

$this->params['breadcrumbs'][] = [
	'label' => Yii::t('frontend', 'Articles'),
	'url' => Url::to('/article')
];
$this->params['breadcrumbs'][] = [
	'label' => $model->category->title,
	'url' => Url::to('/place/'.$model->category->slug)
];
$this->params['breadcrumbs'][] = Yii::t('frontend', $model->title);
$this->title = Yii::t('frontend', $model->title);
?>

<article class="wallpaper">
	<header class="article-header">
		<div class="article-header__meta">
			<ul class="meta-comment-tag">
				<li><a href="#"><span class="icons"><i class="ti-user"></i></span><?= Html::a($model->author->username, ['account/default/view', 'id' => $model->author->id]) ?></a></li>
				<!-- <li><a href="#"><span class="icons"><i class="ti-comment-alt"></i></span>45 Comments</a></li> -->
				<li><a href="#"><span class="icons"><i class="ti-map"></i></span><?= Html::a($model->category->title, ['article/category', 'slug' => $model->category->slug]) ?></a></li>
				<li><a href="#"><span class="icons"><i class="ti-time"></i></span><?= Yii::$app->formatter->asDatetime($model->published_at, 'HH:mm') ?></a></li>
			</ul>
		</div>
		<?php $img = $model->getImage(); ?>
		<div class="article-header__cover" style="background-image: url(<?= $img->getUrl('1800x') ?>)"></div>
		<h1 class="article-header__title"><?= Html::encode($this->title) ?></h1>
	</header>

	<div class="row post-details">
	<div class="col-lg-8 col-md-12 col-sm-12 col-12">
		<?php foreach ($data['blocks'] as $blocks) {
			if (isset($blocks['data'])) {
				switch ($blocks['type']):
					case 'header':
						echo "<h2>" . $blocks['data']['text'] . "</h2>" . PHP_EOL;
						break;
					case 'paragraph':
						echo '<p class="heading">' . $blocks['data']['text'] . '</p>' . PHP_EOL;
						break;
					case 'image':
						(isset($blocks['data']['file']['url'])) ? Html::img($blocks['data']['file']['url'], ['alt' => $blocks['data']['caption'], 'class' => 'img-responsive image-tool__image-picture']) : "";
						break;
					case 'delimiter':
						echo '<div class="delimiter"></div>' . PHP_EOL;
						break;
					case 'checklist':
						foreach ($blocks['data']['items'] as $items) {
							echo ($items['checked']) ? '<div class="cdx-checklist__item cdx-checklist__item--checked"><span class="cdx-checklist__item-checkbox"></span><div class="cdx-checklist__item-text">' . $items['text'] . '</div></div>' : '<div class="cdx-checklist__item"><span class="cdx-checklist__item-checkbox"></span><div class="cdx-checklist__item-text">' . $items['text'] . '</div></div>';
						}
						break;
					case 'list':
						echo ($blocks['data']['style'] == 'ordered') ? "<ol>" : "<ul>";
						foreach ($blocks['data']['items'] as $items) {
							echo '<li>' . $items . '</li>' . PHP_EOL;
						}
						echo ($blocks['data']['style'] == 'ordered') ? "</ol>" : "</ul>";
						break;

					case 'carousel':
						$fotorama = Fotorama::begin(
							[
								'options' => [
									'loop' => true,
									'hash' => true,
									'ratio' => 800 / 600,
									'nav' => 'thumbs',
									'arrows' => false,
								],
								'spinner' => [
									'lines' => 20,
								],
								'tagName' => 'span',
								'useHtmlData' => true,
								'htmlOptions' => [
									// 'class' => 'custom-class',
									// 'id' => 'custom-id',
								],
							]
						);
						foreach ($blocks['data'] as $image) {
							echo (isset($image['url'])) ? Html::img(Html::decode($image['url']), [
								'alt' => $image['caption'],
								'data-caption' => $image['caption'],
								'class' => 'image-tool__image-picture img-responsive'
							]) : "";
						}
						Fotorama::end();
						break;
				endswitch;
			}
		}
		?>

<footer class="post-bottom-meta">
		<?php if ($model->tagValues) : ?>
			<div class="post-tags">
				<!-- <h4 class="pbm-title">Метки</h4> -->
				<ul class="list">
					<?php foreach ($model->tagLinksArray as $tag) : ?>
						<li><?= $tag ?></li>
					<?php endforeach ?>
				</ul>
			</div>
		<?php endif ?>
	</footer>


	</div>

	<div class="col-lg-3 col-md-12 col-sm-12 col-12">
			<!-- Categories -->
			<div class="single-widgets widget_category">
			<h4 class="title">Категории</h4>
			<ul>
				<?php foreach ($categories as $category) : ?>
					<li><?= Html::a($category->title, ['category', 'slug' => $category->slug]) ?></li>
				<?php endforeach ?>
			</ul>
		</div>

		<!-- Trending Posts -->
		<!-- <div class="single-widgets widget_thumb_post">
								<h4 class="title">Trending Posts</h4>
								<ul>
									<li>
										<span class="left">
											<img src="https://via.placeholder.com/1200x850" alt="" class="">
										</span>
										<span class="right">
											<a class="feed-title" href="#">Alonso Kelina Falao Asiano Pero</a> 
											<span class="post-date"><i class="ti-calendar"></i>10 Min ago</span>
										</span>
									</li>
								</ul>
							</div> -->

		<!-- Tags Cloud -->
		<div class="single-widgets widget_tags">
			<h4 class="title">Метки</h4>
			<ul>
				<?php foreach ($tags as $tag) : ?>
					<li><?= Html::a($tag->name, ['tag', 'slug' => $tag->slug]) ?></li>
				<?php endforeach ?>
			</ul>
		</div>
	</div>

</div>


	<!-- <div class="single-post-pagination">
										<div class="prev-post">
											<a href="#">
												<div class="title-with-link">
													<span class="intro">Prev Post</span>
													<h3 class="title">Tips on Minimalist</h3>
												</div>
											</a>
										</div>
										<div class="post-pagination-center-grid">
											<a href="#"><i class="ti-layout-grid3"></i></a>
										</div>
										<div class="next-post">
											<a href="#">
												<div class="title-with-link">
													<span class="intro">Next Post</span>
													<h3 class="title">Less Is More</h3>
												</div>
											</a>
										</div>
									</div> -->

	<!-- Author Detail -->
	<!-- <div class="blog-details single-post-item format-standard">
								
								<div class="posts-author">
									<span class="img"><img class="img-fluid" src="https://via.placeholder.com/400x400" alt=""></span>
									<h3 class="pa-name">Rosalina William</h3>
									<ul class="social-links">
										<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
										<li><a href="#"><i class="fab fa-twitter"></i></a></li>
										<li><a href="#"><i class="fab fa-behance"></i></a></li>
										<li><a href="#"><i class="fab fa-youtube"></i></a></li>
										<li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
									</ul>
									<p class="pa-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
									aliqua. Ut enim ad minim veniam, quis nostrud
									exercitation ullamco laboris nisi ut aliquip ex ea commodo.</p>
								</div>
								
							</div> -->

	<!-- Blog Comment -->
	<!-- <div class="blog-details single-post-item format-standard">
								
								<div class="comment-area">
									<div class="all-comments">
										<h3 class="comments-title">05 Comments</h3>
										<div class="comment-list">
											<ul>
												<li class="single-comment">
													<article>
														<div class="comment-author">
															<img src="https://via.placeholder.com/400x400" alt="">
														</div>
														<div class="comment-details">
															<div class="comment-meta">
																<div class="comment-left-meta">
																	<h4 class="author-name">Rosalina Kelian <span class="selected"><i class="fas fa-bookmark"></i></span></h4>
																	<div class="comment-date">19th May 2018</div>
																</div>
																<div class="comment-reply">
																	<a href="#" class="reply"><span class="icona"><i class="ti-back-left"></i></span> Reply</a>
																</div>
															</div>
															<div class="comment-text">
																<p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim laborumab.
																	perspiciatis unde omnis iste natus error.</p>
															</div>
														</div>
													</article>
													<ul class="children">
														<li class="single-comment">
															<article>
																<div class="comment-author">
																	<img src="https://via.placeholder.com/400x400" alt="">
																</div>
																<div class="comment-details">
																	<div class="comment-meta">
																		<div class="comment-left-meta">
																			<h4 class="author-name">Rosalina Kelian</h4>
																			<div class="comment-date">19th May 2018</div>
																		</div>
																		<div class="comment-reply">
																			<a href="#" class="reply"><span class="icons"><i class="ti-back-left"></i></span> Reply</a>
																		</div>
																	</div>
																	<div class="comment-text">
																		<p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim laborumab.
																			perspiciatis unde omnis iste natus error.</p>
																	</div>
																</div>
															</article>
															<ul class="children">
																<li class="single-comment">
																	<article>
																		<div class="comment-author">
																			<img src="https://via.placeholder.com/400x400" alt="">
																		</div>
																		<div class="comment-details">
																			<div class="comment-meta">
																				<div class="comment-left-meta">
																					<h4 class="author-name">Rosalina Kelian</h4>
																					<div class="comment-date">19th May 2018</div>
																				</div>
																				<div class="comment-reply">
																					<a href="#" class="reply"><span class="icons"><i class="ti-back-left"></i></span> Reply</a>
																				</div>
																			</div>
																			<div class="comment-text">
																				<p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim laborumab.
																					perspiciatis unde omnis iste natus error.</p>
																			</div>
																		</div>
																	</article>
																</li>
															</ul>
														</li>
													</ul>
												</li>
												<li class="single-comment">
													<article>
														<div class="comment-author">
															<img src="https://via.placeholder.com/400x400" alt="">
														</div>
														<div class="comment-details">
															<div class="comment-meta">
																<div class="comment-left-meta">
																	<h4 class="author-name">Rosalina Kelian</h4>
																	<div class="comment-date">19th May 2018</div>
																</div>
																<div class="comment-reply">
																	<a href="#" class="reply"><span class="icons"><i class="ti-back-left"></i></span> Reply</a>
																</div>
															</div>
															<div class="comment-text">
																<p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim laborumab.
																	perspiciatis unde omnis iste natus error.</p>
															</div>
														</div>
													</article>
												</li>
											</ul>
										</div>
									</div>
									<div class="comment-box submit-form">
										<h3 class="reply-title">Post Comment</h3>
										<div class="comment-form">
											<form action="#">
												<div class="row">
													<div class="col-lg-6 col-md-6 col-sm-12">
														<div class="form-group">
															<input type="text" class="form-control" placeholder="Your Name">
														</div>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-12">
														<div class="form-group">
															<input type="text" class="form-control" placeholder="Your Email">
														</div>
													</div>
													<div class="col-lg-12 col-md-12 col-sm-12">
														<div class="form-group">
															<textarea name="comment" class="form-control" cols="30" rows="6" placeholder="Type your comments...."></textarea>
														</div>
													</div>
													<div class="col-lg-12 col-md-12 col-sm-12">
														<div class="form-group">
															<a href="#" class="btn search-btn">Submit Now</a>
														</div>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
								
							</div> -->



	<!-- Single blog Grid -->
	<!-- <div class="col-lg-3 col-md-12 col-sm-12 col-12"> -->
		<!-- Searchbard -->
		<!-- <div class="single-widgets widget_search">
								<h4 class="title">Search</h4>
								<form action="#" class="sidebar-search-form">
									<input type="search" name="search" placeholder="Search..">
									<button type="submit"><i class="ti-search"></i></button>
								</form>
							</div> -->


	<!-- </div> -->
</article>