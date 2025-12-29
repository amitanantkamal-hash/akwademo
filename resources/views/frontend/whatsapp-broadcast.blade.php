@extends('frontend.layout.master')
@section('title', 'whatsapp-broadcast')
@section('content')

<style>
  .icon i {
  font-size: 34px;
  color: #024430;
}

</style>
  <!-- HERO -->
  <section class="hero">
    <div class="hero-left">
      <div class="eyebrow">
        <h1>Amplify your reach with our WhatsApp Broadcast software</h1>
      </div>
      <p>Boost engagement with targeted, personalized, and automated campaigns, while keeping it human</p>
      <div class="hero-ctas">
        <a class="btn">Start Your Free Trial</a>
      </div>
    </div>

    <div class="hero-right">
      <img src="assets/imgs/images/whtup_broadcast/50.jpg" class="hero-image">
    </div>
  </section>

  <div class="trusted">
    <strong class="trusted-title">Trusted by businesses</strong>
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
    <h1>Top Features and Functionalities of WhatsApp Broadcast Solutions</h1>
    <div class="f-container">

      <!-- Row 1 -->
      <div class="f-row">
        <div class="f-col">
          <h3>Reach the audience that matters most</h3>
          <!--<p>Design high-converting chatbot journeys without writing any code.</p>-->
          <ul class="feature-list">
            <li><i class="fa-solid fa-circle-check" style="color: #0b63d8; margin-right: 10px;"></i>Upload contact lists or segment groups by opt-ins, tags, or demographics</li>
            <li><i class="fa-solid fa-circle-check" style="color: #0b63d8; margin-right: 10px;"></i>Craft relevant content using Meta-approved templates that resonate with each audience</li>
            <li><i class="fa-solid fa-circle-check" style="color: #0b63d8; margin-right: 10px;"></i>Test your messages with up to 10 sample contacts for flawless delivery</li>
          </ul>
        </div>
        <div class="f-col">
          <div class="feature-card card-bg-blue">
            <img src="assets/imgs/images/whtup_broadcast/51.jpg" class="responsive-img">
          </div>
        </div>
      </div>

      <hr style="margin:50px 0">

      <!-- Row 2 -->
      <div class="f-row">
        <div class="f-col">
          <h3>Deliver your messages with perfect precision every time</h3>
          <!--<p>Automate WhatsApp sequences to achieve up to 45% higher engagement and conversions compared to email.</p>-->
          <ul class="feature-list">
            <li><i class="fa-solid fa-circle-check" style="color: #0b63d8; margin-right: 10px;"></i>Automatically resend undelivered messages (up to 3 attempts) on your chosen date</li>
            <li><i class="fa-solid fa-circle-check" style="color: #0b63d8; margin-right: 10px;"></i>Schedule campaigns to send at the most effective times for maximum impact</li>
            <li><i class="fa-solid fa-circle-check" style="color: #0b63d8; margin-right: 10px;"></i>Edit or cancel broadcasts anytime with ease</li>
          </ul>
        </div>
        <div class="f-col">
          <div class="feature-card card-bg-orange">
            <img src="assets/imgs/images/whtup_broadcast/52.jpg" class="responsive-img">
          </div>
        </div>
      </div>

      <hr style="margin:50px 0">

      <div class="f-row">
        <div class="f-col">
          <h3>Verified templates to suit every communication need</h3>
          <!--<p>Keep your customers updated with automated notifications.</p>-->
          <ul class="feature-list">
            <li><i class="fa-solid fa-circle-check" style="color: #0b63d8; margin-right: 10px;"></i>Ready-to-use templates for notifications, alerts, and updates</li>
            <li><i class="fa-solid fa-circle-check" style="color: #0b63d8; margin-right: 10px;"></i>Select from utility (billing alerts), marketing (promotions), or authentication (OTPs) templates to match your objective</li>
            <li><i class="fa-solid fa-circle-check" style="color: #0b63d8; margin-right: 10px;"></i>Add customer-specific details to make your messages feel personalized</li>
          </ul>
        </div>
        <div class="f-col">
          <div class="feature-card card-bg-blue">
            <img src="assets/imgs/images/whtup_broadcast/53.jpg" class="responsive-img">
          </div>
        </div>
      </div>

      <hr style="margin:50px 0">

      <div class="f-row">
        <div class="f-col">
          <h3>Optimize your processes effortlessly</h3>
          <!--<p>Our WhatsApp Business automation platform connects effortlessly with all your essential business tools.</p>-->
          <ul class="feature-list">
            <li><i class="fa-solid fa-circle-check" style="color: #0b63d8; margin-right: 10px;"></i>Create, track, and manage all broadcasts from a single dashboard.</li>
            <li><i class="fa-solid fa-circle-check" style="color: #0b63d8; margin-right: 10px;"></i>Automatically route replies to the appropriate team with smart assignment.</li>
            <li><i class="fa-solid fa-circle-check" style="color: #0b63d8; margin-right: 10px;"></i>Reassign conversations instantly to balance workloads efficiently.</li>
          </ul>
        </div>
        <div class="f-col">
          <div class="feature-card card-bg-orange">
            <img src="assets/imgs/images/540-623 wademo (1)/15.jpg" class="responsive-img">
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- <section class="why-whatsapp">
    <div class="container">
      <h2>Top Benefits of Using WADEMO WhatsApp Broadcast Solution</h2>
      <div class="cards">
        <div class="card">
          <div class="icon">📊</div>
          <h3>Boost opens, replies, and conversions.</h3>
          <p>Send personalized messages at scale by segmenting your audience, and watch engagement surpass email and SMS.</p>
        </div>
        <div class="card">
          <div class="icon">💬</div>
          <h3>Start your campaigns instantly</h3>
          <p>Manage, schedule, and track all your messages from a single dashboard—no manual effort, just quick and effective outreach</p>
        </div>
        <div class="card">
          <div class="icon">📢</div>
          <h3>Adjust campaigns in real time</h3>
          <p>Preview messages, track performance metrics, and optimize your strategy for better results—fully compliant</p>
        </div>
        <div class="card">
          <div class="icon">💲</div>
          <h3>Real-time updates and offers</h3>
          <p>Take advantage of WhatsApp’s high open rates for urgent alerts, and maintain engagement with smooth two-way conversations</p>
        </div>
      </div>
    </div>
  </section> -->

  <section class="why-whatsapp">
  <div class="container">
    <h2>Top Benefits of Using WADEMO WhatsApp Broadcast Solution</h2>

    <div class="cards">
      <div class="card">
        <div class="icon">
          <i class="fas fa-chart-line"></i>
        </div>
        <h3>Boost opens, replies, and conversions.</h3>
        <p>
          Send personalized messages at scale by segmenting your audience, and watch engagement surpass email and SMS.
        </p>
      </div>

      <div class="card">
        <div class="icon">
          <i class="fas fa-comments"></i>
        </div>
        <h3>Start your campaigns instantly</h3>
        <p>
          Manage, schedule, and track all your messages from a single dashboard—no manual effort, just quick and effective outreach
        </p>
      </div>

      <div class="card">
        <div class="icon">
          <i class="fas fa-bullhorn"></i>
        </div>
        <h3>Adjust campaigns in real time</h3>
        <p>
          Preview messages, track performance metrics, and optimize your strategy for better results—fully compliant
        </p>
      </div>

      <div class="card">
        <div class="icon">
          <i class="fas fa-hand-holding-dollar"></i>
        </div>
        <h3>Real-time updates and offers</h3>
        <p>
          Take advantage of WhatsApp’s high open rates for urgent alerts, and maintain engagement with smooth two-way conversations
        </p>
      </div>
    </div>
  </div>
