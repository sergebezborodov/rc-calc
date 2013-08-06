<?php

/**
 * Url Manager с поддержкой языков
 */
class UrlManager extends CUrlManager
{
    public $defaultLanguage = 'en';

    public $notLangRoutes = array();

    protected function isNoLangRoute($route)
    {
        return in_array($route, $this->notLangRoutes);
    }

    /**
     * @param string $route
     * @param array $params
     * @param string $ampersand
     * @return string
     */
    public function createUrl($route, $params=array(), $ampersand='&')
    {
        if (empty($params['nl']) && !isset($params['language']) && !$this->isNoLangRoute($route)) {
            if (Yii::app()->user->hasState('language')) {
                Yii::app()->language = Yii::app()->user->getState('language');
            } else if(isset(Yii::app()->request->cookies['language'])) {
                Yii::app()->language = Yii::app()->request->cookies['language']->value;
            } else {
                Yii::app()->language = $this->defaultLanguage;
            }
            $params['language'] = Yii::app()->language;
            if (substr($route, 0, 1) != '/') {
                $route = '/'.$route;
            }
        }
        unset($params['nl']);
        return parent::createUrl($route, $params, $ampersand);
    }
}
