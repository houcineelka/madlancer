<?php

namespace App\Http\Livewire\Admin\Services;

use App\Http\Validators\Admin\Services\PaypalValidator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Livewire\Component;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;

class PaypalComponent extends Component
{
    use SEOToolsTrait;
    
    public $mode;
    public $client_id;
    public $client_secret;

    /**
     * Initialize component
     *
     * @return void
     */
    public function mount()
    {
        // Fill default settings
        $this->fill([
            'mode'          => config('paypal.mode'),
            'client_id'     => config('paypal.mode') == 'sandbox' ? config('paypal.sandbox.client_id') : config('paypal.live.client_id'),
            'client_secret' => config('paypal.mode') == 'sandbox' ? config('paypal.sandbox.client_secret') : config('paypal.live.client_secret'),
        ]);
    }


    /**
     * Render component
     *
     * @return Illuminate\View\View
     */
    public function render()
    {
        // Seo
        $this->seo()->setTitle( setSeoTitle(__('messages.t_paypal'), true) );
        $this->seo()->setDescription( settings('seo')->description );

        return view('livewire.admin.services.paypal')->extends('livewire.admin.layout.app')->section('content');
    }


    /**
     * Update settings
     *
     * @return void
     */
    public function update()
    {
        try {

            // Validate form
            PaypalValidator::validate($this);

            // Check mode
            if ($this->mode === "sandbox") {
                
                // Write sandbox config
                Config::write('paypal.mode', 'sandbox');
                Config::write('paypal.sandbox.client_id', $this->client_id);
                Config::write('paypal.sandbox.client_secret', $this->client_secret);

            } else {

                // Write live config
                Config::write('paypal.mode', 'live');
                Config::write('paypal.live.client_id', $this->client_id);
                Config::write('paypal.live.client_secret', $this->client_secret);

            }

            // Update currency
            Config::write('paypal.currency', settings('currency')->code);

            // Clear config
            Artisan::call('config:clear');

            // Success
            $this->dispatchBrowserEvent('alert',[
                "message" => __('messages.t_toast_operation_success'),
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            // Validation error
            $this->dispatchBrowserEvent('alert',[
                "message" => __('messages.t_toast_form_validation_error'),
                "type"    => "error"
            ]);

            throw $e;

        } catch (\Throwable $th) {

            // Error
            $this->dispatchBrowserEvent('alert',[
                "message" => __('messages.t_toast_something_went_wrong'),
                "type"    => "error"
            ]);

            throw $th;

        }
    }
    
}
