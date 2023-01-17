<?php
 
namespace Txd\XPay\View\Components;
 
use Illuminate\View\Component;
use Txd\XPay\Models\XpayPagamento;


class Form extends Component
{
    public XpayPagamento $avvio;
    public string $requestUrl;
 
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
        return view('xpay::form');
    }
}