<?php

namespace Txd\XPay;

use Illuminate\Support\ServiceProvider;

/**
 *  *
 * @author Fabio Spadea <fabio@techseed.it>
 */
class XPayServiceProvider extends ServiceProvider
{

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {   
        $this->publishes([
			__DIR__.'/config/txd_forms.php' => config_path('txd_forms.php'),
		], "txd_forms:config");

        $this->publishes([
			__DIR__.'/../views/Forms' => base_path('resources/views/vendor/txd/Forms'),
        ], "txd_forms:views");
        
        $this->mergeConfigFrom(
			__DIR__.'/../config/txd_forms.php', 'txd_forms'
		);

        //caricamento namespace per view
		$this->loadViewsFrom(base_path('resources/views/vendor/txd'), 'txd');
		$this->loadViewsFrom(__DIR__.'/../views', 'txd');
        
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    
    }

    

}
