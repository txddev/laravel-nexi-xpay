<?php
 
namespace Txd\XPay\Rules;
 
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;
 
class MacEsito implements InvokableRule, DataAwareRule
{
    /**
     * All of the data under validation.
     *
     * @var array
     */
    protected $data = [];
 
    // ...
 
    /**
     * Set the data under validation.
     *
     * @param  array  $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
 
        return $this;
    }
    
    public function __invoke($attribute, $value, $fail)
    {
        $macFields = ["codTrans","esito","importo","divisa","data","orario","codAut"];
        $macString ="";
        foreach($macFields as $field){
            $macString .="$field={$this->data[$field]}";
        }
        $evaluatedMac = sha1($macString. config("xpay.secret"));
        //codTrans=<val>esito=<val>importo=<val>divisa=<val>data=<val>orario=<val>codAut=<val><chiaveSegreta>
        if ($evaluatedMac !== $value) {
            $fail('The :attribute does not match teh request');
        }
    }
}