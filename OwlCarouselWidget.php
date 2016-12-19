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

class OwlCarouselWidget extends Widget

{

    public $enablePopUp = true;

    /**
     * img, caption pair
     * @example [['img' =>'http://domain.com/my_image.jpg', 'caption' => '<p>my caption</p>']]
     * @var array
     */
    public $items = [];

    public $itemView;

    public $options;

    public $separator = '';

    public $itemOptions = [];

    public $imgOptions = [];

    public $clientOptions = [];
    /**
     * @var array
     */

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (empty($this->items)) {
            throw new InvalidConfigException;
        }


        foreach ($this->items as $index => &$item) {

            if (isset($item['caption'])) {
                $item['content'] = Html::tag('div', $item['caption'] . Html::img($item['img'], $this->imgOptions));
            }else if (isset($item['img'])) {
                $item['content'] = Html::img($item['img'], $this->imgOptions);
            }

        }
        //Yii::$app->cache->set($cacheKey, $items, 60 * 60 * 24 * 365);

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
        foreach ($this->items as $index => $item) {
            $items[] = $this->renderItem($item, $index);
//            $items[] = $item['content'];
        }
        //return implode($this->separator, $items);
        return Html::tag('div', implode("\n", $items), $this->options);
    }

    /**
     * Renders a single data model.
     * @param mixed $model the data model to be rendered
     * @param int $index the zero-based index of the data model in the model array returned by [[dataProvider]].
     * @return string the rendering result
     */
    public function renderItem($model, $index)
    {
        if ($this->itemView === null) {
            $content = $model['content'];
        } elseif (is_string($this->itemView)) {
            $content = $this->getView()->render($this->itemView, array_merge([
                'model' => $model,
                'index' => $index,
                'widget' => $this,
            ], $this->viewParams));
        } else {
            $content = call_user_func($this->itemView, $model, $index, $this);
        }
        if ($this->itemOptions instanceof Closure) {
            $options = call_user_func($this->itemOptions, $model, $index, $this);
        } else {
            $options = $this->itemOptions;
        }
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        return Html::tag($tag, $content, $options);
    }

    protected function registerPlugin()
    {


        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }

        $view = $this->getView();



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
            'items' => 1,
            'nav' => true,
            'navText' => ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"]
        ];
    }

    protected function getClientOptions()
    {
        $this->clientOptions = ArrayHelper::merge($this->defaultClientOptions(), $this->clientOptions);
    }

}