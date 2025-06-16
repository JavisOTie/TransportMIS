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
class Loginf extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
// class Loginf extends \yii\base\BaseObject implements \yii\web\IdentityInterface
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
            'id' => Yii::t( 'app','ID',),
            'username' =>Yii::t('app' ,'Username'),
            'password' =>Yii::t('app', 'Password'),
            'authKey' =>Yii::t('app', 'Auth Key'),
            'accessToken' =>Yii::t('app', 'Access Token'),
        ];
    }
public function getAuthKey(){
 return $this->authKey;
}
public function getId(){
return $this->id;
}
public function validateAuthkey($authKey){
return $this->authKey === $authKey;
}
public static function findIdentity($id)
    {
        return static::findOne($id);
    }
   public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);

    }  
    public static function findByUsername($username){
    return self::findOne(['username'=>$username]);
        }
        
     public function validatePassword($password)
    {
        //dd(Yii::$app->security->generatePasswordHash('judyp'));
 
      // dd($password, $this->password, Yii::$app->security->validatePassword($password, $this->password));
        return  Yii::$app->security->validatePassword($password, $this->password);
        

    }
    
}