</section>


  <!-- CTA SECTION -->
  <section class="cta-whatsapp-section">
    <h2 style="font-size: 40px;">How to get started?</h2>
    <div class="container">

      <div class="steps" id="steps">
        <div class="step active" data-img="assets/imgs/images/540-623 wademo (1)/8.jpg">
          <span class="icon"></span>
          <h4>Open the broadcast option</h4>
          <p>Log in to your Wademo account and navigate to the Broadcast area from the dashboard.</p>
        </div>
        <div class="step" data-img="assets/imgs/images/540-623 wademo (1)/10.jpg">
          <span class="icon"></span>
          <h4>Pick your contacts</h4>
          <p>Create a fresh broadcast group by selecting the contacts you wish to include.</p>
        </div>
        <div class="step" data-img="assets/imgs/images/540-623 wademo (1)/14.jpg">
          <span class="icon"></span>
          <h4>Write your message</h4>
          <p>Prepare the message and modify it according to what you want to send.</p>
        </div>

        <div class="step active" data-img="assets/imgs/images/540-623 wademo (1)/8.jpg">
          <span class="icon"></span>
          <h4>Send or schedule</h4>
          <p>You can either send the broadcast immediately or set a time to send it later.</p>
        </div>
      </div>

      <div class="preview-image">
        <img id="previewImg" src="assets/imgs/images/540-623 wademo (1)/8.jpg" alt="Preview">
      </div>
    </div>
  </section>


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