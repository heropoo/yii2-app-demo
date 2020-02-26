<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class LayuiAsset extends AssetBundle
{
    public $sourcePath = '@npm';
    public $css = [
        'layui-src/dist/css/layui.css'
    ];
    public $js = [
        'jquery/dist/jquery.js',
        'layui-src/dist/layui.js'
    ];
    public $depends = [
    ];
}
