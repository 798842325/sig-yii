<?php
namespace phone\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{

    public $password;
    public $phone;
    public $realname,$username;
    public $verifyPassword;
    public $invite_code;
    public $openid;



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required','message'=>'密码不能为空'],
            ['password', 'string', 'min' => 6,'message'=>'密码不能小于6位'],
            ['verifyPassword', 'compare', 'compareAttribute' => 'password', 'message' => '两次密码输入不一致'],
            [['invite_code','openid'],'string'],
            ['phone','required','message'=>'手机号码不能为空'],
            ['phone', 'unique','targetClass' => '\common\models\User','message'=>'该手机号已被注册'],

            ['realname', 'required','message'=>'真实姓名不能为空'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {

        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->realname = $this->realname;
        $user->phone = $this->phone;
        $user->openid = $this->openid;
        $user->invite_code = $this->invite_code;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->save();

        return $user->save() ? $user : null;
    }
}
