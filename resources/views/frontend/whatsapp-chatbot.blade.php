@extends('frontend.layout.master')
@section('title', 'whatsapp Chatbot')
@section('content')

<style>
  .icon i {
  font-size: 36px;
  color: #064431; /* WhatsApp green */
  margin-bottom: 15px;
}

</style>

  <!-- HERO -->
  <section class="hero">
    <div class="hero-left">
      <div class="eyebrow">
        <h1>Double Your ROI with Anantkamal WADEMO Chatbots</h1>
      </div>
      <p>Launch AI-powered chatbots to answer customer queries, qualify leads, and deliver key information — saving you
        time and boosting efficiency.</p>
      <div class="hero-ctas">
        <a class="btn">Start Your Free Trial</a>
      </div>
    </div>

    <div class="hero-right">
      <img src="assets/imgs/images/whtup_chatsbot/37.jpg" class="hero-image">
    </div>
  </section>

  <div class="trusted">
    <strong class="trusted-title">Trusted by businesses </strong>
    <div class="carousel-container">
      <div class="carousel-track">
        <!-- First set of logos -->
        <div class="carousel-logo">
          <img src="assets/imgs/images/brand1.png" alt="Brand 1" loading="lazy">
        </div>
        <div class="carousel-logo">
          <img src="assets/imgs/images/brand2.png" alt="Brand 2" loading="lazy">
        </div>
        <div class="carousel-logo">
          <img src="assets/imgs/images/brand3.png" alt="Brand 3" loading="lazy">
        </div>
        <div class="carousel-logo">
          <img src="assets/imgs/images/brand4.png" alt="Brand 4" loading="lazy">
        </div>
        <div class="carousel-logo">
          <img src="assets/imgs/images/brand6.png" alt="Brand 6" loading="lazy">
        </div>
        <div class="carousel-logo">
          <img src="assets/imgs/images/brand7.png" alt="Brand 7" loading="lazy">
        </div>
        <div class="carousel-logo">
          <img src="assets/imgs/images/brand8.png" alt="Brand 8" loading="lazy">
        </div>
        <div class="carousel-logo">
          <img src="assets/imgs/images/brand9.png" alt="Brand 9" loading="lazy">
        </div>

        <!-- Duplicate set for seamless loop -->
        <div class="carousel-logo">
          <img src="assets/imgs/images/brand1.png" loading="lazy" alt="">
        </div>
        <div class="carousel-logo">
          <img src="assets/imgs/images/brand2.png" alt="Brand 2" loading="lazy">
        </div>
        <div class="carousel-logo">
          <img src="assets/imgs/images/brand3.png" alt="Brand 3" loading="lazy">
        </div>
        <div class="carousel-logo">
          <img src="assets/imgs/images/brand4.png" alt="Brand 4" loading="lazy">
        </div>
        <div class="carousel-logo">
          <img src="assets/imgs/images/brand6.png" alt="Brand 6" loading="lazy">
        </div>
        <div class="carousel-logo">
          <img src="assets/imgs/images/brand7.png" alt="Brand 7" loading="lazy">
        </div>
        <div class="carousel-logo">
          <img src="assets/imgs/images/brand8.png" alt="Brand 8" loading="lazy">
        </div>
        <div class="carousel-logo">
          <img src="assets/imgs/images/brand9.png" alt="Brand 9" loading="lazy">
        </div>
      </div>
    </div>
  </div>



  <!-- FEATURES -->
  <section class="feature-section">
    <h1>Main Features and Capabilities of the WhatsApp Chatbot Platform</h1>
    <div class="f-container">

      <!-- Row 1 -->
      <div class="f-row">
        <div class="f-col">
          <h3>Smart AI conversations</h3>
          <p>Move past generic greetings—make every response feel genuinely human</p>
          <ul class="feature-list">
            <li><i class="fa-solid fa-circle-check" style="color: #0b63d8; margin-right: 10px;"></i>Leverage ChatGPT to transform scripted replies into dynamic, context-aware conversations</li>
            <li><i class="fa-solid fa-circle-check" style="color: #0b63d8; margin-right: 10px;"></i>Personalize chats using customer data and past interactions for a tailored experience</li>
            <li><i class="fa-solid fa-circle-check" style="color: #0b63d8; margin-right: 10px;"></i>Instantly correct translation errors to eliminate “Sorry, I don’t understand” moments</li>
            </ul>
        </div>
        <div class="f-col">
          <div class="feature-card card-bg-blue">
            <img src="assets/imgs/images/whtup_chatsbot/38.jpg" class="responsive-img">
          </div>
        </div>
      </div>

      <hr style="margin:50px 0">

      <!-- Row 2 -->
      <div class="f-row">
        <div class="f-col">
          <h3>Replace recurring questions with 24/7 automated bot support</h3>
          <p>Create smart chatbots without any coding</p>
          <ul class="feature-list">
            <li><i class="fa-solid fa-circle-check" style="color: #0b63d8; margin-right: 10px;"></i>Design drag-and-drop workflows for order updates, booking confirmations, or returns in minutes</li>
            <li><i class="fa-solid fa-circle-check" style="color: #0b63d8; margin-right: 10px;"></i>Support customers in 90+ languages, 24/7, without expanding your support team</li>
            <li><i class="fa-solid fa-circle-check" style="color: #0b63d8; margin-right: 10px;"></i>Free agents from repetitive queries like “Where’s my order?” so they can focus on complex issues</li>
          </ul>
        </div>
        <div class="f-col">
          <div class="feature-card card-bg-orange">
            <img src="assets/imgs/images/whtup_chatsbot/39.jpg" class="responsive-img">
          </div>
        </div>
      </div>

      <hr style="margin:50px 0">

      <div class="f-row">
        <div class="f-col">
          <h3>Make Selling effortless-Handle the Entire sales process directly in WhatsApp</h3>
          <p>Turn chats into seamless checkouts—no app switching required</p>
          <ul class="feature-list">
            <li><i class="fa-solid fa-circle-check" style="color: #0b63d8; margin-right: 10px;"></i>Display product catalogs directly in conversations, complete with prices, images, and SKUs</li>
            <li><i class="fa-solid fa-circle-check" style="color: #0b63d8; margin-right: 10px;"></i>Let customers select sizes, add items to their cart, and pay—all within WhatsApp</li>
            <li><i class="fa-solid fa-circle-check" style="color: #0b63d8; margin-right: 10px;"></i>Automatically send shipping updates and reorder reminders to drive repeat sales</li>
          </ul>
        </div>
        <div class="f-col">
          <div class="feature-card card-bg-blue">
            <img src="assets/imgs/images/whtup_chatsbot/40.jpg" class="responsive-img">
          </div>
        </div>
      </div>

      <hr style="margin:50px 0">

      <div class="f-row">
        <div class="f-col">
          <h3>Distribute leads like a pro—no micromanagement needed</h3>
          <p>Instantly route chats to the right representative</p>
          <ul class="feature-list">
            <li><i class="fa-solid fa-circle-check" style="color: #0b63d8; margin-right: 10px;"></i>Set smart rules to assign chats based on location, department, or agent availability</li>
            <li><i class="fa-solid fa-circle-check" style="color: #0b63d8; margin-right: 10px;"></i>Let bots qualify leads—like asking “What’s your budget?”—before passing warm prospects to sales</li>
            <li><i class="fa-solid fa-circle-check" style="color: #0b63d8; margin-right: 10px;"></i>Balance workloads automatically by rotating chat assignments among team members</li>
          </ul>
        </div>
        <div class="f-col">
          <div class="feature-card card-bg-orange">
            <img src="assets/imgs/images/whtup_chatsbot/41.jpg" class="responsive-img">
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- BENEFITS -->
  <!-- <section class="benefits-section">
  <h2 class="benefits-title">Unlock the Benefits of WhatsApp Business Automation</h2>
  <div class="benefits-container">
    
    <div class="benefits-left">
      
      <div class="benefit-item active" data-image="img1">
        <h3>Automate Your Lead Qualification</h3>
        <p>Qualify leads around the clock and free your sales team from repetitive back-and-forth. Use chatbots to automatically assess prospects and deliver warm, high-value leads that are more likely to convert.</p>
      </div>
      <div class="benefit-item" data-image="img2">
        <h3>Leverage Agentic AI to Drive Conversions</h3>
        <p>Qualify leads 24/7 and free your sales team from repetitive follow-ups. Automate lead qualification with chatbots to deliver warm, high-value prospects ready to convert.</p>
      </div>
      <div class="benefit-item" data-image="img3">
        <h3>Save Time and Boost ROI</h3>
        <p>Automate responses to common customer and prospect queries. Create conversation flows that guide users seamlessly through the support process. Route interactions from Click-to-WhatsApp ads, QR codes, and web widgets to the right bot or team automatically.</p>
      </div>
    </div>

    <div class="benefits-right">
      <div class="image-box">
        <img id="benefitImage" src="assets/imgs/images/540-623 wademo (1)/8.jpg" alt="">
      </div>
    </div>
  </div>
