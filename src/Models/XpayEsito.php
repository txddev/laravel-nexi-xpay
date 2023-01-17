<?php

/**
 * Created by Reliese Model.
 */

namespace Txd\XPay\Models;



use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Txd\XPay\Rules\MacEsito;
use Validator;

/**
 * Class XpayEsito
 * 
 * @property int $id
 * @property string $codTrans
 * @property string $esito
 * @property string $codiceEsito
 * @property string $messaggio
 * @property string $codAut
 * @property string $alias
 * @property int $importo
 * @property string $divisa
 * @property string $data
 * @property string $orario
 * @property string $mac
 * @property array $aggiuntivi_json
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class XpayEsito extends Model
{
	
	protected $table = 'xpay_esiti';

	protected $casts = [
		'importo' => 'int',
		'aggiuntivi_json' => 'json'
	];

	public static function validationRules(){

	}
	
	public static function fromRequest(Request $request){
		$rules = [
			"esito" => ["required","string","required"],
			"alias" => ["required","string"],
			"importo" => ["required","integer"],
			"divisa" => ["required","string"],
			"codTrans" => ["required","string"],
			// required only on esito
			"mac" => ["sometimes","required",new MacEsito],
			"codAut" => ["string","required_with:mac"],
			"data" => ["string","required_with:mac"],
			"orario" => ["string","required_with:mac"],
			"codiceEsito" => ["string","required_with:mac"],
			"messaggio" => ["string","required_with:mac"],
			
		];
		$validator = Validator::make($request->input(),$rules);
		
		if($validator->passes()){
			static::unguard();
			$esito = new static($validator->validated());
			$esito->aggiuntivi_json = array_diff($request->input(),$validator->validated());
			static::reguard();
			return $esito;
		}else{
			return null;
		}
		
	}
	
	public function pagamento()
	{
		return $this->belongsTo(XpayPagamento::class, 'codTrans', 'codTrans');
	}
	
};
