<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("supplier_id");
            $table->unsignedBigInteger("project_id")->nullable();
            $table->string("material_type");
            $table->decimal("unit_price_of_material",$precision = 11, $scale = 2);
            $table->decimal("square_meters",$precision = 11, $scale = 2);
            $table->decimal("material_amount",$precision = 11, $scale = 2);
            $table->decimal("pending_payment",$precision = 11, $scale = 2);
            $table->integer("paid_payment");
            $table->decimal("cost",$precision = 11, $scale = 2);
            $table->timestamps();

            $table->foreign("supplier_id")->references("id")->on("suppliers")->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("project_id")->references("id")->on("projects")->onUpdate("cascade")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('debts');
    }
}
