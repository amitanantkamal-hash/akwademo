@extends('frontend.layout.master')
@section('title', 'Whatsapp QR')
@section('content')

<style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      /* font-family: 'Inter', sans-serif; */
    }

    body {
      background: #ffffff;
      color: #1a1a1a;
      line-height: 1.6;
    }

    /* ------------------------ HERO SECTION ------------------------ */
    .section-hero {
      padding: 60px 20px;
      max-width: 1200px;
      margin: auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 30px;
    }

    .hero-content-left h1 {
      /* font-size: 32px;
      font-weight: 700;
      color: #0b305b;
      margin-bottom: 15px; */
          /* font-size: 48px; */
    /* font-weight: 700; */
    /* color: #0b305b; */
     font-size: 40px;
    color: #064431;
    /* max-width: 550px; */
    margin-bottom: 25px;
    font-weight: 700 !important;
    line-height: 56px;
    }

    .hero-content-left p {
      /* font-size: 16px;
      color: #333;
      max-width: 450px;
      margin-bottom: 25px; */
          font-size: 16px;
    color: #3D565F;
    max-width: 550px;
    margin-bottom: 25px;
    font-size: 16px;
    line-height: 24px;
    }

    .hero-content-left .btn {
      /* background: #0b63d8; */
        background: #064431;
    color: #fbe3bb;
      /* color: #fff; */
      padding: 12px 22px;
      border-radius: 8px;
      font-weight: 600;
      border: none;
      cursor: pointer;
      transition: 0.3s;
    }

    .hero-content-left .btn:hover {
      background: #064431;
    }

    .hero-content-right img {
      width: 885px;
      max-width: 100%;
      border-radius: 12px;
    }

    /* ------------------------ WHY SECTION ------------------------ */
    .section-why {
      padding: 40px 20px;
      max-width: 1200px;
      margin: auto;
      display: flex;
      align-items: flex-start;
      gap: 50px;
    }

    .why-image-box img {
      width: 645px;
      max-width: 100%;
      border-radius: 12px;
    }

    .why-content-box h2 {
      /* font-size: 30px;
      font-weight: 700;
      color: black;
      margin-bottom: 15px; */
          font-size: 30px;
    font-weight: 700;
    color: #064431;
    margin-bottom: 15px;
    line-height: 48px;
    }

    .why-content-box p span {
      /* font-weight: 600;
      color: black;
      font-size: 25px; */
          font-weight: 500;
    color: #064431;
    font-size: 25px;
    }

    .why-content-box p {
      /* margin-bottom: 16px; */
      margin-bottom: 25px;
    line-height: 28px;
    }

    /* ------------------------ STEPS SECTION ------------------------ */
    .section-qr-steps {
      background: #eafaf0;
      padding: 60px 20px 120px;
      text-align: center;
    }

    .section-qr-steps h2 {
      font-size: 26px;
      font-weight: 700;
      color: #064431;
    }

    .subtext {
      margin-top: 8px;
      color: #333;
      font-size: 15px;
    }

    .qr-steps-wrapper {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 24px;
  margin-top: 40px;
  flex-wrap: wrap;
}

.qr-step-item {
  max-width: 260px;
  text-align: center;
}

.qr-step-circle {
  width: 48px;
  height: 48px;
  background: #024430;
  color: #fff;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
  margin: 0 auto 12px;
}

.qr-step-item h3 {
  font-size: 18px;
  margin-bottom: 8px;
  line-height: 24px;
}

.qr-step-item p {
  font-size: 14px;
  color: #555;
}

