@extends('shop::layouts.master')

@section('page_title')
    {{ __('contact_lang::app.shop.title') }}
@endsection

@section('content-wrapper')
    @push('css')
        <style>
            button {
                padding: 8px 22px;
                align-items: center;
                border-radius: 8px !important;
                background: #1197C2;
                color: #FFF;
                text-align: center;
                font-size: 16px;
                font-style: normal;
                font-weight: 600;
                line-height: 22px;
                letter-spacing: 0.48px;
            }

            input, textarea {
                border: transparent 0px !important;
                border-radius: 8px !important;
            }

            label {
                color: #777777;
            }

            .shaka-p {
                font-family: Outfit;
                font-size: 16px;
                font-style: normal;
                color: #777777;
                font-weight: 300;
                line-height: normal;
            }
        </style>
    @endpush
    @push('scripts')
        <script src="https://www.google.com/recaptcha/api.js" async></script>

        <script async>
            function onSubmit(token) {
                document.getElementById("contactForm").submit();
            }
        </script>
    @endpush

    <div class="d-block mt-0 bg-shaka-light" style="position: relative">

        <img src="{{asset('images/contact.png')}}" class="d-none d-md-block" alt="" style="
        object-fit: cover;
        position: absolute;
        top: 0;
        right: 50%;
        height: 100%;
        width: 50vw;
        object-position: left;">
        <img src="{{asset('images/contact.png')}}" alt="" class="d-block d-md-none w-100">
        <div class="container">
            <div class="row py-5">
                <div class="col-sm-12 col-md-6">
                </div>
                <div class="align-items-center col-md-6 col-sm-12 d-flex flex-column justify-content-center py-5">
                    <div class="auth-content w-100">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 pl-md-5">
                                <div class="body col-12 w-100">
                                    <h1 class="fw2 mb-3">Contact</h1>
                                    <p class="mt-2 mb-5 shaka-p">If you need any help or have collaboration on mind,
                                        please reach out via contact form.</p>
                                    <form class="cd-form floating-labels w-100 "
                                          action="{{ route('shop.contact.send-message') }}" method="post"
                                          id="contactForm">
                                        {{ csrf_field() }}
                                        @error('g-recaptcha-response')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="cd-label mb-2" for="cd-name"><b>Name</b></label>
                                                    <input class="text-input form-style py-4"
                                                           placeholder="Name..." type="text" name="name"
                                                           id="cd-name" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="cd-label mb-2"
                                                           for="cd-email"><b>E-mail address</b></label>
                                                    <input class="text-input form-style py-4"
                                                           placeholder="Email..." type="email" name="email"
                                                           id="cd-email" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mt-4">
                                            <label class="cd-label mb-2"
                                                   for="cd-message_title"><b>Subject</b></label>
                                            <input class="text-input form-style py-4"
                                                   placeholder="Subject..." type="text" name="message_title"
                                                   id="cd-message_title" required>
                                        </div>

                                        <div class="form-group mt-5">
                                            <label class="cd-label mb-2" for="cd-textarea"><b>Your
                                                    message</b></label>
                                            <textarea class="message form-control"
                                                      placeholder="Message..." name="message_body" rows="10"
                                                      id="cd-textarea" required></textarea>
                                        </div>

                                        <div class="form-group captcha g-recaptcha "
                                             data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}">
                                        </div>

                                        <button
                                            class="theme-btn btn-shaka bg-shaka-primary fw1 btn mt-4"
                                            type="submit"
                                            data-action='submit'>Send a message </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{--    <script type="text/javascript">--}}
{{--        $('#contactForm').submit(function(event) {--}}
{{--            event.preventDefault();--}}
{{--            grecaptcha.ready(function() {--}}
{{--                grecaptcha.execute("{{ env('RECAPTCHA_SECRET_KEY') }}", {action: 'subscribe_newsletter'}).then(function(token) {--}}

{{--                    $('#contactForm').prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');--}}
{{--                    $('#contactForm').unbind('submit').submit()--}}
{{--                });--}}
{{--            });--}}
{{--        });--}}

{{--    </script>--}}

@endsection