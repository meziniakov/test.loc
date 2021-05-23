<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use common\assets\Highlight;
use metalguardian\fotorama\Fotorama;

/* @var $this yii\web\View */
/* @var $model common\models\Article */

Highlight::register($this);

$this->title = $model->title;
?>
<article class="wallpaper">
	<div class="row post-details">
	<div class="col-lg-8 col-md-12 col-sm-12 col-12">
		<?php foreach($data['blocks'] as $blocks) {
			if (isset($blocks['data'])) {
				switch ($blocks['type']):
					case 'header':
						echo "<h2>" . $blocks['data']['text'] . "</h2>" . PHP_EOL;
						break;
					case 'paragraph':
						echo '<p class="heading">' . $blocks['data']['text'] . '</p>' . PHP_EOL;
						break;
					// case 'image':
					// 	echo (isset($blocks['data']['file']['url'])) ? Html::img($blocks['data']['file']['url'], ['alt' => $blocks['data']['caption'], 'class' => 'image-tool__image-picture img-responsive']) : "";
					// 	break;
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
								'useHtmlData' => false,
								'htmlOptions' => [
									'class' => 'custom-class',
									'id' => 'custom-id',
								],
							]
						);
						foreach ($blocks['data'] as $image) {
							echo (isset($image['url'])) ? Html::img($image['url'], [
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

</div>
</article>