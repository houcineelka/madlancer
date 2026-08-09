<html lang="en" class="">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{config('app.name')}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    {{-- @vite(['resources/sass/app.scss','resources/js/app.js']) --}}
    {{-- @vite('resources/css/app.css') --}}
    <link rel='stylesheet' href='https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css'>
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com/" />
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link
      href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;family=Noto+Sans+JP:wght@400;500;700;900&amp;display=swap"
      rel="stylesheet"
    />
    
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link href="{{asset('public/madlancer/libs/font-awesome/css/font-awesome.css')}}" rel="stylesheet" />

    <link href="{{asset('public/madlancer/module/superio/css/font.css')}}" rel="stylesheet"  />
    <link href="{{asset('public/madlancer/libs/carousel-2/owl.carousel.css')}}" rel="stylesheet" />
    <link href="{{asset('public/madlancer/module/superio/css/style.css')}}" rel="stylesheet" />
    <link href="{{asset('public/madlancer/module/superio/css/responsive.css')}}" rel="stylesheet" />
    <link href="{{asset('public/madlancer/dist/frontend/css/app9c9f.css?_ver=1.2.3')}}" rel="stylesheet" />
    <link href="{{asset('public/madlancer/dist/frontend/module/gig/css/gig9c9f.css?_ver=1.2.3')}}" rel="stylesheet"/>
    <link href="{{asset('css/home-redesign.css')}}?v={{ filemtime(public_path('css/home-redesign.css')) }}" rel="stylesheet" />
    <script src="//unpkg.com/alpinejs" defer></script>

  <script src="{{ asset('public/js/app.js') }}" defer></script>

  <link rel="stylesheet" type="text/css" href="{{asset('public/madlancer/libs/fotorama/fotorama.css')}}" />

    <style>
      :root {
        --main-color: #1967d2;
      }
      
    </style>
    <livewire:styles />
    @stack('style')
  </head>
  
  <body
    data-anm=".anm"
    class="frontend-page header_transparent mm-wrapper"
    style=""
  >
  {{-- Loading indicator --}}
  <div id="loading" class="fixed-top bg-light opacity-100" style="z-index: 9999; height: 100vh;width: 100%">
    <div role="status" class="d-flex justify-content-center align-items-center" style="height: 100%;"> <svg aria-hidden="true" style="height: 100px;width: 100px;" class="text-primary  spinner-border" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/> <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/> </svg> <span class="sr-only">Loading...</span> </div>
  </div>

  <div
      id="nav-mobile"
      class="mm-menu mm-menu_offcanvas mm-menu_position-bottom mm-menu_fullscreen mm-menu_theme-black"
      aria-hidden="true"
    >
      <div class="mm-panels">
        <div id="navbar" class="mm-panel mm-panel_opened">
          <div class="mm-navbar mm-navbar_sticky">
            <a class="mm-navbar__title"><span>Menu</span></a>
          </div>
          <ul class="navigation mm-listview">
            <li class="dropdown depth-0 mm-listitem">
              <a target="" href="{{url('/')}}" class="mm-listitem__text"
                >Home <i class="caret flaticon-down-arrow"></i
              ></a>
            </li>

            <li class="dropdown depth-0 mm-listitem">
              <a target="" href="{{ url('categories', 'all') }}" class="mm-listitem__text"
                >Categories<i class="caret flaticon-down-arrow"></i
              ></a>

              
            </li>
            <li class="dropdown depth-0 mm-listitem">
              <a target="" href="{{url('/'."#job")}}" class="mm-listitem__text"
                >Start Job<i class="caret flaticon-down-arrow"></i
              ></a>
            </li>
            <li class="dropdown depth-0 mm-listitem">
              <a target="" href="{{route('contact')}}" class="mm-listitem__text"
                >Contact<i class="caret flaticon-down-arrow"></i
              ></a>
            </li>
          </ul>
        </div>
        <div class="mm-panels mm-panel mm-hidden" id="mm-1">
          <div class="mm-navbar mm-navbar_sticky">
            <a class="mm-navbar__title"><span>Menu</span></a>
          </div>
          <div id="navbar" class="mm-panel mm-panel_opened">
            <div class="mm-navbar mm-navbar_sticky">
              <a class="mm-navbar__title"><span>Menu</span></a>
            </div>
            <ul class="navigation mm-listview">
              <li class="dropdown depth-0 mm-listitem">
                <a target="" href="{{url('/')}}" class="mm-listitem__text"
                  >Home <i class="caret flaticon-down-arrow"></i
                ></a>
              </li>

              <li class="dropdown depth-0 mm-listitem">
                <a target="" href="{{ url('categories', 'all') }}" class="mm-listitem__text"
                  >Categories<i class="caret flaticon-down-arrow"></i
                ></a>

               
              </li>
              <li class="dropdown depth-0 mm-listitem">
                <a target="" href="{{url('/'."#job")}}" class="mm-listitem__text"
                  >Start Job<i class="caret flaticon-down-arrow"></i
                ></a>
              </li>
              <li class="dropdown depth-0 mm-listitem">
                <a target="" href="{{url('contact')}}" class="mm-listitem__text"
                  >Contact<i class="caret flaticon-down-arrow"></i
                ></a>
              </li>
            </ul>
          </div>
          <div class="mm-panels mm-panel mm-hidden" id="mm-0">
            <div class="mm-navbar mm-navbar_sticky">
              <a class="mm-navbar__title"><span>Menu</span></a>
            </div>
            <div id="navbar" class="mm-panel mm-panel_opened">
              <div class="mm-navbar mm-navbar_sticky">
                <a class="mm-navbar__title"><span>Menu</span></a>
              </div>
              <ul class="navigation mm-listview">
                <li class="dropdown depth-0 mm-listitem">
                  <a target="" href="{{url('/')}}" class="mm-listitem__text"
                    >Home <i class="caret flaticon-down-arrow"></i
                  ></a>
                </li>

                <li class="dropdown depth-0 mm-listitem">
                  <a target="" href="{{ url('categories', 'all') }}" class="mm-listitem__text"
                    >Categories<i class="caret flaticon-down-arrow"></i
                  ></a>

                  
                  
                </li>
                <li class="dropdown depth-0 mm-listitem">
                  <a target="" href="{{url('/'."#job")}}" class="mm-listitem__text"
                    >Start Job<i class="caret flaticon-down-arrow"></i
                  ></a>
                </li>
                <li class="dropdown depth-0 mm-listitem">
                  <a target="" href="{{url('contact')}}" class="mm-listitem__text"
                    >Contact<i class="caret flaticon-down-arrow"></i
                  ></a>
                </li>
              </ul>
            </div>
            <div id="mm-1" class="mm-panel mm-hidden" aria-hidden="true">
              <div class="mm-navbar mm-navbar_sticky">
                <a
                  class="mm-btn mm-btn_prev mm-navbar__btn"
                  href="#navbar"
                  aria-haspopup="true"
                  aria-owns="navbar"
                  ><span class="mm-sronly">Close submenu</span></a
                ><a class="mm-navbar__title" href="#navbar" aria-hidden="true"
                  ><span>Home </span></a
                >
              </div>
              
            </div>
            <div id="mm-2" class="mm-panel mm-hidden" aria-hidden="true">
              <div class="mm-navbar mm-navbar_sticky">
                <a
                  class="mm-btn mm-btn_prev mm-navbar__btn"
                  href="#navbar"
                  aria-haspopup="true"
                  aria-owns="navbar"
                  ><span class="mm-sronly">Close submenu</span></a
                ><a class="mm-navbar__title" href="#navbar" aria-hidden="true"
                  ><span>GIG </span></a
                >
              </div>
              <ul class="children-menu menu-dropdown mm-listview">
                <li class="depth-1 mm-listitem">
                  <a
                    target=""
                    href="gig-cat/graphics-design.html"
                    class="mm-listitem__text"
                    >Category Level 1</a
                  >
                </li>
                <li class="depth-1 mm-listitem">
                  <a
                    target=""
                    href="gig-cat/logo-design.html"
                    class="mm-listitem__text"
                    >Category Level 2</a
                  >
                </li>
                <li class="depth-1 mm-listitem">
                  <a target="" href="gig.html" class="mm-listitem__text"
                    >Gigs Listing</a
                  >
                </li>
                <li class="depth-1 mm-listitem">
                  <a
                    target=""
                    href="gig/i-will-quod-corrupti-veritatis.html"
                    class="mm-listitem__text"
                    >Gig Single</a
                  >
                </li>
              </ul>
            </div>
            <div id="mm-3" class="mm-panel mm-hidden" aria-hidden="true">
              <div class="mm-navbar mm-navbar_sticky">
                <a
                  class="mm-btn mm-btn_prev mm-navbar__btn"
                  href="#navbar"
                  aria-haspopup="true"
                  aria-owns="navbar"
                  ><span class="mm-sronly">Close submenu</span></a
                ><a class="mm-navbar__title" href="#navbar" aria-hidden="true"
                  ><span>Find Jobs </span></a
                >
              </div>
              <ul class="children-menu menu-dropdown mm-listview">
                <li class="dropdown depth-1 mm-listitem">
                  <a target="" href="job.html" class="mm-listitem__text"
                    >Jobs Listing <i class="caret flaticon-down-arrow"></i
                  ></a>

                  <a
                    class="mm-btn mm-btn_next mm-listitem__btn"
                    href="#mm-4"
                    aria-haspopup="true"
                    aria-owns="mm-4"
                    ><span class="mm-sronly">Open submenu</span></a
                  >
                </li>
                <li class="dropdown depth-1 mm-listitem">
                  <a
                    target=""
                    href="job/product-designer-ui-designer.html"
                    class="mm-listitem__text"
                    >Job Single <i class="caret flaticon-down-arrow"></i
                  ></a>

                  <a
                    class="mm-btn mm-btn_next mm-listitem__btn"
                    href="#mm-5"
                    aria-haspopup="true"
                    aria-owns="mm-5"
                    ><span class="mm-sronly">Open submenu</span></a
                  >
                </li>
              </ul>
            </div>
            <div id="mm-4" class="mm-panel mm-hidden" aria-hidden="true">
              <div class="mm-navbar mm-navbar_sticky">
                <a
                  class="mm-btn mm-btn_prev mm-navbar__btn"
                  href="#mm-3"
                  aria-haspopup="true"
                  aria-owns="mm-3"
                  ><span class="mm-sronly">Close submenu</span></a
                ><a class="mm-navbar__title" href="#mm-3" aria-hidden="true"
                  ><span>Jobs Listing </span></a
                >
              </div>
              <ul class="children-menu menu-dropdown mm-listview">
                <li class="depth-2 mm-listitem">
                  <a target="" href="job.html" class="mm-listitem__text"
                    >Jobs Listing V1</a
                  >
                </li>
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="job03bf.html?_layout=v2"
                    class="mm-listitem__text"
                    >Jobs Listing V2</a
                  >
                </li>
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="jobb598.html?_layout=v3"
                    class="mm-listitem__text"
                    >Jobs Listing V3</a
                  >
                </li>
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="job5aea.html?_layout=v4"
                    class="mm-listitem__text"
                    >Jobs Listing V4</a
                  >
                </li>
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="jobdf54.html?_layout=v5"
                    class="mm-listitem__text"
                    >Jobs Listing V5</a
                  >
                </li>
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="job4475.html?_layout=v6"
                    class="mm-listitem__text"
                    >Jobs Listing V6</a
                  >
                </li>
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="jobc2b9.html?_layout=v7"
                    class="mm-listitem__text"
                    >Jobs Listing V7</a
                  >
                </li>
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="jobf892.html?_layout=v8"
                    class="mm-listitem__text"
                    >Jobs Listing V8</a
                  >
                </li>
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="jobd777.html?_layout=v9"
                    class="mm-listitem__text"
                    >Jobs Listing V9</a
                  >
                </li>
              </ul>
            </div>
            <div id="mm-5" class="mm-panel mm-hidden" aria-hidden="true">
              <div class="mm-navbar mm-navbar_sticky">
                <a
                  class="mm-btn mm-btn_prev mm-navbar__btn"
                  href="#mm-3"
                  aria-haspopup="true"
                  aria-owns="mm-3"
                  ><span class="mm-sronly">Close submenu</span></a
                ><a class="mm-navbar__title" href="#mm-3" aria-hidden="true"
                  ><span>Job Single </span></a
                >
              </div>
              <ul class="children-menu menu-dropdown mm-listview">
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="job/product-designer-ui-designer.html"
                    class="mm-listitem__text"
                    >Job Single V1</a
                  >
                </li>
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="job/product-designer-ui-designer03bf.html?_layout=v2"
                    class="mm-listitem__text"
                    >Job Single V2</a
                  >
                </li>
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="job/product-designer-ui-designerb598.html?_layout=v3"
                    class="mm-listitem__text"
                    >Job Single V3</a
                  >
                </li>
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="job/restaurant-team-member5aea.html?_layout=v4"
                    class="mm-listitem__text"
                    >Job Single V4</a
                  >
                </li>
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="job/product-designer-ui-designerdf54.html?_layout=v5"
                    class="mm-listitem__text"
                    >Job Single V5</a
                  >
                </li>
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="job/product-designer-ui-designer.html"
                    class="mm-listitem__text"
                    >Job – Internal Apply</a
                  >
                </li>
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="job/software-engineer-android-lib.html"
                    class="mm-listitem__text"
                    >Job – External Apply</a
                  >
                </li>
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="job/group-marketing-manager.html"
                    class="mm-listitem__text"
                    >Job – Email Apply</a
                  >
                </li>
              </ul>
            </div>
            <div id="mm-6" class="mm-panel mm-hidden" aria-hidden="true">
              <div class="mm-navbar mm-navbar_sticky">
                <a
                  class="mm-btn mm-btn_prev mm-navbar__btn"
                  href="#navbar"
                  aria-haspopup="true"
                  aria-owns="navbar"
                  ><span class="mm-sronly">Close submenu</span></a
                ><a class="mm-navbar__title" href="#navbar" aria-hidden="true"
                  ><span>Employers </span></a
                >
              </div>
              <ul class="children-menu menu-dropdown mm-listview">
                <li class="dropdown depth-1 mm-listitem">
                  <a target="" href="companies.html" class="mm-listitem__text"
                    >Employers List <i class="caret flaticon-down-arrow"></i
                  ></a>

                  <a
                    class="mm-btn mm-btn_next mm-listitem__btn"
                    href="#mm-7"
                    aria-haspopup="true"
                    aria-owns="mm-7"
                    ><span class="mm-sronly">Open submenu</span></a
                  >
                </li>
                <li class="dropdown depth-1 mm-listitem">
                  <a
                    target=""
                    href="companies/netflix.html"
                    class="mm-listitem__text"
                    >Employer Single <i class="caret flaticon-down-arrow"></i
                  ></a>

                  <a
                    class="mm-btn mm-btn_next mm-listitem__btn"
                    href="#mm-8"
                    aria-haspopup="true"
                    aria-owns="mm-8"
                    ><span class="mm-sronly">Open submenu</span></a
                  >
                </li>
              </ul>
            </div>
            <div id="mm-7" class="mm-panel mm-hidden" aria-hidden="true">
              <div class="mm-navbar mm-navbar_sticky">
                <a
                  class="mm-btn mm-btn_prev mm-navbar__btn"
                  href="#mm-6"
                  aria-haspopup="true"
                  aria-owns="mm-6"
                  ><span class="mm-sronly">Close submenu</span></a
                ><a class="mm-navbar__title" href="#mm-6" aria-hidden="true"
                  ><span>Employers List </span></a
                >
              </div>
              <ul class="children-menu menu-dropdown mm-listview">
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="companies7a7e.html?_layout=v1"
                    class="mm-listitem__text"
                    >Employers Listing V1</a
                  >
                </li>
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="companies03bf.html?_layout=v2"
                    class="mm-listitem__text"
                    >Employers Listing V2</a
                  >
                </li>
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="companiesb598.html?_layout=v3"
                    class="mm-listitem__text"
                    >Employers Listing V3</a
                  >
                </li>
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="companies5aea.html?_layout=v4"
                    class="mm-listitem__text"
                    >Employers Listing V4</a
                  >
                </li>
              </ul>
            </div>
            <div id="mm-8" class="mm-panel mm-hidden" aria-hidden="true">
              <div class="mm-navbar mm-navbar_sticky">
                <a
                  class="mm-btn mm-btn_prev mm-navbar__btn"
                  href="#mm-6"
                  aria-haspopup="true"
                  aria-owns="mm-6"
                  ><span class="mm-sronly">Close submenu</span></a
                ><a class="mm-navbar__title" href="#mm-6" aria-hidden="true"
                  ><span>Employer Single </span></a
                >
              </div>
              <ul class="children-menu menu-dropdown mm-listview">
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="companies/netflix7a7e.html?_layout=v1"
                    class="mm-listitem__text"
                    >Employer Single V1</a
                  >
                </li>
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="companies/netflix03bf.html?_layout=v2"
                    class="mm-listitem__text"
                    >Employer Single V2</a
                  >
                </li>
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="companies/netflixb598.html?_layout=v3"
                    class="mm-listitem__text"
                    >Employer Single V3</a
                  >
                </li>
              </ul>
            </div>
            <div id="mm-9" class="mm-panel mm-hidden" aria-hidden="true">
              <div class="mm-navbar mm-navbar_sticky">
                <a
                  class="mm-btn mm-btn_prev mm-navbar__btn"
                  href="#navbar"
                  aria-haspopup="true"
                  aria-owns="navbar"
                  ><span class="mm-sronly">Close submenu</span></a
                ><a class="mm-navbar__title" href="#navbar" aria-hidden="true"
                  ><span>Candidates </span></a
                >
              </div>
              <ul class="children-menu menu-dropdown mm-listview">
                <li class="dropdown depth-1 mm-listitem">
                  <a target="" href="candidate.html" class="mm-listitem__text"
                    >Candidates List <i class="caret flaticon-down-arrow"></i
                  ></a>

                  <a
                    class="mm-btn mm-btn_next mm-listitem__btn"
                    href="#mm-10"
                    aria-haspopup="true"
                    aria-owns="mm-10"
                    ><span class="mm-sronly">Open submenu</span></a
                  >
                </li>
                <li class="dropdown depth-1 mm-listitem">
                  <a
                    target=""
                    href="candidate/ui-designer-at-invision-1.html"
                    class="mm-listitem__text"
                    >Candidates Single <i class="caret flaticon-down-arrow"></i
                  ></a>

                  <a
                    class="mm-btn mm-btn_next mm-listitem__btn"
                    href="#mm-11"
                    aria-haspopup="true"
                    aria-owns="mm-11"
                    ><span class="mm-sronly">Open submenu</span></a
                  >
                </li>
              </ul>
            </div>
            <div id="mm-10" class="mm-panel mm-hidden" aria-hidden="true">
              <div class="mm-navbar mm-navbar_sticky">
                <a
                  class="mm-btn mm-btn_prev mm-navbar__btn"
                  href="#mm-9"
                  aria-haspopup="true"
                  aria-owns="mm-9"
                  ><span class="mm-sronly">Close submenu</span></a
                ><a class="mm-navbar__title" href="#mm-9" aria-hidden="true"
                  ><span>Candidates List </span></a
                >
              </div>
              <ul class="children-menu menu-dropdown mm-listview">
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="candidate7a7e.html?_layout=v1"
                    class="mm-listitem__text"
                    >Candidates Listing V1</a
                  >
                </li>
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="candidate03bf.html?_layout=v2"
                    class="mm-listitem__text"
                    >Candidates Listing V2</a
                  >
                </li>
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="candidateb598.html?_layout=v3"
                    class="mm-listitem__text"
                    >Candidates Listing V3</a
                  >
                </li>
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="candidate5aea.html?_layout=v4"
                    class="mm-listitem__text"
                    >Candidates Listing V4</a
                  >
                </li>
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="candidatedf54.html?_layout=v5"
                    class="mm-listitem__text"
                    >Candidates Listing V5</a
                  >
                </li>
              </ul>
            </div>
            <div id="mm-11" class="mm-panel mm-hidden" aria-hidden="true">
              <div class="mm-navbar mm-navbar_sticky">
                <a
                  class="mm-btn mm-btn_prev mm-navbar__btn"
                  href="#mm-9"
                  aria-haspopup="true"
                  aria-owns="mm-9"
                  ><span class="mm-sronly">Close submenu</span></a
                ><a class="mm-navbar__title" href="#mm-9" aria-hidden="true"
                  ><span>Candidates Single </span></a
                >
              </div>
              <ul class="children-menu menu-dropdown mm-listview">
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="candidate/ui-designer-at-invision-1.html"
                    class="mm-listitem__text"
                    >Candidate Single V1</a
                  >
                </li>
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="candidate/ui-designer-at-invision-103bf.html?_layout=v2"
                    class="mm-listitem__text"
                    >Candidate Single V2</a
                  >
                </li>
                <li class="depth-2 mm-listitem">
                  <a
                    target=""
                    href="candidate/ui-designer-at-invision-1b598.html?_layout=v3"
                    class="mm-listitem__text"
                    >Candidate Single V3</a
                  >
                </li>
              </ul>
            </div>
            <div id="mm-12" class="mm-panel mm-hidden" aria-hidden="true">
              <div class="mm-navbar mm-navbar_sticky">
                <a
                  class="mm-btn mm-btn_prev mm-navbar__btn"
                  href="#navbar"
                  aria-haspopup="true"
                  aria-owns="navbar"
                  ><span class="mm-sronly">Close submenu</span></a
                ><a class="mm-navbar__title" href="#navbar" aria-hidden="true"
                  ><span>Pages </span></a
                >
              </div>
              <ul class="children-menu menu-dropdown mm-listview">
                <li class="depth-1 mm-listitem">
                  <a target="" href="news.html" class="mm-listitem__text"
                    >Blog List</a
                  >
                </li>
                <li class="depth-1 mm-listitem">
                  <a
                    target=""
                    href="news/5-tips-for-your-job-interviews.html"
                    class="mm-listitem__text"
                    >Blog Single</a
                  >
                </li>
                <li class="depth-1 mm-listitem">
                  <a target="" href="page/about.html" class="mm-listitem__text"
                    >About Us</a
                  >
                </li>
                <li class="depth-1 mm-listitem">
                  <a target="" href="page/faqs.html" class="mm-listitem__text"
                    >FAQ's</a
                  >
                </li>
                <li class="depth-1 mm-listitem">
                  <a
                    target=""
                    href="page/terms-and-conditions.html"
                    class="mm-listitem__text"
                    >Terms</a
                  >
                </li>
                <li class="depth-1 mm-listitem">
                  <a target="" href="{{url('contact')}}" class="mm-listitem__text"
                    >Contact</a
                  >
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  


    <div class="mm-page mm-slideout" id="mm-0">
      <div class="bravo_wrap page-wrapper mm-page mm-slideout" id="mm-0" style="">
      
        {{-- navbar --}}
          <livewire:navbar/>

        {{-- session message --}}
          
      <div class="fixed-bottom row container m-auto" >
            
            {{-- message status --}}
          @if (session('status'))
          <span>
            @livewire('components.alert-popup', ['message' => session('status'),'type' => 'primary','icon' => 'notifications'])
          </span>
          @endif 
          {{-- message success --}}
          @if (session('success'))
          <span>

            @livewire('components.alert-popup', ['message' => session('success'),'type' => 'success','icon' => 'check_circle'])
          </span> 
          @endif 
          {{-- message warning --}}
          @if (session('warning'))
          <span>
            @livewire('components.alert-popup', ['message' => session('warning'),'type' => 'warning','icon' => 'warning'])
          </span>
          @endif 
          {{-- message error --}}
          @if (session('error'))
          <span>

            @livewire('components.alert-popup', ['message' => session('error'),'type' => 'danger','icon' => 'error'])
          </span>
                  
          @endif 
          
            
      </div>
        {{-- END session message --}}

        {{-- main --}}
        @yield('main')



        {{-- footer --}}
          <livewire:footer/>

  @include('layouts.script')
