<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id");
            $table->foreignId("platform_id");
            $table->string("ref_number")->unique()->nullable()->comment("unique reference number genereted by us");
            $table->string("shipment_id")->nullable()->comment("shipment id returned from the platform");
            $table->string("status");
            $table->boolean("cash_on_delivery");
            $table->date("pickup_date");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign("user_id")->references("id")->on("users")->cascadeOnDelete();
            $table->foreign("platform_id")->references("id")->on("platforms")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
