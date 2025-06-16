<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "login".
 *
 * @property string $Username
 * @property string $password
 */
class Login extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'login';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Username', 'password'], 'required'],
            [['Username'], 'string'],
            [['password'], 'string', 'max' => 16],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Username' => 'Username',
            'password' => 'Password',
        ];
    }

}
