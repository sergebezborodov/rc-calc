<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 *
 * @property string pageTitle
 */
abstract class BaseController extends MController
{
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/1column.php'.
     */
    public $layout = '//layouts/main';
    
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    public $langMenu = array();

    public $hideBreadcrumbs = false;

    public $langs;

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    public $leftMenu = array();

    public function beforeAction($action)
    {
        // редирект старого урла без языка
        if ($this->id == 'calc' && $this->action->id == 'copter' && empty($_GET['language'])) {
            $this->redirect(array('/calc/copter', 'language' => 'ru'));
        }

        if(isset($_GET['language'])) {
            Yii::app()->language = $_GET['language'];
            Yii::app()->user->setState('language', $_GET['language']);
            $cookie = new CHttpCookie('language', $_GET['language']);
            $cookie->expire = time() + (60*60*24*365); // (1 year)
            Yii::app()->request->cookies['language'] = $cookie;
        }
        else if (Yii::app()->user->hasState('language')) {
            Yii::app()->language = Yii::app()->user->getState('language');
        } else if(isset(Yii::app()->request->cookies['language'])) {
            Yii::app()->language = Yii::app()->request->cookies['language']->value;
        }

        return true;
    }
    
    /**
     * Главная ли это страница
     * 
     * @return bool
     */
    public function getIsMainPage() 
    {
        return Y::app()->controller->id === 'site' 
            && Y::app()->controller->action->id === 'index';
    }

    /**
     * Add item to left menu
     *
     * @param $item
     */
    protected function addLeftMenuItem($item)
    {
        $this->leftMenu[] = $item;
    }

    /**
     * Добавляет элемент в breadcrumbs
     *
     * @param string       $title
     * @param array|string $url
     * @return void
     */
    protected function addBreadcrumbs($title, $url = null)
    {
        if ($url === null) {
            $this->breadcrumbs[] = $title;
        } else {
            $this->breadcrumbs[$title] = $url;
        }
    }

    /**
     * Загрузка модели по id
     *
     * @throws CHttpException
     * @param string $modelName
     * @param int $modelId
     * @return BaseActiveRecord
     */
    protected function loadModel($modelName, $modelId = null)
    {
        if ($modelId === null && empty($_GET['id'])) {
            throw new CHttpException(400, 'Не указан id модели');
        }
        $id    = $modelId === null ? $_GET['id'] : $modelId;
        $model = BaseActiveRecord::model($modelName)->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, "Запись #{$id} модели {$modelName} не найден в системе");
        }
        return $model;
    }

    public function beforeRender($view)
    {
        parent::beforeRender($view);

        $this->menu = array(
            array('label' => _t('menu', 'Home'), 'url' => array('/site/index')),
            array('label' => _t('menu', 'Copter'), 'url' => array('/calc/copter'))
        );

        $langsMenu = array();
        $availableLangs = Y::param('langs');
        foreach ($availableLangs as $lang => $title) {
            $params = array_merge($_GET, array('language' => $lang));
            $langsMenu[] = array(
                'label' => $title,
                'url'   => $this->createUrl('/'.$this->id . '/' . $this->action->id, $params),
            );
            $this->langs[$title] = $this->createUrl('/'.$this->id . '/' . $this->action->id, $params);
        }
        $this->langMenu = array(
            array('label' => $availableLangs[Yii::app()->language], 'url' => '#',
                  'items' => $langsMenu,
            ),
        );

        return true;
    }

    /**
     * Проверка на залогиненность
     */
    protected function checkIsLogged()
    {
        if (Y::isGuest()) {
            $this->denyRequest(_t('frontend', 'You need to login'));
        }
    }

    /**
     * @return string url refferer
     */
    public function refferer()
    {
        return Y::request()->urlReferrer;
    }

    /**
     * Output JSON data with success result and end application
     *
     * @param string $message
     * @param array $data
     */
    public function endJson($message = '', $data = array())
    {
        echo json_encode(array(
            'result'	=> 'ok',
            'message'	=> $message,
            'data'		=> $data,
        ));
        Yii::app()->end();
    }

    /**
     * Output JSON data with error result and end application
     *
     * @param string $message
     * @param array $data
     */
    public function errorJson($message = '', $data = array())
    {
        echo json_encode(array(
            'result'	=> 'error',
            'message'	=> $message,
            'data'		=> $data,
        ));
        Yii::app()->end();
    }
}
