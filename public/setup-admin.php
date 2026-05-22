<?php
// HAPUS FILE INI SETELAH DIGUNAKAN!
define('SECRET', 'apjikom2026');

if (($_GET['key'] ?? '') !== SECRET) {
    http_response_code(403);
    die('403 Forbidden');
}

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$email    = 'admin@apdesyi.or.id';
$password = 'Admin@2026!';

$existing = User::where('email', $email)->first();
if ($existing) {
    $existing->update([
        'password'          => Hash::make($password),
        'role'              => 'admin',
        'email_verified_at' => now(),
    ]);
    echo "<b>Akun diperbarui.</b><br>";
} else {
    User::create([
        'name'              => 'Admin APJIKOM',
        'username'          => 'admin',
        'email'             => $email,
        'password'          => Hash::make($password),
        'role'              => 'admin',
        'email_verified_at' => now(),
    ]);
    echo "<b>Akun dibuat.</b><br>";
}

echo "Email    : <b>{$email}</b><br>";
echo "Password : <b>{$password}</b><br>";
echo "<br><span style='color:red'><b>SEGERA HAPUS FILE INI dari server!</b></span>";
