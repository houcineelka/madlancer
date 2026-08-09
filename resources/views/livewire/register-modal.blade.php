<div class="blocker text-centers" style="height:104vh;width:100%;"  >
<div class="model bc-model modal pt-5 " id="register" style="opacity: 1; display: inline-block;">
    <div id="login-modal">
        <div class="login-form default-form">
            
            <div class="form-inner">
                <div class="form-inner">
                    <h3>Create a Free MadLancer Account</h3>
                    @if(session('error'))
                        <div class="alert alert-danger text-center">{{session('error')}}</div>
                    @endif
                    <form class="form bravo-form-register" method="post">
                    <div class="form-group" >
                    <div class="btn-box row">
                    <div class="col-lg-6 col-md-12">
                    <input class="checked" wire:model.defer='type' type="radio" name="type" id="checkbox1" value="seller">
                    <label for="checkbox1" class="theme-btn btn-style-four"><i class="la la-user"></i> Freelancer</label>
                    </div>
                    <div class="col-lg-6 col-md-12">
                    <input class="checked" wire:model.defer='type' type="radio" name="type" id="checkbox2" value="buyer" checked>
                    <label for="checkbox2" class="theme-btn btn-style-four"><i class="la la-briefcase"></i> Client</label>
                    </div>
                    </div>
                    </div>
                    <div class="row form-group">
                    <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                    <label>First Name</label>
                    <input type="text" wire:model.defer='first_name'  class="form-control" name="first_name" autocomplete="off" placeholder="First Name">
                    <i class="input-icon field-icon icofont-waiter-alt"></i>
                    @error('first_name') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" wire:model.defer='last_name'  class="form-control" name="last_name" autocomplete="off" placeholder="Last Name">
                    <i class="input-icon field-icon icofont-waiter-alt"></i>
                    @error('last_name') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    </div>
                    </div>
                    <div class="form-group">
                    <label>Email address</label>
                    <input type="email" wire:model.defer='email'  name="email" placeholder="Email address" required="">
                    
                    @error('email') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                    <label>Password</label>
                    <input id="password-field" wire:model.defer='password'  type="password" name="password" value="" placeholder="Password">
                    
                    @error('password') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                    <label>Re-Password</label>
                    <input id="re-password-field" wire:model.defer='password_confirmation'  type="password" name="password_confirmation" value="" placeholder="Re-Password">
                    
                    @error('password_confirmation') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    
                    {{-- spinner loading --}}
                    <div wire:loading.flex class="text-center justify-content-center mb-3">
                        <span class="spinner-border text-primary"  role="status">
                        </span>
                    </div>
                    <div class="form-group">
                    
                    <button class="theme-btn btn-style-one" wire:click.prevent='store()' wire:loading.attr="disabled" name="Register">Sign Up
                    </button>
                    
                    </div>
                    </form>
                    <a rel="modal:close" class="close-modal" @click="open2 = false" x-show="open2" " >Close</a>

                </div>
            </div>
            </div>
        </div>
    </div>
    
</div>
@push('scripts')
    <script>
        function XnbzELJbXoSEFED() {
            return {
                open: false,

                init() {
                    window.addEventListener('cart-updated', () => {
                        Livewire.emit('cart-updated')
                    });
                }
            }
        }
        window.XnbzELJbXoSEFED = XnbzELJbXoSEFED();
    </script>
@endpush
