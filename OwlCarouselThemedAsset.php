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
class OwlCarouselThemedAsset extends AssetBundle
{
    public $sourcePath = '@bower/owl.carousel/dist';
    public $js = [
        'owl.carousel.min.js',
    ];

    public $css = [
        'assets/owl.carousel.min.css',
        'assets/owl.theme.default.min.css',
    ];

    public $depends=[
        'yii\web\JqueryAsset'
    ];

}