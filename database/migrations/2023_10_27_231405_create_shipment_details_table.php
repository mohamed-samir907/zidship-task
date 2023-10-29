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
        Schema::create('shipment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId("shipment_id");
            $table->enum("type", ["sender", "recipient"]);
            $table->string("name");
            $table->string("phone");
            $table->string("email")->nullable();
            $table->string("country");
            $table->string("state")->nullable();
            $table->string("city");
            $table->string("postal_code")->nullable();
            $table->string("address_line1");
            $table->string("address_line2")->nullable();
            $table->string("address_line3")->nullable();
            $table->timestamps();

            $table->foreign("shipment_id")->references("id")->on("shipments")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipment_details');
    }
};
