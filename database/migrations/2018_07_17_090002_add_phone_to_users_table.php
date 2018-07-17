<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhoneToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone',11)->default('')->comment('手机号');
            $table->string('weixin_openid', 100)->default('');
            $table->string('mini_openid', 100)->default('')->comment('小程序 openid');
            $table->string('weixin_unionid', 100)->default('');
            $table->string('weixin_session_key', 100)->default('');
            $table->string('weixin_head_image_path', 255)->default('')->comment('微信头像路径');
            $table->string('country',15)->default('');
            $table->string('province',15)->default('');
            $table->string('city',15)->default('');

            $table->index('phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('weixin_openid');
            $table->dropColumn('mini_openid');
            $table->dropColumn('weixin_unionid');
            $table->dropColumn('weixin_session_key');
            $table->dropColumn('weixin_head_image_path');
            $table->dropColumn('country');
            $table->dropColumn('province');
            $table->dropColumn('city');
        });
    }
}
