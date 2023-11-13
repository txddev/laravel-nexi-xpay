<?php
 
namespace Txd\XPay;
 
use Txd\XPay\Models\XpayPagamento;

class Form 
{
    public $avvio;
    public $requestUrl;
 
    /**
     * Create the component instance.
     *
     * @param  string  $type
     * @param  string  $message
     * @return void
     */
    public function __construct(XpayPagamento $pagamento)
    {
        $this->avvio = $pagamento;
        $this->avvio->save();
        $this->requestUrl = config("xpay.url");
    }
 
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {        
        return view('xpay::form', ['avvio' => $this->avvio, 'requestUrl' => $this->requestUrl]);
    }
}