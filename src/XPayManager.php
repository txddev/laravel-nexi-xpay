<?php

namespace Txd\XPay;

use Closure;
use Illuminate\Http\Request;
use Txd\XPay\Models\XpayEsito;
use Txd\XPay\Models\XpayPagamento;
use Txd\XPay\View\Components\Form;

class XPayManager {
    protected static $urlBackCallback = null;
    protected static $urlCallback = null;
    protected static $errorCallback = null;
    
    public static function setUrlBackAction(Closure $action) {
        static::$urlBackCallback = $action;
    }
    public static function setUrlAction(Closure $action) {
        static::$urlCallback = $action;
    }
    public static function setErrorAction(Closure $action) {
        static::$errorCallback = $action;
    }
    
    public static function urlAction(XpayEsito $esito){
        $action = static::$urlCallback;
        if(is_null($action)){
            $action = function(XpayEsito $e){
              return "PAYMENT STATUS:".$e->esito;  
            };
        }
        return $action($esito);
    }
    public static function urlBackAction(XpayEsito $esito){
        $action = static::$urlBackCallback;
        if(is_null($action)){
            $action = function(XpayEsito $e){
              return "PAYMENT STATUS:".$e->esito;  
            };
        }
        return $action($esito);
    }
    public static function errorAction(...$args){
        $action = static::$errorCallback;
        if(is_null($action)){
            $action = function(...$args){
              return "PAYMENT ERROR";  
            };
        }
        return $action(...$args);
    }
    
    public static function formPagamento($importo,$dati_aggiuntivi = []){
        $pagamento = XpayPagamento::fromImporto($importo);
        $pagamento->dati_aggiuntivi_json = $dati_aggiuntivi;
        return new Form($pagamento);
            
    }
}