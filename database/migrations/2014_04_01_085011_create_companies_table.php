<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->datetime('deadline');
            $table->string('domain');
            $table->decimal('contract_total', 10, 0)->default(0);
            $table->boolean('has_shop')->default(0);
            $table->boolean('has_revenue')->default(0);
            $table->boolean('has_attendance')->default(0);
            $table->boolean('has_account')->default(0);
            $table->boolean('has_log')->default(0);
            $table->string('address', 125)->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('email', 125)->nullable();
            $table->string('tax_id', 125)->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->string('note')->nullable();
            $table->text('bank_info')->nullable();
            $table->unsignedInteger('standard_attendance_time')->default(4);
            $table->unsignedInteger('max_attendance_time')->default(12);
            $table->string('ip', 191)->nullable();
            $table->tinyInteger('ip_attendance_required')->comment('0: No; 1: Yes')->default(1);
            $table->tinyInteger('image_attendance_required')->comment('0: No; 1: Yes')->default(1);
            $table->tinyInteger('attendance_by_standard_attendance_time')->comment('0: No; 1: Yes')->default(1);
            $table->string('pass_wifi', 191)->nullable();
            $table->string('favicon', 191)->nullable();
            $table->string('logo_horizon', 191)->nullable();
            $table->string('logo_square', 191)->nullable();
            $table->string('logo_horizon_bw', 191)->nullable();
            $table->string('logo_square_bw', 191)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
