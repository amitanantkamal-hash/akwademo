@extends('frontend.layout.master')
@section('title', 'AI Whatsapp Template Generator')
@section('content')

<style>
    /* Global */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Inter', sans-serif;
    }

    .tone-options{
      padding:10px;
    }

    body {
      background: #f7f9fb;
      line-height: 1.6;
      color: #1e1e1e;
    }

    section {
      padding: 60px 6%;
    }

    /* Buttons */
    .btn-primary,
    .btn-secondary {
      padding: 12px 24px;
      border-radius: 10px;
      font-weight: 600;
      display: inline-block;
      text-decoration: none;
      cursor: pointer;
      font-size: 16px;
    } 

    .btn-primary {
      background: #024430;
      color: #fff;
    }

    .btn-secondary {
      background: #fff;
      border: 2px solid #024430;
      color: #024430;
    }

    /* Header Section */
    /* WA AI Section */
.wa-ai-section {
  text-align: center;
}

.ai-header{
  margin-top:70px;
}

/* Header */
.ai-header h2 {
  font-size: 36px;
  font-weight: 700;
  margin-top: 10px;
  line-height: 1.3;
  color: #024430;
}

.ai-header p {
  max-width: 780px;
  margin: 14px auto 22px;
  font-size: 18px;
  color: #555;
  line-height: 1.6;
}

.ai-badge {
  background: #daf6eb;
  color: #024430;
  padding: 8px 18px;
  border-radius: 20px;
  font-size: 14px;
  display: inline-block;
}

/* Form + Preview Layout */
.ai-template-container {
  margin-top: 50px;
  display: flex;
  justify-content: center;
  align-items: stretch;
  gap: 40px;
  flex-wrap: wrap;
}

/* FORM BOX */
.template-form {
  background: #fff;
  padding: 30px;
  border: 1px solid #ddd;
  border-radius: 18px;
  width: 48%;
  min-width: 340px;
  text-align: left;
}

.template-form h3 {
  margin-bottom: 20px;
  font-size: 22px;
  font-weight: 600;
  color: #024430;
}

.template-form label {
  display: block;
  margin: 10px 0 5px;
  font-weight: 600;
  color: #024430;
}

.template-form input {
  width: 100%;
  padding: 14px;
  border: 1px solid #ccc;
  border-radius: 8px;
  margin-bottom: 18px;
  font-size: 15px;
}

/* Tone Buttons */
.tone-options button {
  padding: 8px 14px;
  border-radius: 8px;
  border: 1px solid #024430;
  background: #fff;
  margin-right: 10px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 500;
}

.tone-options button.active {
  background: #024430;
  color: #fff;
}

/* PREVIEW BOX */
.template-preview {
  background: #fff;
  padding: 30px;
  border: 1px solid #ddd;
  border-radius: 18px;
  width: 48%;
  min-width: 340px;
  text-align: center;
}

.whatsapp-box {
  background: #e7ffe7;
  border-radius: 14px;
  padding: 22px;
  text-align: left;
  min-height: 240px;
  font-size: 15px;
  line-height: 1.6;
}

.wa-header {
  font-weight: 700;
  margin-bottom: 10px;
  font-size: 16px;
  color: #024430;
}

.copy-btn {
  padding: 12px 28px;
  background: #024430;
  color: #fff;
  border-radius: 10px;
  border: none;
  margin-top: 22px;
  cursor: pointer;
  font-size: 16px;
}

/* RESPONSIVE DESIGN */
@media(max-width: 1024px) {
  .ai-template-container {
    gap: 25px;
  }

  .template-form,
  .template-preview {
    width: 100%;
  }
}

@media(max-width: 600px) {
  .ai-header h2 {
    /* font-size: 28px; */
     font-size: 24px;
  }
  .wa-ai-section{
     text-align:left;
  }

  .template-form,
  .template-preview {
    padding: 22px;
  }

  .tone-options button {
    margin-bottom: 8px;
  }
}

    /* More AI Section */
    /* More AI Section */
.more-ai {
  text-align: center;
}

