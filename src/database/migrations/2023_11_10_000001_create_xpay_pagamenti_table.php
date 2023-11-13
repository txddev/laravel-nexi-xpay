<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXpayPagamentiTable extends Migration
{


	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('xpay_pagamenti', function(Blueprint $table)
        {
            $table->char("codTrans", 26)->primary();
			$table->string('alias');
			$table->integer('importo');
			$table->string('divisa');
			$table->text('url');
			$table->text('url_back');
			$table->string('mac');
			$table->integer("tentativi")->default(0);
			$table->jsonb('facoltativi_json');
			$table->jsonb('dati_aggiuntivi_json');
            
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
        Schema::drop('xpay_pagamenti');
	}

};
