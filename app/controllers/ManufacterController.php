<?php

/**
 * Управление производителями
 */
class ManufacterController extends BaseAdminController
{

    public function adminPageName()
    {
        return _t('manufacter', 'Manufacter');
    }

    /**
     * Все производители
     */
    public function actionIndex()
    {
        $model = new ManufacterModel('search');
        $model->unsetAttributes();

        $dataProvider = $model->search();
        $dataProvider->pagination->pageSize = Y::param('admin.pageSize');

        $this->addLeftMenuItem(array('label' => _t('manufacter', 'Add new'),
                                     'url' => array('update'), 'icon' => 'plus'));
        $this->pageTitle = _t('manufacter', 'Manufacters List');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Добавление и редактирование
     */
    public function actionUpdate()
    {
        $model = isset($_GET['id']) ? $this->loadModel('ManufacterModel') : new ManufacterModel;

        if (isset($_POST['ManufacterModel'])) {
            $model->attributes = $_POST['ManufacterModel'];
            if ($model->save()) {
                $this->flash(_t('manufacter', 'Manufacter was saved'));
                $this->redirect(array('index'));
            }
        }

        $this->title = $model->isNewRecord ? _t('manufacter', 'Add new manufacter') :
            _t('manufacter', 'Edit manufacter');
        $this->render('update', array(
            'model' => $model,
        ));
    }
}
