@extends('frontend.layout.master')
@section('title', 'WhatsApp Pricing Calculator')
@section('content')  
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Inter", sans-serif;
    }

    body {
      background: #f5f8ff;
      color: #1f1f1f;
            text-transform: capitalize;
    }

    /* MAIN CONTAINER */
    .main-container {
      width: 90%;
      max-width: 1250px;
      margin: auto;
      padding: 60px 0;
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 50px;
      flex-wrap: wrap;
    }

    /* LEFT TEXT BOX */
    .left-box {
      flex: 1;
      min-width: 300px;
      max-width: 600px;
    }

    .left-box h1 {
      font-size: 45px;
      font-weight: 800;
      line-height: 1.2;
      margin: 20px 0;
    }

    .left-box p {
      color: #444;
      font-size: 17px;
      line-height: 1.6;
    }

    /* NOTE BOX */
    .note-box {
      margin-top: 35px;
      background: #fff;
      border-radius: 14px;
      padding: 18px 20px;
      display: flex;
      gap: 12px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    }

    .note-box h4 {
      font-size: 16px;
      font-weight: 700;
      margin-bottom: 6px;
    }

    .note-box p {
      font-size: 15px;
      color: #555;
    }

    /* CALCULATOR */
    .calc-box {
      width: 420px;
      min-width: 300px;
      background: #fff;
      border-radius: 16px;
      padding: 28px;
      box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
    }

    .calc-box label {
      font-size: 15px;
      font-weight: 600;
      margin-bottom: 6px;
      display: block;
    }

    .select-country {
      width: 100%;
      padding: 12px;
      border-radius: 10px;
      border: 1px solid #d3d9e4;
      font-size: 15px;
      margin-bottom: 18px;
    }

    .radio-tabs {
      display: flex;
      gap: 25px;
      align-items: center;
      margin-bottom: 20px;
    }

    .radio-tabs label {
      font-weight: 600;
      font-size: 15px;
    }

    .row {
      margin: 15px 0;
    }

    .row .price-value {
      float: right;
      font-size: 15px;
      font-weight: 700;
      color: #064431;
    }

    input[type="range"] {
      width: 100%;
      appearance: none;
      height: 6px;
      border-radius: 5px;
      background: #e5e7ef;
      margin-top: 10px;
      outline: none;
    }

    input[type="range"]::-webkit-slider-thumb {
      appearance: none;
      height: 18px;
      width: 18px;
      border-radius: 50%;
      background: #064431;
      cursor: pointer;
    }

    /* TOGGLE */
    .switch {
      position: relative;
      display: inline-block;
      width: 46px;
      height: 22px;
      margin-left: 10px;
    }

    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: #ccc;
      border-radius: 34px;
      transition: .3s;
    }

    .slider:before {
      content: "";
      position: absolute;
      height: 18px;
      width: 18px;
      left: 3px;
      bottom: 2px;
      background: #fff;
      border-radius: 50%;
      transition: .3s;
    }

    input:checked+.slider {
      background: #064431;
    }

    input:checked+.slider:before {
      transform: translateX(22px);
    }

    .total-box {
      background: #064431;
      margin-top: 25px;
      padding: 14px;
      border-radius: 10px;
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: space-between;
      font-size: 20px;
      font-weight: 700;
    }

    /* MESSAGE SECTION */
    .message-types-section {
      padding: 80px 0;
      background: #fff;
    }

    .message-wrapper {
      width: 90%;
      max-width: 1250px;
      margin: auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 50px;
      flex-wrap: wrap;
    }

    .message-content {
      flex: 1;
      min-width: 300px;
    }

    .message-content h2 {
      font-size: 32px;
      margin-bottom: 15px;
      font-weight: 700;
    }

    .message-tabs {
      display: flex;
      gap: 12px;
      margin: 20px 0;
      flex-wrap: wrap;
    }

    .message-tabs .tab-btn {
      padding: 15px 20px;
      border-radius: 25px;
      border: 1px solid #dfe5f2;
      background: #fff;
      cursor: pointer;
      font-weight: 600;
      font-size: 15px;
      transition: .3s;
    }

    .message-tabs .tab-btn.active {
      background: #064431;
      color: #fff;
      border-color: #064431;
    }

    .message-image {
      flex: 1;
      text-align: center;
    }

    .message-image img {
      width: 350px;
      max-width: 100%;
      border-radius: 20px;
    }

    /* OPTIMIZE SECTION */
    /* Section */
