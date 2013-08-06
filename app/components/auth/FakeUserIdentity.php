<?php

/**
 * Фейковая внутрення авторизация
 */
class FakeUserIdentity extends CBaseUserIdentity
{
    private $id;

    /**
     * @param UserModel $profile
     */
    public function __construct($profile)
    {
        $this->id = $profile->id;
    }

    /**
     * Authenticates the user.
     * The information needed to authenticate the user
     * are usually provided in the constructor.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        return true;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
