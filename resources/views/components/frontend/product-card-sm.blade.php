<div>
    <!-- When there is no desire, all things are at peace. - Laozi -->
    <article class="row align-items-center hover-up">
        <figure class="col-sm-4 mb-0">
            <a href="#"><img src="{{ asset($product->primaryImage->path) }}" alt="" /></a>
        </figure>
        <div class="col-sm-8 mb-0">
            <h6>
                <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
            </h6>
            <div class="product-rate-cover">
                <div class="product-rate d-inline-block">
                    <div class="product-rating" style="width: 90%"></div>
                </div>
                <span class="font-small ml-5 text-muted"> (4.0)</span>
            </div>
            <div class="product-price">
                @php
                    $price = $product->getEffectivePriceAndStock();
                @endphp

                @if ($price['in_stock'])
                    @if ($price['old_price'] > 0)
                        <span>${{ $price['price'] }}</span>
                        <span class="old-price">${{ $price['old_price'] }}</span>
                    @else
                        <span>${{ $price['price'] }}</span>
                    @endif
                @else
                    <span class="text-danger">Out of stock</span>
                @endif
            </div>
        </div>
    </article>
</div>
