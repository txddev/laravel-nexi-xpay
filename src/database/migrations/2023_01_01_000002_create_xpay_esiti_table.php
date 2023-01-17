<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{


	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('xpay_esiti', function(Blueprint $table)
        {
	    	
			$table->bigIncrements("id");
            $table->ulid('codTrans');
			$table->string("esito");
			$table->string("codiceEsito")->nullable();
			$table->text("messaggio")->nullable();
			$table->string("codAut")->nullable();
			$table->string("alias");
			$table->integer("importo");
			$table->string("divisa");
			$table->string("data")->nullable();
			$table->string("orario")->nullable();
			$table->string("mac")->nullable();
			$table->jsonb("aggiuntivi_json");
			
			
            
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
        Schema::drop('xpay_esiti');
	}

};
