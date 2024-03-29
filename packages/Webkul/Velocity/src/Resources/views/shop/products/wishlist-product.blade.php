@inject ('wishListHelper', 'Webkul\Customer\Helpers\Wishlist')

{!! view_render_event('bagisto.shop.products.wishlist.before') !!}

    @auth('customer')
        @php
            /* search wishlist on the basis of product's id so that wishlist id can be catched */
            $wishlist = $wishListHelper->getWishlistProduct($product);

            /* link making */
            $href = isset($route) ? $route : ($wishlist ? route('customer.wishlist.remove', $wishlist->id) : route('customer.wishlist.add', $product->product_id));

            /* method */
            $method = isset($route) ? 'POST' : ( $wishlist ? 'DELETE' : 'POST' );

            /* is confirmation needed */
            $isConfirm = isset($route) ? 'true' : 'false';

            /* title */
            $title = $wishlist ? __('velocity::app.shop.wishlist.remove-wishlist-text') : __('velocity::app.shop.wishlist.add-wishlist-text');
        @endphp

        <a
            class="unset -icon float-left w-100 pr-3 {{ $addWishlistClass ?? '' }} text-right"
            href="javascript:void(0);"
            title="{{ $title }}"
            onclick="submitWishlistForm(
                '{{ $href }}',
                '{{ $method }}',
                {{ $isConfirm }},
                '{{ csrf_token() }}'
            )"
        >
            <wishlist-component-product active="{{ $wishlist ? false : true }}"></wishlist-component-product>

            @if (isset($text))
                {!! $text !!}
            @endif
        </a>
    @endauth

    @guest('customer')
        <form
            id="wishlist-{{ $product->product_id }}"
            action="{{ route('customer.wishlist.add', $product->product_id) }}"
            method="POST">
            @csrf

            <a
                class="unset wishlist-icon float-left {{ $addWishlistClass ?? '' }} text-right"
                href="javascript:void(0);"
                style="margin-left: 0!important;"
                title="{{ __('velocity::app.shop.wishlist.add-wishlist-text') }}"
                onclick="document.getElementById('wishlist-{{ $product->product_id }}').submit();">

                <wishlist-component-product active="false"></wishlist-component-product>
            </a>
        </form>
    @endauth

{!! view_render_event('bagisto.shop.products.wishlist.after') !!}
