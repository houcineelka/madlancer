<span>
  <div class="g-gallery">
      <div
        class="fotorama"
        data-width="100%"
        data-thumbwidth="90"
        data-thumbheight="90"
        data-thumbmargin="15"
        data-nav="thumbs"
        data-allowfullscreen="true"
      >
          {{-- List of images --}}
        @foreach ($gig->images as $image)
        <a href="{{src($image->medium)}}" data-alt="Gallery"></a>
        
        @endforeach
      </div>
   </div>


</span>
