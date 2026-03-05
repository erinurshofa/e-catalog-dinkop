<?php

namespace common\services;

use Yii;
use common\models\UmkmProfile;
use common\models\User;
use Exception;

/**
 * Service class for handling UMKM-related business logic.
 */
class UmkmService
{
    /**
     * Daftarkan UMKM baru
     * 
     * @param User $user
     * @param array $profileData
     * @return UmkmProfile|null
     * @throws Exception
     */
    public function registerProfile(User $user, array $profileData)
    {
        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();

        try {
            $profile = new UmkmProfile();
            $profile->user_id = $user->id;
            $profile->nama_pemilik = isset($profileData['nama_pemilik']) ? $profileData['nama_pemilik'] : '';
            $profile->nama_usaha = isset($profileData['nama_usaha']) ? $profileData['nama_usaha'] : '';
            $profile->no_whatsapp = isset($profileData['no_telepon']) ? $profileData['no_telepon'] : '';
            $profile->status_verifikasi = 0; // Draft/Pending
            $profile->created_at = time();
            $profile->updated_at = time();

            if (!$profile->save(false)) { // Skip validation here since we trust the Controller/SignupForm validator
                throw new Exception('Failed to save UMKM Profile: ' . json_encode($profile->getErrors()));
            }

            // Jika role user masih umum, ubah menjadi Role UMKM (10)
            if ($user->role !== 10) {
                $user->role = 10;
                $user->save(false);
            }

            $transaction->commit();
            return $profile;
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::error('Register UMKM Error: ' . $e->getMessage(), __METHOD__);
            throw $e;
        }
    }
}
