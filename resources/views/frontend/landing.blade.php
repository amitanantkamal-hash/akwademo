@extends('frontend.layout.master')

@section('content')
    <main class="main">
        <!-- Expert Connection Modal -->
        <div class="modal fade" id="expertModal" tabindex="-1" aria-labelledby="expertModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- <div class="modal-header">
                        <h5 class="modal-title color-brand-1" id="expertModalLabel">Connect with Our Expert</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div> -->
                    <div class="modal-header d-flex align-items-center justify-content-between">
                        <h5 class="modal-title mb-0 text-success fw-bold"  id="expertModalLabel">
                            Connect With Our Expert
                        </h5>
                        
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="expertForm">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control" id="name" name="name" required
                                    placeholder="Enter your full name">
                                <div class="invalid-feedback">Please enter your name</div>
                            </div>
                            <div class="mb-3">
                                <label for="city" class="form-label">City *</label>
                                <input type="text" class="form-control" id="city" name="city" required
                                    placeholder="Enter your city">
                                <div class="invalid-feedback">Please enter your city</div>
                            </div>
                            <div class="mb-3">
                                <label for="whatsapp" class="form-label">WhatsApp Number *</label>
                                <input type="tel" class="form-control" id="whatsapp" name="whatsapp" required
                                    placeholder="Enter your WhatsApp number with country code">
                                <div class="invalid-feedback">Please enter a valid WhatsApp number (minimum 10 digits)</div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="email" name="email" required
                                    placeholder="Enter your email address">
                                <div class="invalid-feedback">Please enter a valid email address</div>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message (Optional)</label>
                                <textarea class="form-control" id="message" name="message" rows="3"
                                    placeholder="Tell us about your requirements..."></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                        <button type="button" class="btn btn-brand-1" id="submitExpertForm">Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thank You Modal -->
        <div class="modal fade" id="thankYouModal" tabindex="-1" aria-labelledby="thankYouModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content thank-you-modal">
                    <div class="modal-body text-center p-5">
                        <div class="thank-you-icon mb-4">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M22 11.08V12C21.9988 14.1564 21.3005 16.2547 20.0093 17.9818C18.7182 19.709 16.9033 20.9725 14.8354 21.5839C12.7674 22.1953 10.5573 22.1219 8.53447 21.3746C6.51168 20.6273 4.78465 19.2461 3.61096 17.4371C2.43727 15.628 1.87979 13.4881 2.02168 11.3363C2.16356 9.18455 2.99721 7.13631 4.39828 5.49706C5.79935 3.85781 7.69279 2.71537 9.79619 2.24013C11.8996 1.7649 14.1003 1.98232 16.07 2.85999"
                                    stroke="#4CAF50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M22 4L12 14.01L9 11.01" stroke="#4CAF50" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                        <h3 class="color-brand-1 mb-3">Thank You!</h3>
                        <p class="color-grey-600 mb-4">We've received your information and our team will be in touch with
                            you shortly.</p>
                        <button type="button" class="btn btn-brand-1" data-bs-dismiss="modal">Got It</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Error Modal -->
        <div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body text-center p-5">
                        <div class="error-icon mb-4">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                    stroke="#dc3545" stroke-width="2" />
                                <path d="M15 9L9 15" stroke="#dc3545" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M9 9L15 15" stroke="#dc3545" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                        <h4 class="color-danger mb-3">Oops!</h4>
                        <p class="color-grey-600 mb-4">There was an error submitting your form. Please try again or contact
                            us directly.</p>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Try Again</button>
                    </div>
                </div>
            </div>
        </div>

        <section class="section banner-6">
            <div class="container">
                <div class="row align-items-end">
                    <div class="col-xl-6 d-none d-xl-block">
                        <div class="box-banner-6">
                            <div class="img-testimonials-1 shape-1"><img src="assets/imgs/page/homepage6/testimonial.png"
                                    alt="iori"></div>
                            <div class="img-testimonials-2 shape-2"><img src="assets/imgs/page/homepage6/testimonial2.png"
                                    alt="iori"></div><img class="img-main"
                                src="assets/imgs/page/homepage6/test789.png" alt="iori">
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="box-banner-right-home6"><span
                                class="title-line line-48 wow animate__animated animate__fadeIn"
                                data-wow-delay=".s">Think.
                                Creative. Solve</span>
                            <h1 class="color-brand-1 mb-20 mt-5 wow animate__animated animate__fadeIn"
                                data-wow-delay=".1s">
                                Innovative Method to Help Move Your Business forward</h1>
                            <div class="row">
                                <div class="col-lg-10">
                                    <p class="font-md color-grey-500 mb-30 wow animate__animated animate__fadeIn"
                                        data-wow-delay=".2s">Utilize WhatsApp's authentic WhatsApp API with
                                        {{ env('BRAND_NAME') }} and stay clear of exclusions. Benefit from the lowest prices
                                        and
                                        zero markup costs for the Meta API, unlike others which charge 20-25% higher.</p>
                                </div>
                            </div>
                            <div class="mt-30">
                                <h5 class="color-brand-1 wow animate__animated animate__fadeIn" data-wow-delay=".3s">
                                    {{-- <a target="_blank" class="btn btn-brand-1 hover-up"
                                        href="{{ env('DEMO_BOOK_LINK') }}">Book Your Demo</a> --}}
                                    <!-- Connect with Expert Button -->
                                    <button class="btn btn-brand-1 hover-up" data-bs-toggle="modal"
                                        data-bs-target="#expertModal">
                                        Connect with Our Expert
                                    </button>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
        </section>

        <!-- Rest of your existing code remains exactly the same -->
        <div class="section mt-55">
            <div class="container">
                <ul class="lists-logo">
                    <li class="wow animate__animated animate__fadeIn" data-wow-delay=".s"><img
                            src="assets/imgs/page/homepage1/hp_logo.png" alt="iori"></li>
                    <li class="wow animate__animated animate__fadeIn" data-wow-delay=".1s"><img
                            src="assets/imgs/page/homepage1/hp_logo_1.png" alt="iori"></li>
                    <li class="wow animate__animated animate__fadeIn" data-wow-delay=".2s"><img
                            src="assets/imgs/page/homepage1/hp_logo_2.png" alt="iori"></li>
                    <li class="wow animate__animated animate__fadeIn" data-wow-delay=".3s"><img
                            src="assets/imgs/page/homepage1/hp_logo_3.png" alt="iori"></li>
                    <li class="wow animate__animated animate__fadeIn" data-wow-delay=".4s"><img
                            src="assets/imgs/page/homepage1/hp_logo_4.png" alt="iori"></li>
                    <li class="wow animate__animated animate__fadeIn" data-wow-delay=".5s"><img
                            src="assets/imgs/page/homepage1/hp_logo_5.png" alt="iori"></li>
                </ul>
            </div>
        </div>

        <section class="section mt-110">
            <div class="container">
                <div class="row align-items-end">
                    <div class="col-lg-6 mb-20">
                        <h2 class="color-brand-1 mb-0 wow animate__animated animate__fadeIn" data-wow-delay=".s">
                            Connecting
                            Businesses via Whatsapp Business API</h2>
                    </div>
                    <div class="col-lg-6 mb-20 wow animate__animated animate__fadeIn" data-wow-delay=".2s">
                        <p class="color-grey-500 font-md mb-20">Find powerful functions that can boost your performance. It
                            is always a pleasure to come by our cozy home. Experts in their field! Everything was
                            impressive, with a keen focus on particulars, comps, as well as the general atmosphere.</p><a
                            class="btn btn-default p-0 font-sm-bold hover-up" href="{{ route('front.contact') }}">Contact
                            Us
                            <svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg></a>
                    </div>
                </div>
                <div class="row mt-45">
                    <div class="col-lg-4 wow animate__animated animate__fadeIn" data-wow-delay=".s">
                        <div class="card-human">
                            <div class="card-image mb-15"><img src="assets/imgs/page/homepage6/slider1.png"
                                    alt="iori">
                            </div>
                            <div class="card-info mb-30">
                                <h4 class="color-brand-1 mt-15 mb-10">Interactive Message</h4>
                                <p class="font-sm color-grey-500">Customize quick replies, call-to-actions, and opt-in
                                    buttons in WhatsApp chat threads.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 wow animate__animated animate__fadeIn" data-wow-delay=".2s">
                        <div class="card-human">
                            <div class="card-info mb-30">
                                <h4 class="color-brand-1 mt-15 mb-10">Develop WhatsApp Catalogs and Carts Easily</h4>
                                <p class="font-sm color-grey-500">Set up WhatsApp store to display your products. Allow
                                    customers to browse items and add them to cart without leaving the chat.</p>
                            </div>
                            <div class="card-image mb-15"><img src="assets/imgs/page/homepage6/slider2.png"
                                    alt="iori">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 wow animate__animated animate__fadeIn" data-wow-delay=".4s">
                        <div class="card-human">
                            <div class="card-image mb-15"><img src="assets/imgs/page/homepage6/slider3.png"
                                    alt="iori">
                            </div>
                            <div class="card-info mb-30">
                                <h4 class="color-brand-1 mt-15 mb-10">Automate Workflows</h4>
                                <p class="font-sm color-grey-500">Build and Automate Engaging Conversations Easily with Our
                                    Drag-and-Drop Chatbot Builder.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section mt-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2 class="color-brand-1 mb-20 wow animate__animated animate__fadeIn" data-wow-delay=".0s">What We
                            Offer</h2>
                        <p class="font-lg color-gray-500 wow animate__animated animate__fadeIn" data-wow-delay=".2s">
                            Automate Your Business using a Trustworthy WhatsApp Business API<br
                                class="d-none d-lg-block">Broadcast Promotional Offers on Broadcasts to Unlimited Users
                            Sell your items via WhatsApp through Catalogs
                            Chatbots to be created for 24/7 support for customers
                        </p>
                    </div>
                </div>
                <div class="mt-50 wow animate__animated animate__fadeIn" data-wow-delay=".0s">
                    <div class="box-swiper">
                        <div class="swiper-container swiper-group-4">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="card-offer-style-3">
                                        <div class="card-head">
                                            <div class="card-image"><img src="assets/imgs/page/homepage1/cross.png"
                                                    alt="iori"></div>
                                            <div class="carrd-title">
                                                <h4 class="color-brand-1">Whatsapp Catalog</h4>
                                            </div>
                                        </div>
                                        <div class="card-info">
                                            <p class="font-sm color-grey-500 mb-15">Improve sales by integrating WhatsApp
                                                Catalog Integration: Showcase items, sell directly through WhatsApp and
                                                improve the customer's engagement easily.</p>
                                            <div class="box-button-offer">
                                                <!-- <a class="btn btn-default font-sm-bold pl-0 color-brand-1 hover-up">Learn More
                                                            <svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                            </svg></a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide head-bg-brand-2">
                                    <div class="card-offer-style-3">
                                        <div class="card-head">
                                            <div class="card-image"><img src="assets/imgs/page/homepage1/cross2.png"
                                                    alt="iori"></div>
                                            <div class="carrd-title">
                                                <h4 class="color-brand-1">Easy Chatbot Builder</h4>
                                            </div>
                                        </div>
                                        <div class="card-info">
                                            <p class="font-sm color-grey-500 mb-15">{{ env('BRAND_NAME') }} Visual Drag and
                                                Drop
                                                Builder assists in the visual design of the bot. It gives you a bird's-eye
                                                view of your bot's entire structure that aids in the creation of a bot that
                                                is highly engaging for your business.</p>
                                            <div class="box-button-offer">
                                                <!-- <a class="btn btn-default font-sm-bold pl-0 color-brand-1 hover-up">Learn More
                                                            <svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                            </svg></a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide head-bg-2">
                                    <div class="card-offer-style-3">
                                        <div class="card-head">
                                            <div class="card-image"><img src="assets/imgs/page/homepage1/business.svg"
                                                    alt="iori"></div>
                                            <div class="carrd-title">
                                                <h4 class="color-brand-1">Bulk Broadcast</h4>
                                            </div>
                                        </div>
                                        <div class="card-info">
                                            <p class="font-sm color-grey-500 mb-15">Increase business growth by using
                                                {{ env('APP_SHORT_NAME') }} tools for broadcasting. Aim at specific
                                                audiences by
                                                sending messages, reminders, or following-ups to maximize engagement and the
                                                possibility of reactivation.</p>
                                            <div class="box-button-offer">
                                                <!-- <a class="btn btn-default font-sm-bold pl-0 color-brand-1 hover-up">Learn More
                                                            <svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                            </svg></a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide head-bg-5">
                                    <div class="card-offer-style-3">
                                        <div class="card-head">
                                            <div class="card-image"><img src="assets/imgs/page/homepage1/cross4.png"
                                                    alt="iori"></div>
                                            <div class="carrd-title">
                                                <h4 class="color-brand-1">Template Messages</h4>
                                            </div>
                                        </div>
                                        <div class="card-info">
                                            <p class="font-sm color-grey-500 mb-15">Create professional and effective
                                                templates for messages that can be customized with buttons and calls the
                                                action of the WhatsApp chatbot. Conversions can be improved and
                                                communication is improved.</p>
                                            <div class="box-button-offer">
                                                <!-- <a class="btn btn-default font-sm-bold pl-0 color-brand-1 hover-up">Learn More
                                                            <svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                            </svg></a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide head-bg-brand-2">
                                    <div class="card-offer-style-3">
                                        <div class="card-head">
                                            <div class="card-image"><img src="assets/imgs/page/homepage1/cross2.png"
                                                    alt="iori"></div>
                                            <div class="carrd-title">
                                                <h4 class="color-brand-1">Webhook Workflow</h4>
                                            </div>
                                        </div>
                                        <div class="card-info">
                                            <p class="font-sm color-grey-500 mb-15">Any third-party webhook service,
                                                comprising Typeform, Google Forms, WP Elementor, WooCommerce, Shopify and
                                                many others can be connected via Anantkamal WA Demo in order to send
                                                messages to WhatsApp using webhook data.</p>
                                            <div class="box-button-offer">
                                                <!-- <a class="btn btn-default font-sm-bold pl-0 color-brand-1 hover-up">Learn More
                                                            <svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                            </svg></a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide head-bg-2">
                                    <div class="card-offer-style-3">
                                        <div class="card-head">
                                            <div class="card-image"><img src="assets/imgs/page/homepage1/cross4.png"
                                                    alt="iori"></div>
                                            <div class="carrd-title">
                                                <h4 class="color-brand-1">Auto-responders Integration</h4>
                                            </div>
                                        </div>
                                        <div class="card-info">
                                            <p class="font-sm color-grey-500 mb-15">Any Lead Generation platform source
                                                like
                                                Facebook, Instagram, Google Form, Google Ad. All Linkedin integrations'
                                                interactive auto-responder messages are fired all under one roof.</p>
                                            <div class="box-button-offer">
                                                <!-- <a class="btn btn-default font-sm-bold pl-0 color-brand-1 hover-up">Learn More
                                                            <svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                            </svg></a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide head-bg-5">
                                    <div class="card-offer-style-3">
                                        <div class="card-head">
                                            <div class="card-image"><img src="assets/imgs/page/homepage1/cross4.png"
                                                    alt="iori"></div>
                                            <div class="carrd-title">
                                                <h4 class="color-brand-1">Leads Center Mobile Apps</h4>
                                            </div>
                                        </div>
                                        <div class="card-info">
                                            <p class="font-sm color-grey-500 mb-15">Meta, Linkedin & Google Leads
                                                Integration using Real-time Notification. The method, the methods, or
                                                strategies for integrating these platforms an automated lead management
                                                system as well as making notifications.</p>
                                            <div class="box-button-offer">
                                                <!-- <a class="btn btn-default font-sm-bold pl-0 color-brand-1 hover-up">Learn More
                                                            <svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                            </svg></a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-button-slider-bottom">
                                <div class="swiper-button-prev swiper-button-prev-group-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg>
                                </div>
                                <div class="swiper-button-next swiper-button-next-group-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section mt-50 bg-grey-80 bg-plan pt-110 pb-110">
            <div class="container">
                <div class="row align-items-end">
                    <div class="col-lg-8 col-md-8">
                        <h2 class="color-brand-1 mb-20 wow animate__animated animate__fadeInUp" data-wow-delay=".s">Choose
                            The Best Plan</h2>
                        <p class="font-lg color-gray-500 wow animate__animated animate__fadeInUp" data-wow-delay=".2s">
                            Pick
                            your plan.<br class="d-none d-lg-block"> Change whenever you want.</p>
                    </div>
                    <!-- <div class="col-lg-4 col-md-4 text-md-end text-start wow animate__animated animate__fadeInUp" data-wow-delay=".4s"><a class="btn btn-default font-sm-bold pl-0">Compare plans
                                    <svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg></a></div> -->
                </div>
                <div class="row mt-50 home_page_plan">
                    @foreach ($plans as $keyp => $plan)
                        <div class="col-xl-3 col-lg-6 col-md-6 wow animate__animated animate__fadeIn"
                            data-wow-delay=".0s">
                            <div class="card-plan hover-up">
                                <div class="card-image-plan">
                                    <div class="icon-plan"><img src="/assets/imgs/page/homepage1/free.svg"
                                            alt="iori"></div>
                                    <div class="info-plan">
                                        <h4 class="color-brand-1">{{ $plan->name }}</h4>
                                        <p class="font-md color-grey-400">{{ $plan->description }}</p>
                                    </div>
                                </div>
                                <div class="box-day-trial">
                                    <span class="font-lg-bold color-brand-1">
                                        {{ config('money')[strtoupper(config('settings.cashier_currency'))]['symbol'] }}
                                        {{ $plan->price }}
                                    </span>
                                    <span class="font-md color-grey-500">
                                        @if (config('settings.free_pricing_id') == $plan->id)
                                            - {{ config('settings.free_trail_days') }} days trial
                                        @else
                                            - {{ $plan['period'] == 1 ? __('month') : __('year') }}
                                        </span></p>
                                        @endif
                                    </span><br>
                                    <span class="font-xs color-grey-500">{{ __('wpbox.no_contracts') }} </span>
                                </div>
                                <div class="mt-30 mb-30 price_fea">
                                    <ul class="list-ticks list-ticks-2">
                                        @foreach (explode(',', $plan['features']) as $feature)
                                            <li>
                                                <svg class="w-6 h-6 icon-16" fill="none" stroke="currentColor" viewbox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7"></path>
                                                </svg>{{ $feature }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @if (!config('settings.disable_registration_page', false))
                                    <div class="mt-20">
                                        <a class="btn btn-brand-1-full hover-up" href="{{ route('register') }}">
                                            @if (config('settings.free_pricing_id') == $plan->id)
                                                {{ __('Try for free') }}
                                            @else
                                                {{ __('wpbox.start_now') }}
                                            @endif
                                            <svg class="w-6 h-6 icon-16 ml-10" fill="none" stroke="currentColor" viewbox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                            </svg>
                                        </a>
                                    </div>
                                @endif

                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>
        <section class="section mt-50 pt-50 pb-40">
            <div class="container">
                <div class="box-cover-border">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="img-reveal"><img class="d-block"
                                    src="assets/imgs/page/homepage2/img-marketing.png" alt="iori"></div>
                        </div>
                        <div class="col-lg-6">
                            <div class="box-info-video"><span class="btn btn-tag wow animate__animated animate__fadeInUp"
                                    data-wow-delay=".0s">Get in touch</span>
                                <h2 class="color-brand-1 mt-15 mb-20 wow animate__animated animate__fadeInUp"
                                    data-wow-delay=".1s">Want to talk to a marketing expert?</h2>
                                <p class="font-md color-grey-500 wow animate__animated animate__fadeInUp"
                                    data-wow-delay=".2s">
                                    Looking to boost your business? Talk to a marketing expert today and discover strategies
                                    that drive results! Let us help you elevate your brand and reach your goals. Book your
                                    consultation now!
                                </p>
                                <div class="box-button text-start mt-65 wow animate__animated animate__fadeInUp"
                                    data-wow-delay=".3s"><a class="btn btn-brand-1 hover-up"
                                        href="{{ route('front.contact') }}">Contact Us</a><a
                                        class="btn btn-default font-sm-bold hover-up" target="_blank"
                                        href="{{ env('BUSINESS_SUPPORT_WHATSAPP') }}">Support Center
                                        <svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor"
                                            viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section pt-80 mb-30" id="faqs">
            <div class="container">
                <div class="text-center">
                    <h2 class="color-brand-1 mb-20 wow animate__animated animate__fadeIn" data-wow-delay=".1s">Frequently
                        asked questions</h2>
                    <p class="font-lg color-gray-500 wow animate__animated animate__fadeIn" data-wow-delay=".2s">Feeling
                        inquisitive? Have a read through some of our FAQs or<br class="d-none d-lg-block"> contact our
                        supporters for help</p>
                </div>
                <div class="row mt-50 mb-50">
                    <div class="col-xl-2 col-lg-2"></div>
                    <div class="col-xl-8 col-lg-8 position-relative">
                        <div class="box-author-1"><img src="assets/imgs/page/homepage6/author.png" alt="iori"></div>
                        <div class="box-author-2"><img src="assets/imgs/page/homepage6/author2.png" alt="iori"></div>
                        <div class="box-author-3"><img src="assets/imgs/page/homepage6/author3.png" alt="iori"></div>
                        <div class="accordion" id="accordionFAQ">
                            @foreach ($faqs as $fkey => $faq)
                                <div class="accordion-item wow animate__animated animate__fadeIn">
                                    <h5 class="accordion-header" id="{{ $fkey }}">
                                        <button
                                            class="accordion-button text-heading-5 {{ $fkey == 0 ? '' : 'collapsed' }}"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $fkey }}" aria-expanded="true"
                                            aria-controls="collapseOne">{{ $faq->title }}</button>
                                    </h5>
                                    <div class="accordion-collapse collapse {{ $fkey == 0 ? 'show' : '' }}"
                                        id="collapse{{ $fkey }}" aria-labelledby="{{ $fkey }}"
                                        data-bs-parent="#accordionFAQ">
                                        <div class="accordion-body">{{ $faq->description }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- <section class="section mt-40 pt-50 pb-15 bg-grey-80">
            <div class="container">
                <div class="box-swiper">
                    <div class="swiper-container swiper-group-3">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="card-guide">
                                    <div class="card-image"><img src="assets/imgs/page/help/icon1.svg" alt="iori">
                                    </div>
                                    <div class="card-info">
                                        <h5 class="color-brand-1 mb-15">Knowledge Base</h5>
                                        <p class="font-xs color-grey-500">Aliquam a augue suscipit, luctus neque purus
                                            ipsum
                                            neque dolor primis a libero tempus</p>
                                        <div class="mt-10"><a class="btn btn-default font-sm-bold pl-0"
                                                href="#">Get Started
                                                <svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor"
                                                    viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                </svg></a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card-guide">
                                    <div class="card-image"><img src="assets/imgs/page/help/icon2.svg" alt="iori">
                                    </div>
                                    <div class="card-info">
                                        <h5 class="color-brand-1 mb-15">Community Forums</h5>
                                        <p class="font-xs color-grey-500">Aliquam a augue suscipit, luctus neque purus
                                            ipsum
                                            neque dolor primis a libero tempus</p>
                                        <div class="mt-10"><a class="btn btn-default font-sm-bold pl-0"
                                                href="#">Get Started
                                                <svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor"
                                                    viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                </svg></a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card-guide">
                                    <div class="card-image"><img src="assets/imgs/page/help/icon3.svg" alt="iori">
                                    </div>
                                    <div class="card-info">
                                        <h5 class="color-brand-1 mb-15">Documentation</h5>
                                        <p class="font-xs color-grey-500">Aliquam a augue suscipit, luctus neque purus
                                            ipsum
                                            neque dolor primis a libero tempus</p>
                                        <div class="mt-10"><a class="btn btn-default font-sm-bold pl-0"
                                                href="#">Get Started
                                                <svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor"
                                                    viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                </svg></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}
        <div class="mt-50"></div>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const submitBtn = document.getElementById('submitExpertForm');
            const form = document.getElementById('expertForm');
            const webhookUrl = 'https://sendinai.com/api/webhook/jZKxnFFKCs6iq5qc4Y9fCsj68hZzVgI9BxlIs8pT';

            // Modal instances
            const expertModal = new bootstrap.Modal(document.getElementById('expertModal'));
            const thankYouModal = new bootstrap.Modal(document.getElementById('thankYouModal'));
            const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));

            // Validation functions
            function validateEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            function validateWhatsApp(whatsapp) {
                // Remove all non-digit characters except +
                const cleaned = whatsapp.replace(/[^\d+]/g, '');
                // Check if it has at least 10 digits (excluding country code)
                const digitsOnly = cleaned.replace(/\D/g, '');
                return digitsOnly.length >= 10;
            }

            function showFieldError(field, message) {
                field.classList.add('is-invalid');
                const feedback = field.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.textContent = message;
                    feedback.style.display = 'block';
                }
            }

            function clearFieldError(field) {
                field.classList.remove('is-invalid');
                const feedback = field.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.style.display = 'none';
                }
            }

            function validateForm() {
                let isValid = true;
                const fields = {
                    name: document.getElementById('name'),
                    city: document.getElementById('city'),
                    whatsapp: document.getElementById('whatsapp'),
                    email: document.getElementById('email')
                };

                // Clear previous errors
                Object.values(fields).forEach(field => clearFieldError(field));

                // Validate name
                if (!fields.name.value.trim()) {
                    showFieldError(fields.name, 'Please enter your name');
                    isValid = false;
                }

                // Validate city
                if (!fields.city.value.trim()) {
                    showFieldError(fields.city, 'Please enter your city');
                    isValid = false;
                }

                // Validate WhatsApp
                if (!fields.whatsapp.value.trim()) {
                    showFieldError(fields.whatsapp, 'Please enter your WhatsApp number');
                    isValid = false;
                } else if (!validateWhatsApp(fields.whatsapp.value)) {
                    showFieldError(fields.whatsapp, 'Please enter a valid WhatsApp number (minimum 10 digits)');
                    isValid = false;
                }

                // Validate email
                if (!fields.email.value.trim()) {
                    showFieldError(fields.email, 'Please enter your email address');
                    isValid = false;
                } else if (!validateEmail(fields.email.value)) {
                    showFieldError(fields.email, 'Please enter a valid email address');
                    isValid = false;
                }

                return isValid;
            }

            async function submitToWebhook(formData) {
                try {
                    const response = await fetch(webhookUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(formData)
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const result = await response.json();
                    return {
                        success: true,
                        data: result
                    };
                } catch (error) {
                    console.error('Error submitting to webhook:', error);
                    return {
                        success: false,
                        error: error.message
                    };
                }
            }

            submitBtn.addEventListener('click', async function() {
                if (!validateForm()) {
                    return;
                }

                // Disable submit button and show loading state
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML =
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting...';
                submitBtn.disabled = true;

                try {
                    // Prepare form data
                    const formData = {
                        name: document.getElementById('name').value.trim(),
                        city: document.getElementById('city').value.trim(),
                        whatsapp: document.getElementById('whatsapp').value.trim(),
                        email: document.getElementById('email').value.trim(),
                        message: document.getElementById('message').value.trim(),
                        source: 'Landing Page Form',
                        submitted_at: new Date().toISOString()
                    };

                    // Submit to webhook
                    const result = await submitToWebhook(formData);

                    if (result.success) {
                        // Close the expert modal
                        expertModal.hide();

                        // Reset the form
                        form.reset();

                        // Show thank you modal after a small delay
                        setTimeout(() => {
                            thankYouModal.show();
                        }, 300);
                    } else {
                        throw new Error(result.error);
                    }
                } catch (error) {
                    // Show error modal
                    errorModal.show();
                    console.error('Form submission error:', error);
                } finally {
                    // Re-enable submit button
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            });

            // Real-time validation and error clearing
            const formFields = ['name', 'city', 'whatsapp', 'email', 'message'];

            formFields.forEach(fieldName => {
                const field = document.getElementById(fieldName);
                if (field) {
                    // Clear error on input
                    field.addEventListener('input', function() {
                        clearFieldError(this);

                        // Optional: Real-time validation for email and whatsapp
                        if (fieldName === 'email' && this.value.trim()) {
                            if (!validateEmail(this.value)) {
                                showFieldError(this, 'Please enter a valid email address');
                            }
                        }

                        if (fieldName === 'whatsapp' && this.value.trim()) {
                            if (!validateWhatsApp(this.value)) {
                                showFieldError(this,
                                    'Please enter a valid WhatsApp number (minimum 10 digits)');
                            }
                        }
                    });

                    // Clear error on focus
                    field.addEventListener('focus', function() {
                        clearFieldError(this);
                    });

                    // Validate on blur (optional)
                    field.addEventListener('blur', function() {
                        if (this.value.trim()) {
                            if (fieldName === 'email' && !validateEmail(this.value)) {
                                showFieldError(this, 'Please enter a valid email address');
                            } else if (fieldName === 'whatsapp' && !validateWhatsApp(this.value)) {
                                showFieldError(this,
                                    'Please enter a valid WhatsApp number (minimum 10 digits)');
                            }
                        }
                    });
                }
            });

            // Clear all errors when modal is opened
            document.getElementById('expertModal').addEventListener('show.bs.modal', function() {
                formFields.forEach(fieldName => {
                    const field = document.getElementById(fieldName);
                    if (field) {
                        clearFieldError(field);
                    }
                });
            });

            // Reset form when expert modal is completely hidden
            document.getElementById('expertModal').addEventListener('hidden.bs.modal', function() {
                form.reset();
                // Clear any remaining errors
                formFields.forEach(fieldName => {
                    const field = document.getElementById(fieldName);
                    if (field) {
                        clearFieldError(field);
                    }
                });
            });
        });
    </script>

    <style>
        .is-invalid {
            border-color: #dc3545 !important;
        }

        .btn-outline-brand-1 {
            border: 2px solid var(--color-brand-1);
            color: var(--color-brand-1);
            background: transparent;
        }

        .btn-outline-brand-1:hover {
            background: var(--color-brand-1);
            color: white;
        }

        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        }

        .thank-you-modal {
            border: 2px solid #4CAF50;
        }

        .modal-header {
            border-bottom: 1px solid #e9ecef;
           
            padding: 16px 24px;
        }
        .modal-header .btn-close {
            margin: 5px;              /* 🔥 remove Bootstrap negative margin */
            padding: 1rem;
            align-self: center;     /* ensure vertical centering */
        }
        .modal-body {
            padding: 2rem;
        }

        .modal-footer {
            border-top: 1px solid #e9ecef;
            padding: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--color-brand-1);
            margin-bottom: 0.5rem;
        }

        .form-control {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 0.75rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control:focus {
            border-color: var(--color-brand-1);
            box-shadow: 0 0 0 0.2rem rgba(var(--color-brand-1-rgb), 0.25);
        }

        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
            transition: display 0.15s ease-in-out;
        }

        .form-control.is-invalid~.invalid-feedback {
            display: block;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }

        .thank-you-icon svg {
            stroke: #4CAF50;
        }

        .thank-you-icon {
            animation: bounceIn 0.6s ease-in-out;
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0.3);
                opacity: 0;
            }

            50% {
                transform: scale(1.05);
            }

            70% {
                transform: scale(0.9);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .error-icon svg {
            stroke: #dc3545;
        }

        .color-danger {
            color: #dc3545;
        }

        /* Smooth transitions for error messages */
        .form-control.is-invalid {
            transition: border-color 0.3s ease-in-out;
        }
    </style>
@endsection
