<?php

namespace Txd\XPay;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Txd\XPay\View\Components\Form;
use Illuminate\Support\Facades\Route;
use Txd\XPay\Models\XpayEsito;
use Txd\XPay\XPayManager;

/**
 *  *
 * @author Fabio Spadea <fabio@techseed.it>
 */
class XPayServiceProvider extends ServiceProvider
{
    public function registerRoutes(){
        Route::middleware('web')->prefix("/xpay")->name("xpay.")->group(function(){
            Route::get("url",function(Request $request){
                $esito = XpayEsito::fromRequest($request);
                if(!is_null($esito)){
                    if(is_null($duplicate = XpayEsito::findDuplicate($esito))){
                        $esito->save();
                    }else{
                        $esito = $duplicate;
                    }
                    return XPayManager::urlAction($esito);
                }
                return XPayManager::errorAction();
            })->name("url");
            
            Route::get("url_back",function(Request $request){
                $esito = XpayEsito::fromRequest($request);
                if(!is_null($esito)){
                    if(is_null($duplicate = XpayEsito::findDuplicate($esito))){
                        $esito->save();
                    }else{
                        $esito = $duplicate;
                    }
                    return XPayManager::urlBackAction($esito);
                }
                return XPayManager::errorAction();
            })->name("url_back");
            
            Route::post("url_post",function(Request $request){
                $esito = XpayEsito::fromRequest($request);
                if(!is_null($esito)){
                    if(is_null($duplicate = XpayEsito::findDuplicate($esito))){
                        $esito->save();
                    }else{
                        $esito = $duplicate;
                    }
                    return XPayManager::urlPostAction($esito);
                }
                return XPayManager::errorAction();
            })->name("url_post");
            
        });
    }
    
    public function registerConfig(){
        $this->publishes([
			__DIR__.'/config/xpay.php' => config_path('xpay.php'),
		], "xpay:config");

        $this->mergeConfigFrom(
            __DIR__.'/config/xpay.php', 'xpay'
        );
    }
    
    public function bootViews(){
        $this->publishes([
			__DIR__.'/views/' => base_path('resources/views/vendor/txd/XPay'),
        ], "txd_forms:views");
        
		$this->loadViewsFrom(base_path('resources/views/vendor/txd/XPay'), 'xpay');
		$this->loadViewsFrom(__DIR__.'/views', 'xpay');
        $this->loadViewComponentsAs('xpay', $this->viewComponents());
    }
    
    public function bootMigrations(){
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }
    
    protected function viewComponents(): array
    {
        return [
            Form::class
        ];
    }
    
    
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {   
        $this->bootMigrations();
        $this->bootViews();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
        $this->registerRoutes();
    }

    

}
