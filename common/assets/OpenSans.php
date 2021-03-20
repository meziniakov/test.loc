<?php

namespace common\assets;

use yii\web\AssetBundle;

class OpenSans extends AssetBundle
{
    public $sourcePath = '@bower/open-sans-fontface';
    public $css = [
        'open-sans.css',
        // ['open-sans.css', 'media' => 'print', 'onload' => 'this.media="all"; this.onload=null;']
    ];
}
