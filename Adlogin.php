<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "adlogin".
 *
 * @property string $username
 * @property string $password
 */
class Adlogin extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adlogin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 255],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'password' => 'Password',
        ];
    }

}
