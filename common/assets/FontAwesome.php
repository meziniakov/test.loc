<?php

namespace common\assets;

use yii\web\AssetBundle;

class FontAwesome extends AssetBundle
{
    public $sourcePath = '@bower/font-awesome';
    public $css = [
        ['css/font-awesome.min.css', 'media' => 'print', 'onload' => 'this.media="all"; this.onload=null;']
    ];
}
