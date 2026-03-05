<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\rbac\DbManager;

/**
 * Controller for initializing RBAC roles.
 */
class RbacController extends Controller
{
    public function actionInit()
    {
        /** @var DbManager $auth */
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        // Add "umkm" role
        $roleUmkm = $auth->createRole('umkm');
        $roleUmkm->description = 'Pelaku UMKM yang terdaftar';
        $auth->add($roleUmkm);

        // Add "admin_dinkop" role
        $roleAdminDinkop = $auth->createRole('admin_dinkop');
        $roleAdminDinkop->description = 'Admin Dinas Koperasi dan Usaha Mikro';
        $auth->add($roleAdminDinkop);
        
        // Add "superadmin" role
        $roleSuperadmin = $auth->createRole('superadmin');
        $roleSuperadmin->description = 'Super Administrator Sistem';
        $auth->add($roleSuperadmin);
        
        // Add "guest" role
        $roleGuest = $auth->createRole('guest');
        $roleGuest->description = 'Pengunjung Publik';
        $auth->add($roleGuest);
        
        // (Optional) Define permissions here
        // $manageUmkm = $auth->createPermission('manageUmkm');
        // $manageUmkm->description = 'Memverifikasi dan mengelola UMKM';
        // $auth->add($manageUmkm);
        // $auth->addChild($roleAdminDinkop, $manageUmkm);

        echo "RBAC roles initialization completed.\n";
    }

    public function actionSeed()
    {
        $users = [
            'umkm' => [
                'username' => 'umkm_demo',
                'email' => 'umkm@semarang.go.id',
                'password' => 'SemarangHebat123',
                'role' => 'umkm',
                'role_id' => 10
            ],
            'dinkop' => [
                'username' => 'admin_dinkop',
                'email' => 'admin@semarang.go.id',
                'password' => 'AdminHebat123',
                'role' => 'admin_dinkop',
                'role_id' => 20
            ],
            'superadmin' => [
                'username' => 'superadmin',
                'email' => 'super@semarang.go.id',
                'password' => 'SuperHebat123',
                'role' => 'superadmin',
                'role_id' => 99
            ],
        ];

        $auth = Yii::$app->authManager;

        foreach ($users as $key => $data) {
            $user = \common\models\User::findOne(['username' => $data['username']]);
            if (!$user) {
                $user = new \common\models\User();
                $user->username = $data['username'];
                $user->email = $data['email'];
                $user->setPassword($data['password']);
                $user->generateAuthKey();
                $user->status = \common\models\User::STATUS_ACTIVE;
                $user->role = $data['role_id'];
                
                if ($user->save(false)) { // Skip validation untuk seeder
                    echo "User {$data['username']} created successfully.\n";
                    
                    // Assign RBAC Role
                    $role = $auth->getRole($data['role']);
                    if ($role) {
                        try {
                            $auth->assign($role, $user->id);
                            echo "Assigned role {$data['role']} to {$data['username']}.\n";
                        } catch (\Exception $e) {
                            echo "Role already assigned.\n";
                        }
                    }
                    
                    // Buat Profil Kosong jika UMKM
                    if ($key === 'umkm') {
                        $profile = new \common\models\UmkmProfile();
                        $profile->user_id = $user->id;
                        $profile->nama_pemilik = 'Pemilik Demo';
                        $profile->nik = time() . rand(100, 999); // Generate pseudo-random NIK
                        $profile->nama_usaha = 'UMKM Demo Semarang';
                        $profile->no_whatsapp = '081234567890';
                        $profile->status_verifikasi = 1; // Langsung diverifikasi agar bisa upload barang
                        $profile->created_at = time();
                        $profile->updated_at = time();
                        $profile->save(false);
                    }
                } else {
                    echo "Failed to create user {$data['username']}.\n";
                }
            } else {
                echo "User {$data['username']} already exists.\n";
            }
        }
        echo "Data seed completed.\n";
    }
}
