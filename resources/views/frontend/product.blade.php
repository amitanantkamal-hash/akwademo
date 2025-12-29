@extends('frontend.layout.master')
@section('title', 'Project Management & Issue Tracking')
@section('content')

<style>
body {
    font-family: "Inter", sans-serif;
    background: #ffffff;
    margin: 0;
}

/* Heading */
.pm-section h1 {
    padding-top:60px;
    font-size: 39px;
    font-weight: 800;
    margin-bottom: 10px;
    text-align: center;
    color: #064431;;
}

/* Grid Layout */
.pm-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 28px;
    padding: 70px;
}

/* Card Style */
.pm-card {
    background: #ffffff;
    /* background:#eefcff; */
    border-radius: 18px;
    padding: 30px;
    border: 1px solid #e6e6e6;
    box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    transition: all 0.35s ease;
    position: relative;
    cursor: pointer;
}

/* Hover Effect */
.pm-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 16px 35px rgba(0,0,0,0.10);
    /* border-color: #dcdcdc; */
     border-color: #eefcff;
}

/* Icon Styling */
.pm-card img {
    width: 48px;
    height: 48px;
    margin-bottom: 18px;
    filter: drop-shadow(0 3px 5px rgba(0,0,0,0.1));
    transition: 0.3s ease;
}

.pm-card:hover img {
    transform: scale(1.1);
}

/* Title */
.pm-card h3 {   
    font-size: 18px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 12px;
    line-height: 1.35;
    max-width: 230px;
    margin-left: auto;
    margin-right: auto;
}

/* Description */
.pm-card p {
    font-size: 15px;
    color: #6b7280;
    margin-bottom: 25px;
    line-height: 1.5;
}

/* Button */
.pm-card button {
    padding: 10px 20px;
    font-size: 14px;
    border-radius: 10px;
    border: 1px solid #d1d5db;
    background: #ffffff;
    cursor: pointer;
    transition: 0.3s ease;
    font-weight: 600;
}

.pm-card button:hover {
    background: #f9fafb;
    border-color: #c5cad0;
}

/* Make full card clickable */
.pm-grid a {
    text-decoration: none;
    color: inherit;
    display: block;
}

/* ========== LARGE DESKTOPS (1440px and above) ========== */
@media (min-width: 1440px) {
    .pm-section h1 {
        font-size: 38px;
    }
    .pm-grid {
        padding: 90px;
        gap: 35px;
    }
}

/* ========== LAPTOPS / MEDIUM DESKTOPS (1024px – 1439px) ========== */
@media (max-width: 1439px) {
    .pm-section h1 {
        font-size: 30px;
    }
    .pm-grid {
        padding: 60px;
        gap: 25px;
    }
}

/* ========== TABLETS (768px – 1023px) ========== */
@media (max-width: 1023px) {
    .pm-section h1 {
        font-size: 28px;
    }
    .pm-grid {
        padding: 40px 30px;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    }
    .pm-card {
        padding: 25px;
    }
    .pm-card h3 {
        font-size: 17px;
    }
    .pm-card p {
        font-size: 14px;
    }
}

/* ========== MOBILE (480px – 767px) ========== */
@media (max-width: 767px) {
    .pm-section h1 {
        font-size: 26px;
        padding-top: 60px;
    }
    .pm-grid {
        padding: 25px 20px;
        grid-template-columns: 1fr;
        gap: 20px;
    }
    .pm-card {
        padding: 20px;
    }
    .pm-card img {
        width: 42px;
        height: 42px;
    }
    .pm-card h3 {
        font-size: 16px;
    }
}

/* ========== SMALL MOBILE (Below 480px) ========== */
@media (max-width: 480px) {
    .pm-section h1 {
        font-size: 22px;
    }
    .pm-card {
        padding: 18px;
    }
    .pm-card img {
        width: 38px;
        height: 38px;
    }
    .pm-card p {
        font-size: 13px;
        line-height: 1.4;
    }
}

