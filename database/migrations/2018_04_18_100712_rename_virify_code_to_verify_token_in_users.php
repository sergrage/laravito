<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameVirifyCodeToVerifyTokenInUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->renameColumn('verify_code', 'verify_token');
        });
    }


    public function down()
    {
        Schema::table('users', function ($table) {
            $table->renameColumn( 'verify_token', 'verify_code');
        });
    }
}

// "doctrine/dbal"