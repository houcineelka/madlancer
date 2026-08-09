@section('title','Checkout')
<span x-data="window.LjqGJmYrwJSjIHT"  x-init="init()">
  {{-- Loading indicator --}}
  <div class="fixed-top bg-light opacity-50" style="z-index: 9999; height: 100vh;width: 100%" wire:loading>
    <div role="status" class="d-flex justify-content-center align-items-center" style="height: 100%;"> <svg aria-hidden="true" style="height: 100px;width: 100px;" class="text-primary  spinner-border" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/> <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/> </svg> <span class="sr-only">Loading...</span> </div>
  </div>
    <div class="container" style="margin-top: 200px;margin-bottom:100px" >
        <div class="row">
            <div class="col-md-7 order-md-1">
              <h4 class="mb-3">Billing address</h4>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="firstName">First name</label>
                  <input
                    type="text"
                    class="form-control"
                    id="firstName"
                    placeholder="Enter firstname"
                    value=""
                     
                    wire:model.defer="firstname"
                  />
             
                </div>
                <div class="col-md-6 mb-3">
                  <label for="lastName">Last name</label>
                  <input
                    type="text"
                    class="form-control"
                    id="lastName"
                    placeholder="Enter lastName"
                    value=""
                     
                    wire:model.defer="lastname"
                  />
                </div>
              </div>
  
              <div class="mb-3">
                <label for="email">E-mail address</label>
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  placeholder="Enter e-mail address"
                   
                  wire:model.defer="email"
                />
             
              </div>
  
              <div class="mb-3">
                <label for="address2"
                  >Company <span class="text-muted">(Optional)</span></label
                >
                <input
                  type="text"
                  class="form-control"
                  id="address2"
                  placeholder="Enter company (optional)"
                  wire:model.defer="company"
                />
              </div>
  
              <div class="mb-3">
                <label for="address">Address</label>
                <input
                  type="text"
                  class="form-control"
                  id="address"
                  placeholder="Enter address"
                   
                  wire:model.defer="address"
                />

            
              </div>
            </div>
  
            <div class="col-md-5 order-md-1">
              <h4 class="mb-3">
                Payment  | @money($this->total() + $this->taxes(), settings('currency')->code, true)
              </h4>
              <div></div>
                {{-- credit card --}}
                <div class="d-block my-3">
                    <div class="custom-control custom-radio">
                    <input
                        id="credit"
                        name="payment_method"
                        type="radio"
                        class="custom-control-input"
                         
                        wire:model.defer="payment_method" x-model="payment_method" value="credit_card"
                    />
                    <label class="custom-control-label" for="credit"
                        >Credit card</label
                    >
                    </div>
                {{-- end --}}

                {{-- balance --}}
                @if (auth()->user()->balance_available >= $this->total() + $this->taxes())

                    <div class="custom-control custom-radio">
                    <input
                        id="debit"
                        name="payment_method"
                        type="radio"
                        class="custom-control-input"
                         
                        name="payment_method" type="radio" wire:model.defer="payment_method" x-model="payment_method" value="balance"
                        />
                    <label class="custom-control-label" for="debit"
                        >Balance</label
                    >
                    </div>
                @endif
                {{-- end --}}

                {{-- paypal --}}
                @if (settings('gateways')->is_paypal)
                    <div class="custom-control custom-radio">
                    <input
                        id="paypal"
                        name="payment_method"
                        type="radio"
                        class="custom-control-input"
                          
                        wire:model.defer="payment_method" x-model="payment_method" value="paypal"
                    />
                    <label class="custom-control-label" for="paypal">PayPal</label>
                    </div>
                @endif
                {{-- end  --}}
              </div>

              {{-- start --}}
              
                <div x-show="payment_method === 'credit_card'">
          
                    <div>

                    <div id="error" class="text text-danger m-1"></div>
                    
                    <div class="border border-black p-3" id="card-element"></div>

                       
                    </div>
                    <button class="mt-3 btn btn-primary" id="card-button" type="button">Pay with Card</button>
                    

                </div>
                {{-- balance test --}}
                <span x-show="payment_method === 'balance'"  wire:ignore x-cloak>
                    <div class="row mb-4">
                        <div class="col-lg-12 col-sm-12">
                            Available balance:&nbsp;
                            <b>
                                @money(auth()->user()->balance_available, settings('currency')->code, true)
                            </b>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-lg btn-block" wire:click="pay" wire:loading.attr="disabled" wire:target="pay">
                      Continue to checkout
                    </button>
                </span>
                {{-- balance test --}}
                <span x-show="payment_method === 'paypal'"  wire:ignore x-cloak >
                    <div id="paypal-button">
                        
                    </div>
                   
                </span>

              {{-- end --}}
           
             
            </div>
        </div>
      </div>
    
      