.more-ai h2 {
  font-size: 32px;
  font-weight: 700;
  margin-bottom: 14px;
  color: #024430;
}

.more-ai p {
  max-width: 760px;
  margin: 0 auto 30px auto;
  font-size: 18px;
  color: #555;
}


/* AI Features (Image Left + Text Right) */
.ai-features {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 50px;
  margin-top: 50px;
}

.ai-img {
  flex: 1;
}

.ai-img img {
  width: 480px;
  max-width: 100%;
  border-radius: 12px;
}

.ai-text {
  flex: 1;
  text-align: left;
}

.ai-text h3 {
  margin-top: 20px;
  /* font-size: 24px; */
    font-size: 22px;
  color: #024430;
  font-weight: 700;
  line-height: 1.3;
}

.ai-text p {
  margin: 10px 0 20px;
  font-size: 16px;
  color: #555;
  line-height: 1.6;
}

/* Responsive */
@media (max-width: 900px) {
  .more-ai h2 {
    /* font-size:25px; */
     font-size:24px;
  }
  .ai-features {
    flex-direction: column;
    text-align: center;
  }

  .ai-text {
    text-align: center;
  }
        .ai-text h3 {
        text-align:left;
      }
}


    @media(max-width:500px) {
        .more-ai h2 {
        /* font-size:25px; */
        font-size:24px;
        text-align:left;
      }
      section {
        padding: 40px 5%;
      }

      .btn-primary,
      .btn-secondary {
        width: 100%;
        text-align: center;
      }
      .more-ai p {
        text-align:center;
      }

      .ai-text h3 {
        text-align:left;
      }
    }


    /* All-in-One WA Platform Section */
      .allinone-section {
        text-align: center;
        padding: 60px 6%;
        background: #fff;
      }

    .section-title {
      /* font-size: 34px; */
       font-size: 30px;
      font-weight: 700;
      margin-bottom: 14px;
      color: #024430;
    }

    .section-subtitle {
      max-width: 800px;
      margin: 0 auto 40px auto;
      font-size: 18px;
      color: #555;
    }

    .ai-features-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 30px;
      margin-top: 20px;
    }

    .ai-feature-card {
      padding: 30px 22px;
      border-radius: 18px;
      border: 1px solid #ddd;
      background: #fff;
      transition: all .3s ease;
      cursor: pointer;
    }

    .ai-feature-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
      border-color: #024430;
    }

    .ai-feature-icon {
      font-size: 32px;
      background: #daf6eb;
      width: 58px;
      height: 58px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 15px auto;
      color: #024430;
    }

    .ai-feature-card h3 {
      font-size: 20px;
      margin-bottom: 12px;
      font-weight: 600;
      color: #024430;
    }

    .ai-feature-card p {
      font-size: 15px;
      color: #555;
      line-height: 1.5;
    }

    /* Responsive */
    @media(max-width:992px) {
      .ai-features-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      .more-ai p {
        text-align:left;
      }
    }

    @media(max-width:600px) {
      .ai-features-grid {
        grid-template-columns: 1fr;
      }

      .section-title {
        /* font-size: 26px; */
        font-size: 24px;
        text-align:left;
      }

      .section-subtitle {
        font-size: 16px;
         text-align:left;

      }

      .more-ai p {
        text-align:left;
      }
    }
  </style>
</head>

<body>

  <section class="wa-ai-section">
    <div class="ai-header">
      <span class="ai-badge">AI-Powered Messaging Automation</span>
      <h2>Create WhatsApp Message Templates with Anantkamal WADEMO AI</h2>
      <p>Convert your messages into ready-to-use WhatsApp templates instantly using Anantkamal WADEMO AI</p>
      <a href="#" class="btn-primary">Try it now</a>
    </div>

    <div class="ai-template-container">
      <div class="template-form">
        <h3>Create Personalized Templates</h3>

        <label>Your Business Name</label>
        <input type="text" placeholder="Enter your business name">

        <label>Audience</label>
        <input type="text" placeholder="Describe your audience">

        <label>Message Purpose</label>
        <input type="text" placeholder="What is the objective of the message?">

        <label>Message Tone</label>
        <div class="tone-options">
          <button class="active">Friendly</button>
          <button>Formal</button>
          <button>Bold</button>
        </div>

        <button class="btn-secondary">Generate Template</button>
      </div>

      <div class="template-preview">
        <div class="whatsapp-box">
          <div class="wa-header">WhatsApp Preview</div>
          <p>Hello 👋,<br><br>Thank you for reaching out! We're excited to support you. Share your questions anytime —
            we're here to help. 😊</p>
        </div>
        <button class="copy-btn">Copy</button>
      </div>
    </div>
  </section>

