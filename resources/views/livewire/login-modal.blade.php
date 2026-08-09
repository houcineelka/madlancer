<div class="blocker text-center" style="height:100vh;width:100%;"   >
    <div class="model bc-model modal pt-5" id="login" style="opacity: 1; display: inline-block;" >
        <div id="login-modal">
          <div class="login-form default-form">
            <div class="form-inner">
              <h3>Login</h3>
                @if(session('error'))
                    <div class="alert alert-danger text-center">{{session('error')}}</div>
                @endif
              <form method="post" class="bravo-form-login" >
                <input type="hidden" name="redirect" value="">
                <input type="hidden" name="_token" value="e8Ji1dII5C3GXYl5UqU50cAbAphkdKTH8XM84pXk">
                <div class="form-group">
                  <label>Email address</label>
                  <input type="text" wire:model.defer="email" name="email" placeholder="Email address" required="">
                  <span class="text-danger">
                    @error('email')
                        {{$message}}
                    @enderror
                  </span>
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input type="password" wire:model.defer="password" name="password" value="" placeholder="Password">
                  <span class="text-danger">
                    @error('password')
                        {{$message}}
                    @enderror
                  </span>
                </div>
                <div class="form-group">
                  <div class="field-outer">
                    <div class="input-group checkboxes square">
                      <input type="checkbox" name="remember" value="1" id="remember">
                      <label for="remember" wire:model.defer="remember_me" class="remember"><span class="custom-checkbox"></span> Remember
                        me</label>
                    </div>
                    <a href="{{url('/reset')}}" class="pwd">Forgot password?</a>
                  </div>
                </div>
                {{-- spinner loading --}}
                <div wire:loading.flex class="text-center justify-content-center mb-3">
                    <span class="spinner-border text-primary"  role="status">
                    </span>
                </div>
                <div class="form-group">
                  <button class="theme-btn btn-style-one" name="log-in" wire:click.prevent="verify()">
                    Log In
                    <span class="spinner-grow spinner-grow-sm icon-loading" role="status" aria-hidden="true"></span>
                  </button>
                </div>
                <div class="bottom-box">
                  <div class="text">
                    Don't have an account?
                    <a  @click="open2 = true" class="bc-call-modal signup">Signup</a>
                  </div>
                </div>
              </form>
              <a rel="modal:close" class="close-modal" @click="open = false" x-show="open" >Close</a>

            </div>

          </div>
        </div>
      </div></div>