.optimize-section {
    padding: 80px 20px;
    background: linear-gradient(180deg, #f8fffd, #ffffff);
}

/* Title */
.optimize-title {
    text-align: center;
    font-size: 40px;
    font-weight: 800;
    color: #064431;
    margin-bottom: 50px;
}

/* Cards Grid */
.optimize-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
    max-width: 1100px;
    margin: auto;
}

/* Card */
.optimize-card {
    background: #ffffff;
    border-radius: 18px;
    padding: 32px 28px;
    text-align: center;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    border: 1px solid #e7f0ee;
    transition: 0.35s ease;
}

/* Hover Animation */
.optimize-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 32px rgba(0,0,0,0.12);
    border-color: #bcd8d1;
}

/* Icon Wrapper */
.icon-wrapper {
    width: 72px;
    height: 72px;
    background: #e8f6f2;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: auto;
    margin-bottom: 18px;
    transition: 0.3s ease;
}

.optimize-card:hover .icon-wrapper {
    background: #d9f4ec;
    transform: scale(1.08);
}

/* Icon */
.icon-wrapper i {
    font-size: 34px;
    color: #024430;
}

/* Text */
.optimize-card h4 {
    font-size: 20px;
    font-weight: 700;
    color: #024430;
    margin-bottom: 10px;
}

.optimize-card p {
    color: #475467;
    font-size: 15px;
    line-height: 1.5;
}

/* Responsive */
@media(max-width: 480px) {
    .optimize-title {
        font-size: 30px;
    }
}

    /* RESPONSIVE */
    @media(max-width:900px) {
      .main-container {
        flex-direction: column;
        text-align: center;
      }

      .left-box h1 {
        font-size: 32px;
      }

      .calc-box {
        width: 100%;
      }

      .message-wrapper {
        flex-direction: column;
        text-align: center;
      }
    }

    @media(max-width:600px) {
      .message-tabs {
        justify-content: center;
      }

      h2 {
        font-size: 26px;
      }
    }

    .card-premium {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            padding: 30px;
        }

        .type-pill {
            border-radius: 999px;
            background: #eef2f7;
            padding: 8px 18px;
            margin-right: 8px;
            cursor: pointer;
            transition: 0.25s;
            font-weight: 500;
        }

        .type-pill.active {
            background: #064431;
            color: white;
        }

        .info-card {
            background: white;
            border-radius: 14px;
            padding: 26px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .info-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 6px 22px rgba(0, 0, 0, 0.1);
        }

                .output-box {
            /* background: #eef4ff; */
              background: #beeddf;
            padding: 20px;
            border-radius: 14px;
            border-left: 5px solid #064431;
            margin-bottom: 16px;
        }

        select,
        input[type="range"] {
            border-radius: 10px !important;
        }

        .optimize-icon {
    font-size: 42px;
    color: #024430;     /* Your required color */
    margin-bottom: 14px;
    display: block;
}

  </style>
</head>

