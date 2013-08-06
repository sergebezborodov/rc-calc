<?php

Yii::import('zii.widgets.*');

/**
 * Админское меню
 * формат item
 *
 * array('label'=>'Home', 'url'=>array('site/index'), 'icon' => 'путь к иконке'),
 *
 */
class AdminMenuWidget extends CMenu {

    /**
     * @var string путь к иконкам
     */
    public $iconsRoot = '/images/icons/';

    /**
     * Иницилизация меню
     */
    public function init() {

        foreach ($this->items as &$item) {
            if (empty($item['linkOptions']['class'])) {
                $item['linkOptions']['class'] = '';
            }
            if (empty($item['linkOptions']['style'])) {
                $item['linkOptions']['style'] = '';
            }

            if (isset($item['icon'])) {
                $item['label'] = "<i class='icon-{$item['icon']}'></i>" . $item['label'];
                unset($item['icon']);
            }
        }

        parent::init();
    }

}
