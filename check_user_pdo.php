<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=semarang_umkm', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT id FROM user WHERE username = 'erinurshofa'");
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $userId = $user['id'];
        echo "User ID: " . $userId . "\n";

        // Check auth_assignment
        $stmtRole = $pdo->prepare("SELECT item_name FROM auth_assignment WHERE user_id = :id");
        $stmtRole->execute(['id' => $userId]);
        $roles = $stmtRole->fetchAll(PDO::FETCH_ASSOC);
        echo "Roles: ";
        print_r($roles);
        
        // Check umkm_profile
        $stmtProfile = $pdo->prepare("SELECT status_verifikasi FROM umkm_profile WHERE user_id = :id");
        $stmtProfile->execute(['id' => $userId]);
        $profile = $stmtProfile->fetch(PDO::FETCH_ASSOC);
        if ($profile) {
            echo "\nExists. Verifikasi Status: " . $profile['status_verifikasi'] . "\n";
        } else {
            echo "\nProfile NOT FOUND\n";
        }
    } else {
        echo "User 'erinurshofa' not found in database.\n";
    }

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