</section> -->

  <!-- <section class="why-whatsapp">
    <div class="container">
      <h2 style="color: white;">Getting Started with a WhatsApp Chatbot Platform</h2>
      <div class="cards">
        <div class="card">
          <div class="icon">📊</div>
          <h3>Qualify Leads Around the Clock</h3>
          <p>Your chatbot automatically screens prospects with key questions like ‘Budget?’ and ‘Timeline?’, 
            routes high-potential leads to your sales team, and nurtures interested buyers with personalized content — all without manual effort</p>
        </div>
        <div class="card">
          <div class="icon">💬</div>
          <h3>Handle Routine Queries Automatically</h3>
          <p>Let bots manage tracking, returns, and FAQs with visual guides, while your team concentrates on critical issues such as refunds or churn prevention</p>
        </div>
        <div class="card">
          <div class="icon">📢</div>
          <h3>Engage and Nurture Effortlessly</h3>
          <p>Automatically deliver rich-media guides (videos, PDFs) the moment prospects reach out. No delays, no unanswered queries — achieve reply rates exceeding 90%</p>
        </div>
        <div class="card">
          <div class="icon">💲</div>
          <h3>Showcase Products with Maximum Impact</h3>
          <p>Showcase Catalogs, Demos, and Guides Eliminate dead links and boost engagement up to 5X by sharing product PDFs, sending video tutorials, or embedding pricing directly within chats</p>
        </div>
      </div>
    </div>
  </section> -->

  <section class="why-whatsapp">
  <div class="container">
    <h2 style="color: white;">Getting Started with a WhatsApp Chatbot Platform</h2>

    <div class="cards">
      <div class="card">
        <div class="icon">
          <i class="fa-solid fa-chart-line"></i>
        </div>
        <h3>Qualify Leads Around the Clock</h3>
        <p>
          Your chatbot automatically screens prospects with key questions like ‘Budget?’ and ‘Timeline?’,
          routes high-potential leads to your sales team, and nurtures interested buyers with personalized content — all without manual effort
        </p>
      </div>

      <div class="card">
        <div class="icon">
          <i class="fa-solid fa-comments"></i>
        </div>
        <h3>Handle Routine Queries Automatically</h3>
        <p>
          Let bots manage tracking, returns, and FAQs with visual guides, while your team concentrates on critical issues such as refunds or churn prevention
        </p>
      </div>

      <div class="card">
        <div class="icon">
          <i class="fa-solid fa-bullhorn"></i>
        </div>
        <h3>Engage and Nurture Effortlessly</h3>
        <p>
          Automatically deliver rich-media guides (videos, PDFs) the moment prospects reach out.
          No delays, no unanswered queries — achieve reply rates exceeding 90%
        </p>
      </div>

      <div class="card">
        <div class="icon">
          <i class="fa-solid fa-tags"></i>
        </div>
        <h3>Showcase Products with Maximum Impact</h3>
        <p>
          Showcase catalogs, demos, and guides. Eliminate dead links and boost engagement up to 5X
          by sharing product PDFs, video tutorials, or embedded pricing directly within chats
        </p>
      </div>
    </div>
  </div>
