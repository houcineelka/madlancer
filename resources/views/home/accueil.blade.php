@extends('layouts.myL')
@section('title','Home')
@section('main')

<div class="page-template-content page-home-page-1">
    <section class="banner-section hero-banner-style-1">
      <div class="auto-container">
        <div class="row">
          <div class="content-column col-lg-7 col-md-12 col-sm-12">
            <div class="inner-column wow fadeInUp" data-wow-delay="1000ms">
              <div class="title-box">
                <h3>
                  There Are More Than <span class="colored">10.000</span> Services And Jobs
                  Here<br />
                  For you!
                </h3>
              </div>

              <div class="job-search-form">
                <form
                  method="get"
                  action="{{route('/search')}}"
                >
                  <div class="row">
                    <div class="form-group col-lg-5 col-md-12 col-sm-12">
                      <span class="icon flaticon-search-1"></span>
                      <input type="text" name="key"/>
                    </div>
                    
                    <div class="form-group col-lg-4 col-md-12 col-sm-12  ">
                        <select  name="by" class="form-select" >
                            <option value="">Search By</option>
                            <option value="categories">category</option>
                            <option value="services">services</option>
                        </select>
                    </div>
                    <div
                      class="form-group col-lg-3 col-md-12 col-sm-12 btn-box"
                    >
                      <button type="submit" class="theme-btn btn-style-one">
                        <span class="btn-title">Search</span>
                      </button>
                    </div>
                  </div>
                </form>
              </div>

              <div class="popular-searches">
                <span class="title">Popular Searches : </span>
                <a href="job17f4.html?s=Designer">Designer</a>
                , <a href="job1d69.html?s=Developer">Developer</a> ,
                <a href="joba400.html?s=Web">Web</a> ,
                <a href="jobf314.html?s=IOS">IOS</a> ,
                <a href="job85f0.html?s=PHP">PHP</a> ,
                <a href="jobb139.html?s=Senior">Senior</a> ,
                <a href="joba77b.html?s=Engineer">Engineer</a>
              </div>
            </div>
          </div>
          <div class="image-column col-lg-5 col-md-12">
            <div class="image-box">
              <figure class="main-image wow fadeIn" data-wow-delay="500ms">
                <img
                  src="{{asset('public/madlancer/img/i1.png')}}"
                  alt=""
                />
              </figure>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="job-categories">
      <div class="auto-container">
        <div class="sec-title text-center">
          <h2> Latest Gigs</h2>
        </div>
        <div class="row wow fadeInUp">
          <div class="category-block col-lg-4 col-md-6 col-sm-12">
            <div class="inner-box">
              <a href="job7a81.html?category=1">
                <div class="content">
                  <span class="icon icon flaticon-money-1"></span>
                  <h4>Accounting / Finance</h4>
                  <p>(1 open position)</p>
                </div>
              </a>
            </div>
          </div>

          <div class="category-block col-lg-4 col-md-6 col-sm-12">
            <div class="inner-box">
              <a href="job9297.html?category=2">
                <div class="content">
                  <span class="icon icon flaticon-promotion"></span>
                  <h4>Marketing</h4>
                  <p>(2 open positions)</p>
                </div>
              </a>
            </div>
          </div>

          <div class="category-block col-lg-4 col-md-6 col-sm-12">
            <div class="inner-box">
              <a href="jobdb58.html?category=3">
                <div class="content">
                  <span class="icon icon flaticon-vector"></span>
                  <h4>Design</h4>
                  <p>(1 open position)</p>
                </div>
              </a>
            </div>
          </div>

          <div class="category-block col-lg-4 col-md-6 col-sm-12">
            <div class="inner-box">
              <a href="job3eca.html?category=4">
                <div class="content">
                  <span class="icon icon flaticon-web-programming"></span>
                  <h4>Development</h4>
                  <p>(2 open positions)</p>
                </div>
              </a>
            </div>
          </div>

          <div class="category-block col-lg-4 col-md-6 col-sm-12">
            <div class="inner-box">
              <a href="jobaa07.html?category=5">
                <div class="content">
                  <span class="icon icon flaticon-headhunting"></span>
                  <h4>Human Resource</h4>
                  <p>(2 open positions)</p>
                </div>
              </a>
            </div>
          </div>

          <div class="category-block col-lg-4 col-md-6 col-sm-12">
            <div class="inner-box">
              <a href="joba8ee.html?category=6">
                <div class="content">
                  <span class="icon icon flaticon-rocket-ship"></span>
                  <h4>Project Management</h4>
                </div>
              </a>
            </div>
          </div>

          <div class="category-block col-lg-4 col-md-6 col-sm-12">
            <div class="inner-box">
              <a href="job2a93.html?category=7">
                <div class="content">
                  <span class="icon icon flaticon-support-1"></span>
                  <h4>Customer Service</h4>
                  <p>(1 open position)</p>
                </div>
              </a>
            </div>
          </div>

          <div class="category-block col-lg-4 col-md-6 col-sm-12">
            <div class="inner-box">
              <a href="joba771.html?category=8">
                <div class="content">
                  <span class="icon icon flaticon-first-aid-kit-1"></span>
                  <h4>Health and Care</h4>
                  <p>(1 open position)</p>
                </div>
              </a>
            </div>
          </div>

          <div class="category-block col-lg-4 col-md-6 col-sm-12">
            <div class="inner-box">
              <a href="job9a33.html?category=9">
                <div class="content">
                  <span class="icon icon flaticon-car"></span>
                  <h4>Automotive Jobs</h4>
                  <p>(1 open position)</p>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="job-section">
      <div class="auto-container">
        <div class="sec-title text-center">
          <h2>Featured Jobs</h2>
          <div class="text">
            Know your worth and find the job that qualify your life
          </div>
        </div>
        <div class="row wow fadeInUp">
          <div class="job-block col-lg-6 col-md-12 col-sm-12">
            <div class="inner-box">
              <div class="content">
                <span class="company-logo">
                  <a href="companies/mural.html"
                    ><img
                      src="uploads/demo/company/bc_company-4.png"
                      alt="Mural"
                  /></a>
                </span>
                <h4>
                  <a href="job/software-engineer-android-lib.html"
                    >Software Engineer (Android), Libraries</a
                  >
                </h4>
                <ul class="job-info">
                  <li>
                    <span class="icon flaticon-briefcase"></span>
                    Development
                  </li>
                  <li>
                    <span class="icon flaticon-map-locator"></span> Miami
                  </li>
                  <li>
                    <span class="icon flaticon-clock-3"></span> 02/21/2023
                  </li>
                  <li>
                    <span class="icon flaticon-money"></span> $2.500 -
                    $3.500
                  </li>
                </ul>
                <ul class="job-other-info">
                  <li class="time">Full Time</li>
                  <li class="privacy">Featured</li>
                </ul>
                <button
                  class="bookmark-btn service-wishlist"
                  data-id="11"
                  data-type="job"
                >
                  <img
                    src="images/loading.gif"
                    class="loading-icon"
                    alt="loading"
                  />
                  <span class="flaticon-bookmark"></span>
                </button>
              </div>
            </div>
          </div>
          <div class="job-block col-lg-6 col-md-12 col-sm-12">
            <div class="inner-box">
              <div class="content">
                <span class="company-logo">
                  <a href="companies/checkr.html"
                    ><img
                      src="uploads/demo/company/bc_company-3.png"
                      alt="Checkr"
                  /></a>
                </span>
                <h4>
                  <a href="job/restaurant-team-member.html"
                    >Restaurant Team Member</a
                  >
                </h4>
                <ul class="job-info">
                  <li>
                    <span class="icon flaticon-briefcase"></span> Customer
                    Service
                  </li>
                  <li>
                    <span class="icon flaticon-map-locator"></span> London
                  </li>
                  <li>
                    <span class="icon flaticon-clock-3"></span> 02/21/2023
                  </li>
                  <li>
                    <span class="icon flaticon-money"></span> $4.500 -
                    $6.000
                  </li>
                </ul>
                <ul class="job-other-info">
                  <li class="time">Part Time</li>
                  <li class="privacy">Featured</li>
                  <li class="required">Urgent</li>
                </ul>
                <button
                  class="bookmark-btn service-wishlist"
                  data-id="9"
                  data-type="job"
                >
                  <img
                    src="images/loading.gif"
                    class="loading-icon"
                    alt="loading"
                  />
                  <span class="flaticon-bookmark"></span>
                </button>
              </div>
            </div>
          </div>
          <div class="job-block col-lg-6 col-md-12 col-sm-12">
            <div class="inner-box">
              <div class="content">
                <span class="company-logo">
                  <a href="companies/netflix.html"
                    ><img
                      src="uploads/demo/company/bc_company-1.png"
                      alt="Netflix"
                  /></a>
                </span>
                <h4>
                  <a href="job/assistant-store-keeper.html"
                    >Assistant / Store Keeper</a
                  >
                </h4>
                <ul class="job-info">
                  <li>
                    <span class="icon flaticon-briefcase"></span> Automotive
                    Jobs
                  </li>
                  <li>
                    <span class="icon flaticon-map-locator"></span> Miami
                  </li>
                  <li>
                    <span class="icon flaticon-clock-3"></span> 02/21/2023
                  </li>
                  <li>
                    <span class="icon flaticon-money"></span> $4.500 -
                    $6.000
                  </li>
                </ul>
                <ul class="job-other-info">
                  <li class="time">Internship</li>
                  <li class="privacy">Featured</li>
                </ul>
                <button
                  class="bookmark-btn service-wishlist"
                  data-id="6"
                  data-type="job"
                >
                  <img
                    src="images/loading.gif"
                    class="loading-icon"
                    alt="loading"
                  />
                  <span class="flaticon-bookmark"></span>
                </button>
              </div>
            </div>
          </div>
          <div class="job-block col-lg-6 col-md-12 col-sm-12">
            <div class="inner-box">
              <div class="content">
                <span class="company-logo">
                  <a href="companies/checkr.html"
                    ><img
                      src="uploads/demo/company/bc_company-3.png"
                      alt="Checkr"
                  /></a>
                </span>
                <h4>
                  <a
                    href="job/senior-full-stack-engineer-creator-success.html"
                    >Senior Full Stack Engineer, Creator Success</a
                  >
                </h4>
                <ul class="job-info">
                  <li>
                    <span class="icon flaticon-briefcase"></span>
                    Development
                  </li>
                  <li>
                    <span class="icon flaticon-map-locator"></span> Paris
                  </li>
                  <li>
                    <span class="icon flaticon-clock-3"></span> 02/21/2023
                  </li>
                  <li>
                    <span class="icon flaticon-money"></span> $4.500 -
                    $6.000
                  </li>
                </ul>
                <ul class="job-other-info">
                  <li class="time">Temporary</li>
                  <li class="privacy">Featured</li>
                </ul>
                <button
                  class="bookmark-btn service-wishlist"
                  data-id="4"
                  data-type="job"
                >
                  <img
                    src="images/loading.gif"
                    class="loading-icon"
                    alt="loading"
                  />
                  <span class="flaticon-bookmark"></span>
                </button>
              </div>
            </div>
          </div>
          <div class="job-block col-lg-6 col-md-12 col-sm-12">
            <div class="inner-box">
              <div class="content">
                <span class="company-logo">
                  <a href="companies/opendoor.html"
                    ><img
                      src="uploads/demo/company/bc_company-2.png"
                      alt="Opendoor"
                  /></a>
                </span>
                <h4>
                  <a href="job/senior-product-designer.html"
                    >Senior Product Designer</a
                  >
                </h4>
                <ul class="job-info">
                  <li>
                    <span class="icon flaticon-briefcase"></span> Design
                  </li>
                  <li>
                    <span class="icon flaticon-map-locator"></span> Paris
                  </li>
                  <li>
                    <span class="icon flaticon-clock-3"></span> 02/21/2023
                  </li>
                  <li>
                    <span class="icon flaticon-money"></span> $4.500 -
                    $6.000
                  </li>
                </ul>
                <ul class="job-other-info">
                  <li class="time">Full Time</li>
                  <li class="privacy">Featured</li>
                  <li class="required">Urgent</li>
                </ul>
                <button
                  class="bookmark-btn service-wishlist"
                  data-id="3"
                  data-type="job"
                >
                  <img
                    src="images/loading.gif"
                    class="loading-icon"
                    alt="loading"
                  />
                  <span class="flaticon-bookmark"></span>
                </button>
              </div>
            </div>
          </div>
          <div class="job-block col-lg-6 col-md-12 col-sm-12">
            <div class="inner-box">
              <div class="content">
                <span class="company-logo">
                  <a href="companies/netflix.html"
                    ><img
                      src="uploads/demo/company/bc_company-1.png"
                      alt="Netflix"
                  /></a>
                </span>
                <h4>
                  <a href="job/product-manager-studio.html"
                    >Product Manager, Studio</a
                  >
                </h4>
                <ul class="job-info">
                  <li>
                    <span class="icon flaticon-briefcase"></span> Health and
                    Care
                  </li>
                  <li>
                    <span class="icon flaticon-map-locator"></span> New York
                  </li>
                  <li>
                    <span class="icon flaticon-clock-3"></span> 02/21/2023
                  </li>
                  <li>
                    <span class="icon flaticon-money"></span> $4.500 -
                    $6.000
                  </li>
                </ul>
                <ul class="job-other-info">
                  <li class="time">Full Time</li>
                  <li class="privacy">Featured</li>
                </ul>
                <button
                  class="bookmark-btn service-wishlist"
                  data-id="1"
                  data-type="job"
                >
                  <img
                    src="images/loading.gif"
                    class="loading-icon"
                    alt="loading"
                  />
                  <span class="flaticon-bookmark"></span>
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="btn-box">
          <a href="job.html" class="theme-btn btn-style-one bg-blue"
            ><span class="btn-title">Load More Listing</span></a
          >
        </div>
      </div>
    </section>



    <div class="list-brands clients-section">
      <div class="sponsors-outer">
        <ul class="sponsors-carousel owl-carousel owl-theme" data-items="7">
          <li class="slide-item">
            <figure class="image-box">
              <a href="#">
                <img
                  class="img-fluid d-inline-block w-auto"
                  src="uploads/demo/general/brand-1.png"
                  alt="Invision"
                />
              </a>
            </figure>
          </li>
          <li class="slide-item">
            <figure class="image-box">
              <img
                class="img-fluid d-inline-block w-auto"
                src="uploads/demo/general/brand-2.png"
                alt="Figma"
              />
            </figure>
          </li>
          <li class="slide-item">
            <figure class="image-box">
              <img
                class="img-fluid d-inline-block w-auto"
                src="uploads/demo/general/brand-3.png"
                alt="Amazon"
              />
            </figure>
          </li>
          <li class="slide-item">
            <figure class="image-box">
              <img
                class="img-fluid d-inline-block w-auto"
                src="uploads/demo/general/brand-4.png"
                alt="Airbnb"
              />
            </figure>
          </li>
          <li class="slide-item">
            <figure class="image-box">
              <img
                class="img-fluid d-inline-block w-auto"
                src="uploads/demo/general/brand-5.png"
                alt="Spotify"
              />
            </figure>
          </li>
          <li class="slide-item">
            <figure class="image-box">
              <img
                class="img-fluid d-inline-block w-auto"
                src="uploads/demo/general/brand-6.png"
                alt="Slack"
              />
            </figure>
          </li>
          <li class="slide-item">
            <figure class="image-box">
              <img
                class="img-fluid d-inline-block w-auto"
                src="uploads/demo/general/brand-7.png"
                alt="Paypal"
              />
            </figure>
          </li>
        </ul>
      </div>
    </div>

    <section class="about-section about-style-1" id="job">
      <div class="auto-container">
        <div class="row mb-5">
          <div class="content-column col-lg-6 col-md-12 col-sm-12 order-2">
            <div class="inner-column wow fadeInUp">
              <h2 class="about-title">
                Millions of Jobs. Find the one that suits you.
              </h2>
              <div class="sec-content">
                <p>
                  Search all the open positions on the web. Get your own
                  personalized salary estimate. Read reviews on over 600,000
                  companies worldwide.
                </p>
                <ul class="list-style-one">
                  <li>Bring to the table win-win survival</li>
                  <li>Capitalize on low hanging fruit to identify</li>
                  <li>But I must explain to you how all this</li>
                </ul>
              </div>
              <a
                href="#"
                target="self"
                class="theme-btn btn-style-one bg-blue"
                ><span class="btn-title">Get Started</span></a
              >
            </div>
          </div>

          <div class="image-column col-lg-6 col-md-12 col-sm-12" >
            <figure class="image wow fadeInLeft">
              <img src="{{asset('public/madlancer/img/job.jpg')}}" alt="" class="imgHome" />
            </figure>
          </div>
        </div>
      </div>
    </section>
    <livewire:news-component />
    
  </div>


@endsection