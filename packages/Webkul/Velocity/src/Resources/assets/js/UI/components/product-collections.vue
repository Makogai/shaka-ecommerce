<template>
    <div class="container-fluid">
        <shimmer-component v-if="isLoading"></shimmer-component>

        <template v-else-if="productCollections.length > 0">
            <!--            <card-list-header-->
            <!--                :heading="isCategory ? categoryDetails.name : productTitle"-->
            <!--                :view-all="isCategory ? `${this.baseUrl}/${categoryDetails.url_path}` : ''">-->
            <!--            </card-list-header>-->

            <div class="row" :class="localeDirection">
                <div
                    class="col-md-12 no-padding carousel-products"
                    :class="showRecentlyViewed === 'true' ? 'with-recent-viewed col-lg-9' : 'without-recent-viewed col-lg-12'">
                    <div class="row">
                        <div class="col-6 col-md-4 col-lg-3" v-for="product in productCollections">

                            <product-card
                                :list="list"
                                :product="product">
                            </product-card>
                        </div>

                        <div class="col-12 d-flex justify-content-center align-items-center">
                            <button class="mt-5 btn rounded-0 py-3 px-5 bg-shaka-primary" :disabled="buttonDisabled" @click="getProducts(true)">More items</button>
                        </div>
                    </div>
                    <!--                    <carousel-component-->
                    <!--                        :slides-per-page="slidesPerPage"-->
                    <!--                        -->
                    <!--                        :id="isCategory ? `${categoryDetails.name}-carousel` : productId"-->
                    <!--                        :locale-direction="localeDirection"-->
                    <!--                        :slides-count="productCollections.length"-->
                    <!--                        v-if="count != 0">-->

                    <!--                        <slide-->
                    <!--                            :key="index"-->
                    <!--                            :slot="`slide-${index}`"-->
                    <!--                            v-for="(product, index) in productCollections">-->
                    <!--                            <product-card-->
                    <!--                                :list="list"-->
                    <!--                                :product="product">-->
                    <!--                            </product-card>-->
                    <!--                        </slide>-->
                    <!--                    </carousel-component>-->
                </div>

                <recently-viewed
                    :title="recentlyViewedTitle"
                    :no-data-text="noDataText"
                    :add-class="`col-lg-3 col-md-12 ${localeDirection}`"
                    quantity="3"
                    add-class-wrapper=""
                    v-if="showRecentlyViewed === 'true'">
                </recently-viewed>
            </div>
        </template>
    </div>
</template>

<script>
export default {
    props: {
        count: {
            type: String,
            default: '10'
        },
        productId: {
            type: String,
            default: ''
        },
        productTitle: String,
        productRoute: String,
        localeDirection: String,
        showRecentlyViewed: {
            type: String,
            default: 'false'
        },
        recentlyViewedTitle: String,
        noDataText: String,
    },

    data: function () {
        return {
            list: false,
            isLoading: true,
            isCategory: false,
            productCollections: [],
            slidesPerPage: 4,
            windowWidth: window.innerWidth,
            route: '',
            pagination: [],
            buttonDisabled: true
        }
    },

    mounted: function () {
        this.$nextTick(() => {
            window.addEventListener('resize', this.onResize);
        });

        this.route = this.productRoute;

        this.getProducts();
        this.setWindowWidth();
        this.setSlidesPerPage(this.windowWidth);
    },

    watch: {
        /* checking the window width */
        windowWidth(newWidth, oldWidth) {
            this.setSlidesPerPage(newWidth);
        }
    },

    methods: {
        /* fetch product collections */
        getProducts: function (loadMore = false) {
            this.isLoading = true;
            this.$http.get(this.route)
                .then(response => {
                    let count = this.count;

                    if (response.data.status && count != 0) {
                        if (response.data.categoryProducts !== undefined) {
                            this.isCategory = true;
                            this.categoryDetails = response.data.categoryDetails;
                            this.productCollections = response.data.categoryProducts;
                            this.pagination = response.data.pagination;
                        } else {
                            if(loadMore){
                                response.data.products.forEach(item => {
                                    this.productCollections.push(item)
                                })

                            }else{
                                this.productCollections = response.data.products;
                            }
                            this.pagination = response.data.pagination;
                        }
                    } else {
                        this.productCollections = 0;
                    }

                    if (this.pagination.total !== this.pagination.to){
                        this.buttonDisabled = false;
                        this.route = this.pagination.next_page_url;
                    }else {
                        this.buttonDisabled = true;
                    }

                    this.isLoading = false;
                })
                .catch(error => {
                    this.isLoading = false;
                    console.log(error)
                    console.log(this.__('error.something_went_wrong'));
                })
        },

        /* waiting for element */
        waitForElement: function (selector, callback) {
            if (jQuery(selector).length) {
                callback();
            } else {
                setTimeout(() => {
                    this.waitForElement(selector, callback);
                }, 100);
            }
        },

        /* setting window width */
        setWindowWidth: function () {
            let windowClass = this.getWindowClass();

            this.waitForElement(windowClass, () => {
                this.windowWidth = $(windowClass).width();
            });
        },

        /* get window class */
        getWindowClass: function () {
            return this.showRecentlyViewed === 'true'
                ? '.with-recent-viewed'
                : '.without-recent-viewed';
        },

        /* on resize set window width */
        onResize: function () {
            this.windowWidth = $(this.getWindowClass()).width();
        },

        /* setting slides on the basis of window width */
        setSlidesPerPage: function (width) {
            if (width >= 1200) {
                this.slidesPerPage = 4;
            } else if (width < 1200 && width >= 992) {
                this.slidesPerPage = 3;
            } else if (width < 992 && width >= 822) {
                this.slidesPerPage = 2;
            } else if (width < 822 && width >= 626) {
                this.slidesPerPage = 2;
            } else {
                this.slidesPerPage = 2;
            }
        }
    },

    /* removing event */
    beforeDestroy: function () {
        window.removeEventListener('resize', this.onResize);
    },
}
</script>