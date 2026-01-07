<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$email = 'admin@apjikom.or.id';
$password = 'Admin123!';

$user = User::where('email', $email)->first();

if ($user) {
    $user->update([
        'password' => Hash::make($password),
        'role' => 'admin',
    ]);
    echo "✅ Password admin berhasil diupdate!\n\n";
} else {
    User::create([
        'name' => 'Admin APJIKOM',
        'email' => $email,
        'password' => Hash::make($password),
        'role' => 'admin',
        'email_verified_at' => now(),
    ]);
    echo "✅ Admin baru berhasil dibuat!\n\n";
}

echo "📝 Login Info:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "Email   : {$email}\n";
echo "Password: {$password}\n";
echo "URL     : /admin-panel-apjikom\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
