@extends('frontend.layout.master')
@section('content')
    <style>
        .form-response-container {
            position: relative;
        }

        #form-response {
            display: none;
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }

        #form-response.alert-success {
            background-color: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
        }

        #form-response.alert-danger {
            background-color: #f8d7da;
            color: #842029;
            border: 1px solid #f5c2c7;
        }

        #form-response .btn-close {
            padding: 0.5rem;
            background-size: 0.75rem;
        }
    </style>
    <main class="main">

        <!-- Expert Connection Modal -->
        <div class="modal fade" id="expertModal" tabindex="-1" aria-labelledby="expertModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title color-brand-1" id="expertModalLabel">Connect with Our Expert</h5>
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
        <section class="section banner-contact">
            <div class="container">
                <div class="banner-1">
                    <div class="row align-items-center">
                        <div class="col-lg-7"><span class="title-line line-48 wow animate__animated animate__fadeIn"
                                data-wow-delay=".0s">Get in Touch</span>
                            <h1 class="color-brand-1 mb-20 mt-10 wow animate__animated animate__fadeIn"
                                data-wow-delay=".2s">
                                We’d love
                                to hear<br class="d-none d-lg-block">from you.</h1>
                            <div class="row">
                                <div class="col-lg-9">
                                    <p class="font-md color-grey-500 wow animate__animated animate__fadeIn"
                                        data-wow-delay=".4s">Request a
                                        demo, ask a question, or get in touch here. If you’re interested in working at Iori
                                        Coporation, check
                                        out our<a class="ml-3" href="#"> careers page.</a></p>
                                </div>
                            </div>
                            <div class="mt-30 wow animate__animated animate__fadeIn" data-wow-delay=".6s">
                                {{-- <h5 class="color-brand-1 wow animate__animated animate__fadeIn" data-wow-delay=".3s"><a
                                        class="btn btn-brand-1 hover-up" target="_blank"
                                        href="{{ env('DEMO_BOOK_LINK') }}">Book Your Demo</a></h5> --}}


                                <button class="btn btn-brand-1 hover-up" data-bs-toggle="modal"
                                    data-bs-target="#expertModal">
                                    Connect with Our Expert
                                </button>
                            </div>
                            <div class="box-button mt-20">
                                <!-- <a class="btn-app mb-15 hover-up" href="#"><img
                                                                                          src="assets/imgs/template/appstore-btn.png" alt="iori"></a><a class="btn-app mb-15 hover-up"
                                                                                        href="#"><img src="assets/imgs/template/google-play-btn.png" alt="iori"></a><a
                                                                                        class="btn btn-default mb-15 pl-10 font-sm-bold hover-up" href="#">Learn More
                                                                                        <svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"
                                                                                          xmlns="http://www.w3.org/2000/svg">
                                                                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                                                                                          </path>
                                                                                        </svg></a> -->
                            </div>
                        </div>
                        <div class="col-lg-5 d-none d-lg-block">
                            <div class="box-banner-contact"><img src="assets/imgs/page/contact/banner.png"
                                    alt="iori">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section mt-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".0s">
                        <div class="card-small card-small-2">
                            <div class="card-image">
                                <div class="box-image"><img src="assets/imgs/page/contact/headphone.png" alt="iori">
                                </div>
                            </div>
                            <div class="card-info">
                                <h6 class="color-brand-1 mb-10">Help &amp; support</h6>
                                <p class="font-xs color-grey-500">Email<a class="color-success" product or service or
                                        refer to FAQs and developer tools href="mailto:{{ env('BUSINESS_EMAIL') }}">
                                        {{ env('BUSINESS_EMAIL') }}</a><br>For help with a current
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                        <div class="card-small card-small-2">
                            <div class="card-image">
                                <div class="box-image"><img src="assets/imgs/page/contact/phone.png" alt="iori">
                                </div>
                            </div>
                            <div class="card-info">
                                <h6 class="color-brand-1 mb-10">Call Us</h6>
                                <p class="font-xs color-grey-500">Call us to speak to a member of our
                                    team.<br>{{ env('BUSINESS_PHONE') }}
                                    <br>
                                    {{ env('BUSINESS_PHONE_OTHER') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".2s">
                        <div class="card-small card-small-2">
                            <div class="card-image">
                                <div class="box-image"><img src="assets/imgs/page/contact/chart.png" alt="iori">
                                </div>
                            </div>
                            <div class="card-info">
                                <h6 class="color-brand-1 mb-10">Bussiness Department</h6>
                                <p class="font-xs color-grey-500">Contact the sales department about cooperation
                                    projects<br>{{ env('BUSINESS_PHONE_SALES') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 wow animate__animated animate__fadeIn" data-wow-delay=".3s">
                        <div class="card-small card-small-2">
                            <div class="card-image">
                                <div class="box-image"><img src="assets/imgs/page/contact/earth.png" alt="iori">
                                </div>
                            </div>
                            <div class="card-info">
                                <h6 class="color-brand-1 mb-10">Global branch</h6>
                                <p class="font-xs color-grey-500">Contact us to open our branches
                                    globally.<br>{{ env('BUSINESS_PHONE_GLOBAL_SALES') }}<br>{{ env('BUSINESS_PHONE_GLOBAL_SALES_OTHERS') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section mt-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <h2 class="color-brand-1 mb-15">Get in touch</h2>
                        <p class="font-sm color-grey-500">Do you want to know more or contact our sales department?</p>
                        <div class="mt-50">
                            <div class="wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                <div class="card-offer card-we-do card-contact hover-up">
                                    <div class="card-image"><img src="assets/imgs/page/contact/img1.png" alt="iori">
                                    </div>
                                    <div class="card-info">
                                        <h6 class="color-brand-1 mb-10">Visit the Knowledge Base</h6>
                                        <p class="font-md color-grey-500 mb-5">Browse customer support articles and
                                            step-by-step instructions
                                            for specific features.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="wow animate__animated animate__fadeInUp" data-wow-delay=".2s">
                                <div class="card-offer card-we-do card-contact hover-up">
                                    <div class="card-image"><img src="assets/imgs/page/contact/img2.png" alt="iori">
                                    </div>
                                    <div class="card-info">
                                        <h6 class="color-brand-1 mb-10">Watch Product Videos</h6>
                                        <p class="font-md color-grey-500 mb-5">Watch our video tutorials for visual
                                            walkthroughs on how to use
                                            our features.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="wow animate__animated animate__fadeInUp" data-wow-delay=".4s">
                                <div class="card-offer card-we-do card-contact hover-up">
                                    <div class="card-image"><img src="assets/imgs/page/contact/img3.png" alt="iori">
                                    </div>
                                    <div class="card-info">
                                        <h6 class="color-brand-1 mb-10">Get in touch with Sales</h6>
                                        <p class="font-md color-grey-500 mb-5">Let us talk about how we can help your
                                            enterprise.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <form id="contactForm" action="{{ route('contact.submit') }}" method="POST">
                            @csrf
                            <div class="box-form-contact wow animate__animated animate__fadeIn" data-wow-delay=".6s">
                                <div class="row">
                                    <!-- Name Field -->
                                    <div class="col-lg-6 col-sm-6">
                                        <div class="form-group mb-25">
                                            <input class="form-control icon-user" name="name" type="text"
                                                placeholder="Your name" required>
                                            <div class="invalid-feedback name-error text-danger"></div>
                                        </div>
                                    </div>

                                    <!-- Email Field -->
                                    <div class="col-lg-6 col-sm-6">
                                        <div class="form-group mb-25">
                                            <input class="form-control icon-email" name="email" type="email"
                                                placeholder="Email" required>
                                            <div class="invalid-feedback email-error text-danger"></div>
                                        </div>
                                    </div>

                                    <!-- Phone Field with Country Code -->
                                    <div class="col-lg-6 col-sm-6">
                                        <div class="form-group mb-25">
                                            <input class="form-control icon-phone" id="phone" name="phone"
                                                type="tel" placeholder="Phone" required>
                                            <input type="hidden" name="country_code" id="country_code">
                                            <div class="invalid-feedback phone-error text-danger"></div>
                                        </div>
                                    </div>

                                    <!-- Company Field -->
                                    <div class="col-lg-6 col-sm-6">
                                        <div class="form-group mb-25">
                                            <input class="form-control icon-company" name="company" type="text"
                                                placeholder="Company">
                                            <div class="invalid-feedback company-error text-danger"></div>
                                        </div>
                                    </div>

                                    <!-- Subject Field -->
                                    <div class="col-lg-12">
                                        <div class="form-group mb-25">
                                            <input class="form-control" name="subject" type="text"
                                                placeholder="Subject" required>
                                            <div class="invalid-feedback subject-error text-danger"></div>
                                        </div>
                                    </div>

                                    <!-- Message Field -->
                                    <div class="col-lg-12">
                                        <div class="form-group mb-25">
                                            <textarea class="form-control textarea-control" name="message" placeholder="Write something" required></textarea>
                                            <div class="invalid-feedback message-error text-danger"></div>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="col-xl-4 col-lg-5 col-md-5 col-sm-6 col-9">
                                        <div class="form-group">
                                            <button class="btn btn-brand-1-full font-sm" type="submit">Send message
                                                <svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor"
                                                    viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="form-response" class="mt-3" style="display: none;"></div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <div class="no-bg-faqs">
            <section class="section pt-80 mb-30" id="faqs">
                <div class="container">
                    <div class="text-center">
                        <h2 class="color-brand-1 mb-20 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                            Frequently asked questions</h2>
                        <p class="font-lg color-gray-500 wow animate__animated animate__fadeIn" data-wow-delay=".2s">
                            Feeling inquisitive? Have a read through some of our FAQs or<br class="d-none d-lg-block">
                            contact our supporters for help</p>
                    </div>
                    <div class="row mt-50 mb-50">
                        <div class="col-xl-2 col-lg-2"></div>
                        <div class="col-xl-8 col-lg-8 position-relative">
                            <div class="box-author-1"><img src="assets/imgs/page/homepage6/author.png" alt="iori">
                            </div>
                            <div class="box-author-2"><img src="assets/imgs/page/homepage6/author2.png" alt="iori">
                            </div>
                            <div class="box-author-3"><img src="assets/imgs/page/homepage6/author3.png" alt="iori">
                            </div>
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
            <!-- <section class="section pt-80 mb-30 bg-faqs">
                                                                              <div class="container">
                                                                                <div class="row align-items-end">
                                                                                  <div class="col-lg-8 col-md-8">
                                                                                    <h2 class="color-brand-1 mb-20 wow animate__animated animate__fadeInUp" data-wow-delay=".0s">Frequently
                                                                                      asked questions</h2>
                                                                                    <p class="font-lg color-gray-500 wow animate__animated animate__fadeInUp" data-wow-delay=".2s">Feeling
                                                                                      inquisitive? Have a read through some of our FAQs or<br class="d-none d-lg-block"> contact our supporters
                                                                                      for help</p>
                                                                                  </div>
                                                                                  <div class="col-lg-4 col-md-4 text-md-end text-start wow animate__animated animate__fadeInUp"
                                                                                    data-wow-delay=".4s"><a class="btn btn-default font-sm-bold pl-0">Contact Us
                                                                                      <svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"
                                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                                                                                        </path>
                                                                                      </svg></a></div>
                                                                                </div>
                                                                                <div class="row mt-50 mb-100">
                                                                                  <div class="col-xl-3 col-lg-4">
                                                                                    <ul class="list-faqs nav nav-tabs" role="tablist">
                                                                                      <li class="wow animate__animated animate__fadeInUp" data-wow-delay=".0s"><a class="active"
                                                                                          href="#tab-support" data-bs-toggle="tab" role="tab" aria-controls="tab-support"
                                                                                          aria-selected="true"><span>General Support</span>
                                                                                          <svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"
                                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                                                                                            </path>
                                                                                          </svg></a></li>
                                                                                      <li class="wow animate__animated animate__fadeInUp" data-wow-delay=".0s"><a href="#tab-order"
                                                                                          data-bs-toggle="tab" role="tab" aria-controls="tab-order" aria-selected="true"><span>Order /
                                                                                            Purchase</span>
                                                                                          <svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"
                                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                                                                                            </path>
                                                                                          </svg></a></li>
                                                                                      <li class="wow animate__animated animate__fadeInUp" data-wow-delay=".0s"><a href="#tab-download"
                                                                                          data-bs-toggle="tab" role="tab" aria-controls="tab-download" aria-selected="true"><span>Download /
                                                                                            Install</span>
                                                                                          <svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"
                                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                                                                                            </path>
                                                                                          </svg></a></li>
                                                                                      <li class="wow animate__animated animate__fadeInUp" data-wow-delay=".0s"><a href="#tab-technology"
                                                                                          data-bs-toggle="tab" role="tab" aria-controls="tab-technology"
                                                                                          aria-selected="true"><span>Technology</span>
                                                                                          <svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"
                                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                                                                                            </path>
                                                                                          </svg></a></li>
                                                                                      <li class="wow animate__animated animate__fadeInUp" data-wow-delay=".0s"><a href="#tab-account"
                                                                                          data-bs-toggle="tab" role="tab" aria-controls="tab-account" aria-selected="true"><span>Your
                                                                                            Account</span>
                                                                                          <svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"
                                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                                                                                            </path>
                                                                                          </svg></a></li>
                                                                                    </ul>
                                                                                    <div class="mt-80 text-start mb-40 wow animate__animated animate__fadeInUp" data-wow-delay=".0s"><a
                                                                                        class="btn btn-brand-1 hover-up" href="#">Contact Us</a><a class="btn btn-default font-sm-bold hover-up"
                                                                                        href="#">Support Center
                                                                                        <svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"
                                                                                          xmlns="http://www.w3.org/2000/svg">
                                                                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                                                                                          </path>
                                                                                        </svg></a></div>
                                                                                  </div>
                                                                                  <div class="col-xl-9 col-lg-8">
                                                                                    <div class="tab-content tab-content-slider">
                                                                                      <div class="tab-pane fade active show" id="tab-support" role="tabpanel" aria-labelledby="tab-support">
                                                                                        <div class="accordion" id="accordionFAQ">
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingOne">
                                                                                              <button class="accordion-button text-heading-5" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Where is my
                                                                                                order? Quisque molestie</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse show" id="collapseOne" aria-labelledby="headingOne"
                                                                                              data-bs-parent="#accordionFAQ">
                                                                                              <div class="accordion-body">Vel tenetur officiis ab reiciendis dolor aut quae doloremque est ipsum
                                                                                                natus et consequatur animi aut sunt dolores ut quasi rerum. Aut velit velit id quasi velit eum
                                                                                                reiciendis laudantium quo galisum incidunt aut velit animi hic temporibus blanditiis sit odit
                                                                                                iure. Eum laborum dolores ea molestias fuga qui temporibus accusantium qui soluta aliquid ab
                                                                                                vero soluta.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingTwo">
                                                                                              <button class="accordion-button text-heading-5 collapsed" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">How can I return
                                                                                                an item purchased online?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseTwo" aria-labelledby="headingTwo"
                                                                                              data-bs-parent="#accordionFAQ">
                                                                                              <div class="accordion-body">Contrary to popular belief, Lorem Ipsum is not simply random text. It
                                                                                                has roots in a piece of classical Latin literature Id pro doctus mediocrem erroribus, diam
                                                                                                nostro sed cu. Ea pri graeco tritani partiendo. Omittantur No tale choro fastidii his, pri cu
                                                                                                epicuri perpetua. Enim dictas omittantur et duo, vocent lucilius quaestio mea ex. Ex illum
                                                                                                officiis id.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingThree">
                                                                                              <button class="accordion-button text-heading-5 collapsed text-heading-5 type="
                                                                                                data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false"
                                                                                                aria-controls="collapseThree">Can I cancel or change my order?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseThree" aria-labelledby="headingThree"
                                                                                              data-bs-parent="#accordionFAQ">
                                                                                              <div class="accordion-body">Aut architecto consequatur sit error nemo sed dolorum suscipit 33
                                                                                                impedit dignissimos ut velit blanditiis qui quos magni id dolore dignissimos. Sit ipsa
                                                                                                consectetur et sint harum et dicta consequuntur id cupiditate perferendis qui quisquam enim. Vel
                                                                                                autem illo id error excepturi est dolorum voluptas qui maxime consequatur et culpa quibusdam in
                                                                                                iusto vero sit amet Quis.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingFour">
                                                                                              <button class="accordion-button text-heading-5 collapsed" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">I have
                                                                                                promotional or discount code?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseFour" aria-labelledby="headingFour"
                                                                                              data-bs-parent="#accordionFAQ">
                                                                                              <div class="accordion-body">Eos nostrum aperiam ab enim quas sit voluptate fuga. Ea aperiam
                                                                                                voluptas a accusantium similique 33 alias sapiente non vitae repellat et dolorum omnis eos
                                                                                                beatae praesentium id sunt corporis. Aut nisi blanditiis aut corrupti quae et accusantium
                                                                                                doloribus sed tempore libero a dolorum beatae.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingFive">
                                                                                              <button class="accordion-button text-heading-5 collapsed" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">What are the
                                                                                                delivery types you use?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseFive" aria-labelledby="headingFive"
                                                                                              data-bs-parent="#accordionFAQ">
                                                                                              <div class="accordion-body">Et beatae quae ex minima porro aut nihil quia sed optio dignissimos et
                                                                                                voluptates deleniti et nesciunt veritatis et suscipit quod. Est sint voluptate id unde nesciunt
                                                                                                non deleniti debitis. Ut dolores tempore vel placeat nemo quo enim reprehenderit eos corrupti
                                                                                                maiores et minima quaerat. Quo sequi eaque eum similique sint et autem perspiciatis cum Quis
                                                                                                exercitationem quo quos excepturi non ducimus ducimus eos natus velit.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingSix">
                                                                                              <button class="accordion-button text-heading-5 collapsed" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">How can I pay
                                                                                                for my purchases?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseSix" aria-labelledby="headingSix"
                                                                                              data-bs-parent="#accordionFAQ">
                                                                                              <div class="accordion-body">Qui quas itaque ut molestias culpa vel culpa voluptas eos fugit sint
                                                                                                ex veritatis totam cum unde maxime! Qui eius fugiat qui veritatis cumque a nesciunt nemo. Id
                                                                                                numquam rerum est molestiae quia ut nisi architecto a officiis itaque eum quod repellat ut
                                                                                                dolorem dolorem aut ipsam ipsa.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingSeven">
                                                                                              <button class="accordion-button text-heading-5 collapsed" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">Can I cancel
                                                                                                my order?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseSeven" aria-labelledby="headingSeven"
                                                                                              data-bs-parent="#accordionFAQ">
                                                                                              <div class="accordion-body">Sed assumenda minus est omnis internos nam corrupti eius non
                                                                                                perferendis vero. Est ratione dolor ab veniam quas ex praesentium consequatur ut vero rerum est
                                                                                                impedit nihil vel Quis consequatur ut vero sapiente. Ut optio ipsum ad temporibus voluptates et
                                                                                                alias numquam eos reiciendis voluptatum. Id omnis modi est vero adipisci qui omnis ipsum rem
                                                                                                necessitatibus perspiciatis aut modi iste ab dolores sequi.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                      <div class="tab-pane fade" id="tab-order" role="tabpanel" aria-labelledby="tab-order">
                                                                                        <div class="accordion" id="accordionFAQ2">
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingOne-1">
                                                                                              <button class="accordion-button text-heading-5" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseOne-1" aria-expanded="true" aria-controls="collapseOne-1">Where is my
                                                                                                order? Quisque molestie</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse show" id="collapseOne-1" aria-labelledby="headingOne-1"
                                                                                              data-bs-parent="#accordionFAQ2">
                                                                                              <div class="accordion-body">Contrary to popular belief, Lorem Ipsum is not simply random text. It
                                                                                                has roots in a piece of classical Latin literature Id pro doctus mediocrem erroribus, diam
                                                                                                nostro sed cu. Ea pri graeco tritani partiendo. Omittantur No tale choro fastidii his, pri cu
                                                                                                epicuri perpetua. Enim dictas omittantur et duo, vocent lucilius quaestio mea ex. Ex illum
                                                                                                officiis id.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingTwo-1">
                                                                                              <button class="accordion-button text-heading-5 collapsed" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseTwo-1" aria-expanded="false" aria-controls="collapseTwo-1">How can I
                                                                                                return an item purchased online?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseTwo-1" aria-labelledby="headingTwo-1"
                                                                                              data-bs-parent="#accordionFAQ2">
                                                                                              <div class="accordion-body">In debitis minus sit doloribus consectetur vel voluptates rerum. Et
                                                                                                facere dolor qui voluptas fuga et asperiores eveniet! Et voluptatem voluptates et earum
                                                                                                consequatur in porro molestias id omnis Quis qui consequatur laborum. Vel dolor odit in nesciunt
                                                                                                sint aut quia excepturi id expedita voluptatem ea repellat voluptates?</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingThree-1">
                                                                                              <button class="accordion-button text-heading-5 collapsed text-heading-5 type="
                                                                                                data-bs-toggle="collapse" data-bs-target="#collapseThree-1" aria-expanded="false"
                                                                                                aria-controls="collapseThree-1">Can I cancel or change my order?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseThree-1" aria-labelledby="headingThree-1"
                                                                                              data-bs-parent="#accordionFAQ2">
                                                                                              <div class="accordion-body">In repellendus ratione ut tempora nesciunt est veniam esse qui optio
                                                                                                fugiat non dignissimos distinctio non excepturi eius. Id aperiam corporis et galisum earum cum
                                                                                                sint minima? Et harum nulla sit voluptate odio qui animi nulla et temporibus fuga ut atque modi
                                                                                                quo eveniet perferendis et deserunt rerum?</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingFour-1">
                                                                                              <button class="accordion-button text-heading-5 collapsed" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseFour-1" aria-expanded="false" aria-controls="collapseFour-1">I have
                                                                                                promotional or discount code?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseFour-1" aria-labelledby="headingFour-1"
                                                                                              data-bs-parent="#accordionFAQ2">
                                                                                              <div class="accordion-body">Ab necessitatibus quis ut vero voluptates qui voluptatibus minus 33
                                                                                                temporibus dolore et expedita adipisci et minus rerum. Sed repellat molestiae quo omnis minus
                                                                                                qui culpa fuga quo minima molestiae et veniam necessitatibus ut placeat dolore est tempora quia?
                                                                                                Ut Quis nemo et minus voluptatem ex dolorem voluptates est eius harum ut aliquam voluptatem aut
                                                                                                culpa dolorem sed itaque molestiae. Cum doloribus quia et neque quam ad repellat nesciunt.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingFive-1">
                                                                                              <button class="accordion-button text-heading-5 collapsed" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseFive-1" aria-expanded="false" aria-controls="collapseFive-1">What are
                                                                                                the delivery types you use?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseFive-1" aria-labelledby="headingFive-1"
                                                                                              data-bs-parent="#accordionFAQ2">
                                                                                              <div class="accordion-body">Contrary to popular belief, Lorem Ipsum is not simply random text. It
                                                                                                has roots in a piece of classical Latin literature Id pro doctus mediocrem erroribus, diam
                                                                                                nostro sed cu. Ea pri graeco tritani partiendo. Omittantur No tale choro fastidii his, pri cu
                                                                                                epicuri perpetua. Enim dictas omittantur et duo, vocent lucilius quaestio mea ex. Ex illum
                                                                                                officiis id.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingSix-1">
                                                                                              <button class="accordion-button text-heading-5 collapsed" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseSix-1" aria-expanded="false" aria-controls="collapseSix-1">How can I
                                                                                                pay for my purchases?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseSix-1" aria-labelledby="headingSix-1"
                                                                                              data-bs-parent="#accordionFAQ2">
                                                                                              <div class="accordion-body">Est quisquam fugit ut nemo repellat ab distinctio dolores eos nulla
                                                                                                dolor ea ipsa deleniti. In odit corrupti id fugiat omnis rem voluptatem recusandae ut atque odit
                                                                                                ut adipisci laudantium ea dolor illo! Et officiis officiis sit accusantium sint ex beatae error
                                                                                                eos dolorum rerum. Id doloribus doloribus et possimus corrupti est nostrum laudantium non nihil
                                                                                                rerum id alias nisi! Est laudantium itaque quo galisum vitae qui debitis dignissimos aut illum
                                                                                                nihil.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingSeven-1">
                                                                                              <button class="accordion-button text-heading-5 collapsed" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseSeven-1" aria-expanded="false" aria-controls="collapseSeven-1">Can I
                                                                                                cancel my order?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseSeven-1" aria-labelledby="headingSeven-1"
                                                                                              data-bs-parent="#accordionFAQ2">
                                                                                              <div class="accordion-body">Contrary to popular belief, Lorem Ipsum is not simply random text. It
                                                                                                has roots in a piece of classical Latin literature Id pro doctus mediocrem erroribus, diam
                                                                                                nostro sed cu. Ea pri graeco tritani partiendo. Omittantur No tale choro fastidii his, pri cu
                                                                                                epicuri perpetua. Enim dictas omittantur et duo, vocent lucilius quaestio mea ex. Ex illum
                                                                                                officiis id.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                      <div class="tab-pane fade" id="tab-download" role="tabpanel" aria-labelledby="tab-download">
                                                                                        <div class="accordion" id="accordionFAQ3">
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingOne-2">
                                                                                              <button class="accordion-button text-heading-5" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseOne-2" aria-expanded="true" aria-controls="collapseOne-2">Where is my
                                                                                                order? Quisque molestie</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse show" id="collapseOne-2" aria-labelledby="headingOne-2"
                                                                                              data-bs-parent="#accordionFAQ3">
                                                                                              <div class="accordion-body">Sed modi suscipit sit ducimus beatae qui expedita nihil ea ullam
                                                                                                voluptates est voluptatem cumque et repellendus culpa. Et quasi necessitatibus aut doloribus
                                                                                                magnam qui veritatis fugiat quo velit nulla ut error nesciunt ex omnis beatae. Est nemo illo ut
                                                                                                doloribus excepturi qui galisum consectetur cum commodi tempora et obcaecati doloremque. Qui
                                                                                                animi ipsum vel inventore nulla eum voluptate modi et incidunt rerum.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingTwo-2">
                                                                                              <button class="accordion-button text-heading-5 collapsed" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseTwo-2" aria-expanded="false" aria-controls="collapseTwo-2">How can I
                                                                                                return an item purchased online?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseTwo-2" aria-labelledby="headingTwo-2"
                                                                                              data-bs-parent="#accordionFAQ3">
                                                                                              <div class="accordion-body">Contrary to popular belief, Lorem Ipsum is not simply random text. It
                                                                                                has roots in a piece of classical Latin literature Id pro doctus mediocrem erroribus, diam
                                                                                                nostro sed cu. Ea pri graeco tritani partiendo. Omittantur No tale choro fastidii his, pri cu
                                                                                                epicuri perpetua. Enim dictas omittantur et duo, vocent lucilius quaestio mea ex. Ex illum
                                                                                                officiis id.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingThree-2">
                                                                                              <button class="accordion-button text-heading-5 collapsed text-heading-5 type="
                                                                                                data-bs-toggle="collapse" data-bs-target="#collapseThree-2" aria-expanded="false"
                                                                                                aria-controls="collapseThree-2">Can I cancel or change my order?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseThree-2" aria-labelledby="headingThree-2"
                                                                                              data-bs-parent="#accordionFAQ3">
                                                                                              <div class="accordion-body">Ea earum tempora et obcaecati voluptatem ea reprehenderit itaque sed
                                                                                                cumque nisi aut internos error id nihil nobis quo optio ullam. Quo repudiandae incidunt hic quis
                                                                                                libero et dolorem ullam est neque delectus 33 eius incidunt qui iusto laborum sed quod officia.
                                                                                                Ea omnis provident et voluptatem aperiam id eveniet quis eos sequi fuga. Et consequuntur ducimus
                                                                                                a consequatur nemo ex illum aliquam. Sit repellat quasi qui numquam perspiciatis et laboriosam
                                                                                                optio.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingFour-2">
                                                                                              <button class="accordion-button text-heading-5 collapsed" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseFour-2" aria-expanded="false" aria-controls="collapseFour-2">I have
                                                                                                promotional or discount code?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseFour-2" aria-labelledby="headingFour-2"
                                                                                              data-bs-parent="#accordionFAQ3">
                                                                                              <div class="accordion-body">Contrary to popular belief, Lorem Ipsum is not simply random text. It
                                                                                                has roots in a piece of classical Latin literature Id pro doctus mediocrem erroribus, diam
                                                                                                nostro sed cu. Ea pri graeco tritani partiendo. Omittantur No tale choro fastidii his, pri cu
                                                                                                epicuri perpetua. Enim dictas omittantur et duo, vocent lucilius quaestio mea ex. Ex illum
                                                                                                officiis id.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingFive-2">
                                                                                              <button class="accordion-button text-heading-5 collapsed" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseFive-2" aria-expanded="false" aria-controls="collapseFive-2">What are
                                                                                                the delivery types you use?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseFive-2" aria-labelledby="headingFive-2"
                                                                                              data-bs-parent="#accordionFAQ3">
                                                                                              <div class="accordion-body">Ea veniam adipisci sit modi nobis eum dolores ullam! Et omnis nobis
                                                                                                qui itaque esse a fuga nihil. Nam omnis temporibus ab dolor quasi sed nesciunt commodi non
                                                                                                praesentium eveniet. Qui quia sapiente et praesentium nobis aut odio debitis vel corrupti sunt
                                                                                                quo dolor internos non dignissimos iste. Et nesciunt soluta qui voluptatem cumque sed vero minus
                                                                                                et dolorem Quis aut quisquam sunt nam laboriosam placeat.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingSix-2">
                                                                                              <button class="accordion-button text-heading-5 collapsed" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseSix-2" aria-expanded="false" aria-controls="collapseSix-2">How can I
                                                                                                pay for my purchases?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseSix-2" aria-labelledby="headingSix-2"
                                                                                              data-bs-parent="#accordionFAQ3">
                                                                                              <div class="accordion-body">Ut unde laboriosam ut eius illo aut culpa debitis. Et vitae quia aut
                                                                                                atque sunt eum veniam voluptas aut laudantium suscipit eum rerum praesentium. Et odit
                                                                                                dignissimos sed ipsam natus et earum dolore! Et blanditiis Quis ut necessitatibus atque 33 omnis
                                                                                                totam sed voluptatem suscipit! A libero molestias et quos sunt et illum dignissimos. Aut
                                                                                                blanditiis voluptas At fugiat maiores aut eligendi velit et cumque voluptas. Et officiis libero
                                                                                                aut beatae quis sed rerum dicta.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingSeven-2">
                                                                                              <button class="accordion-button text-heading-5 collapsed" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseSeven-2" aria-expanded="false" aria-controls="collapseSeven-2">Can I
                                                                                                cancel my order?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseSeven-2" aria-labelledby="headingSeven-2"
                                                                                              data-bs-parent="#accordionFAQ3">
                                                                                              <div class="accordion-body">Contrary to popular belief, Lorem Ipsum is not simply random text. It
                                                                                                has roots in a piece of classical Latin literature Id pro doctus mediocrem erroribus, diam
                                                                                                nostro sed cu. Ea pri graeco tritani partiendo. Omittantur No tale choro fastidii his, pri cu
                                                                                                epicuri perpetua. Enim dictas omittantur et duo, vocent lucilius quaestio mea ex. Ex illum
                                                                                                officiis id.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                      <div class="tab-pane fade" id="tab-technology" role="tabpanel" aria-labelledby="tab-technology">
                                                                                        <div class="accordion" id="accordionFAQ4">
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingOne-3">
                                                                                              <button class="accordion-button text-heading-5" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseOne-3" aria-expanded="true" aria-controls="collapseOne-3">Where is my
                                                                                                order? Quisque molestie</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse show" id="collapseOne-3" aria-labelledby="headingOne-3"
                                                                                              data-bs-parent="#accordionFAQ4">
                                                                                              <div class="accordion-body">Contrary to popular belief, Lorem Ipsum is not simply random text. It
                                                                                                has roots in a piece of classical Latin literature Id pro doctus mediocrem erroribus, diam
                                                                                                nostro sed cu. Ea pri graeco tritani partiendo. Omittantur No tale choro fastidii his, pri cu
                                                                                                epicuri perpetua. Enim dictas omittantur et duo, vocent lucilius quaestio mea ex. Ex illum
                                                                                                officiis id.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingTwo-3">
                                                                                              <button class="accordion-button text-heading-5 collapsed" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseTwo-3" aria-expanded="false" aria-controls="collapseTwo-3">How can I
                                                                                                return an item purchased online?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseTwo-3" aria-labelledby="headingTwo-3"
                                                                                              data-bs-parent="#accordionFAQ4">
                                                                                              <div class="accordion-body">Contrary to popular belief, Lorem Ipsum is not simply random text. It
                                                                                                has roots in a piece of classical Latin literature Id pro doctus mediocrem erroribus, diam
                                                                                                nostro sed cu. Ea pri graeco tritani partiendo. Omittantur No tale choro fastidii his, pri cu
                                                                                                epicuri perpetua. Enim dictas omittantur et duo, vocent lucilius quaestio mea ex. Ex illum
                                                                                                officiis id.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingThree-3">
                                                                                              <button class="accordion-button text-heading-5 collapsed text-heading-5 type="
                                                                                                data-bs-toggle="collapse" data-bs-target="#collapseThree-3" aria-expanded="false"
                                                                                                aria-controls="collapseThree-3">Can I cancel or change my order?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseThree-3" aria-labelledby="headingThree-3"
                                                                                              data-bs-parent="#accordionFAQ4">
                                                                                              <div class="accordion-body">Contrary to popular belief, Lorem Ipsum is not simply random text. It
                                                                                                has roots in a piece of classical Latin literature Id pro doctus mediocrem erroribus, diam
                                                                                                nostro sed cu. Ea pri graeco tritani partiendo. Omittantur No tale choro fastidii his, pri cu
                                                                                                epicuri perpetua. Enim dictas omittantur et duo, vocent lucilius quaestio mea ex. Ex illum
                                                                                                officiis id.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingFour-3">
                                                                                              <button class="accordion-button text-heading-5 collapsed" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseFour-3" aria-expanded="false" aria-controls="collapseFour-3">I have
                                                                                                promotional or discount code?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseFour-3" aria-labelledby="headingFour-3"
                                                                                              data-bs-parent="#accordionFAQ4">
                                                                                              <div class="accordion-body">Contrary to popular belief, Lorem Ipsum is not simply random text. It
                                                                                                has roots in a piece of classical Latin literature Id pro doctus mediocrem erroribus, diam
                                                                                                nostro sed cu. Ea pri graeco tritani partiendo. Omittantur No tale choro fastidii his, pri cu
                                                                                                epicuri perpetua. Enim dictas omittantur et duo, vocent lucilius quaestio mea ex. Ex illum
                                                                                                officiis id.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingFive-3">
                                                                                              <button class="accordion-button text-heading-5 collapsed" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseFive-3" aria-expanded="false" aria-controls="collapseFive-3">What are
                                                                                                the delivery types you use?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseFive-3" aria-labelledby="headingFive-3"
                                                                                              data-bs-parent="#accordionFAQ4">
                                                                                              <div class="accordion-body">Contrary to popular belief, Lorem Ipsum is not simply random text. It
                                                                                                has roots in a piece of classical Latin literature Id pro doctus mediocrem erroribus, diam
                                                                                                nostro sed cu. Ea pri graeco tritani partiendo. Omittantur No tale choro fastidii his, pri cu
                                                                                                epicuri perpetua. Enim dictas omittantur et duo, vocent lucilius quaestio mea ex. Ex illum
                                                                                                officiis id.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingSix-3">
                                                                                              <button class="accordion-button text-heading-5 collapsed" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseSix-3" aria-expanded="false" aria-controls="collapseSix-3">How can I
                                                                                                pay for my purchases?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseSix-3" aria-labelledby="headingSix-3"
                                                                                              data-bs-parent="#accordionFAQ4">
                                                                                              <div class="accordion-body">Contrary to popular belief, Lorem Ipsum is not simply random text. It
                                                                                                has roots in a piece of classical Latin literature Id pro doctus mediocrem erroribus, diam
                                                                                                nostro sed cu. Ea pri graeco tritani partiendo. Omittantur No tale choro fastidii his, pri cu
                                                                                                epicuri perpetua. Enim dictas omittantur et duo, vocent lucilius quaestio mea ex. Ex illum
                                                                                                officiis id.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingSeven-3">
                                                                                              <button class="accordion-button text-heading-5 collapsed" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseSeven-3" aria-expanded="false" aria-controls="collapseSeven-3">Can I
                                                                                                cancel my order?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseSeven-3" aria-labelledby="headingSeven-3"
                                                                                              data-bs-parent="#accordionFAQ4">
                                                                                              <div class="accordion-body">Contrary to popular belief, Lorem Ipsum is not simply random text. It
                                                                                                has roots in a piece of classical Latin literature Id pro doctus mediocrem erroribus, diam
                                                                                                nostro sed cu. Ea pri graeco tritani partiendo. Omittantur No tale choro fastidii his, pri cu
                                                                                                epicuri perpetua. Enim dictas omittantur et duo, vocent lucilius quaestio mea ex. Ex illum
                                                                                                officiis id.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                      <div class="tab-pane fade" id="tab-account" role="tabpanel" aria-labelledby="tab-order">
                                                                                        <div class="accordion" id="accordionFAQ5">
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingOne-4">
                                                                                              <button class="accordion-button text-heading-5" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseOne-4" aria-expanded="true" aria-controls="collapseOne-4">Where is my
                                                                                                order? Quisque molestie</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse show" id="collapseOne-4" aria-labelledby="headingOne-4"
                                                                                              data-bs-parent="#accordionFAQ5">
                                                                                              <div class="accordion-body">Contrary to popular belief, Lorem Ipsum is not simply random text. It
                                                                                                has roots in a piece of classical Latin literature Id pro doctus mediocrem erroribus, diam
                                                                                                nostro sed cu. Ea pri graeco tritani partiendo. Omittantur No tale choro fastidii his, pri cu
                                                                                                epicuri perpetua. Enim dictas omittantur et duo, vocent lucilius quaestio mea ex. Ex illum
                                                                                                officiis id.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingTwo-4">
                                                                                              <button class="accordion-button text-heading-5 collapsed" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseTwo-4" aria-expanded="false" aria-controls="collapseTwo-4">How can I
                                                                                                return an item purchased online?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseTwo-4" aria-labelledby="headingTwo-4"
                                                                                              data-bs-parent="#accordionFAQ5">
                                                                                              <div class="accordion-body">Contrary to popular belief, Lorem Ipsum is not simply random text. It
                                                                                                has roots in a piece of classical Latin literature Id pro doctus mediocrem erroribus, diam
                                                                                                nostro sed cu. Ea pri graeco tritani partiendo. Omittantur No tale choro fastidii his, pri cu
                                                                                                epicuri perpetua. Enim dictas omittantur et duo, vocent lucilius quaestio mea ex. Ex illum
                                                                                                officiis id.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingThree-4">
                                                                                              <button class="accordion-button text-heading-5 collapsed text-heading-5 type="
                                                                                                data-bs-toggle="collapse" data-bs-target="#collapseThree-4" aria-expanded="false"
                                                                                                aria-controls="collapseThree-4">Can I cancel or change my order?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseThree-4" aria-labelledby="headingThree-4"
                                                                                              data-bs-parent="#accordionFAQ5">
                                                                                              <div class="accordion-body">Contrary to popular belief, Lorem Ipsum is not simply random text. It
                                                                                                has roots in a piece of classical Latin literature Id pro doctus mediocrem erroribus, diam
                                                                                                nostro sed cu. Ea pri graeco tritani partiendo. Omittantur No tale choro fastidii his, pri cu
                                                                                                epicuri perpetua. Enim dictas omittantur et duo, vocent lucilius quaestio mea ex. Ex illum
                                                                                                officiis id.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingFour-4">
                                                                                              <button class="accordion-button text-heading-5 collapsed" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseFour-4" aria-expanded="false" aria-controls="collapseFour-4">I have
                                                                                                promotional or discount code?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseFour-4" aria-labelledby="headingFour-4"
                                                                                              data-bs-parent="#accordionFAQ5">
                                                                                              <div class="accordion-body">Contrary to popular belief, Lorem Ipsum is not simply random text. It
                                                                                                has roots in a piece of classical Latin literature Id pro doctus mediocrem erroribus, diam
                                                                                                nostro sed cu. Ea pri graeco tritani partiendo. Omittantur No tale choro fastidii his, pri cu
                                                                                                epicuri perpetua. Enim dictas omittantur et duo, vocent lucilius quaestio mea ex. Ex illum
                                                                                                officiis id.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingFive-4">
                                                                                              <button class="accordion-button text-heading-5 collapsed" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseFive-4" aria-expanded="false" aria-controls="collapseFive-4">What are
                                                                                                the delivery types you use?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseFive-4" aria-labelledby="headingFive-4"
                                                                                              data-bs-parent="#accordionFAQ5">
                                                                                              <div class="accordion-body">Contrary to popular belief, Lorem Ipsum is not simply random text. It
                                                                                                has roots in a piece of classical Latin literature Id pro doctus mediocrem erroribus, diam
                                                                                                nostro sed cu. Ea pri graeco tritani partiendo. Omittantur No tale choro fastidii his, pri cu
                                                                                                epicuri perpetua. Enim dictas omittantur et duo, vocent lucilius quaestio mea ex. Ex illum
                                                                                                officiis id.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingSix-4">
                                                                                              <button class="accordion-button text-heading-5 collapsed" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseSix-4" aria-expanded="false" aria-controls="collapseSix-4">How can I
                                                                                                pay for my purchases?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseSix-4" aria-labelledby="headingSix-4"
                                                                                              data-bs-parent="#accordionFAQ5">
                                                                                              <div class="accordion-body">Contrary to popular belief, Lorem Ipsum is not simply random text. It
                                                                                                has roots in a piece of classical Latin literature Id pro doctus mediocrem erroribus, diam
                                                                                                nostro sed cu. Ea pri graeco tritani partiendo. Omittantur No tale choro fastidii his, pri cu
                                                                                                epicuri perpetua. Enim dictas omittantur et duo, vocent lucilius quaestio mea ex. Ex illum
                                                                                                officiis id.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                          <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay=".0s">
                                                                                            <h5 class="accordion-header" id="headingSeven-4">
                                                                                              <button class="accordion-button text-heading-5 collapsed" type="button" data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseSeven-4" aria-expanded="false" aria-controls="collapseSeven-4">Can I
                                                                                                cancel my order?</button>
                                                                                            </h5>
                                                                                            <div class="accordion-collapse collapse" id="collapseSeven-4" aria-labelledby="headingSeven-4"
                                                                                              data-bs-parent="#accordionFAQ5">
                                                                                              <div class="accordion-body">Contrary to popular belief, Lorem Ipsum is not simply random text. It
                                                                                                has roots in a piece of classical Latin literature Id pro doctus mediocrem erroribus, diam
                                                                                                nostro sed cu. Ea pri graeco tritani partiendo. Omittantur No tale choro fastidii his, pri cu
                                                                                                epicuri perpetua. Enim dictas omittantur et duo, vocent lucilius quaestio mea ex. Ex illum
                                                                                                officiis id.</div>
                                                                                            </div>
                                                                                          </div>
                                                                                        </div>
                                                                                      </div>
                                                                                    </div>
                                                                                  </div>
                                                                                </div>
                                                                              </div>
                                                                              <div class="border-bottom"></div>
                                                                            </section> -->
        </div>
        <!-- <section class="section mt-50">
                                                                            <div class="container">
                                                                              <div class="box-newsletter box-newsletter-2 wow animate__animated animate__fadeIn">
                                                                                <div class="row align-items-center">
                                                                                  <div class="col-lg-6 col-md-7 m-auto text-center"><span
                                                                                      class="font-lg color-brand-1 wow animate__animated animate__fadeIn" data-wow-delay=".0s">Newsletter</span>
                                                                                    <h2 class="color-brand-1 mb-15 mt-5 wow animate__animated animate__fadeIn" data-wow-delay=".1s">Subcribe our
                                                                                      newsletter</h2>
                                                                                    <p class="font-md color-grey-500 wow animate__animated animate__fadeIn" data-wow-delay=".2s">Do not miss the
                                                                                      latest information from us about the trending in the market. By clicking the button, you are areeing with
                                                                                      our Term & Conditions</p>
                                                                                    <div class="form-newsletter mt-30 wow animate__animated animate__fadeIn" data-wow-delay=".3s">
                                                                                      <form action="#">
                                                                                        <input type="text" placeholder="Enter you mail ..">
                                                                                        <button class="btn btn-submit-newsletter" type="submit">
                                                                                          <svg class="w-6 h-6 icon-16" fill="none" stroke="currentColor" viewbox="0 0 24 24"
                                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                                                                                            </path>
                                                                                          </svg>
                                                                                        </button>
                                                                                      </form>
                                                                                    </div>
                                                                                  </div>
                                                                                </div>
                                                                              </div>
                                                                            </div>
                                                                          </section> -->
    </main>


    <!-- Add this JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const input = document.querySelector("#phone");
        const country_code = document.querySelector("#country_code");
        const iti = window.intlTelInput(input, {
            initialCountry: "auto",
            separateDialCode: true,
            geoIpLookup: callback => {
                fetch("https://ipapi.co/json")
                    .then(res => res.json())
                    .then(data => callback(data.country_code))
                    .catch(() => callback("us"));
            },
            utilsScript: "{{ asset('vendor/IntlTelInput/utils.js') }}",
        });
        input.addEventListener("countrychange", function() {
            country_code.value = iti.getSelectedCountryData().dialCode;
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#contactForm').on('submit', function(e) {
                e.preventDefault(); // This is crucial to prevent traditional form submission

                const $form = $(this);
                const $submitBtn = $form.find('button[type="submit"]');
                const $responseDiv = $('#form-response');

                // Reset UI state
                $submitBtn.html('<span class="spinner-border spinner-border-sm"></span> Sending...').prop(
                    'disabled', true);
                $responseDiv.removeClass('alert-danger alert-success').html('').hide();
                $('.invalid-feedback').hide();
                $('.form-control').removeClass('is-invalid');

                // Validate phone
                // if (!iti.isValidNumber()) {
                //     $('#phone').addClass('is-invalid').next('.invalid-feedback').text(
                //         'Please enter a valid phone number').show();
                //     $submitBtn.html('Send message').prop('disabled', false);
                //     return;
                // }

                // Prepare data
                const phoneNumber = $('#phone').val(); // Get the phone number input
                const countryCode = iti.getSelectedCountryData().dialCode; // Get country code from intlTel
                const fullPhone = `+${countryCode}${phoneNumber}`;

                const formData = new FormData($form[0]);
                formData.append('full_phone', fullPhone);
                //formData.append('country_code', iti.getSelectedCountryData().dialCode);

                // Add headers to indicate this is an AJAX request
                const headers = {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                };

                // AJAX request
                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: headers,
                    success: function(response) {
                        $form[0].reset();
                        showSweetAlert('Success!', response.message, 'success');
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                const $input = $(`[name="${key}"]`);
                                const $errorDiv = $input.next('.invalid-feedback');

                                $input.addClass('is-invalid');
                                $errorDiv.text(value[0]).show();
                            });
                            showSweetAlert('Validation Error', 'Please fix the form errors',
                                'error');
                        } else {
                            const errorMsg = xhr.responseJSON?.message || 'An error occurred';
                            showSweetAlert('Error', errorMsg, 'error');
                        }
                    },
                    complete: function() {
                        $submitBtn.html('Send message').prop('disabled', false);
                    }
                });

                function showMessage(msg, type) {
                    $responseDiv.removeClass('alert-danger alert-success')
                        .addClass(`alert-${type}`)
                        .html(`<strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${msg}`)
                        .fadeIn();

                    // Auto-hide after 5 seconds
                    setTimeout(() => $responseDiv.fadeOut(), 5000);

                    // Scroll to message if not visible
                    if (!$responseDiv.is(':visible')) {
                        $('html, body').animate({
                            scrollTop: $responseDiv.offset().top - 100
                        }, 500);
                    }
                }
            });

            function showSweetAlert(title, message, type) {
                Swal.fire({
                    title: title,
                    text: message,
                    icon: type, // 'success', 'error', 'warning', 'info', 'question'
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                    timer: type === 'success' ? 3000 : undefined // Auto-close success after 3sec
                });
            }
        });
    </script>

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
            padding: 1.5rem;
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
