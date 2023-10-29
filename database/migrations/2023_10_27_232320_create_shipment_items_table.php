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
        Schema::create('shipment_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId("shipment_id");
            $table->string("title");
            $table->text("description")->nullable();
            $table->integer("quantity");
            $table->float("weight");
            $table->string("unit");
            $table->decimal("price", 10, 2);
            $table->timestamps();

            $table->foreign("shipment_id")->references("id")->on("shipments")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipment_items');
    }
};
