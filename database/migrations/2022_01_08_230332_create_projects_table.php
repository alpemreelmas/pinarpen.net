<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("customer_id");
            $table->unsignedBigInteger("supplier_id");
            $table->string("material_type");
            $table->integer("material_amount");
            $table->decimal("unit_price_of_material",$precision = 11, $scale = 2);
            $table->decimal("square_meters",$precision = 11, $scale = 2);
            $table->integer("earning");
            $table->string("payment_type");
            $table->integer("paid_payment")->default(0);
            $table->integer("pending_payment");
            $table->integer("cost");
            $table->integer("pay_date");
            $table->timestamps();

            $table->foreign("customer_id")->references("id")->on("customers")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("supplier_id")->references("id")->on("suppliers")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
