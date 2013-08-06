<?php

/**
 * Управление каталогом моторов
 */
class MotorController extends BaseAdminController
{
    public function adminPageName()
    {
        return _t('motor', 'Motor');
    }

    /**
     * Список моторов
     */
    public function actionIndex()
    {
        $model = new MotorModel('search');
        $model->unsetAttributes();

        if (isset($_GET['MotorModel'])) {
            $model->attributes = $_GET['MotorModel'];
        }

        $dataProvider = $model->search();
        $dataProvider->pagination->pageSize = Y::param('admin.pageSize');

        $this->addLeftMenuItem(array('label' => _t('manufacter', 'Add new'),
                                     'url' => array('update'), 'icon' => 'plus'));
        $this->title = _t('motor', 'Motor List');
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Добавление и редактирование
     */
    public function actionUpdate()
    {
        $model = isset($_GET['id']) ? $this->loadModel('MotorModel') : new MotorModel;
        $returnTo = $this->getReturnTo($model, 'motor/index');


        if (isset($_POST['MotorModel'])) {
            $model->attributes = $_POST['MotorModel'];
            if ($model->save()) {
                $this->flash(_t('motor', 'Saved'));
                $this->redirect($returnTo);
            }
        }

        $manufacters = ManufacterModel::getList();

        $this->title = $model->isNewRecord ? _t('motor', 'Add new motor') :
            _t('motor', 'Edit motor');
        $this->render('update', array(
            'model'       => $model,
            'returnTo'    => $returnTo,
            'manufacters' => $manufacters,
        ));
    }

    /**
     * AJAX загрузка моторов по производителю
     */
    public function actionLoadMotorsByManufacter()
    {
        if (($id = Y::getGet('id')) == null) {
            $this->errorJson('Manufacter id must exist ');
        }

        $empty = array(null => _t('calc', ' - custom - '));
        $motors = MotorModel::loadByManufacterId($id) + $empty;

        $this->endJson('', array(
            'motors' => $motors,
        ));
    }
}
