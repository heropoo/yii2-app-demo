<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Register form
 */
class RegisterForm extends Model
{
    public $username;
    public $password;
    public $confirm_password;

    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password', 'confirm_password'], 'required'],
            // password is validated by validatePassword()
            ['confirm_password', 'validateConfirmPassword'],

            ['username', 'validateUsername'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateConfirmPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if($this->confirm_password !== $this->password){
                $this->addError($attribute, "'Confirm password' must be same as 'password'.");
            }
        }
    }

    /**
     * Validates the username.
     * @param $attribute
     * @param $params
     */
    public function validateUsername($attribute, $params){
        if (!$this->hasErrors()) {
            if($this->getUser()){
                $this->addError($attribute, "Username '".$this->username."' is already exists.");
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function register()
    {
        if ($this->validate()) {
            $user = new User();
            $user->status = User::STATUS_ACTIVE;
            $user->setPassword($this->password);
            $user->username = $this->username;
            $user->email = $this->username.'@localhost';
            $user->auth_key = '';
            return $user->save();
        }
        
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