</div>
</div>

{{-- cart drawer: rendered outside .mm-page.mm-slideout (which always carries a
     CSS transform for the mmenu slide animation) so its position:fixed overlay
     is never trapped inside a transformed ancestor's containing block --}}
<livewire:services.cart-drawer-component />

<div class="mm-wrapper__blocker mm-slideout">
<a href="#mm-0"><span class="mm-sronly">Close menu</span></a>
</div>

<div class="mm-wrapper__blocker mm-slideout">
<a href="#mm-0"><span class="mm-sronly">Close menu</span></a>
</div>

<div class="mm-wrapper__blocker mm-slideout">
<a href="#mm-0"><span class="mm-sronly">Close menu</span></a>
</div>

</body>
<livewire:scripts />
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-right',
        showConfirmButton: false,
        showCloseButton: true,
        timer: 5000,
        timerProgressBar:true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    window.addEventListener('alert',({detail:{type,message}})=>{
        Toast.fire({
            icon:type,
            title:message
        })
    })
    document.addEventListener('alpine:init', () => {
        Alpine.store('cart', {
            open: false,
            toggle() { this.open = !this.open },
            close() { this.open = false },
        });
    });

    window.addEventListener('cart-updated', () => {
        Livewire.emit('cart-updated')
    });
</script>

</html>