<section class="more-ai">
  <h2>Experience the full potential of AI when you switch to a WhatsApp Business API provider like Anantkamal WADEMO</h2>
  <!-- <p>Create AI-powered WhatsApp templates that simplify approvals and engage prospects efficiently. Beyond templates, WhatsApp Business APIs handle repetitive tasks and guide leads through every stage of the sales lifecycle</p> -->

  <div class="ai-features">

    <div class="ai-img">
      <img src="assets/imgs/images/whtup_AI_genertor/61.jpg" alt="Dashboard UI">
    </div>

    <div class="ai-text">
      <h3>Handle higher ticket volumes without expanding your team.</h3>
      <p>Scale AI-powered WhatsApp chatbot workflows to answer common queries around the clock, freeing your team to focus on building relationships and closing deals</p>

      <h3>Personalization and creativity, just a click away</h3>
      <p>Leverage Anantkamal WADEMO generative AI editor to craft personalized responses with just a few prompts. Engaging prospects is now effortless and no longer a time-consuming task</p>

      <h3>Respond in any language without leaving WhatsApp</h3>
      <p>With Anantkamal WADEMO, there’s no need to toggle between tabs to translate a prospect’s reply, understand the context, and craft your response. Everything happens seamlessly on a single platform</p>

      <a href="#" class="btn-primary">Learn More</a>
    </div>

  </div>
</section>


  <section class="allinone-section">
    <div class="container">
      <h2 class="section-title">Anantkamal WADEMO — Complete WhatsApp Automation, All in One Place</h2>
      <p class="section-subtitle">
       No matter if you’re leading sales, marketing, or running a business, Anantkamal WADEMO empowers you to turn your vision into results. See how its features can elevate your marketing game
      </p>

      <div class="ai-features-grid">

        <div class="ai-feature-card">
          <div class="ai-feature-icon"><i class="fa-solid fa-lightbulb"></i></div>
          <h3>Personalized Customer Recommendations</h3>
          <p>Send relevant and tailored suggestions to customers based on their preferences and actions</p>
        </div>

        <div class="ai-feature-card">
          <div class="ai-feature-icon"><i class="fa-solid fa-chart-line"></i></div>
          <h3>Boost Sales Team Productivity</h3>
          <p>Automate WhatsApp workflows and let chatbots qualify leads — helping your team close more deals</p>
        </div>

        <div class="ai-feature-card">
          <div class="ai-feature-icon"><i class="fa-solid fa-folder-open"></i></div>
          <h3>Unified Communication Hub</h3>
          <p>Store and track all customer conversations in one place to avoid missed follow-ups</p>
        </div>

        <div class="ai-feature-card">
          <div class="ai-feature-icon"><i class="fa-solid fa-rocket"></i></div>
          <h3>Supercharge Marketing Campaigns</h3>
          <p>Run segmented broadcasts, drip campaigns, and automated notifications for higher engagement</p>
        </div>

        <div class="ai-feature-card">
          <div class="ai-feature-icon"><i class="fa-solid fa-handshake"></i></div>
          <h3>Strengthen Customer Engagement</h3>
          <p>Share reminders, updates, and automated responses to keep your audience actively connected</p>
        </div>

        <div class="ai-feature-card">
          <div class="ai-feature-icon"><i class="fa-solid fa-sack-dollar"></i></div>
          <h3>Increase Revenue & Profit</h3>
          <p>Run targeted Instagram and Facebook ads that drive leads directly to WhatsApp while reducing costs</p>
        </div>

      </div>
    </div>
  </section>

@endsection