.qr-step-arrow {
  font-size: 24px;
  color: #024430;
}

    /* FORM BOX */
    .qr-form-container {
      background: #fff;
      max-width: 450px;
      margin: 40px auto;
      padding: 25px;
      border-radius: 12px;
      border: 1px solid #e1e1e1;
      box-shadow: 0 4px 18px rgba(0, 0, 0, 0.05);
      text-align: left;
    }

    .qr-form-container label {
      font-weight: 600;
      font-size: 14px;
    }

    .qr-input-group {
      display: flex;
      align-items: center;
      background: #fff;
      border: 1px solid #ccc;
      border-radius: 8px;
      margin: 8px 0 18px;
      padding: 10px;
    }

    .qr-input-group input {
      border: none;
      outline: none;
      width: 100%;
      font-size: 14px;
    }

    .qr-form-container textarea {
      width: 100%;
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 10px;
      height: 80px;
      font-size: 14px;
      margin: 8px 0 18px;
      outline: none;
    }

    .generate-btn {
      width: 100%;
      /* background: #00c853; */
      background:#064431;
      color: #fff;
      padding: 12px;
      font-weight: 700;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 15px;
    }

    /* ------------------------ TRUST SECTION ------------------------ */
    .section-trust {
      text-align: center;
      padding: 60px 20px;
    }

    .trust-section-title {
      font-size: 30px;
      font-weight: 700;
      margin-bottom: 10px;
      /* color: #111; */
      color:#064431;
    }

    .trust-section-title span {
      color: #0a73ff;
    }

    .trust-section-subtitle {
      max-width: 800px;
      margin: 0 auto 40px;
      font-size: 15px;
      color: #555;
      line-height: 1.6;
    }

    .trust-features-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 30px;
      max-width: 1100px;
      margin: auto;
    }

    .trust-feature-card {
      background: #fff;
      padding: 20px 15px;
      text-align: center;
      border-radius: 10px;
      transition: all 0.35s ease;
      cursor: pointer;
      border: 1px solid #e5e5e5;
    }

    .trust-feature-card:hover {
      transform: translateY(-8px) scale(1.03);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.10);
      border-color: #0a73ff;
    }

    .trust-feature-icon img {
      width: 40px;
      margin-bottom: 10px;
    }

    .trust-feature-card h3 {
      font-size: 17px;
      font-weight: 600;
      margin-bottom: 10px;
    }

    .trust-feature-card p {
      font-size: 14px;
      color: #666;
      line-height: 1.5;
    }

    /* Responsive */
    @media(max-width:900px) {
      .why-content-box h2{
        text-align:left;
      }

      .why-content-box p{
   text-align:left;
}

      .hero-content-left p{
        text-align:left;
      }
      .hero-content-left h1{
        text-align: left; 
      }
      .section-hero {
        flex-direction: column;
        text-align: center;
      }

      .section-why {
        flex-direction: column;
        text-align: center;
      }

      .qr-steps-wrapper {
        flex-direction: column;
        gap: 25px;
      }

      .qr-step-arrow {
        display: none;
      }

      .qr-step-item {
        width: 100%;
      }
    }

    @media (max-width: 992px) {
      .trust-features-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 600px) {
            .why-content-box h2{
        text-align:left;
        }

      .why-content-box p{
        text-align:left;
      }

      .hero-content-left p{
        text-align:left;
      }

      .hero-content-left p{
        text-align:left;
      }
      .trust-features-grid {
        grid-template-columns: 1fr;
      }

      .trust-section-title {
        font-size: 24px;
      }
    }

    .trust-feature-icon {
    font-size: 40px;
        color: #024430; /* Updated color */
        margin-bottom: 15px;
    }

  </style>

  <!-- ======================== HERO SECTION ======================== -->
  <section class="section-hero">
    <div class="hero-content-left">
      <h1>Generate Free WhatsApp Links for Quick Customer Engagement</h1>
      <p>Increase sales and foster meaningful connections with WADEMO WhatsApp Link Generator. Enhance customer satisfaction and maximize business impact by giving your customers a direct line to reach you instantly!</p>
      <button class="btn">Generate Links Now</button>
    </div>

    <div class="hero-content-right">
      <img src="assets/imgs/images/whtup_link_genertor/35.jpg">
    </div>
  </section>

  <!-- ======================== WHY SECTION ======================== -->
  <section class="section-why">
    <div class="why-image-box">
      <img src="assets/imgs/images/whtup_link_genertor/36.jpg">
    </div>

    <div class="why-content-box">
      <h2>Why Use a WhatsApp Link Generator?</h2>
      
      <p><span>Connect Instantly With Your Audience</span><br>