</style>
<main class="main">
    <section class="pm-section">
        <h1 style="line-height: 48px !important;">All-in-One WhatsApp Solutions by AnantKamal WADEMO <br>Automate, Engage & Grow</h1>

        <div class="pm-grid">

            <a href="/whatsapp-business-api" class="pm-card">
                <img src="assets/imgs/images/12.svg" alt="Asana">
                <h3>WhatsApp Business API</h3>
                <p>Handle conversations seamlessly across every stage of the customer lifecycle</p>
                <!-- <button>See details</button> -->
            </a>

            <a href="/whatsapp-automation" class="pm-card">
                <img src="assets/imgs/images/13.svg" alt="Bugpilot">
                <h3>WhatsApp automation tool</h3>
                <p>Create automated workflows and responses with a simple drag-and-drop builder</p>
                <!-- <button>See details</button> -->
            </a>

            <a href="/whatsapp-marketing" class="pm-card">
                <img src="assets/imgs/images/14.svg" alt="ClickUp">
                <h3>WhatsApp marketing software</h3>
                <p>Engage prospects and streamline lead qualification with campaign tools</p>
                <!-- <button>See details</button> -->
            </a>

            <a href="/whatsapp-conversation-pricing-calculator" class="pm-card">
                <img src="assets/imgs/images/15.svg" alt="Conveyor">
                <h3>WhatsApp Business API pricing calculator </h3>
                <p>Assess your WhatsApp API requirements and costs</p>
                <!-- <button>See details</button> -->
            </a>

            <a href="/whatsapp_add" class="pm-card">
                <img src="assets/imgs/images/1.svg" alt="Github">
                <h3>Click-to-WhatsApp ads</h3>
                <p>Convert Meta ad clicks into qualified leads</p>
                <!-- <button>See details</button> -->
            </a>

            <a href="/whatsapp_qr" class="pm-card">
                <img src="assets/imgs/images/2.svg" alt="Instabug">
                <h3>WhatsApp QR code</h3>
                <p>Create WhatsApp QR codes instantly</p>
                <!-- <button>See details</button> -->
            </a>

            <a href="/whatsapp-link-generator" class="pm-card">
                <img src="assets/imgs/images/3.svg" alt="Jira">
                <h3>WhatsApp link generator</h3>
                <p>Generate links to start conversations with customers</p>
                <!-- <button>See details</button> -->
            </a>

            <a href="/whatsapp-chat-button" class="pm-card">
                <img src="assets/imgs/images/4.svg" alt="Linear">
                <h3>WhatsApp chat widgetear</h3>
                <p>Place a chat button to engage website visitors instantly</p>
                <!-- <button>See details</button> -->
            </a>

            <a href="/whatsapp-chatbot" class="pm-card">
                <img src="assets/imgs/images/5.svg" alt="Monday">
                <h3>WhatsApp Chatbots</h3>
                <p>Enable real-time engagement with a simple chat button</p>
                <!-- <button>See details</button> -->
            </a>

            <a href="/whatsapp-flows" class="pm-card">
                <img src="assets/imgs/images/6.svg" alt="Monday">
                <h3>WhatsApp Flows</h3>
                <p>Capture user details effortlessly with forms</p>
                <!-- <button>See details</button> -->
            </a>

            <a href="/whatsapp-broadcast" class="pm-card">
                <img src="assets/imgs/images/7.svg" alt="Next Matter">
                <h3>WhatsApp Broadcast</h3>
                <p>Run high-impact campaigns targeting many users simultaneously</p>
                <!-- <button>See details</button> -->
            </a>

            <a href="/whatsapp-drip-marketing" class="pm-card">
                <img src="assets/imgs/images/8.svg" alt="Syncly">
                <h3>WhatsApp Drip Marketing</h3>
                <p>Set up automated message sequences</p>
                <!-- <button>See details</button> -->
            </a>

            <a href="/ai-whatsapp-template-generator" class="pm-card">
                <img src="assets/imgs/images/9.svg" alt="Todoist">
                <h3>WhatsApp AI template generator</h3>
                <p>Design ready-to-use WhatsApp templates with guided prompts</p>
                <!-- <button>See details</button> -->
            </a>


            <a href="/whatsapp-shared-inbox" class="pm-card">
                <img src="assets/imgs/images/10.svg" alt="Todoist">
                <h3>WhatsApp Shared Team Inbox</h3>
                <p>Work together effortlessly with your team</p>
                <!-- <button>See details</button> -->
            </a>

            <a href="/whatsapp-payments" class="pm-card">
                <img src="assets/imgs/images/11.svg" alt="Todoist">
                <h3>WhatsApp Payments</h3>
                <p>Set up seamless one-tap payments via WhatsApp</p>
                <!-- <button></button> -->
            </a>

        </div>

    </section>
</main>
@endsection

