<?php
 
namespace Txd\XPay\Rules;
 
use Illuminate\Contracts\Validation\Rule;
 
class MacEsito implements Rule
{

    protected $data;
    public function __construct(array $data) {
        $this->data = $data;
    }
    public function passes($attribute, $value)
    {
        $macFields = ["codTrans","esito","importo","divisa","data","orario","codAut"];
        $macString ="";
        foreach($macFields as $field){
            $macString .="$field={$this->data[$field]}";
        }
        $evaluatedMac = sha1($macString. config("xpay.secret"));
        //codTrans=<val>esito=<val>importo=<val>divisa=<val>data=<val>orario=<val>codAut=<val><chiaveSegreta>
        if ($evaluatedMac !== $value) {
            return false;
        }
        return true;
    }
    

    public function message()
    {
        return 'The :attribute does not match the request';
    }

}