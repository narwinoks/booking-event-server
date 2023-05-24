<?php

use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class);
            $table->foreignIdFor(Ticket::class);
            $table->string('code')->nullable();
            $table->string('title');
            $table->string('name');
            $table->string('email');
            $table->string('phone_number')->nullable();
            $table->string('no_ktp')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
