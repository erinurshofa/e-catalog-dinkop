<?php
$baseDir = 'e:/xampp 7.4/htdocs/e-catalog-dinkop';
require $baseDir . '/vendor/autoload.php';
require $baseDir . '/vendor/yiisoft/yii2/Yii.php';

$config = require $baseDir . '/frontend/config/main.php';
(new yii\web\Application($config));

$user = \common\models\User::findByUsername('erinurshofa');
if ($user) {
    echo "User ID: " . $user->id . "\n";
    echo "Roles: \n";
    print_r(\Yii::$app->authManager->getRolesByUser($user->id));
    
    echo "\nUMKM Profile: \n";
    $profile = \common\models\UmkmProfile::findOne(['user_id' => $user->id]);
    if ($profile) {
        echo "Exists. Verifikasi Status: " . $profile->status_verifikasi . "\n";
    } else {
        echo "NOT FOUND\n";
    }
} else {
    echo "User 'erinurshofa' not found\n";
}
