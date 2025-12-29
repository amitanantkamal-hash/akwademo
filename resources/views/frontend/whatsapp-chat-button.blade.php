@extends('frontend.layout.master')
@section('title', 'Anantkamal WADEMO - WhatsApp Chat Widget Builder')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary: #04694d;
      --border: #dfe4ea;
      --bg: #ffffff;
      --text: #1e1e1e;
    }

    /* Global */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      /* font-family: 'Inter', sans-serif; */
    }

    body {
      background: #f4f7fa;
      padding: 0;
         text-transform: capitalize;
    }

    /* Common container */
    .container-whatsapp-chat {
      max-width: 1200px;
      width: 100%;
      margin: auto;
      padding: 60px 20px;
      text-align: center;
          padding-top: 120px;
    }
    .container-whatsapp-chat h2{
      text-align:center;
      font-weight:700;
      color:#064431;
      font-size:40px;
      line-height:56px;
    }

    .ai-badge {
      background: #daf6eb;
      color: #024430;
      padding: 8px 18px;
      border-radius: 20px;
      font-size: 14px;
      display: inline-block;
      margin-bottom: 14px;
      text-align: center;
    }

    /* Builder Area Section */
    .builder-area {
      display: flex;
      gap: 40px;
      margin-top: 35px;
    }

    .left-panel {
      width: 55%;
      background: #fff;
      border-radius: 10px;
      padding: 25px;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
    }

    .right-preview {
      width: 45%;
      display: flex;
      justify-content: center;
      height: 400px;
    }

    label {
      font-size: 14px;
      font-weight: 600;
      margin: 15px 0 6px;
      display: block;
    }

    input,
    select,
    textarea {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid var(--border);
      border-radius: 6px;
      font-size: 14px;
    }

    textarea {
      resize: none;
      height: 70px;
    }

    .section-title {
      font-size: 18px;
      font-weight: 600;
      color: var(--primary);
      margin: 20px 0 10px;
    }

    /* Preview Box */
    .preview-box {
      width: 330px;
      border-radius: 14px;
      overflow: hidden;
      background: #e5ddd5;
      border: 1px solid #d1d1d1;
    }

    .preview-header {
      background: var(--primary);
      padding: 15px;
      color: white;
      font-weight: 600;
    }

    .messages-area {
      padding: 15px;
      min-height: 260px;
      /*background: url('https://i.imgur.com/k7X7iri.png');*/
    }

    .message {
      background: white;
      padding: 10px;
      border-radius: 10px;
      max-width: 250px;
      margin-bottom: 10px;
      font-size: 14px;
    }

    .input-area {
      padding: 10px;
      background: white;
      display: flex;
      gap: 10px;
    }

    .send-btn {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      border: none;
      background: var(--primary);
      color: white;
      cursor: pointer;
    }

    button.generate {
      width: 100%;
      margin-top: 25px;
      padding: 12px;
      background: #024430;
      color: #fff;
      border: none;
      border-radius: 6px;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
    }

    /* Responsive Builder */
    @media(max-width:900px) {
      .builder-area {
        flex-direction: column;
      }

      .left-panel,
      .right-preview {
        width: 100%;
      }

      .right-preview {
        justify-content: center;
      }


        .benefits-content h2 {
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 15px;
      text-align:left;
      color:#064431;
      line-height:48px;
    }
    }

    /* Benefits Section */
    .benefits-section {
      background: #fff;
      padding: 80px 0;
      border-top: 1px solid #e2e8f0;
    }

    .benefits-container {
      max-width: 1200px;
      margin: auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 50px;
      padding: 0 20px;
    }

    .benefits-image img {
      width: 100%;
      max-width: 500px;
      border-radius: 12px;
    }

    .benefits-content {
      max-width: 600px;
    }

    .benefits-content h2 {
      font-size: 32px;
      font-weight: 700;
      margin-bottom: 15px;
      /* color: #111827; */
      color:#064431;
      line-height:48px;
    }

    .benefits-content p {
      font-size: 16px;
      color: #4b5563;
      line-height: 1.6;
      margin-bottom: 20px;
      text-align:left;
    }
    
    .benefits-content p span {
      font-weight: 500;
      color: #064431;
      font-size: 20px;
    }
    

    .benefits-list {
      list-style: none;
      padding: 0;
    }

    .benefits-list li {
      margin-bottom: 18px;
      font-size: 16px;
      color: #4b5563;
    }

    .benefit-title {
      font-weight: 700;
      color: #111827;
    }

    .benefits-btn {
      display: inline-block;
      margin-top: 25px;
      padding: 12px 28px;
      background: #024430;
      color: #fff;
      border-radius: 6px;
      font-size: 16px;
      font-weight: 600;
      text-decoration: none;
    }

    .benefits-btn:hover {
      background: #024430;
    }

    @media(max-width:992px) {
      .benefits-container {
        flex-direction: column;
        text-align: center;
      }

      .benefits-list li {
        text-align: left;
      }
          .container-whatsapp-chat h2{
          line-height:40px !important;
          font-size:28px !important;
          text-align:left;
        }

        .benefits-content h2 {
          font-size: 28px;
          font-weight: 700;
          margin-bottom: 15px;
          /* color: #111827; */
          color:#064431;
          text-align:left;
        }
    }


    /* WHY CHOOSE SECTION */
    .why-choose-section {
      background: #ffffff;
      padding: 80px 20px;
      text-align: center;
    }

    .container-why {
      max-width: 1200px;
      margin: auto;
    }

    .why-title {
      font-size: 30px;
      font-weight: 700;
      /* color: #1e293b; */
          color: #064431;
      margin-bottom: 12px;
      line-height:40px;
    }

    .why-subtitle {
      max-width: 900px;
      margin: auto;
      font-size: 16px;
      color: #64748b;
      line-height: 1.6;
      margin-bottom: 50px;
    }

    .why-features {
      display: flex;
      justify-content: space-between;
      gap: 25px;
      flex-wrap: wrap;
    }

    .chat-features-card {
      background: #fff;
      padding: 25px;
      width: 23%;
      min-height: 260px;
      border-radius: 14px;
      box-shadow: 0 8px 28px rgba(0, 0, 0, 0.05);
      transition: 0.3s;
      text-align: center;
      border: 1px solid rgba(0, 0, 0, 0.04);
    }

    .chat-features-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 32px rgba(0, 0, 0, 0.08);
    }

    .icon-box img {
      width: 46px;
      height: 46px;
      object-fit: contain;
      margin-bottom: 18px;
    }

    .chat-features-card h3 {
      font-size: 18px;
      font-weight: 700;
      color: #1e293b;
      margin-bottom: 12px;
    }

    .chat-features-card p {
      font-size: 15px;
      color: #6b7280;
      line-height: 1.6;
    }

    .why-btn {
      padding: 12px 35px;
      background: #024430;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
    }

    .why-btn:hover {
      background: #024430;
    }

    /* Responsive */
    @media(max-width:992px) {
      .chat-features-card {
        width: 48%;
      }
          .container-whatsapp-chat h2{
      line-height:40px !important;
      font-size:28px !important;
      text-align:left;
    }
      .why-title{
        font-size:28px;
        text-align:left;
      }
    
    .benefits-content h2 {
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 15px;
      text-align:left;
      color:#064431;
    }
   
          .why-subtitle{
         text-align:left;
      }
    }

    @media(max-width:600px) {
      .chat-features-card {
        width: 100%;
      }

          .benefits-content h2 {
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 15px;
      text-align:left;
      color:#064431;
    }
          .container-whatsapp-chat h2{
      line-height:40px !important;
      font-size:28px !important;
      text-align:left;
    }

              .why-title{
        font-size:28px;
        text-align:left;
      }
      .why-subtitle{
         text-align:left;
      }
    }

    .akw-icon {
      font-size: 32px;
      color: #024430;
      margin-bottom: 16px;
      display: block;
    }
  </style>

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
  <!-- HERO / FIRST BUILDER SECTION -->
  <section class="container-whatsapp-chat">
    <span class="ai-badge">WhatsApp Chat Button</span>
    <h2 style="">Instant WhatsApp Chat Widget for Your Website</h2>
    <p style="text-align:center;margin:10px 0 20px;">Boost your conversions and engage customers instantly with
      Anantkamal WADEMO smart chat assistant.</p>

    <div style="text-align:center;margin-bottom:25px;">
      <button
        style="padding:10px 24px;background:#024430;color:white;border:none;border-radius:6px;font-size:14px;cursor:pointer;">Generate
        My Template</button>
    </div>

    <div class="builder-area">
      <div class="left-panel">

        <h3 class="section-title">Chat Widget Builder</h3>
        <label>Enter your WhatsApp number *</label>
        <input type="text" placeholder="+91 XXXXXX">

        <label>Business Name *</label>
        <input type="text" placeholder="Anantkamal WADEMO">

        <label>Availability Tag *</label>
        <input type="text" placeholder="Typically replies in a few minutes">

        <h3 class="section-title">Customize Your Widget</h3>

        <label>Widget Style *</label>
        <select>
          <option>Modern</option>
          <option>Compact</option>
        </select>

        <label>Widget Position *</label>
        <select>
          <option>Left</option>
          <option>Right</option>
        </select>

        <label>Your Logo</label>
        <input type="file">

        <label>Welcome Text *</label>
        <textarea placeholder="Welcome to Anantkamal WADEMO! How can we assist you today?"></textarea>

        <label>Question *</label>
        <input type="text" placeholder="Choose an inquiry option">

        <label>Option 1</label>
        <input type="text" placeholder="Product Inquiry">

        <label>Option 2</label>
        <input type="text" placeholder="Support Request">

        <label>Trigger Message *</label>
        <input type="text" placeholder="Say Hi to start the chat!">

        <button class="generate">Generate Chat Widget Code</button>
      </div>

      <div class="right-preview">
        <div class="preview-box">
          <div class="preview-header">Anantkamal WADEMO Support</div>
          <div class="messages-area">
            <div class="message">Hello! 👋 Welcome to Anantkamal WADEMO</div>
            <div class="message">How can we assist you today?</div>
          </div>
          <div class="input-area">
            <input type="text" placeholder="Send a message">
            <button class="send-btn">➤</button>
          </div>
        </div>
        
      </div>
    </div>
  </section>

  <!-- BENEFITS SECTION -->
  <section class="benefits-section">
    <div class="benefits-container">
      <div class="benefits-image">
        <img src="assets/imgs/images/whatup_chat_widget/39.jpg" alt="Benefits WhatsApp Chat Widget">
      </div>

      <div class="benefits-content">
        <h2>Benefits of Using WhatsApp chat widget</h2>
          <p><span>Make hesitant prospects conversation-ready</span><br>
          Redirect website visitors to your WhatsApp Business account, giving your sales team more control and clarity over the buyer’s journey.</p>
          <p><span>Qualify leads before your team steps in</span><br>
          Increase the efficiency of your sales and marketing teams by adding smart lead-qualification flows directly inside the WhatsApp chat widget</p>
          <p><span>Speed up your sales cycle with assisted buying</span><br>
          Move quickly from lead capture to deal closure using a blend of WhatsApp automation and human support — ensuring a smoother, faster buying experience</p>
        

        <button class="btn btn-brand-1 hover-up" data-bs-toggle="modal" data-bs-target="#expertModal">Connect with Our Expert</button>
      </div>
    </div>
  </section>

  <!-- WHY CHOOSE SECTION -->
  <section class="why-choose-section">
    <div class="container-why">

      <h2 class="why-title">Why Choose Anantkamal WADEMO for WhatsApp Chat Widget?</h2>
      <p class="why-subtitle">
        WADEMO offers much more than a simple chat widget to take your customers to your WhatsApp Business Account.
        Here are four reasons why WADEMO would be a right fit for you:
      </p>

      <div class="why-features">
        <div class="chat-features-card">
          <div class="icon-box"><i class="fa-solid fa-list-check akw-icon"></i></div>
          <h3>Qualify leads effortlessly</h3>
          <p>Let WhatsApp Flows handle the heavy lifting and streamline your lead qualification from the very first interaction</p>
        </div>

        <div class="chat-features-card">
          <div class="icon-box"><i class="fa-solid fa-bolt  akw-icon"></i></div>
          <h3>Boost your productivity</h3>
          <p>Keep leads warm and customers informed by automating replies to common questions</p>
        </div>

        <div class="chat-features-card">
          <div class="icon-box"><i class="fa-solid fa-bullhorn akw-icon"></i></div>
          <h3>Deliver Bulk Broadcasts</h3>
          <p>Send personalized, targeted messages to keep prospects engaged and smoothly guide them toward conversion</p>
        </div>

        <div class="chat-features-card">
          <div class="icon-box"><i class="fa-solid fa-chart-line  akw-icon"></i></div>
          <h3>Boost Your Marketing ROI</h3>
          <p>Don’t let high-quality paid leads slip away—maximize every ad click by turning website visitors into engaged conversations</p>
        </div>

      </div>

    </div>
  </section>
@endsection
