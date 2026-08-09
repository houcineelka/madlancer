<span>
    <button type="button" class="hr-cart-btn ms-4" onclick="notToggle();" aria-label="Notifications">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/>
          <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
        </svg>
        @if($count > 0)
          <span class="hr-cart-btn__badge">{{$count}}</span>
        @endif
      </button>
      <div class="menu2">
        <ul>
           
          @forelse ($notifications as $n)
          <li class="mb-2" wire:key="header-notifications-{{ $n->uid }}">
              <div class="flex items-center">
                    <div class="row">
                        <div class="col-2">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width:30px;" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-gray-500"> <path fill-rule="evenodd" d="M10 2a6 6 0 00-6 6c0 1.887-.454 3.665-1.257 5.234a.75.75 0 00.515 1.076 32.91 32.91 0 003.256.508 3.5 3.5 0 006.972 0 32.903 32.903 0 003.256-.508.75.75 0 00.515-1.076A11.448 11.448 0 0116 8a6 6 0 00-6-6zM8.05 14.943a33.54 33.54 0 003.9 0 2 2 0 01-3.9 0z" clip-rule="evenodd"/></svg>
                        </div>
                        <div class="col-10">
                            <a href="{{ $n->action }}" class="text-sm font-medium text-gray-900">
                                @if ($n->params)
                                    {!! __('messages.' . $n->text, $n->params) !!}
                                @else
                                    {!! __('messages.' . $n->text) !!}
                                @endif
                            </a>
                        </div>
                    </div>
               
                 
                  <div class="ltr:ml-3 rtl:mr-3 w-0 flex-1 pt-0.5">
                     
                      <div class="mt-3 flex space-x-7 rtl:space-x-reverse">
                        <div class="row">
                            <div class="col-4">
                                {{-- View --}}
                                <a href="{{ $n->action }}" class="bg-transparent rounded-md text-xs font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none">
                                    {{ __('messages.t_view') }}
                                </a>
                            </div>
                            <div class="col-4">
                                     {{-- Mark as read --}}
                          <button wire:click="readNotification('{{ $n->uid }}')" wire:loading.attr="disabled" wire:target="read('{{ $n->uid }}')" type="button" class="bg-transparent rounded-md text-xs font-medium text-gray-700 hover:text-gray-500 focus:outline-none">
                            {{-- Loading indicator --}}
                            <div wire:loading wire:target="readNotification('{{ $n->uid }}')">
                                <svg role="status" class="inline w-4 h-4 text-gray-700 animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                </svg>
                            </div>

                            {{-- Button text --}}
                            <div wire:loading.remove wire:target="readNotification('{{ $n->uid }}')">
                                {{ __('messages.t_mark_as_read') }}
                            </div>
                        </button>
                            </div>
                        </div>
                         

                         

                      </div>
                  </div>
              </div>
          </li>
          @empty
              <div class="p-9 flex items-center justify-center text-xs font-medium text-gray-500">
                  {{ __('messages.t_no_notification_right_now') }}
              </div>
          @endforelse
                
            </ul>
      </div>

</span>
