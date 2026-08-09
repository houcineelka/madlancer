@section('title', $page->title)

<section class="hr-section hr-page-section">
  <div class="auto-container">
    <div class="hr-static-page">
      <h1>{{ $page->title }}</h1>
      <div class="hr-static-page__content">
        {!! $page->content !!}
      </div>
    </div>
  </div>
</section>
