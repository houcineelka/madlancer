<link rel="stylesheet" href="{{asset('public/madlancer/libs/flags/css/flag-icon.min.css')}}" />
  <script src="{{asset('public/madlancer/libs/lazy-load/intersection-observer.js')}}"></script>
  <script async="" src="{{asset('public/madlancer/libs/lazy-load/lazyload.min.js')}}"></script>
  <script>
    window.lazyLoadOptions = {
      elements_selector: ".lazy",
    };

    window.addEventListener(
      "LazyLoad::Initialized",
      function (event) {
        window.lazyLoadInstance = event.detail.instance;
      },
      false
    );
  </script>

  <script src="{{asset('public/madlancer/libs/jquery-3.6.0.min.js')}}"></script>
  <script src="{{asset('public/madlancer/libs/jquery-migrate/jquery-migrate.min.js')}}"></script>
  <script src="{{asset('public/madlancer/libs/header.js')}}"></script>

  <script src="{{asset('public/madlancer/libs/lodash.min.js')}}"></script>
  <script src="{{asset('public/madlancer/libs/vue/vue.min.js')}}"></script>
  <script src="{{asset('public/madlancer/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
  <script src="{{asset('public/madlancer/libs/bootbox/bootbox.min.js')}}"></script>
  <script src="{{asset('public/madlancer/libs/tinymce/js/tinymce/tinymce.min.js')}}"></script>
  <script>
    window.superio = {
      rtl: 0,
      currency_rate: 1,
      currency_symbol: "$",
      currency_position: "left",
      booking_decimals: 2,
      decimal_separator: ".",
      thousand_separator: ",",
    };
  </script>
  <script src="{{asset('public/madlancer/js/functions9c9f.js?_ver=1.2.3')}}"></script>
  <script src="{{asset('public/madlancer/module/superio/js/popper.min.js')}}"></script>
  <script src="{{asset('public/madlancer/module/superio/js/jquery-ui.min.js')}}"></script>
  <script src="{{asset('public/madlancer/module/superio/js/chosen.min.js')}}"></script>
  <script src="{{asset('public/madlancer/libs/select2/js/select2.min.js')}}"></script>
  <script src="{{asset('public/madlancer/module/superio/js/jquery.fancybox.js')}}"></script>
  <script src="{{asset('public/madlancer/module/superio/js/jquery.modal.min.js')}}"></script>
  <script src="{{asset('public/madlancer/module/superio/js/mmenu.polyfills.js')}}"></script>
  <script src="{{asset('public/madlancer/module/superio/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('public/madlancer/module/superio/js/mmenu.js')}}"></script>
  <script src="{{asset('public/madlancer/module/superio/js/appear.js')}}"></script>
  <script src="{{asset('public/madlancer/module/superio/js/anm.min.js')}}"></script>
  <script src="{{asset('public/madlancer/module/superio/js/owl.js')}}"></script>
  <script src="{{asset('public/madlancer/module/superio/js/wow.js')}}"></script>
  <script src="{{asset('public/madlancer/module/superio/js/script9c9f.js?_ver=1.2.3')}}"></script>
  <script src="{{asset('public/madlancer/libs/pusher.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('public/madlancer/libs/fotorama/fotorama.js')}}"></script>
  <script type="text/javascript" src="{{asset('public/madlancer/module/gig/js/single-gig2615.js?_ver=2.3.0')}}"></script>
  <script>
    function menuToggle(){
        const toggleMenu = document.querySelector('.menu');
        toggleMenu.classList.toggle('active')
    }
    function notToggle(){
        const toggleMenu = document.querySelector('.menu2');
        toggleMenu.classList.toggle('active')
    }
    $(document).ready(function(){
      $('#loading').fadeOut(500);
    })
</script>




<script >
  const items = document.querySelectorAll(".accordion a");
  function toggleAccordion(){
    this.classList.toggle('active');
    this.nextElementSibling.classList.toggle('active');
  }
  items.forEach(item => item.addEventListener('click', toggleAccordion));
  </script>
{{-- AlpineJs --}}
@stack('scripts')
