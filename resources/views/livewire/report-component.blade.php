<span>

    <div class="blocker text-center" style="height:100vh;width:100%;"   >
        <div class="model bc-model modal pt-5" id="login" style="opacity: 1; display: inline-block;" >
            <div id="login-modal">
              <div class="login-form default-form">
                <div class="form-inner">
                  <h3>Report</h3>
                 
                  <form method="post" class="bravo-form-login" >
                    <input type="hidden" name="redirect" value="">
                    <input type="hidden" name="_token" value="e8Ji1dII5C3GXYl5UqU50cAbAphkdKTH8XM84pXk">
                    <div class="form-group">
                      <label>reason :</label>
                        <textarea name="reason" wire:model.defer="reason" cols="30" rows="10"></textarea>
                      <span class="text-danger">
                        @error('reason')
                         {{$message}} 
                        @enderror
                      </span>
                    </div>
            
          
                    {{-- spinner loading --}}
                    <div wire:loading.flex class="text-center justify-content-center mb-3">
                        <span class="spinner-border text-primary"  role="status">
                        </span>
                    </div>
                    <div class="form-group">
                      <button class="theme-btn " style="background:rgb(66, 66, 200)" name="log-in" wire:click.prevent="report()">
                        Report
                        <span class="spinner-grow spinner-grow-sm icon-loading" role="status" aria-hidden="true"></span>
                      </button>
                    </div>
               
                  </form>
                  <a rel="modal:close" class="close-modal" @click="report = false" x-show="open" >Close</a>
    
                </div>
    
              </div>
            </div>
          </div></div>
    
</span>
