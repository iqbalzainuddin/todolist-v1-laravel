<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $users = User::whereNull("username")->get();
        printf($users);

        foreach ($users as $user) {
            $baseUsername = $this->generateUsername($user);
            $finalUsername = $this->ensureUniqueUsername($baseUsername);
            $user->update(['username' => $finalUsername]);
        }

        Schema::table("users", function (Blueprint $table) {
            $table->string("username")->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("users", function (Blueprint $table) {
            $table->string("username")->nullable()->change();
        });

        $users = User::all();

        foreach ($users as $user) {
            $user->update(["username" => ""]);
        }
    }

    private function generateUsername($user): string
    {
        $emailPart = explode('@', $user->email)[0];   
        return strtolower($emailPart);
    }

    private function ensureUniqueUsername(string $baseUsername): string
    {
        $username = $baseUsername;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }
};
