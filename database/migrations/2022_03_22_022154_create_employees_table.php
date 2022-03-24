<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('address_id');
            $table->unsignedBigInteger('employee_role_id');
            $table->string('code');
            $table->string('first_name');
            $table->string('last_name');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('address_id')->references('id')->on('addresses');
            $table->foreign('employee_role_id')->references('id')->on('employee_roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
