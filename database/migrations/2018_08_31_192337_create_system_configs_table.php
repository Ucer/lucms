<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('flag', 20)->default('')->comment('配置英文标识');
            $table->string('title', 30)->default('')->comment('配置标题');
            $table->string('system_config_group', 10)->default('basic')->comment('配置分组');
            $table->string('system_config_type', 15)->default('input')->comment('配置类型');
            $table->string('item')->default('')->comment('配置项');
            $table->string('value')->default('')->comment('配置值');
            $table->string('description')->default('')->comment('配置描述');
            $table->integer('weight')->default(10);
            $table->enum('enable', ['T', 'F'])->default('T');
            $table->timestamps();

            $table->index('system_config_group');
            $table->index('system_config_type');
            $table->index('enable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_configs');
    }
}
