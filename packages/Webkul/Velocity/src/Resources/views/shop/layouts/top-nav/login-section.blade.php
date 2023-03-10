{!! view_render_event('bagisto.shop.layout.header.account-item.before') !!}

<div id="account" class="d-flex align-items-center cursor-pointer">
    <div class="d-inline-block welcome-content dropdown-toggle">
        @if (auth()->guard('customer')->user() && auth()->guard('customer')->user()->image)
            <i class="align-vertical-top"><img class= "profile-small-icon" src="{{ auth('customer')->user()->image_url }}" alt="{{ auth('customer')->user()->first_name }}"/></i>
        @else
{{--            <i class="material-icons align-vertical-top">perm_identity</i>--}}
            <img src="{{asset('images/account.svg')}}" alt="Account">
        @endif


        <span class="rango-arrow-down"></span>
    </div>

    @guest('customer')
        <div class="dropdown-list" style="width: 290px; margin-top: 262px;
    margin-left: -253px;">
            <div class="modal-content dropdown-container">
                <div class="modal-header no-border pb0">
                    <label class="fs18 text-shaka">{{ __('shop::app.header.title') }}</label>
                </div>

                <div class="fs14 content">
                    <p class="no-margin">{{ __('shop::app.header.dropdown-text') }}</p>
                </div>

                <div class="modal-footer">
                    <a href="{{ route('customer.session.index') }}" class="theme-btn bg-shaka-primary fs14 fw6">
                        {{ __('shop::app.header.sign-in') }}
                    </a>

                    <a href="{{ route('customer.register.index') }}" class="theme-btn bg-shaka-primary fs14 fw6">
                        {{ __('shop::app.header.sign-up') }}
                    </a>
                </div>
            </div>
        </div>
    @endguest

    @auth('customer')
        <div class="dropdown-list" style="margin-top: 262px;
    margin-left: -153px;">
            <div class="dropdown-label text-shaka">
                {{ auth()->guard('customer')->user()->first_name }}
            </div>

            <div class="dropdown-container text-dark">
                <ul type="none">
                    <li>
                        <a href="{{ route('customer.profile.index') }}" class="unset">{{ __('shop::app.header.profile') }}</a>
                    </li>

                    <li>
                        <a href="{{ route('customer.orders.index') }}" class="unset">{{ __('velocity::app.shop.general.orders') }}</a>
                    </li>

                    @php
                        $showCompare = core()->getConfigData('general.content.shop.compare_option') == "1" ? true : false;

                        $showWishlist = core()->getConfigData('general.content.shop.wishlist_option') == "1" ? true : false;
                    @endphp

                    @if ($showWishlist)
                        <li>
                            <a href="{{ route('customer.wishlist.index') }}" class="unset">{{ __('shop::app.header.wishlist') }}</a>
                        </li>
                    @endif

{{--                    @if ($showCompare)--}}
{{--                        <li>--}}
{{--                            <a href="{{ route('velocity.customer.product.compare') }}" class="unset">{{ __('velocity::app.customer.compare.text') }}</a>--}}
{{--                        </li>--}}
{{--                    @endif--}}

                    <li>
                        <form id="customerLogout" action="{{ route('customer.session.destroy') }}" method="POST">
                            @csrf

                            @method('DELETE')
                        </form>

                        <a
                            class="unset"
                            href="{{ route('customer.session.destroy') }}"
                            onclick="event.preventDefault(); document.getElementById('customerLogout').submit();">
                            {{ __('shop::app.header.logout') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    @endauth
</div>

{!! view_render_event('bagisto.shop.layout.header.account-item.after') !!}
