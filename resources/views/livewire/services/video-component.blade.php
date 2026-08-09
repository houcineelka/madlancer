<span>

  <div class="video-outer">
      @if ($gig->video_link)

        <h4>Gig Video</h4>
        <div class="video-box">
          <figure class="image">
            <a href="{{$gig->video_link}}" class="play-now" data-fancybox="gallery" data-caption="">
              <img class=" lazy"  data-src="{{src($gig->thumbnail)}}"
              >
              <i class="icon flaticon-play-button-3" aria-hidden="true"></i>
            </a>
          </figure>
        </div>
      @endif

    </div>


</span>
