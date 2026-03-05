<?php

namespace common\services;

use Yii;
use common\models\UmkmProfile;
use common\models\VerificationLog;
use Exception;

/**
 * Service class for handling Verification logic by Admin.
 */
class VerificationService
{
    /**
     * Verifikasi Profil UMKM oleh Admin
     * 
     * @param int $umkmId
     * @param int $adminId
     * @param int $status (2: Approve, 3: Reject)
     * @param string $notes
     * @return bool
     * @throws Exception
     */
    public function verifyUmkm($umkmId, $adminId, $status, $notes = '')
    {
        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();

        try {
            $profile = UmkmProfile::findOne($umkmId);
            if (!$profile) {
                throw new Exception("UMKM Profile not found.");
            }

            $profile->status_verifikasi = $status;
            $profile->updated_at = time();

            if (!$profile->save(false)) {
                throw new Exception("Gagal menyimpan status UMKM.");
            }

            $log = new VerificationLog();
            $log->entity_type = 'UMKM';
            $log->entity_id = $profile->id;
            $log->admin_user_id = $adminId;
            $log->action = ($status == 2) ? 'APPROVE' : 'REJECT';
            $log->notes = $notes;
            $log->created_at = time();

            if (!$log->save()) {
                throw new Exception("Gagal menyimpan log verifikasi.");
            }

            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::error('Verify UMKM Error: ' . $e->getMessage(), __METHOD__);
            throw $e;
        }
    }
}
