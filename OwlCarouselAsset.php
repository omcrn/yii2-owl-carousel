<?php
/**
 * Created by PhpStorm.
 * User: guga
 * Date: 12/9/16
 * Time: 6:40 PM
 */

namespace omicronsoft\owlcarousel;

use yii\web\AssetBundle;


/**
 * @author
 * @since 2.0
 */
class OwlCarouselAsset extends AssetBundle
{
    public $sourcePath = '@bower/owl.carousel1';
    public $js = [
        'owl-carousel/owl.carousel.' . (YII_DEBUG ? '' : 'min.') . 'js',
    ];

    public $css = [
        'owl-carousel/owl.carousel.css',
        'owl-carousel/owl.theme.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];

}