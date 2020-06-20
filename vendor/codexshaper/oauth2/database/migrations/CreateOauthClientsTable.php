<?php

use CodexShaper\Database\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOauthClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('oauth_clients')) {
            Schema::create('oauth_clients', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('user_id')->index()->nullable();
                $table->string('name');
                $table->string('secret', 100)->nullable();
                $table->text('redirect');
                $table->boolean('personal_access_client')->default(0);
                $table->boolean('password_client')->default(0);
                $table->boolean('authorization_code_client')->default(0);
                $table->boolean('revoked')->default(false);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('oauth_clients')) {
            Schema::dropIfExists('oauth_clients');
        }
    }
}
