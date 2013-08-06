<?php

/**
 * @property string $title
 */
class BaseAdminController extends BaseController
{
    public $layout = 'admin';

    public function adminPageName()
    {
        return null;
    }

    /**
     * Check rights for actions
     *
     * @param $action
     * @return bool
     */
    public function beforeAction($action)
    {
//        if (!(Y::checkAccess('admin') || Y::checkAccess('manager')) && !$this->isNoAuthAction()) {
//            $this->denyRequest('Недостаточно прав', array('/user/login'));
//        }

        $this->breadcrumbs = array(_t('admin', 'Control panel') => '/');
        if ($this->adminPageName() !== null) {
            $path = '';
            if (($module = $this->getModule()) !== null) {
                $path = '/'. $module->getName() . '/';
            }
            $this->breadcrumbs[$this->adminPageName()] = array('/'.$path.$this->id.'/index');
        }

        return parent::beforeAction($action);
    }

    public function beforeRender($view)
    {
        parent::beforeRender($view);

        $this->menu = array(
            array('label' => _t('admin-menu', 'Manufacters'), 'url' => array('/manufacter/index')),
            array('label' => _t('admin-menu', 'Motors'), 'url' => array('/motor/index')),
        );

        return true;
    }

    /**
     * Устаналивает название страницы и добавляет элемент в breadcrumbs
     *
     * @param string $title
     * @return void
     */
    protected function setTitle($title)
    {
        $this->breadcrumbs[] = $this->pageTitle = $title;
    }

    /**
     * Записывает в сессию реффер откуда пришли и достает его, если уже другой реферрер
     *
     * @param BaseActiveRecord $model
     * @param string $fromAction controller/action откуда должны прийти и куда потом редиректить
     * @param array $default урл по умолчанию
     * @return string|array
     */
    protected function getReturnTo($model, $fromAction, $default = array('index'))
    {
        // если на страницу пришли со страницы поиска, запоминаем урл
        $returnTo = $default;
        /** @var CHttpSession $session */
        $session = Yii::app()->getSession();
        $refferer = Y::app()->request->getUrlReferrer();

        $sessionKey = 'return_'.get_class($model).$model->id;
        $sessionKey2 = 'return_'.get_class($model);

        if (strpos($refferer, $fromAction)) {
            $session->add($sessionKey, $refferer);
            $returnTo = $refferer;
        } else if ($session->offsetExists($sessionKey)) {
            $returnTo = $session[$sessionKey];
        } else if ($session->offsetExists($sessionKey2)) {
            $returnTo = $session[$sessionKey2];
        }

        return $returnTo;
    }
}
