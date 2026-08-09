@section('title')
{{ __('messages.t_orders_history') }}
@endsection
<section class="py-5 header">
    <div class="container py-5">
        <div class="row pt-5">
            <div class="col-md-3" wire:ignore>
                <x-main.account.sidebar />
            </div>

            <div class="col-md-9">
                <!-- Tabs content -->
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade shadow rounded bg-white show active p-5" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <h5 class="fw-bold">{{ __('messages.t_orders_history') }}</h5>
                        <p class="text-muted mb-4">{{ __('messages.t_orders_history_subtitle') }}</p>
                        <p class="mb-2">
                            {{-- Session flash message --}}
                            @if (session()->has('message'))
                                <div class="alert alert-warning">
                                    <div class="d-flex">
                                        <p>
                                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                            {{ session()->get('message') }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                           {{-- favorite gigs --}}
                           <div class="table-responsive">
                            @forelse ($orders as $order)
                                <div class="card shadow-sm mb-3" style="height: max-content !important">
                                    <div class="card-header">
                                        {{-- Order quick stats --}}
                                        <dl class="row">

                                            {{-- Date placed --}}
                                            <div class="col-4">
                                                <dt class="text-secondary">{{ __('messages.t_date_placed') }}</dt>
                                                <dd class="mt-2 text-secondary">{{ format_date($order->placed_at, 'F j, Y h:i A') }}</dd>
                                            </div>

                                            {{-- Total amount --}}
                                            <div class="col-8">
                                                <dt class="text-secondary">{{ __('messages.t_total_amount') }}</dt>
                                                <dd class="mt-1 text-secondary">@money($order->total_value, settings('currency')->code, true)</dd>
                                            </div>

                                        </dl>
                                    </div>
                                  <div class="card-body">
                                    {{-- List of gigs in this order --}}
                                    @foreach ($order->items as $item)
                                    <p class="card-text mb-2 p-0" style="height: max-content !important">
                                        {{-- Gig thumbnail --}}
                                        <div class="row flex-nowrap m-0 p-0 container-fluid" style="height: max-content !important">
                                            <div class="rounded overflow-hidden text-center col-4 p-0" style="height: 100px; width:100px !important;">
                                                <img src="{{ src($item->gig->thumbnail) }}" alt="{{ $item->gig->title }}" style="height: 100%; width:100px;">
                                            </div>
                                            {{-- Gig title  / Upgrades --}}
                                            <div class="col-7">
                                                {{-- Item title --}}
                                                <p class="fw-bold mb-1">
                                                    <a class="text-dark" href="{{ url('service', $item->gig->slug) }}" target="_blank">I will {{ $item->gig->title }}</a>
                                                </p>
                                                <div class="table-responsive" >
                                                    <table class="table
                                                    table-borderless
                                                    text-center text-nowrap" style="width: 100%;font-size: 10px; height: max-content;">
                                                            <thead class="text-muted text-uppercase">
                                                            <tr>
                                                                <td>{{ __('messages.t_total') }}</td>
                                                                <td>{{ __('messages.t_quantity') }}</td>
                                                                <td>{{ __('messages.t_expected_delivery_date') }}</td>
                                                                <td>{{ __('messages.t_status') }}</td>
                                                            </tr>
                                                            </thead>
                                                            <tbody class="text-nowrap">
                                                                <tr>
                                                                    <td>@money($item->total_value, settings('currency')->code, true)</td>
                                                                    <td>{{ $item->quantity }}</td>
                                                                    <td>
                                                                        @if ($item->expected_delivery_date)
                                                                            {{ format_date($item->expected_delivery_date, 'F j, Y h:i A') }}
                                                                        @else
                                                                            —
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        {{-- Has refund opened --}}
                                                                        @if ($item->refund && $item->refund->status === 'pending')
                                                                        <p class="badge rounded-pill bg-danger">
                                                                            {{ __('messages.t_dispute_opened') }}
                                                                        </p>
                                                                    @else

                                                                        @switch($item->status)

                                                                            {{-- Pending --}}
                                                                            @case('pending')
                                                                                <p class="badge rounded-pill bg-warning">
                                                                                    {{ __('messages.t_pending') }}
                                                                                </p>
                                                                                @break

                                                                            {{-- In progress --}}
                                                                            @case('proceeded')
                                                                                <p  class="badge rounded-pill bg-primary">
                                                                                    {{ __('messages.t_in_the_process') }}
                                                                                </p>
                                                                                @break

                                                                            {{-- Delivered --}}
                                                                            @case('delivered')
                                                                                <p class="badge rounded-pill bg-success">
                                                                                    {{ __('messages.t_delivered') }}
                                                                                </p>
                                                                                @break

                                                                            {{-- Canceled --}}
                                                                            @case('canceled')
                                                                                <p class="badge rounded-pill bg-light text-dark">
                                                                                    {{ __('messages.t_canceled') }}
                                                                                </p>
                                                                                @break
                                                                            
                                                                            {{-- Refunded --}}
                                                                            @case('refunded')
                                                                                <p class="badge rounded-pill bg-danger">
                                                                                    {{ __('messages.t_refunded') }}
                                                                                </p>
                                                                                @break
                                                                                
                                                                            @default
                                                                                
                                                                        @endswitch

                                                                    @endif
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                    </table>
                                                </div>
                                                 {{-- Upgrades --}}
                                                 @if ($item->has('upgrades'))
                                                 <div class="mt-2">
 
                                                         @foreach ($item->upgrades as $upgrade)
                                                                 <div class="">
                                                                    <label class="fw-bold" style="font-size: 12px"><input type="checkbox" class="border-secondary border-2 text-light rounded-sm" checked disabled>{{ $upgrade->title }}</label><br>
                                                                         <div class="mt-1 d-flex">
                                                                             <p class="me-3" style="font-size: 10px !important">+ @money($upgrade->price, settings('currency')->code, true)</p>
                                                         
                                                                             @if ($upgrade->extra_days)
                                                                                 <p class="mx-3" style="font-size: 10px !important">
                                                                                     {{ __('messages.t_extra_days_delivery_time_short', ['time' => delivery_time_trans($upgrade->extra_days)]) }}
                                                                                 </p>
                                                                             @else
                                                                                 <p class="mx-3" style="font-size: 10px !important">
                                                                                     {{ __('messages.t_no_changes_delivery_time') }}
                                                                                 </p>
                                                                             @endif
                                                                         </div>
                                                                 </div>
                                                         @endforeach
                                                 </div>
                                             @endif
                                            </div>
                                            {{-- actions --}}
                                            <div class="col text-center d-flex align-items-center">
                                                <span class="dropmenu-right dropdown">
                                                    <a href="#" id="dropdownLang" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="dropdown-toggle text-center p-1">
                                                        <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                                                    </a>
                                                    <ul class="dropdown-menu text-left" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 50px, 0px);width: 50px">
                                                    {{-- Contact seller --}}
                                                    <li>
                                                        <a href="{{ url('messages/new', $item->owner?->username) }}" target="_blank" class="px-2 py-1 rounded">
                                                            <span class="text-secondary">
                                                                <i class="fa fa-envelope me-2" aria-hidden="true"></i>
                                                                {{ __('messages.t_contact_seller') }}
                                                            </span>
                                                        </a>
                                                    </li>
                                                    
                                                    @php
                                                        
                                                        // Check expected delivery date
                                                        if ($item->expected_delivery_date && !$item->is_finished) {
                                                            
                                                            // Parse expected delivery date
                                                            $parsed = \Carbon\Carbon::parse($item->expected_delivery_date);

                                                            // Check if date is past
                                                            if ($parsed->isPast()) {
                                                                
                                                                // Date in past, check item status
                                                                if (in_array($item->status, ['delivered', 'proceeded', 'pending'])) {
                                                                    
                                                                    // Can request refund
                                                                    $can_refund = true;

                                                                } else {

                                                                    // Cannot request refund
                                                                    $can_refund = false;

                                                                }

                                                            } else if ($item->status === 'delivered' && !$item->is_finished) {
                                                                
                                                                // Can refund
                                                                $can_refund = true;

                                                            } else {

                                                                // Cannot request refund
                                                                $can_refund = false;

                                                            }

                                                        } else {

                                                            $can_refund = false;

                                                        }

                                                    @endphp

                                                    {{-- View refund --}}
                                                    @if ($item->refund)
                                                        
                                                        <li>
                                                            <a href="{{ url('account/refunds/details', $item->refund->uid) }}" target="_blank" class="px-2 py-1">
                                                                <span class="text-secondary"><i class="fa fa-info-circle me-2" aria-hidden="true"></i>{{ __('messages.t_refund_details') }}</span>
                                                            </a>
                                                        </li>

                                                    @else
                                                        
                                                        {{-- Request refund --}}
                                                        @if ($can_refund)
                                                            <li>
                                                                <a href="{{ url('account/refunds/request', $item->uid) }}" target="_blank" class="px-2 py-1">
                                                                    <span class="text-secondary">
                                                                        <i class="fa fa-reply me-2" aria-hidden="true"></i>
                                                                        {{ __('messages.t_request_refund') }}</span>
                                                                </a>
                                                            </li>
                                                        @endif

                                                    @endif

                                                    {{-- Delivered work --}}
                                                    @if ($item->status === 'delivered')
                                                        <li>
                                                            <a href="{{ url('account/orders/files?orderId=' . $order->uid . '&itemId=' . $item->uid) }}"  class="px-2 py-1">
                                                                <span class="text-secondary"><i class="fa fa-download me-2" aria-hidden="true"></i>{{ __('messages.t_delivered_work') }}</span>
                                                            </a>
                                                        </li>
                                                    @endif

                                                    {{-- Cancel service --}}
                                                    @if ($item->status === 'pending')
                                                        <li>
                                                            <button type="button" onclick="confirm('{{ __('messages.t_are_u_sure_u_want_to_cancel_service') }}')" wire:click="cancel('{{ $item->uid }}')" wire:loading.attr="disabled" wire:target="cancel('{{ $item->uid }}')" class="d-flex align-items-center px-2 py-1">
                                                                {{-- Loading indicator --}}
                                                                <div wire:loading wire:target="cancel('{{ $item->uid }}')">
                                                                   <div class="d-flex justify-content-center align-items-center">
                                                                    <div class="spinner-border text-dark spinner-border-sm"
                                                                        role="status">
                                                                        <span class="visually-hidden">Loading...</span>
                                                                    </div>
                                                                   </div>
                                                                </div>

                                                                <span class="text-danger"><i class="fa fa-ban me-2" aria-hidden="true"></i>{{ __('messages.t_cancel_service') }}</span>
                                                                
                                                            </button>
                                                        </li>
                                                    @endif

                                                    {{-- Send requirements --}}
                                                    @if ($item->status === 'pending' || $item->status === 'proceeded')
                                                        <li>
                                                            <a href="{{ url('account/orders/requirements?order=' . $order->uid . '&item=' . $item->uid) }}"  class="flex items-center px-2 py-1 rounded-b">
                                                                <span class="text-secondary"><i class="fa fa-paper-plane me-2" aria-hidden="true"></i>{{ __('messages.t_send_requirements') }}</span>
                                                            </a>
                                                        </li>
                                                    @endif

                                                   
                                                    </ul>
                                                </span>
                                            </div>

                                        </div>
                                        
                                        
                                    </p>
                                    @endforeach
                                  </div>
                                </div>
                            @empty
                                {{-- No orders yet --}}
                                <div class="alert alert-light">
                                        <div class="">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="" style="height: 20px;width: 20px;" viewBox="0 0 20 20" fill="currentColor"> <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/></svg>
                                            <span class="ms-2" >{{ __('messages.t_ur_orders_history_is_empty_right_now') }}</span><p class="container-fluid text-end">
                                                <a href="{{ url('/') }}" class="">{{ __('messages.t_go_shopping') }} <span aria-hidden="true">&rarr;</span></a>
                                            </p>
                                        </div>
                                </div>
                                    
                            @endforelse 
                              

                        </div>
                        </p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>


