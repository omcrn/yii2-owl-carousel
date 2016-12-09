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
    public $basePath = '@vendor/omicronsoft/yii2-owl-carousel/assets';
    public $baseUrl = '@web';



    public $js = [
        'js/owl.carousel.min.js',
    ];

    public $depends = [
        'frontend\assets\FrontendAsset'
    ];

}