<body>

  <section class="hero">
    <div class="hero-left">
      <!-- <h5 style="font-size:15px;font-weight:700;">WhatsApp Business API Pricing Calculator</h5> -->
      <h1>Get an instant, accurate estimate of your WhatsApp Business API costs</h1>

      <p>This smart pricing calculator helps you strategically forecast campaign costs, plan your spending more
        effectively, and identify opportunities to optimise budget usage.</p>

      <div class="note-box">
        <div>💡</div>
        <div>
          <h4>Keep in mind:</h4>
          <p>Pricing is based on Meta’s official rates and may vary depending on your Business Solution Provider (BSP). Currency conversion and additional payment gateway fees may apply.</p>
        </div>
      </div>
    </div>
    <div class="hero-right">
      <img src="assets/imgs/images/whatsapp_flow.jpg" class="hero-image">
    </div>
  </section>
  
  <!-- CALCULATOR -->
    <section class="py-5" id="calculator">
        <div class="container">
            <div class="card-premium">

                <h3 class="fw-bold mb-2">Estimate Your WhatsApp Conversation Costs</h3>
                <p class="text-muted mb-4">Powered by Meta's official global pricing.</p>

                <div class="row">
                    <div class="col-lg-6">

                        <!-- COUNTRY -->
                        <label class="fw-semibold mb-1">Select Country</label>
                        <select class="form-select mb-4" id="countrySelector">
                        </select>

                        <!-- TYPE -->
                        <label class="fw-semibold mb-1">Conversation Category</label>
                        <div class="d-flex flex-wrap mb-3" id="typePills">
                            <div class="type-pill active" data-type="marketing">Marketing</div>
                            <div class="type-pill" data-type="utility">Utility</div>
                            <div class="type-pill" data-type="authentication">Authentication</div>
                            <div class="type-pill" data-type="service">Service</div>
                        </div>
                        <p class="text-muted small" id="typeDescription">Promotional campaigns, offers, product announcements.</p>

                        <!-- VOLUME -->
                        <label class="fw-semibold mb-1">Monthly Conversations</label>
                        <input type="range" class="form-range" min="0" max="100000" step="100" value="1200"
                            id="volumeSlider">
                        <p class="small text-muted">Estimated volume: <b id="volumeDisplay">1200</b></p>

                    </div>

                    <div class="col-lg-6">

                        <div class="output-box">
                            <h6 class="fw-bold">Meta Rate</h6>
                            <p class="fs-3 fw-bold mb-0"><span id="currencySymbol">₹</span><span
                                    id="rateValue">0.50</span></p>
                            <p class="text-muted small">Per conversation cost based on region & category.</p>
                        </div>

                        <div class="output-box">
                            <h6 class="fw-bold">Estimated Monthly Cost</h6>
                            <p class="fs-3 fw-bold mb-0"><span id="currencySymbol2">₹</span><span
                                    id="totalValue">600</span></p>
                            <p class="text-muted small" id="formulaText">0.50 × 1200 conversations</p>
                        </div>

                        <div class="output-box">
                            <h6 class="fw-bold">Billing Notes</h6>
                            <p id="billingNote" class="small mb-0 text-muted">
                                Utility conversations may be free inside the 24-hour service window.
                            </p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

  <!-- MESSAGE TYPE SECTION -->
  <!-- <section class="message-types-section">
    <div class="message-wrapper">

      <div class="message-content">
        <h2>Varieties of Messages</h2>
        <p>WhatsApp conversations fall into four main categories, each with unique pricing tailored to customer
          engagement and region:</p>

        <div class="message-tabs">
          <button class="tab-btn active" data-type="marketing">Marketing</button>
          <button class="tab-btn" data-type="utility">Utility</button>
          <button class="tab-btn" data-type="authentication">Authentication</button>
          <button class="tab-btn" data-type="service">Service</button>
        </div>

        <div class="msg" style="padding:20px;">
          <h4 id="msgTitle" style="padding:10px;">Marketing</h4>
          <p id="msgDesc" style="padding:10px;">✅Designed for promotional and engagement-driven messaging to boost customer interest and sales.
          </p>
          <ul id="msgList" style="list-style: none;padding:10px;">
            <li> ✅Examples: Promotional offers, abandoned cart reminders, customer re-targeting.</li>
          </ul>
        </div>
      </div>

      <div class="message-image">
        <img src="assets/imgs/images/540-623 wademo (1)/8.jpg" alt="Whatsapp Mockup">
      </div>

    </div>
  </section> -->

  <!-- OPTIMIZE SECTION -->
