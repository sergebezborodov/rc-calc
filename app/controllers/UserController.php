<?php

/**
 * Пользовательский контроллер
 */
class UserController extends BaseController
{

    public $layout = '//layouts/page';

    /**
     * Авторизация через сервисы
     */
    public function actionLogin()
    {
        $service = Yii::app()->request->getQuery('service');

        if (isset($service)) {
            /** @var IAuthService $authIdentity */
            $authIdentity = Yii::app()->eauth->getIdentity($service);
            $authIdentity->redirectUrl = Yii::app()->user->returnUrl;
            $authIdentity->cancelUrl = $this->createAbsoluteUrl('user/login');

            if ($authIdentity->authenticate()) {
                $identity = new EAuthUserIdentity($authIdentity);
                // successful authentication
                if ($identity->authenticate()) {

                    $isNewUser = false;
                    if (($user = UserModel::getProfileByIdentity($authIdentity)) == null) {
                        $user = UserModel::createByIdentity($authIdentity, $identity);
                        $isNewUser = true;
                    }

                    $user->login($authIdentity, $identity);

                    if ($isNewUser) {
                        $this->flash(_t('user', 'Please update you profile'));
                        $authIdentity->redirectUrl = $this->createAbsoluteUrl('/user/profile');
                    }

                    // special redirect with closing popup window
                    $authIdentity->redirect();
                } else {
                    // close popup window and redirect to cancelUrl
                    $authIdentity->cancel();
                }
            }

            // Something went wrong, redirect to login page
            $this->redirect(array('site/login'));
        }

        $this->pageTitle = _t('user', 'Login into Rc Calc');
        $this->render('login');
    }


    /**
     * Редактирование профиля пользователя
     */
    public function actionProfile()
    {
        $this->checkIsLogged();

        /** @var UserModel $model */
        $model = Y::user()->getModel();

        if (isset($_POST['UserModel'])) {
            $model->attributes = $_POST['UserModel'];
            if ($model->save()) {
                $this->flash(_t('profile', 'Your profile was saved'));
                $this->redirect(array('/user/page', 'username' => $model->username));
            }
        }

        $this->pageTitle = _t('frontend', 'Your Profile');
        $this->render('profile', array(
            'model' => $model
        ));
    }

    /**
     * Личная страница пользователя
     */
    public function actionPage()
    {
        $user = UserModel::model()->findByUserName(Y::getGet('username'));
        $calcs = CalcModel::findAllByUserId($user->id);

        $this->hideBreadcrumbs = true;
        $this->pageTitle = $user->name;
        $this->render('page', array(
            'user'  => $user,
            'calcs' => $calcs,
        ));
    }
}
