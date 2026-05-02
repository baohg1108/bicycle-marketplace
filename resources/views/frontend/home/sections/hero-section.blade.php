   <section class="home-slider position-relative mb-30">
       <div class="container">
           <div class="row">
               <div class="col-lg-2 d-none d-xxl-flex">
                   <div class="categories-dropdown-wrap style-2 font-heading mt-30">
                       <div class="d-flex categori-dropdown-inner">

                           <ul>
                               @foreach (getNestedCategories() as $category)
                                   <li>
                                       {{-- <a href="{{ route('products.index', ['category' => $category->slug]) }}"> --}}
                                       <a href="#">
                                           <img src="{{ asset($category->icon) }}" alt="" />
                                           <span>{{ $category->name }}</span>
                                       </a>
                                       @if (count($category->children_nested) > 0)
                                           <ul>
                                               @foreach ($category->children_nested as $child)
                                                   <li
                                                       class="{{ count($child->children_nested) > 0 ? '' : 'no_child' }}">
                                                       {{-- <a
                                                           href="{{ route('products.index', ['category' => $child->slug]) }}">
                                                           {{ $child->name }}
                                                       </a> --}}
                                                       <a href="#"> {{ $child->name }}</a>
                                                       @if (count($child->children_nested) > 0)
                                                           <ul>
                                                               @foreach ($child->children_nested as $subchild)
                                                                   <li class="no_child">
                                                                       {{-- <a
                                                                           href="{{ route('products.index', ['category' => $subchild->slug]) }}">
                                                                           {{ $subchild->name }}
                                                                       </a> --}}
                                                                       <a href="#"> {{ $subchild->name }}</a>
                                                                   </li>
                                                               @endforeach
                                                           </ul>
                                                       @endif
                                                   </li>
                                               @endforeach
                                           </ul>
                                       @endif
                                   </li>
                               @endforeach
                           </ul>
                       </div>
                       <a href="#" class="more_categories">
                           view all
                           <i class="fa-solid fa-arrow-right"></i>
                       </a>
                   </div>
               </div>
               <div class="col-lg-8 col-xl-9 col-xxl-7">
                   <div class="home-slide-cover mt-30">
                       <div class="hero-slider-1 style-5 dot-style-1 dot-style-1-position-2">
                           <div class="single-hero-slider single-animation-wrap"
                               style="background-image: url(assets/frontend/dist/imgs/banner/banner-3.avif)">
                               <div class="slider-content">
                                   <a href="shop-grid-right.html" class="btn">Shop Now <i
                                           class="fi-rs-arrow-small-right"></i></a>
                               </div>
                           </div>
                           <div class="single-hero-slider single-animation-wrap"
                               style="background-image: url(assets/frontend/dist/imgs/banner/banner-2.avif)">
                               <div class="slider-content">
                                   <a href="shop-grid-right.html" class="btn">Shop Now <i
                                           class="fi-rs-arrow-small-right"></i></a>
                               </div>
                           </div>
                       </div>
                       <div class="slider-arrow hero-slider-1-arrow"></div>
                   </div>
               </div>
               <div class="col-lg-4 col-xl-3 col-xxl-3">
                   <div class="row">
                       <div class="col-12 col-md-6 col-lg-12">
                           <div class="banner-img style-4 mt-30">
                               <img src="{{ asset('assets/frontend/dist/imgs/banner/banner-4.png') }}" alt="" />
                               <div class="banner-text">
                                   {{-- <h4 class="mb-30">Hi-Res Audio Headphones</h4> --}}
                                   {{-- <a href="shop-grid-right.html" class="btn btn-xs mb-50">Shop Now <i
                                           class="fi-rs-arrow-small-right"></i></a> --}}
                               </div>
                           </div>
                       </div>
                       <div class="col-12 col-md-6 col-lg-12">
                           <div class="banner-img style-5 mt-5 mt-md-30">
                               <img src="{{ asset('assets/frontend/dist/imgs/banner/banner-5.png') }}" alt="" />
                               <div class="banner-text">
                                   {{-- <h5 class="mb-20">Men’s Leather <br> Waterproof Boots</h5>
                                   <a href="shop-grid-right.html" class="btn btn-xs">Shop Now <i
                                           class="fi-rs-arrow-small-right"></i></a> --}}
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </section>
