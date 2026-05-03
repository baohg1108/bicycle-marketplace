@extends('frontend.layouts.app')

@section('contents')
    <x-frontend.breadcrumb :items="[['label' => 'Home', 'url' => '/'], ['label' => 'Products']]" />

    <div class="container mb-30">
        <div class="row">
            <div class="col-xl-12">
                <div class="product-detail accordion-detail">
                    <div class="row mb-50 mt-70">
                        <div class="col-md-6 col-lg-5 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                            <div class="detail-gallery">
                                <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                <!-- MAIN SLIDES -->
                                <div class="product-image-slider">
                                    @foreach ($product->images as $image)
                                        <figure class="border-radius-10">
                                            <img src="{{ asset($image->path) }}" alt=" product image" />
                                        </figure>
                                    @endforeach
                                </div>
                                <!-- THUMBNAILS -->
                                <div class="slider-nav-thumbnails">
                                    @foreach ($product->images as $image)
                                        <div><img src="{{ asset($image->path) }}" alt="product image" /></div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- End Gallery -->
                        </div>
                        <div class="col-md-6 col-lg-7 col-sm-12 col-xs-12">
                            <div class="detail-info pr-30 pl-30">
                                <span class="stock-status out-stock"> Sale Off </span>
                                <h2 class="title-detail">{{ $product->name }}</h2>
                                <div class="product-detail-rating">
                                    <div class="product-rate-cover text-end">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (32 reviews)</span>
                                    </div>
                                </div>
                                <div class="clearfix product-price-cover">
                                    <div class="product-price primary-color float-left">
                                        @if ($product->primaryVariant)
                                            @if ($product->primaryVariant?->special_price > 0)
                                                <span
                                                    class="current-price text-brand">${{ $product->primaryVariant?->special_price }}</span>
                                                <span
                                                    class="old-price font-md ml-15">${{ $product->primaryVariant?->price }}</span>
                                            @else
                                                <span
                                                    class="current-price text-brand">${{ $product->primaryVariant?->price }}</span>
                                            @endif
                                        @else
                                            @if ($product->special_price > 0)
                                                <span class="current-price text-brand">
                                                    ${{ $product->special_price }}
                                                </span>
                                                <span class="old-price font-md ml-15">
                                                    ${{ $product->price }}
                                                </span>
                                            @else
                                                <span class="current-price text-brand">${{ $product->price }}</span>
                                            @endif
                                        @endif

                                    </div>
                                </div>
                                <div class="short-desc mb-30">
                                    <p class="font-lg">{!! $product->short_description !!}</p>
                                </div>
                                @foreach ($product->attributeWithValues as $attribute)
                                    <div class="attr-detail attr-size mb-20">
                                        <strong class="mr-10">{{ $attribute->name }} </strong>
                                        <ul class="attribute-group color-filter list-filter size-filter font-small"
                                            data-attribute="{{ $attribute->id }}">
                                            @foreach ($attribute->values as $value)
                                                @if ($attribute->type == 'color')
                                                    <li class="attribute-badge" data-value="{{ $value->id }}"><a
                                                            href="#" style="background: {{ $value->color }};"></a>
                                                    </li>
                                                @else
                                                    <li class="attribute-badge" data-value="{{ $value->id }}"><a
                                                            href="">{{ $value->value }}</a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                                <input type="hidden" id="variants-data"
                                    value="{{ json_encode(
                                        $product->variants->map(function ($variant) {
                                            return [
                                                'id' => $variant->id,
                                                'price' => $variant->price,
                                                'special_price' => $variant->special_price,
                                                'manage_stock' => $variant->manage_stock,
                                                'quantity' => $variant->qty,
                                                'sku' => $variant->sku,
                                                'in_stock' => $variant->in_stock,
                                                'is_default' => $variant->is_default,
                                                'attribute_values' => $variant->attributeValues->pluck('id'),
                                            ];
                                        }),
                                    ) }}">
                                {{-- <div class="attr-detail attr-size mb-30">
                                    <strong class="mr-10">Color: </strong>
                                    <ul class="color_filter list-filter size-filter font-small">
                                        <li><a href="#" style="background: #000;"></a></li>
                                        <li class="active"><a href="#" style="background: #ff9010;"></a></li>
                                        <li><a href="#" style="background: #1C63E5;"></a></li>
                                        <li><a href="#" style="background: #3BB77E;"></a></li>
                                        <li><a href="#" style="background: #f74b81;"></a></li>
                                    </ul>
                                </div> --}}
                                <div class="detail-extralink mb-50">
                                    <div class="detail-qty border radius">
                                        <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                        <input type="text" name="quantity" class="qty-val" value="1" min="1">
                                        <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                    </div>
                                    <div class="product-extra-link2">
                                        <button type="submit" class="button button-add-to-cart"><i
                                                class="fi-rs-shopping-cart"></i>Add to cart</button>
                                        <a aria-label="Add To Wishlist" class="action-btn hover-up"
                                            href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn hover-up" href="shop-compare.html"><i
                                                class="fi-rs-shuffle"></i></a>
                                    </div>
                                </div>
                                <div class="font-xs">
                                    <ul class="float-start">
                                        <li class="mb-5">SKU: <a href="#" class="sku">
                                                @if ($product?->primaryVariant)
                                                    {{ $product?->primaryVariant?->sku }}
                                                @else
                                                    {{ $product->sku }}
                                                @endif
                                            </a></li>
                                        <li class="mb-5">Tags:
                                            @foreach ($product->tags as $tag)
                                                <a href="#" rel="tag">{{ $tag->name }}</a>
                                                {{ $loop->last ? '' : ', ' }}
                                            @endforeach
                                        </li>
                                        <li>Stock:<span class="in-stock text-brand ml-5"><span class="stock-qty">
                                                    @if ($product->manage_stock == 1)
                                                        {{ $product->qty }}
                                                    @else
                                                        Unlimited
                                                    @endif
                                                </span>
                                                Items In Stock</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Detail Info -->
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="tab-style3">
                            <ul class="nav nav-tabs text-uppercase">
                                <li class="nav-item">
                                    <a class="nav-link active" id="Description-tab" data-bs-toggle="tab"
                                        href="#Description">Description</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="Vendor-info-tab" data-bs-toggle="tab"
                                        href="#Vendor-info">Vendor</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Reviews-tab" data-bs-toggle="tab" href="#Reviews">Reviews
                                        (3)</a>
                                </li>
                            </ul>
                            <div class="tab-content shop_info_tab entry-main-content">
                                <div class="tab-pane fade show active" id="Description">
                                    <div class="">
                                        {!! $product->description !!}
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="Vendor-info">
                                    <div class="vendor-logo d-flex mb-30 align-items-center">
                                        <img src="{{ asset($product->store->logo) }}" alt="" />
                                        <div class="vendor-name ml-15">
                                            <h6>
                                                <a href="vendor-details-2.html">{{ $product->store->name }}</a>
                                            </h6>
                                            <div class="product-rate-cover text-end">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (32 reviews)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="contact-infor mb-50">
                                        @if ($product->store->address)
                                            <li><img src="{{ asset('assets/frontend/dist/imgs/theme/icons/icon-location.svg') }}"
                                                    alt="" /><strong>Address: </strong>
                                                <span>{{ $product->store->address }}</span>
                                            </li>
                                        @endif
                                        @if ($product->store->phone)
                                            <li><img src="{{ asset('assets/frontend/dist/imgs/theme/icons/icon-contact.svg') }}"
                                                    alt="" /><strong>Phone:</strong><span>
                                                    {{ $product->store->phone }} </span></li>
                                        @endif
                                        @if ($product->store->email)
                                            <li><img src="{{ asset('assets/frontend/dist/imgs/theme/icons/icon-contact.svg') }}"
                                                    alt="" /><strong>Phone:</strong><span>
                                                    {{ $product->store->email }} </span></li>
                                        @endif
                                    </ul>

                                    <p>{{ $product->store->short_description }}</p>
                                </div>
                                <div class="tab-pane fade" id="Reviews">
                                    <!--Comments-->
                                    <div class="comments-area">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <h4 class="mb-30">Customer questions & answers</h4>
                                                <div class="comment-list">
                                                    <div class="single-comment justify-content-between d-flex mb-30">
                                                        <div class="user justify-content-between d-flex">
                                                            <div class="thumb text-center">
                                                                <img src="assets/imgs/blog/author-2.png" alt="" />
                                                                <a href="#"
                                                                    class="font-heading text-brand">Sienna</a>
                                                            </div>
                                                            <div class="desc">
                                                                <div class="d-flex justify-content-between mb-10">
                                                                    <div class="d-flex align-items-center">
                                                                        <span class="font-xs text-muted">December 4,
                                                                            2024 at 3:12 pm </span>
                                                                    </div>
                                                                    <div class="product-rate d-inline-block">
                                                                        <div class="product-rating" style="width: 100%">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <p class="mb-10">Lorem ipsum dolor sit amet,
                                                                    consectetur adipisicing elit. Delectus, suscipit
                                                                    exercitationem accusantium obcaecati quos
                                                                    voluptate nesciunt facilis itaque modi commodi
                                                                    dignissimos sequi repudiandae minus ab deleniti
                                                                    totam officia id incidunt? <a href="#"
                                                                        class="reply">Reply</a></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-comment justify-content-between d-flex mb-30 ml-30">
                                                        <div class="user justify-content-between d-flex">
                                                            <div class="thumb text-center">
                                                                <img src="assets/imgs/blog/author-3.png" alt="" />
                                                                <a href="#"
                                                                    class="font-heading text-brand">Brenna</a>
                                                            </div>
                                                            <div class="desc">
                                                                <div class="d-flex justify-content-between mb-10">
                                                                    <div class="d-flex align-items-center">
                                                                        <span class="font-xs text-muted">December 4,
                                                                            2024 at 3:12 pm </span>
                                                                    </div>
                                                                    <div class="product-rate d-inline-block">
                                                                        <div class="product-rating" style="width: 80%">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <p class="mb-10">Lorem ipsum dolor sit amet,
                                                                    consectetur adipisicing elit. Delectus, suscipit
                                                                    exercitationem accusantium obcaecati quos
                                                                    voluptate nesciunt facilis itaque modi commodi
                                                                    dignissimos sequi repudiandae minus ab deleniti
                                                                    totam officia id incidunt? <a href="#"
                                                                        class="reply">Reply</a></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-comment justify-content-between d-flex">
                                                        <div class="user justify-content-between d-flex">
                                                            <div class="thumb text-center">
                                                                <img src="assets/imgs/blog/author-4.png" alt="" />
                                                                <a href="#"
                                                                    class="font-heading text-brand">Gemma</a>
                                                            </div>
                                                            <div class="desc">
                                                                <div class="d-flex justify-content-between mb-10">
                                                                    <div class="d-flex align-items-center">
                                                                        <span class="font-xs text-muted">December 4,
                                                                            2024 at 3:12 pm </span>
                                                                    </div>
                                                                    <div class="product-rate d-inline-block">
                                                                        <div class="product-rating" style="width: 80%">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <p class="mb-10">Lorem ipsum dolor sit amet,
                                                                    consectetur adipisicing elit. Delectus, suscipit
                                                                    exercitationem accusantium obcaecati quos
                                                                    voluptate nesciunt facilis itaque modi commodi
                                                                    dignissimos sequi repudiandae minus ab deleniti
                                                                    totam officia id incidunt? <a href="#"
                                                                        class="reply">Reply</a></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <h4 class="mb-30">Customer reviews</h4>
                                                <div class="d-flex mb-30">
                                                    <div class="product-rate d-inline-block mr-15">
                                                        <div class="product-rating" style="width: 90%"></div>
                                                    </div>
                                                    <h6>4.8 out of 5</h6>
                                                </div>
                                                <div class="progress">
                                                    <span>5 star</span>
                                                    <div class="progress-bar" role="progressbar" style="width: 50%"
                                                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%
                                                    </div>
                                                </div>
                                                <div class="progress">
                                                    <span>4 star</span>
                                                    <div class="progress-bar" role="progressbar" style="width: 25%"
                                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%
                                                    </div>
                                                </div>
                                                <div class="progress">
                                                    <span>3 star</span>
                                                    <div class="progress-bar" role="progressbar" style="width: 45%"
                                                        aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">45%
                                                    </div>
                                                </div>
                                                <div class="progress">
                                                    <span>2 star</span>
                                                    <div class="progress-bar" role="progressbar" style="width: 65%"
                                                        aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">65%
                                                    </div>
                                                </div>
                                                <div class="progress mb-30">
                                                    <span>1 star</span>
                                                    <div class="progress-bar" role="progressbar" style="width: 85%"
                                                        aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">85%
                                                    </div>
                                                </div>
                                                <a href="#" class="font-xs text-muted">How are ratings
                                                    calculated?</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--comment form-->
                                    <div class="comment-form">
                                        <h4 class="mb-15">Add a review</h4>
                                        <div class="product-rate d-inline-block mb-30"></div>
                                        <div class="row">
                                            <div class="col-lg-8 col-md-12">
                                                <form class="form-contact comment_form" action="#" id="commentForm">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <textarea class="form-control w-100" name="comment" id="comment" cols="30" rows="9"
                                                                    placeholder="Write Comment"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <input class="form-control" name="name" id="name"
                                                                    type="text" placeholder="Name" />
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <input class="form-control" name="email" id="email"
                                                                    type="email" placeholder="Email" />
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <input class="form-control" name="website" id="website"
                                                                    type="text" placeholder="Website" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="button button-contactForm">Submit
                                                            Review</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-70">
                        <div class="col-12">
                            <h2 class="section-title style-1 mb-30">Related products</h2>
                        </div>
                        <div class="col-12">
                            <div class="row related-products">
                                @foreach ($relatedProducts as $product)
                                    <x-frontend.product-card :product="$product" class="col-6 col-lg-4 col-xl-3 col-xxl-2" />
                                @endforeach

                                <!--end product card-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            const variantsData = JSON.parse($('#variants-data').val());
            let selectedValues = new Set();

            function selectDefaultVariant() {
                if (variantsData.length > 0) {
                    const defaultVariant = variantsData[0];

                    console.log(variantsData);

                    defaultVariant.attribute_values.forEach(valueId => {
                        const $badge = $(`.attribute-badge[data-value="${valueId}"]`);
                        $badge.addClass('active');
                        selectedValues.add(valueId);
                    })
                }
                updatePrice();
            }
            $('.attribute-badge').on('click', function() {
                const $attributeGroup = $(this).closest('.attribute-group');

                selectedValues = new Set(
                    $('.attribute-badge.active').map(function() {
                        return parseInt($(this).attr('data-value'));
                    }).get()
                );

                updatePrice();
            })

            function updatePrice() {
                const selectedValuesArray = Array.from(selectedValues);

                const matchingVariant = variantsData.find(variant => {
                    const variantValues = new Set(variant.attribute_values);
                    return selectedValuesArray.length === variantValues.size && selectedValuesArray.every(
                        value => variantValues.has(value));
                })

                if (matchingVariant) {
                    $('.button-add-to-cart').attr('data-variant', matchingVariant.id);


                    if (matchingVariant.quantity > 0 && matchingVariant.manage_stock == 1) {
                        $('.stock-qty').text(matchingVariant.quantity);
                    } else if (matchingVariant.manage_stock == 0 && matchingVariant.in_stock == 1) {
                        $('.stock-qty').text('Unlimited');
                    } else {
                        $('.stock-qty').text('0');
                    }

                    $('.sku').text(matchingVariant.sku);


                    if (matchingVariant.in_stock == 0 || matchingVariant.in_stock == null || matchingVariant
                        .quantity < 1 && matchingVariant.manage_stock == 1) {
                        html = `<div class="product-price primary-color float-left">
                            <span class="current-price text-brand">Out Of Stock</span>
                        </div>`

                        $('.product-price').replaceWith(html);

                        return;
                    }

                    if (matchingVariant.special_price > 0) {
                        var html = `
                        <div class="product-price primary-color float-left">
                                <span class="current-price text-brand">$${matchingVariant.special_price}</span>
                                    <span>
                                        <span class="old-price font-md ml-15">$${matchingVariant.price}</span>
                                    </span>
                        </div>
                        `
                    } else {
                        var html = `
                        <div class="product-price primary-color float-left">
                            <span class="current-price text-brand">$${matchingVariant.price}</span>
                        </div>
                        `
                    }

                    $('.product-price').replaceWith(html);
                }

                console.log(matchingVariant);
            }
            selectDefaultVariant();
        })
    </script>
@endpush
