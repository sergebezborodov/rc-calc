<?php

class WebUserException extends AppException {}

/**
 * Компонент пользователя
 */
class WebUser extends CWebUser
{
    public $loginDuration;

    /**
     * @var UserModel
     */
    protected $model;

    /**
     * Авторизация пользователя
     *
     * @param IUserIdentity $identity
     * @param int $duration
     * @return bool
     */
    public function login($identity, $duration = null)
    {
        if ($duration === null) {
            $duration = $this->loginDuration;
        }

        return parent::login($identity, $duration);
    }

    /**
     * Загружает модель текущего залогиненного пользователя
     * для неавторизованного - будет сгенерировано исключение
     *
     * @return UserModel
     */
    public function getModel()
    {
        if ($this->getIsGuest()) {
            throw new WebUserException('Пользователь неавторизирован');
        }

        if ($this->model == null) {
            $this->model = UserModel::model()->findByPk($this->getId());
        }
        return $this->model;
    }
}