Create a direct WhatsApp link in just a few simple steps, allowing anyone—even without your saved number—to start a conversation with your business immediately     </p>

      <p><span>Simplify & Streamline Your Operations</span><br>
        Enhance your communication workflow, improve customer engagement, and deliver a smooth support experience by enabling instant access to your WhatsApp Business chat</p>

      <p><span>Maximize Your Revenue Potential</span><br>
        Unlock new growth opportunities, accelerate sales, and increase profitability by leveraging personalised WhatsApp business links that convert more users into paying customers</p>
    </div>
  </section>

  <!-- ======================== STEPS SECTION ======================== -->
  <section class="section-qr-steps">

    <h2>How to Create a WhatsApp Business QR Code in 3 Easy Steps?</h2>
    <p class="subtext">
      Follow three quick steps to instantly generate a WhatsApp QR code through Anantkamal Wademo.
    </p>

    <!-- Steps Row -->
    <div class="qr-steps-wrapper">

  <div class="qr-step-item">
    <div class="qr-step-circle">1</div>
    <h3>Provide Your Details</h3>
    <p>Simply input your WhatsApp Business number in WADEMO WhatsApp Link Generator</p>
  </div>

  <div class="qr-step-arrow">
    <i class="fa-solid fa-arrow-right"></i>
  </div>

  <div class="qr-step-item">
    <div class="qr-step-circle">2</div>
    <h3>Personalize Your Link</h3>
    <p>Write a unique message to accompany your WhatsApp link for a more engaging touch</p>
  </div>

  <div class="qr-step-arrow">
    <i class="fa-solid fa-arrow-right"></i>
  </div>

  <div class="qr-step-item">
    <div class="qr-step-circle">3</div>
    <h3>Build a Personalized WhatsApp Chat Link</h3>
    <p>Simply hit 'Generate Link' to get your free, unique chat link</p>
  </div>

</div>


    <!-- Form Box -->
    <div class="qr-form-container">

      <label>Enter your WhatsApp number</label>
      <div class="qr-input-group">
        <span class="icon">📞</span>
        <input type="text" placeholder="Your phone number">
      </div>

      <label>Add your custom message</label>
      <textarea placeholder="Add custom message that users will send to you..."></textarea>

      <button class="generate-btn">Generate My Link</button>

    </div>

  </section>

  <!-- ======================== TRUST SECTION ======================== -->
  <section class="section-trust">

    <h2 class="trust-section-title">
      Why Businesses Everywhere Choose Anantkamal WADEMO
    </h2>

    <p class="trust-section-subtitle">
      Anantkamal Wademo is a powerful solution for generating WhatsApp QR codes and enhancing WhatsApp automation
      workflows. Explore why businesses rely on us for reliable messaging automation:
    </p>

    <div class="trust-features-grid">

    <div class="trust-feature-card">
        <div class="trust-feature-icon"><i class="fa-solid fa-chart-line"></i></div>
        <h3>Boost Your Sales Funnel</h3>
        <p>Send tailored messages based on user behavior and past actions to convert more leads.</p>
    </div>

    <div class="trust-feature-card">
        <div class="trust-feature-icon"><i class="fa-solid fa-gears"></i></div>
        <h3>Enhance Operational Efficiency</h3>
        <p>Automate repetitive communications so your team can concentrate on critical work.</p>
    </div>

    <div class="trust-feature-card">
        <div class="trust-feature-icon"><i class="fa-solid fa-bullseye"></i></div>
        <h3>Implement Smart Marketing Campaigns</h3>
        <p>Launch automated WhatsApp promotions that reach the right audience at the right time.</p>
    </div>

    <div class="trust-feature-card">
        <div class="trust-feature-icon"><i class="fa-solid fa-handshake"></i></div>
        <h3>Enhance Customer Satisfaction</h3>
        <p>Engage users with timely reminders, notifications, and interactive content.</p>
    </div>

    <div class="trust-feature-card">
        <div class="trust-feature-icon"><i class="fa-solid fa-comments"></i></div>
        <h3>Unify All Customer Conversations</h3>
        <p>Oversee every customer inquiry in a single dashboard for faster response and clarity.</p>
    </div>

    <div class="trust-feature-card">
        <div class="trust-feature-icon"><i class="fa-solid fa-arrow-trend-up"></i></div>
        <h3>Increase Revenue Effectively</h3>
        <p>Drive ad visitors directly to WhatsApp to lower lead costs and increase ROI.</p>
    </div>

    </div>

  </section>


@endsection