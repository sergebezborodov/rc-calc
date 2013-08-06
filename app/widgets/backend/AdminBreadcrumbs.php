<?php
Yii::import('zii.widgets.*');

/**
 * Админские хлебные крошки
 */
class AdminBreadcrumbs extends CBreadcrumbs {
    public $separator = "\r\n";

    /**
     * Рендеринг
     */
    public function run() {
        if (empty($this->links)) {
            return;
        }

        echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";

        $links = array();

        foreach($this->links as $label=>$url) {
            if(is_string($label) || is_array($url)) {
                $links[]= '<li class="parent">' . CHtml::link($this->encodeLabel ? CHtml::encode($label) : $label, $url)
                        . '<span class="divider">/</span></li>';
            } else {
                $links[]='<li class="current">'.($this->encodeLabel ? CHtml::encode($url) : $url).
                        '</li>';
            }
        }
        echo "<ul class='breadcrumb'>";
        echo implode($this->separator, $links);
        echo '</ul>';
        echo CHtml::closeTag($this->tagName);
    }
}