</span>

@push('scripts')

    {{-- Check if paypal enabled --}}
    @if (settings('gateways')->is_paypal)

        {{-- Get paypal client id --}}
        @php
            $client_id = config('paypal.mode') === 'sandbox' ? config('paypal.sandbox.client_id') : config('paypal.live.client_id')
        @endphp

        {{-- PayPal SDK --}}
        <script src="https://www.paypal.com/sdk/js?client-id={{ $client_id }}&intent=capture&commit=false&vault=true&currency={{ settings('currency')->code }}" data-namespace="paypal_sdk"></script>

    @endif

    {{-- AlpineJs --}}
    <script>
        let buttonsInitialized = false;
        let paypalPaySubmitted = false;
        function LjqGJmYrwJSjIHT() {
            return {

                payment_method     : 'credit_card',

                init() {

                    @if (settings('gateways')->is_paypal)
                      if (!buttonsInitialized) {
                        buttonsInitialized = true;
                        paypal_sdk.Buttons({

                        // Set up the transaction
                        createOrder: function(data, actions) {
                            return actions.order.create({
                                purchase_units: [{
                                    amount: {
                                        value: '{{ $this->total() + $this->taxes() }}'
                                    }
                                }]
                            });
                        },

                        // Finalize the transaction
                        onApprove: function(data, actions) {

                            // Prevent duplicate submission if approve fires more than once
                            if (paypalPaySubmitted) {
                                return;
                            }
                            paypalPaySubmitted = true;

                            // Set order id
                            @this.set('paypal_order_id', data.orderID);

                            Livewire.emit('pay-method')

                          }

                        }).render('#paypal-button');}

                    @endif
                  
                    window.addEventListener('cart-updated', () => {
                        Livewire.emit('cart-updated')
                    });

                }

            }
        }
        window.LjqGJmYrwJSjIHT = LjqGJmYrwJSjIHT();


    </script>
    

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('pk_test_51N0VayFK3dRKEnb1Xk40W7kfIgqX7h8JDnBVHe5byG8qlX3J03UmbBo1GldNDVfPOXZSJfp5n0T3aXBs9N2mzwDT00iHoTCZwW');

        const elements = stripe.elements();
        const cardElement = elements.create('card');

        cardElement.mount('#card-element');

        const cardEmail = document.getElementById('email');
        const cardButton = document.getElementById('card-button');
        let cardPaySubmitting = false;

        cardButton.addEventListener('click', async (e) => {
          e.preventDefault();

          if (cardPaySubmitting) {
            return;
          }
          cardPaySubmitting = true;

        const { paymentMethod, error } = await stripe.createPaymentMethod(
                    'card', cardElement
                );
                if (error) {
                  document.getElementById('error').innerHTML = "your informations incorrect try again !!";
                  cardPaySubmitting = false;
                } else {
                  @this.set('card_order_id', paymentMethod.id);

                    document.getElementById('error').innerHTML = "";

                    Livewire.emit('pay-method');

                }


              });
      

    </script>

@endpush

