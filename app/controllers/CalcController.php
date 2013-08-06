<?php

/**
 * Контроллер калькуляторов
 */
class CalcController extends BaseController
{

    public function actionCopter()
    {
        if (!empty($_GET['hash'])) {
            $model = CopterCalcModel::loadCalc($_GET['hash']);
            if (!$model) {
                throw new CHttpException(404, _t('calc', 'Calc not found'));
            }
            $model->addView();
            if (!$model->getIsVisitorOwner()) { // TODO: проверить с залогиненным пользователем
                $model->resetVisitorOwner();
            }
        } else {
            $model = new CopterCalcModel;
        }
        $motorSelectModel = new MotorSelectFormModel();

        $empty = array('' => _t('calc', ' - custom - '));
        $manufacters = $empty + ManufacterModel::getListWithMotorsExists();
        $motors      = $empty;
        $esc         = $empty + EscModel::getList();
        $batteries   = $empty + BatteryModel::getList();
        $props       = $empty + PropellerModel::getList();

        $this->pageTitle = _t('calc', 'Copter Calc');
        $this->render('copter', array(
            'model'            => $model,
            'motorSelectModel' => $motorSelectModel,

            'esc'              => $esc,
            'manufacters'      => $manufacters,
            'motors'           => $motors,
            'batteries'        => $batteries,
            'props'            => $props,
        ));
    }

    public function actionCalc()
    {
        $model = new CopterCalcModel;
        if (isset($_POST['CopterCalcModel'])) {
            $model->attributes = $_POST['CopterCalcModel'];
            $model->hash = Y::getPost('CopterCalcModel.hash');
            $model->inUserList = (bool)Y::getPost('CopterCalcModel.inUserList');
        }
        if (!$model->validate()) {
            $result = array();
            foreach($model->getErrors() as $attribute => $errors) {
                $result[Html::activeId($model, $attribute)] = $errors;
            }
            $this->errorJson('Error', array(
                'errors' => $result,
                'warnings' => array(
                    _t('calc', 'Please enter values into required fields')
                ),
            ));
        }

        if (Y::getGet('saveInMyCopters') && Y::isAuthed()) {
            $model->addToUserList();
        }

        $calcUrl = null;
        if ($hash = $model->saveCalc()) {
            $calcUrl = $this->createAbsoluteUrl('/calc/redirect', array('hash' => $hash, 'nl' => true));
        }

        $formula = new CopterCalcFormula($model);
        $this->endJson('Success', array(
            'result'  => $formula->calculate()->toArray(),
            'calcUrl' => $calcUrl,
        ));
    }

    public function actionRedirect()
    {
        $this->redirect(array('copter', 'hash' => $_GET['hash']));
    }

    /**
     * JS с данными товаров
     */
    public function actionCacheJs()
    {
        $this->layout = '//layouts/clean';
        $esc          = EscModel::loadAll();
        $props        = PropellerModel::loadAll();
        $batts        = BatteryModel::loadAll();

        header('Content-Type: application/x-javascript');
        echo $this->renderFile($this->getViewFile('cachejs'), array(
            'escs'  => $esc,
            'props' => $props,
            'batts' => $batts,
        ));
    }

    /**
     * Удаление коптера из списка пользователя
     */
    public function actionDelete()
    {
        if (Y::isGuest()) {
            throw new CHttpException(403, 'Access denined');
        }

        $calc = CalcModel::loadCalc(Y::getGet('hash'));
        if (!$calc) {
            throw new CHttpException(404, 'Calc is not found');
        }

        if (!$calc->getIsOwner()) {
            $this->denyRequest(_t('calc', 'You can\'t delete this calc'));
        }

        $calc->removeFromUserList();
        $calc->saveCalc();

        $this->redirect($this->refferer());
    }

    /**
     * Поиск моторов
     */
    public function actionSearchMotors()
    {
        $model = new MotorSelectFormModel;
        if (isset($_POST['MotorSelectFormModel'])) {
            $model->attributes = $_POST['MotorSelectFormModel'];
        }

        if (!$model->validate()) {
            $result = array();
            foreach($model->getErrors() as $attribute => $errors) {
                $result[Html::activeId($model, $attribute)] = $errors;
            }
            $this->errorJson('Error', array(
                'errors' => $result,
                'warnings' => array(
                    _t('calc', 'Please enter values into required fields')
                ),
            ));
        }


        $motors = $model->search();
        $json = array();
        foreach ($motors as $motor) {
            $json[] = array(
                'model_id'            => $motor->id,
                'manufacter_id' => $motor->manufacter_id,
                'manufacter'    => $motor->manufacter ? $motor->manufacter->title : null,
                'model'         => $motor->model,
                'kv'            => $motor->kw,
                'weight'        => $motor->weight,
            );
        }
        $this->endJson('success', array(
            'motors' => $json,
        ));
    }
}
