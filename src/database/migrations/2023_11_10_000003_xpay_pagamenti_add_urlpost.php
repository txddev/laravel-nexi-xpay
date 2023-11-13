<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class XpayPagamentiAddUrlpost extends Migration
{


	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('xpay_pagamenti', function (Blueprint $table) {
            $table->text("urlpost")->nullable()->after("url_back");
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('xpay_pagamenti', function (Blueprint $table) {
			$table->dropColumn(["urlpost"]);
		});
	}

};
