<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (!Schema::hasColumn('events', 'is_paid')) {
                $table->boolean('is_paid')->default(false)->after('registration_fee');
            }
            if (!Schema::hasColumn('events', 'bank_name')) {
                $table->string('bank_name')->nullable()->after('is_paid');
            }
            if (!Schema::hasColumn('events', 'bank_account')) {
                $table->string('bank_account')->nullable()->after('bank_name');
            }
            if (!Schema::hasColumn('events', 'bank_account_name')) {
                $table->string('bank_account_name')->nullable()->after('bank_account');
            }
            if (!Schema::hasColumn('events', 'payment_contact')) {
                $table->string('payment_contact')->nullable()->after('bank_account_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'is_paid',
                'bank_name',
                'bank_account',
                'bank_account_name',
                'payment_contact'
            ]);
        });
    }
};
