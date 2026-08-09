<div class="col-lg-4 col-md-6 col-sm-12 mb-4" >
  <div class="gig-item h-100 border-radius-8">
    {{-- part image of card --}}
    <div class="d-flex flex-column h-100">
      <div class="gig-thumb-title">
        
        <a href="{{ url('service', $g->slug) }}" class="gig-img">
          <img class="lazy loaded" 
           src="{{src($g->thumbnail)}}" data-was-processed="true">
        </a>
        <div class="gig-content flex-grow-1">
          <div class="gig-author mb-3 align-items-center d-none d-md-flex">
            <div class="gig-author-img mr-2">
              @if ($g->owner->isOnline())
                <span  style="background: #1dbf73;border: 1px solid #fff;border-radius: 50%;height: 7px;position: absolute;width: 7px;z-index: 1;"></span>  
              @endif
              <img src="{{src($g->owner->avatar)}}" style="width:100%">
            </div>

            <div>
              <div class="row author-name" style="line-height: 120%;">
                <a class="c-222325" style="font-weight: 600;font-size: 14px;" href="{{ url('profile', $g->owner->username) }}">&nbsp;&nbsp;{{$g->owner->fullname}}</a>
              </div>
              <div class="row author-name" style="line-height: 120%;">
                <span style="color: #74767e;font-size: 14px;" >&nbsp;&nbsp;{{$g->owner->level->account_type}}</span>
              </div>
            </div>
          </div>
          <h3 class="g-title fs-16 fs-16">
            <a href="{{ url('service', $g->slug) }}" >
              I will {{$g->title}}
          </a>
          </h3>
          <div class="div gig-review d-block d-md-none mt-2">
            @if($g->rating==0)
              <i class="fa fa-star text-warning"></i>
              <span style="color:#fcc48c">N/A</span>

            @else
              @for ($i = 0; $i < 5; $i++)
                  @if($i+1<= $g->rating)
                  <i class="fa fa-star text-warning"></i>
                  @else
                  <i class="fa fa-star" style="color:#dcdee2"></i>
                  @endif
              @endfor
              <span style="color:#fcc48c;font-weight:bold">{{ $g->rating }}</span>
            @endif
            (
              {{number_format($g->counter_reviews)}}  

            )
            
          </div>
        </div>
        <div class="ms-3">
          <button type="button" @auth @if ($favorite) wire:click="remove('{{ $g->uid }}')" wire:target="remove('{{ $g->uid }}')" @else wire:click="add('{{ $g->uid }}')" wire:target="add('{{ $g->uid }}')" @endif wire:loading.attr="disabled" @endauth @guest wire:click="alertError" @endguest >
            {{-- auth --}}
            @auth

               {{-- Loading indicator --}}
               <div  wire:loading @if ($favorite) wire:target="remove('{{ $g->uid }}')" @else wire:target="add('{{ $g->uid }}')" @endif>
                <i class="fa fa-spinner fa-lg" style="margin-top:8px;" aria-hidden="true"></i>

                </div>
               {{-- Button icon --}}
              <div  wire:loading.remove @if ($favorite) wire:target="remove('{{ $g->uid }}')" @else wire:target="add('{{ $g->uid }}" @endif>
               
                <i class="fa fa-heart fa-lg" @if ($favorite) style="margin-top:8px;color:red" @else  style="margin-top:8px;color:#dcdee2" @endif></i>

              </div>
            @endauth


            {{-- no auth --}}
            @guest
                <i class="fa fa-heart fa-lg" style="margin-top:8px;color:#dcdee2"></i>
            @endguest
          </button>
        </div>
      </div>
      {{-- end --}}

      {{-- responsive --}}
      <div class="gig-footer p-md-3 d-flex justify-content-between flex-shrink-0">
        <div class="div gig-review d-none d-md-block">
          <div class="rating d-inline-block">
             
              @if($g->rating==0)
              <i class="fa fa-star text-warning"></i>
              <span style="color:#fcc48c">N/A</span>

              @else
              @for ($i = 0; $i < 5; $i++)
                  @if($i+1<= $g->rating)
                  <i class="fa fa-star text-warning"></i>
                  @else
                  <i class="fa fa-star" style="color:#dcdee2"></i>
                  @endif
              @endfor
              <span style="color:#fcc48c;font-weight:bold" >{{ $g->rating }}</span>
            @endif
            (
                {{number_format($g->counter_reviews)}}  
            )          
          </div>
          
        </div>
        <div class="gig-author mb-md-3 d-flex align-items-center d-md-none m-2">
          <div class="gig-author-img mr-2">
            @if ($g->owner->isOnline())
            <span  style="background: #1dbf73;border: 1px solid #fff;border-radius: 50%;height: 7px;position: absolute;width: 7px;z-index: 1;"></span>  
            @endif
            <img src="{{src($g->owner->avatar)}}" style="height:20px">
          </div>

          <div>
            <div class="row author-name" style="line-height: 120%;">
              <a class="c-222325" style="font-weight: 600;font-size: 14px;" href="{{ url('profile', $g->owner->username) }}">&nbsp;&nbsp;{{$g->owner->fullname}}</a>
            </div>
            <div class="row author-name" style="line-height: 120%;">
              <span style="color: #74767e;font-size: 14px;" >&nbsp;&nbsp;{{$g->owner->level->account_type}}</span>
            </div>
          </div>
          
        </div>
        <div>
          <span class="c-7a7d85">Starting at </span>
          <span class="fs-20">{{$g->price}}$</span>
        </div>
      </div>
      


  
    </div>
  </div>
</div>
