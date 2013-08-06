<?php

/**
 * Редактирование батарей
 */
class BatteryController extends BaseAdminController
{
    public function adminPageName()
    {
        return _t('battery', 'Batteries');
    }

    /**
     * Список моторов
     */
    public function actionIndex()
    {
        $model = new BatteryModel('search');
        $model->unsetAttributes();

        if (isset($_GET['BatteryModel'])) {
            $model->attributes = $_GET['BatteryModel'];
        }

        $dataProvider = $model->search();
        $dataProvider->pagination->pageSize = Y::param('admin.pageSize');

        $this->addLeftMenuItem(array('label' => _t('manufacter', 'Add new'),
                                     'url' => array('update'), 'icon' => 'plus'));
        $this->title = _t('motor', 'Battery List');
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
        $model = isset($_GET['id']) ? $this->loadModel('BatteryModel') : new BatteryModel;
        $returnTo = $this->getReturnTo($model, 'battery/index');

        if (isset($_POST['BatteryModel'])) {
            $model->attributes = $_POST['BatteryModel'];
            if ($model->save()) {
                $this->flash(_t('battery', 'Saved'));
                $this->redirect($returnTo);
            }
        }

        $manufacters = ManufacterModel::getList();

        $this->title = $model->isNewRecord ? _t('battery', 'Add new battery') :
            _t('battery', 'Edit battery');
        $this->render('update', array(
            'model'       => $model,
            'returnTo'    => $returnTo,
            'manufacters' => $manufacters,
        ));
    }
}