</section>


  <!-- CTA SECTION -->
  <!--<section class="cta-whatsapp-section">-->
  <!--  <h2 style="font-size: 40px;">Getting started with AnantKamal WADEMO is simple</h2>-->
  <!--  <div class="container">-->

  <!--    <div class="steps" id="steps">-->
  <!--      <div class="step active" data-img="assets/imgs/images/540-623 wademo (1)/8.jpg">-->
  <!--        <span class="icon">🟦</span>-->
  <!--        <h4>Get Started with AnantKamal WADEMO</h4>-->
  <!--        <p>Sign up and connect your WhatsApp Business number. Complete your business profile to build credibility with-->
  <!--          your customers.</p>-->
  <!--      </div>-->
  <!--      <div class="step" data-img="assets/imgs/images/540-623 wademo (1)/10.jpg">-->
  <!--        <span class="icon">🟦</span>-->
  <!--        <h4>Create your first automation</h4>-->
  <!--        <p>Choose from our library of ready-to-use chatbot and broadcast templates. Customize existing flows to match-->
  <!--          your brand voice and business needs, or create your own bots from scratch using our AI bot builder.</p>-->
  <!--      </div>-->
  <!--      <div class="step" data-img="assets/imgs/images/540-623 wademo (1)/14.jpg">-->
  <!--        <span class="icon">🟦</span>-->
  <!--        <h4>Launch and optimize</h4>-->
  <!--        <p>Once your bot’s conversation flow is ready, hit “Publish”. Test each flow before going live, then monitor-->
  <!--          performance metrics and optimize your automation using real-time data.</p>-->
  <!--      </div>-->
  <!--    </div>-->

  <!--    <div class="preview-image">-->
  <!--      <img id="previewImg" src="assets/imgs/images/540-623 wademo (1)/8.jpg" alt="Preview">-->
  <!--    </div>-->
  <!--  </div>-->
  <!--</section>-->


  <script>
    function autoSlider(slider) {
      let timeout;
      let clearNextTimeout = () => clearTimeout(timeout);

      let nextTimeout = () => {
        clearTimeout(timeout);
        timeout = setTimeout(() => slider.next(), 1800);
      };

      slider.on("created", () => {
        slider.container.addEventListener("mouseover", clearNextTimeout);
        slider.container.addEventListener("mouseout", nextTimeout);
        nextTimeout();
      });
    }

    const trustedSlider = new KeenSlider("#trustedSlider", {
      loop: true,
      renderMode: "performance",
      slides: {
        perView: 4,
        spacing: 10,
      },
      breakpoints: {
        "(max-width: 900px)": {
          slides: { perView: 3, spacing: 10 },
        },
        "(max-width: 600px)": {
          slides: { perView: 2, spacing: 8 },
        },
      },
    }, [autoSlider]);
  </script>

  <script>
    const items = document.querySelectorAll(".benefit-item");
    const img = document.getElementById("benefitImage");

    const images = {
      img1: "assets/imgs/images/540-623 wademo (1)/8.jpg",
      img2: "assets/imgs/images/540-623 wademo (1)/10.jpg",
      img3: "assets/imgs/images/540-623 wademo (1)/14.jpg",
    };

    items.forEach(item => {
      item.addEventListener("click", () => {

        // remove active from all
        items.forEach(i => i.classList.remove("active"));

        // activate clicked one
        item.classList.add("active");

        // fade-out animation
        img.style.opacity = 0;

        setTimeout(() => {
          img.src = images[item.dataset.image]; // switch image
          img.style.opacity = 1; // fade-in
        }, 200);
      });
    });
  </script>


  <script>
    const steps = document.querySelectorAll(".step");
    const previewImg = document.getElementById("previewImg");
    let currentIndex = 0;
    let interval;

    // Function to set active step
    function activateStep(index) {
      steps.forEach(step => step.classList.remove("active"));
      steps[index].classList.add("active");

      const newImg = steps[index].getAttribute("data-img");
      previewImg.src = newImg;
    }

    // Auto rotate function
    function startAutoSlide() {
      interval = setInterval(() => {
        currentIndex = (currentIndex + 1) % steps.length;
        activateStep(currentIndex);
      }, 4000); // change every 4 seconds
    }

    // Handle click event
    steps.forEach((step, index) => {
      step.addEventListener("click", () => {
        clearInterval(interval);     // pause auto-slide on click
        currentIndex = index;
        activateStep(currentIndex);
        startAutoSlide();            // resume auto-rotate
      });
    });

    // Initialize
    activateStep(currentIndex);
    startAutoSlide();
  </script>
@endsection
