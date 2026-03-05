<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    
    // Properti khusus pendaftaran UMKM
    public $namaPemilik;
    public $namaUsaha;
    public $nomorWhatsapp;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required', 'message' => 'Username tidak boleh kosong.'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Username ini sudah terdaftar.'],
            ['username', 'string', 'min' => 4, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required', 'message' => 'Email tidak boleh kosong.'],
            ['email', 'email', 'message' => 'Format email tidak valid.'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Email ini sudah terdaftar.'],

            ['password', 'required', 'message' => 'Password tidak boleh kosong.'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
            
            [['namaPemilik', 'namaUsaha', 'nomorWhatsapp'], 'required', 'message' => 'Data UMKM wajib diisi.'],
            [['namaPemilik', 'namaUsaha'], 'string', 'max' => 100],
            ['nomorWhatsapp', 'string', 'max' => 20],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'username' => 'Username Login',
            'email' => 'Alamat Email',
            'password' => 'Kata Sandi',
            'namaPemilik' => 'Nama Pemilik Usaha',
            'namaUsaha' => 'Nama Usaha / Toko',
            'nomorWhatsapp' => 'No. Handphone (WhatsApp)',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null whether the creating new account was successful
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        // Langsung aktifkan user (tidak perlu validasi email sementara waktu untuk kemudahan demo)
        $user->status = User::STATUS_ACTIVE;
        $user->role = 10; // 10 adalah Role UMKM berdasarkan referensi kita
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
