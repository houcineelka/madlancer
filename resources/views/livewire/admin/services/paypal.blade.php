<div class="w-full bg-white shadow rounded-lg">

    <div class="divide-y divide-gray-200 lg:col-span-9">
        <div class="py-10 px-12">

            {{-- Section header --}}
            <div class="mb-14">
                <h2 class="text-sm leading-6 font-bold text-gray-900">{{ __('messages.t_paypal') }}</h2>
                <p class="mt-1 text-xs text-gray-500">{{ __('messages.t_update_paypal_settings') }}</p>
            </div>
            
            {{-- Section content --}}
            <div class="grid grid-cols-12 md:gap-x-8 gap-y-8 mb-6">

                {{-- Default mode --}}
                <div class="col-span-12">
                    <div class="w-full" wire:ignore>
                        <x-forms.select2
                            :label="__('messages.t_default_mode')"
                            :placeholder="__('messages.t_choose_default_mode')"
                            model="mode"
                            :options="[
                                ['text' => __('messages.t_sandbox'), 'value' => 'sandbox'],
                                ['text' => __('messages.t_live'), 'value' => 'live'],
                            ]"
                            :isDefer="true"
                            :isAssociative="false"
                            :componentId="$this->id"
                            value="value"
                            text="text" />
                    </div>
                </div>

                {{-- Client id --}}
                <div class="col-span-12">
                    <x-forms.text-input
                        :label="__('messages.t_paypal_client_id')"
                        :placeholder="__('messages.t_enter_paypal_client_id')"
                        model="client_id"
                        icon="key-variant" />
                </div>

                {{-- Client secret --}}
                <div class="col-span-12">
                    <x-forms.text-input
                        :label="__('messages.t_paypal_client_secret')"
                        :placeholder="__('messages.t_enter_paypal_client_secret')"
                        model="client_secret"
                        icon="lock" />
                </div>

            </div>

        </div>

        {{-- Actions --}}
        <div class="py-4 px-4 flex justify-end sm:px-12 bg-gray-50 rounded-bl-lg rounded-br-lg">
            <x-forms.button action="update" text="{{ __('messages.t_update') }}" :block="false"  />
        </div>                    

    </div>

</div>    