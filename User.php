<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "loginf".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $authKey
 * @property string $accessToken
 */
class User extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'loginf';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'username', 'password', 'authKey', 'accessToken'], 'required'],
            [['id'], 'integer'],
            [['accessToken'], 'string'],
            [['username'], 'string', 'max' => 120],
            [['password'], 'string', 'max' => 20],
            [['authKey'], 'string', 'max' => 18],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
        ];
    }

}
