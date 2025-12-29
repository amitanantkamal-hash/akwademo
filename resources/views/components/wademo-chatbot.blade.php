<!-- WADEMO Chatbot Widget -->
<style>
    /* Floating Chat Button */
    #wademoChatButton {
        position: fixed;
        bottom: 100px;
        right: 20px;
        background: #283d3b;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 6px 15px rgba(0,0,0,0.25);
        z-index: 99990;
        transition: transform 0.2s ease;
    }
    #wademoChatButton:hover { transform: scale(1.08); }

    /* Chat Window */
    #wademoChatWindow {
        position: fixed;
        bottom: 170px;
        right: 20px;
        width: 380px;
        height: 520px;
        background: #fff;
        border-radius: 18px;
        display: none;
        box-shadow: 0 6px 25px rgba(0,0,0,0.25);
        z-index: 99999;
        animation: fadeInUp .25s ease-out;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Header */
    #wademoHeader {
        background: #283d3b;
        padding: 14px 18px;
        color: white;
        font-size: 17px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .wademo-logo {
        width: 28px;   /* Adjust as needed */
        height: 28px;  /* Keeps it square */
        border-radius: 6px; /* Optional rounded corners */
    }

    #wademoChatBody {
        padding: 15px;
        height: 430px;
        overflow-y: auto;
        background: #fafafa;
        font-size: 15px;
    }

    .chat-msg {
        margin-bottom: 12px;
        padding: 10px 14px;
        border-radius: 12px;
        line-height: 1.4;
        max-width: 80%;
    }

    .bot-msg {
        background: #ececec;
        text-align: left;
        color: #000;
    }

    .user-msg {
        background: #283d3b;
        color: #fff;
        text-align: right;
        margin-left: auto;
    }

    .chat-option {
        background: #e6f3ff;
        padding: 10px;
        margin: 6px 0;
        border-radius: 10px;
        cursor: pointer;
        border-left: 4px solid #283d3b;
        transition: 0.3s;
    }

    .chat-option:hover { background: #d9eaff; }

    /* ICONS */
    .icon { width: 28px; height: 28px; }
</style>

<!-- Floating Button -->
<div id="wademoChatButton">
    <span id="chatIcon">
        <!-- Chat bubble icon -->
        <svg class="icon" viewBox="0 0 24 24" fill="#fff">
            <path d="M20 2H4C2.9 2 2 2.9 2 4V22L6 18H20C21.1 18 22 17.1 22 16V4C22 2.9 21.1 2 20 2Z"/>
        </svg>
    </span>

    <span id="closeIcon" style="display:none;">
        <!-- Close (X) icon -->
        <svg class="icon" viewBox="0 0 24 24" fill="#fff">
            <path d="M18 6L6 18M6 6L18 18" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
        </svg>
    </span>
</div>

<!-- Chat Window -->
<div id="wademoChatWindow">
    <div id="wademoHeader">
        <img href="/favicon-16x16.png" alt="Logo" class="wademo-logo">
        <span>WADEMO Assistant</span>
    </div>
    <div id="wademoChatBody"></div>
</div>

<script>
    const chatBtn = document.getElementById("wademoChatButton");
    const chatWindow = document.getElementById("wademoChatWindow");
    const chatBody = document.getElementById("wademoChatBody");

    const chatIcon = document.getElementById("chatIcon");
    const closeIcon = document.getElementById("closeIcon");

    chatBtn.onclick = () => {
        const isOpen = chatWindow.style.display === "block";

        chatWindow.style.display = isOpen ? "none" : "block";

        chatIcon.style.display = isOpen ? "block" : "none";
        closeIcon.style.display = isOpen ? "none" : "block";

        if (!isOpen && chatBody.innerHTML.trim() === "") loadWelcome();
    };

    function botMsg(text) {
        chatBody.innerHTML += `<div class="chat-msg bot-msg">${text}</div>`;
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    function userMsg(text) {
        chatBody.innerHTML += `<div class="chat-msg user-msg">${text}</div>`;
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    function loadOptions(options) {
        options.forEach(opt => {
            chatBody.innerHTML += `<div class="chat-option" onclick="${opt.action}">${opt.text}</div>`;
        });
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    /* ---------------- CHATBOT FLOW (YOUR EXACT CONTENT) ---------------- */

    function loadWelcome() {
        botMsg("👋 Welcome to <b>Anantkamal WADEMO</b>!<br>Your WhatsApp API Demo & Automation Portal.");
        botMsg("How can I help you today?");
        loadOptions([
            { text: "What is WADEMO?", action: "flowWhatIs()" },
            { text: "Features & Benefits", action: "flowFeatures()" },
            { text: "How to Register / Login", action: "flowRegister()" },
            { text: "How WADEMO Works", action: "flowHowWorks()" },
            { text: "Pricing & Plans", action: "flowPricing()" },
            { text: "Live Demo", action: "flowDemo()" },
            { text: "Contact Support", action: "flowSupport()" },
        ]);
    }

    // 1️⃣ What is WADEMO
    function flowWhatIs() {
        userMsg("What is WADEMO?");
        botMsg("WADEMO is a demo platform to explore:<br>• WhatsApp Automation<br>• API Testing<br>• Chatbot Flows<br>• Webhook Testing<br>• Messaging Templates");
        botMsg("Choose a category:");
        loadOptions([
            { text: "Use Cases", action: "flowUseCases()" },
            { text: "Who Can Use It?", action: "flowWhoUse()" },
            { text: "How It Works", action: "flowHowWorks()" },
            { text: "🔙 Back", action: "loadWelcome()" }
        ]);
    }

    function flowUseCases() {
        userMsg("Use Cases");
        botMsg("WADEMO helps you test:<br>✔ Auto Replies<br>✔ Broadcasts<br>✔ Lead Automation<br>✔ OTP Messages<br>✔ CRM Integrations");
    }

    function flowWhoUse() {
        userMsg("Who Can Use");
        botMsg("WADEMO is ideal for:<br>✔ Businesses<br>✔ Startups<br>✔ Agencies<br>✔ Developers<br>✔ E-commerce Owners");
    }

    // 2️⃣ Features
    function flowFeatures() {
        userMsg("Features & Benefits");
        botMsg("Here are the top features:<br>• WhatsApp Chatbot<br>• Automation & Flows<br>• API Testing<br>• Lead Forms<br>• Broadcast Simulation<br>• Dashboard Demo");
    }

    // 3️⃣ How to Register
    function flowRegister() {
        userMsg("How to Register / Login");
        botMsg("Steps:<br>1️⃣ Click on Register<br>2️⃣ Enter Email + OTP<br>3️⃣ Login to Dashboard<br>4️⃣ Explore APIs & Automation");
        botMsg(`<a href="https://anantkamalwademo.online/register" target="_blank">👉 Click here to Register</a>`);
    }

    // 4️⃣ How WADEMO works
    function flowHowWorks() {
        userMsg("How WADEMO Works");
        botMsg("WADEMO works in 3 steps:<br>1️⃣ Register<br>2️⃣ Login<br>3️⃣ Test Automation & API");
    }

    // 5️⃣ Pricing
    function flowPricing() {
        userMsg("Pricing & Plans");
        botMsg("WADEMO is <b>free</b> to try. For full WhatsApp Business API pricing, contact us.");
    }

    // 6️⃣ Live Demo
    function flowDemo() {
        userMsg("Live Demo");
        botMsg(`Click below for Live WhatsApp Demo:<br><a href="https://wa.me/917011767613" target="_blank">👉 Start Demo</a>`);
    }

    // 7️⃣ Support
    function flowSupport() {
        userMsg("Contact Support");
        botMsg(`📞 Call: 91-7776953337<br>💬 WhatsApp: <a href="https://wa.me/917011767613" target="_blank">Chat Now</a><br>📧 Email: support@anantkamalstudios.com`);
    }
</script>