<section class="optimize-section">
    <div class="optimize-section-container">
        <h2 class="optimize-title">Optimize Marketing Budget Using Accurate Predictions</h2>

        <div class="optimize-cards">

            <div class="optimize-card">
                <div class="icon-wrapper">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <h4>Deliver timely support to your customers</h4>
                <p>Utility messages help businesses deliver timely updates, allowing customers to respond without extra
                    charges.</p>
            </div>

            <div class="optimize-card">
                <div class="icon-wrapper">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <h4>Earn more as your business grows</h4>
                <p>Higher sending volumes unlock lower pricing tiers for better savings.</p>
            </div>

            <div class="optimize-card">
                <div class="icon-wrapper">
                    <i class="fa-solid fa-door-open"></i>
                </div>
                <h4>Tap into free gateways for engagement</h4>
                <p>Conversations started through Meta Ads or Facebook CTAs are free for up to 72 hours.</p>
            </div>

        </div>
    </div>
</section>


  <script>
    const price = { marketing: 0.90, utility: 0.45, auth: 0.45 };

    function updateValues() { calculateTotal(); }

    function calculateTotal() {
      let m = document.getElementById("marketing").value * price.marketing;
      let u = document.getElementById("utility").value * price.utility;
      let a = document.getElementById("auth").value * price.auth;

      let planMultiplier = document.querySelector('input[name="plan"]:checked').value;
      let countryMultiplier = document.getElementById("country").value;
      let toggle = document.getElementById("toggle").checked ? 1.15 : 1;

      let total = (m + u + a) * planMultiplier * countryMultiplier * toggle;

      document.getElementById("mPrice").innerText = "₹" + m.toFixed(2);
      document.getElementById("uPrice").innerText = "₹" + u.toFixed(2);
      document.getElementById("aPrice").innerText = "₹" + a.toFixed(2);
      document.getElementById("total").innerText = "₹" + total.toFixed(2);
    }
  </script>

  <!-- <script>
    const tabData = {
      marketing: { title: "Marketing", desc: "✅Designed for promotional and engagement-driven messaging to boost customer interest and sales.", list: ["✅Examples: Promotional offers, abandoned cart reminders, customer re-targeting."] },
      utility: { title: "Utility", desc: "✅Provides essential updates that keep customers informed with important transactional information.", list: ["✅Examples: Order status updates, appointment reminders, payment receipts."] },
      authentication: { title: "Authentication", desc: "✅Secure verification messages used to confirm user identity and access.", list: ["✅Examples: One-time passwords (OTP), login confirmation codes."] },
      service: { title: "Service", desc: "✅Conversations initiated by customers for ongoing support and help.", list: ["✅Examples: Customer support replies, helpdesk communication."] }
    };

    const tabButtons = document.querySelectorAll(".tab-btn");
    const msgTitle = document.getElementById("msgTitle");
    const msgDesc = document.getElementById("msgDesc");
    const msgList = document.getElementById("msgList");

    tabButtons.forEach((btn) => {
      btn.addEventListener("click", () => {
        document.querySelector(".tab-btn.active")?.classList.remove("active");
        btn.classList.add("active");
        const type = btn.getAttribute("data-type");
        const data = tabData[type];
        msgTitle.innerText = data.title;
        msgDesc.innerText = data.desc;
        msgList.innerHTML = "";
        data.list.forEach((item) => {
          const li = document.createElement("li"); li.innerText = item; msgList.appendChild(li);
        });
      });
    });
  </script> -->
  <!-- COUNTRY/PRICING DATA -->
    <script>
        // -----------------------------------
        // GLOBAL META COUNTRY PRICE STRUCTURE
        // -----------------------------------
        // Replace this JSON with the real Meta rate sheet later.
        const metaPricing = {
            "India": {
                currency: "₹",
                marketing: 0.78,
                utility: 0.12,
                authentication: 0.12,
                service: 0
            },
            "USA": {
                currency: "$",
                marketing: 0.03,
                utility: 0.01,
                authentication: 0.02,
                service: 0
            },
            "United Arab Emirates": {
                currency: "AED",
                marketing: 0.32,
                utility: 0.16,
                authentication: 0.18,
                service: 0
            },
            "United Kingdom": {
                currency: "£",
                marketing: 0.039,
                utility: 0.017,
                authentication: 0.029,
                service: 0
            },

            // ---------------------------------------------
            // ADD REMAINING COUNTRIES BELOW (PRESTRUCTURED)
            // Add all Meta pricing rows here when available.
            // ---------------------------------------------
            "Argentina": { currency: "$", marketing: 0.011, utility: 0.008, authentication: 0.009, service: 0 },
            "Australia": { currency: "$", marketing: 0.045, utility: 0.020, authentication: 0.029, service: 0 },
            "Brazil": { currency: "R$", marketing: 0.06, utility: 0.015, authentication: 0.019, service: 0 },
            "Canada": { currency: "$", marketing: 0.03, utility: 0.01, authentication: 0.02, service: 0 },
            "France": { currency: "€", marketing: 0.048, utility: 0.021, authentication: 0.032, service: 0 },
            "Germany": { currency: "€", marketing: 0.047, utility: 0.019, authentication: 0.031, service: 0 },
            "Indonesia": { currency: "Rp", marketing: 350, utility: 190, authentication: 180, service: 0 },
            "Japan": { currency: "¥", marketing: 7.0, utility: 3.2, authentication: 4.5, service: 0 },
            "Malaysia": { currency: "RM", marketing: 0.10, utility: 0.06, authentication: 0.08, service: 0 },
            "Mexico": { currency: "MXN", marketing: 0.57, utility: 0.25, authentication: 0.31, service: 0 },

            // Add more as needed...
        };

        // Populate country dropdown
        const countrySelector = document.getElementById("countrySelector");
        Object.keys(metaPricing).forEach(country => {
            const opt = document.createElement("option");
            opt.value = country;
            opt.textContent = country;
            countrySelector.appendChild(opt);
        });

        // Initial state
        const state = {
            country: "India",
            type: "marketing",
            volume: 1200
        };

        // DOM elements
        const volumeSlider = document.getElementById("volumeSlider");
        const volumeDisplay = document.getElementById("volumeDisplay");
        const rateValue = document.getElementById("rateValue");
        const currencySymbol = document.getElementById("currencySymbol");
        const currencySymbol2 = document.getElementById("currencySymbol2");
        const totalValue = document.getElementById("totalValue");
        const formulaText = document.getElementById("formulaText");
        const typePills = document.querySelectorAll('.type-pill');
        const typeDescription = document.getElementById("typeDescription");
        const billingNote = document.getElementById("billingNote");

        const descriptions = {
            marketing: "Promotional campaigns, re-engagement flows, announcements.",
            utility: "Order updates, invoices, reminders, transactional notifications.",
            authentication: "OTP, login verification and secure user identity checks.",
            service: "Customer-initiated support conversations."
        };

        const billingNotes = {
            marketing: "Marketing templates are always billed per conversation window.",
            utility: "Utility conversations may be free inside a 24-hour service window.",
            authentication: "Authentication messages are always billed, no exceptions.",
            service: "Service conversations are free in many regions in Meta’s rate card."
        };

        // Update UI
        function updateCalculator() {
            const pricing = metaPricing[state.country];
            const rate = pricing[state.type];

            currencySymbol.textContent = pricing.currency;
            currencySymbol2.textContent = pricing.currency;

            rateValue.textContent = rate;
            volumeDisplay.textContent = state.volume;

            const total = rate * state.volume;
            totalValue.textContent = total.toFixed(2);

            formulaText.textContent = `${pricing.currency}${rate} × ${state.volume}`;

            typeDescription.textContent = descriptions[state.type];
            billingNote.textContent = billingNotes[state.type];
        }

        // Country change
        countrySelector.addEventListener("change", function () {
            state.country = this.value;
            updateCalculator();
        });

        // Volume change
        volumeSlider.addEventListener("input", function () {
            state.volume = this.value;
            updateCalculator();
        });

        // Type selection
        typePills.forEach(pill => {
            pill.addEventListener("click", function () {
                typePills.forEach(p => p.classList.remove("active"));
                this.classList.add("active");
                state.type = this.dataset.type;
                updateCalculator();
            });
        });

        // Scroll helper
        function scrollToCalc() {
            document.getElementById("calculator").scrollIntoView({ behavior: "smooth" });
        }
        window.scrollToCalc = scrollToCalc;

        // Initial load
        updateCalculator();
    </script>
@endsection
