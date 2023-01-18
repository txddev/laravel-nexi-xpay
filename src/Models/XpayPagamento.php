<?php

/**
 * Created by Reliese Model.
 */

namespace Txd\XPay\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

/**
 * Class XpayPagamento
 * 
 * @property string $codTrans
 * @property string $alias
 * @property int $importo
 * @property string $divisa
 * @property string $url
 * @property string $url_back
 * @property string $urlpost
 * @property string $mac
 * @property int $tentativi
 * @property array $facoltativi_json
 * @property array $dati_aggiuntivi_json
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class XpayPagamento extends Model
{
	use HasUlids;
	protected $table = 'xpay_pagamenti';
	protected $primaryKey = 'codTrans';
	public $incrementing = false;

	protected $attributes = [
		"divisa" => "EUR"
	];
	
	protected $casts = [
		'importo' => 'int',
		'tentativi' => 'int',
		'facoltativi_json' => 'json',
		'dati_aggiuntivi_json' => 'json'
	];
	
	public static function fromImporto($importo)
	{
		$pagamento = new static;
		$pagamento->alias = config("xpay.alias");
        $pagamento->importo = round($importo,2)*100;
		$pagamento->codTrans = \Illuminate\Support\Str::ulid()->__toString();
        $pagamento->mac();
        $pagamento->url = route("xpay.url");
        $pagamento->url_back = route("xpay.url_back");
		if(!is_null(config("xpay.urlpost",null))){
			$pagamento->urlpost = config("xpay.urlpost");
		}
        $pagamento->facoltativi_json = [];
        $pagamento->dati_aggiuntivi_json = [];
		return $pagamento;
	}
	
	public function mac(){
        $this->mac = sha1('codTrans=' . $this->codTrans . 'divisa=' . $this->divisa . 'importo=' . $this->importo . config("xpay.secret"));
        return $this->mac;
    }

	public static function validationRules(){
		return [
			'codTrans' => [
				'required',
				'max:26'
			],
			'alias' => [
				'required',
				'max:255'
			],
			'importo' => [
				'required',
				'integer',
				'max:2147483647',
				'min:-2147483648'
			],
			'divisa' => [
				'required',
				'max:255'
			],
			'url' => [
				'required'
			],
			'url_back' => [
				'required'
			],
			'mac' => [
				'required',
				'max:255'
			],
			'tentativi' => [
				'integer',
				'max:2147483647',
				'min:-2147483648'
			],
			'facoltativi_json' => [
				'required'
			],
			'dati_aggiuntivi_json' => [
				'required'
			],
			'created_at' => [
				'nullable',
				'date'
			],
			'updated_at' => [
				'nullable',
				'date'
			]
		];
	}
	
	public function esiti()
	{
		return $this->hasMany(XpayEsito::class, 'codTrans', 'codTrans');
	}
}
