<?php

/**
 * Created by PhpStorm.
 * User: guga
 * Date: 12/9/16
 * Time: 6:21 PM
 */
namespace omicronsoft\owlcarousel;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;

class OwlDbCarouselWidget extends Widget

{

    public $enablePopUp = true;

    /**
     * img, caption pair
     * @example [['img' =>'http://domain.com/my_image.jpg', 'caption' => '<p>my caption</p>']]
     * @var array
     */
    public $items = [];

    public $options;

    public $itemOptions = [];

    public $imgOptions = [];

    public $clientOptions = [];
    /**
     * @var array
     */
//    public $controls = [
//        '<span class="glyphicon glyphicon-chevron-left"></span>',
//        '<span class="glyphicon glyphicon-chevron-right"></span>',
//    ];

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (empty($this->items)) {
            throw new InvalidConfigException;
        }

        $items = [];


        foreach ($this->items as $index => $item) {
            /** @var $item \centigen\i18ncontent\models\WidgetCarouselItem */
            if (isset($item['img'])) {
                $items[$index]['content'] = Html::img($item['img'], $this->imgOptions);
            }

            if (isset($item['caption'])) {
                $items[$index]['content'] = Html::tag('div', $items[$index]['content'] . Html::tag('div', $item['caption'],
                        ['class' => 'text-center owl-caption']));
            }
        }
        //Yii::$app->cache->set($cacheKey, $items, 60 * 60 * 24 * 365);
        $this->items = $items;


        parent::init();
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        if (count($this->items) === 0) {
            return "";
        }
        $this->registerPlugin();
        return $this->renderItems();
    }


    protected function renderItems()
    {
        $this->options = ArrayHelper::merge($this->options, ['class' => 'owl-carousel']);


        $items = [];
        foreach ($this->items as $k => $item) {
            $items[] = $item['content'];
        }

        return Html::tag('div', implode("\n", $items), $this->options);
    }

    protected function registerPlugin()
    {


        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }

        $view = $this->getView();

        OwlCarouselAsset::register($view);

        $id = $this->options['id'];

        if ($this->clientOptions !== false) {
            $name = 'owlCarousel';
            $this->getClientOptions();

            $options = empty($this->clientOptions) ? '' : Json::encode($this->clientOptions);


            $js = "$('#$id').$name($options);";


            $view->registerJs($js);
        }
    }

    protected function defaultClientOptions()
    {
        return [
            'autoplay' => true,
            'loop' => true,
            'smartSpeed' => 500,
            'navSpeed' => 1000,
            'singleItem' => false,
            'items' => 6,
            'nav' => true,
            'responsive' => [
                0 => [
                    'items' => 1
                ],
                480 => [
                    'items' => 2
                ],
                767 => [
                    'items' => 3
                ],
                991 => [
                    'items' => 4
                ],
                1200 => [
                    'items' => 6
                ]
            ],
            'navText' => ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"]
        ];
    }

    protected function getClientOptions()
    {
        $this->clientOptions = ArrayHelper::merge($this->defaultClientOptions(), $this->clientOptions);
    }

}