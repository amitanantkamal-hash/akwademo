@extends('frontend.layout.master')
@section('title', 'Onboarding')
@section('content')

<style>
    .onboarding {
      --primary: #024430;
      --accent: #0ea57a;
      --bg: #ffffff;
      --soft: #f6f9f8;
      --text: #1f2937;
      --muted: #6b7280;
      --border: #e5e7eb;
    }


    /* *{
      margin:0;
      padding:0;
      box-sizing:border-box;
      font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Arial;
    }

    body{
      background:var(--bg);
      color:var(--text);
      line-height:1.8;
    } */

    /* ================= PAGE ================= */
    .onboarding {
      max-width: 1100px;
      margin: auto;
      padding: 60px 20px;
    }

    /* ================= HEADER ================= */
    .onboarding .GDPR_TOP {
      border-bottom: 2px solid var(--primary);
      padding-bottom: 24px;
      margin-bottom: 40px;
    }

    .onboarding .GDPR_TOP h1 {
      font-size: 36px;
      color: var(--primary);
      margin-bottom: 8px;
    }

    .onboarding .GDPR_TOP h2 {
      font-size: 18px;
      font-weight: 500;
      color: #065f46;
      margin-bottom: 6px;
    }

    .onboarding .GDPR_TOP p {
      font-size: 14px;
      color: var(--muted);
    }

    /* ================= SECTIONS ================= */
    .onboarding section {
      margin-bottom: 42px;
    }

    .onboarding section h3 {
      font-size: 22px;
      color: var(--primary);
      margin-bottom: 10px;
    }

    .onboarding section h4 {
      font-size: 17px;
      margin: 14px 0 6px;
      color: #064e3b;
    }

    .onboarding section p {
      margin-bottom: 12px;
    }

    /* ================= DEFAULT ✓ LIST ================= */
    .onboarding section ul:not(.dot-list) {
      margin: 14px 0;
      list-style: none;
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      column-gap: 40px;
      row-gap: 10px;
    }

    .onboarding section ul:not(.dot-list) li {
      position: relative;
      padding-left: 26px;
    }

    .onboarding section ul:not(.dot-list) li::before {
      content: "✓";
      position: absolute;
      left: 0;
      top: 0;
      color: var(--accent);
      font-weight: 700;
    }

    /* ================= DOT LIST (GDPR LEGAL LIST) ================= */
    .onboarding section ul.dot-list {
      list-style: disc;
      padding-left: 22px;
      display: block;
    }

    .onboarding section ul.dot-list li {
      padding-left: 0;
    }

    .onboarding section ul.dot-list li::before {
      content: none;
    }

    /* ================= HIGHLIGHT BOX ================= */
    .onboarding .highlight {
      background: var(--soft);
      border-left: 4px solid var(--accent);
      padding: 14px 18px;
      margin-top: 14px;
    }

    .onboarding .highlight ul {
      grid-template-columns: 1fr;
    }

    /* ================= RESPONSIVE ================= */
    @media(max-width:768px) {
      .onboarding .GDPR_TOP h1 {
        font-size: 30px;
      }

      .onboarding section ul:not(.dot-list) {
        grid-template-columns: 1fr;
      }
    }
  </style>

  <div class="onboarding">
    <header>
        <h1>Client Onboarding Process</h1>
        <h2>Anantkamal WADEMO – WhatsApp Business API Platform</h2>
        <p>Operated by: <strong>Anantkamal Software Labs</strong><br/>Role: Meta Tech Provider</p>
    </header>

    <section>
        <h3>1. Introduction</h3>
        <p>Welcome to <strong>Anantkamal WADEMO</strong>, a WhatsApp Business API–based automation and customer engagement platform designed to help businesses manage leads, customer conversations, support, payments, and automation at scale.</p>
        <p>This Client Onboarding Document outlines the <strong>requirements, responsibilities, process flow, timelines, and compliance obligations</strong> for businesses onboarding onto the WADEMO platform.</p>
        <p>By proceeding with onboarding, the client agrees to comply with Meta (WhatsApp) policies, Indian IT laws, and WADEMO platform terms.</p>
    </section>

    <section>
        <h3>2. Eligibility Criteria</h3>
        <ul>
            <li>Legally registered business (Proprietorship / Partnership / LLP / Pvt Ltd / Public Ltd)</li>
            <li>Valid GST number (recommended)</li>
            <li>Mobile number not previously used with WhatsApp Business API</li>
            <li>Agreement to Meta & WhatsApp Business Messaging Policies</li>
        </ul>
    </section>

    <section>
        <h3>3. Documents Required for Onboarding</h3>
        <h4>3.1 Business Documents</h4>
        <ul>
            <li>Business Registration Certificate</li>
            <li>GST Certificate (if applicable)</li>
            <li>PAN Card (Business / Proprietor)</li>
            <li>Business Address Proof</li>
        </ul>

        <h4>3.2 Authorized Signatory Documents</h4>
        <ul>
            <li>Authorized person’s ID proof</li>
            <li>Email ID and mobile number</li>
        </ul>

        <h4>3.3 Digital Assets</h4>
        <ul>
            <li>Business website URL</li>
            <li>Privacy Policy URL</li>
            <li>GDPR / Data Protection Policy URL</li>
            <li>Terms & Conditions URL</li>
        </ul>
    </section>

    <section>
        <h3>4. WhatsApp Business Account (WABA) Setup</h3>
        <ul>
            <li>Meta Business Manager setup</li>
            <li>WhatsApp Business Account (WABA)</li>
            <li>Phone number verification</li>
            <li>Display name approval</li>
        </ul>
        <div class="highlight">
        <strong>Important Rules:</strong>
        <ul>
            <li>Display name must match brand identity</li>
            <li>Phone number must be exclusive to WhatsApp API</li>
            <li>Business verification is subject to Meta approval</li>
        </ul>
        </div>
    </section>

    <section>
        <h3>5. Opt-In & User Consent Policy</h3>
        <ul>
        <li>Explicit user opt-in before sending messages</li>
        <li>Opt-in via website, forms, QR codes, ads, or offline consent</li>
        <li>Clear disclosure of message purpose</li>
        </ul>
        <div class="highlight">
        <strong>Prohibited Activities:</strong>
        <ul>
            <li>Purchased databases</li>
            <li>Cold messaging</li>
            <li>Spam or misleading communication</li>
        </ul>
        </div>
    </section>

    <section>
        <h3>6. Message Templates & Approval</h3>
        <ul>
        <li>All outbound business messages require Meta-approved templates</li>
        <li>Templates must be clear, compliant, and non-misleading</li>
        <li>Marketing templates must follow WhatsApp guidelines</li>
        </ul>
        <p>WADEMO assists with template drafting and submission.</p>
    </section>

    <section>
        <h3>7. Platform Features Access</h3>
        <ul>
        <li>WhatsApp inbox & CRM</li>
        <li>Chatbot & automation builder</li>
        <li>Broadcast & campaign manager</li>
        <li>Payment & invoice integration</li>
        <li>Analytics & reporting</li>
        <li>Role-based team access</li>
        </ul>
    </section>

    <section>
        <h3>8. Data Protection & Privacy</h3>
        <ul>
        <li>WADEMO acts as <strong>Data Processor</strong></li>
        <li>Client acts as <strong>Data Controller</strong> for end‑user data</li>
        <li>Data processing complies with:</li>
        </ul>
        <ul>
        <li>GDPR (EU)</li>
        <li>Indian IT Act & SPDI Rules</li>
        <li>Meta / WhatsApp policies</li>
        </ul>
        <p>Clients are responsible for informing end users about data usage and communication practices.</p>
    </section>

    <section>
        <h3>9. Billing, Pricing & Payments</h3>
        <ul>
        <li>WhatsApp conversation charges apply as per Meta pricing</li>
        <li>WADEMO platform fees are billed as per selected plan</li>
        <li>Invoices are generated electronically</li>
        <li>Payment timelines must be strictly followed</li>
        </ul>
        <p><strong>Non‑payment may result in service suspension.</strong></p>
    </section>

    <section>
        <h3>10. Go-Live Timeline (Indicative)</h3>
        <table>
        <tr><th>Activity</th><th>Timeline</th></tr>
        <tr><td>Document Submission</td><td>Day 1</td></tr>
        <tr><td>Meta Business Setup</td><td>1–2 Working Days</td></tr>
        <tr><td>WABA Approval</td><td>2–5 Working Days</td></tr>
        <tr><td>Template Approval</td><td>1–3 Working Days</td></tr>
        <tr><td>Automation Setup</td><td>1–2 Working Days</td></tr>
        </table>
    </section>

    <section>
        <h3>11. Client Responsibilities</h3>
        <ul>
        <li>Lawful and compliant usage of WADEMO</li>
        <li>Maintain updated business information</li>
        <li>Ensure opt-in compliance</li>
        <li>Adherence to Meta & WhatsApp policies</li>
        </ul>
    </section>

    <section>
        <h3>12. Support & Communication</h3>
        <p>Email Support: <strong>support@anantkamalwademo.online</strong></p>
        <p>Business Hours: Monday to Saturday (10:00 AM – 7:00 PM IST)</p>
        <p>Critical issues are handled as per agreed SLA.</p>
    </section>

    <section>
        <h3>13. Termination & Suspension</h3>
        <ul>
        <li>Meta suspension or restriction</li>
        <li>Policy or legal violations</li>
        <li>Non-payment beyond due date</li>
        </ul>
    </section>

    <section>
        <h3>14. Acceptance & Declaration</h3>
        <p>By onboarding on Anantkamal WADEMO, the client confirms that:</p>
        <ul>
        <li>All submitted information is accurate and authentic</li>
        <li>User consent and opt‑in policies are followed</li>
        <li>The client agrees to WADEMO terms, privacy, and GDPR policies</li>
        </ul>
        <div class="signature">
        <p><strong>Authorized Signatory Name:</strong> Pallavi K</p>
        <p><strong>Business Name:</strong> Anantkamal Software Lab</p>
        <p><strong>Signature & Seal:</strong></p>
        <p><strong>Date:</strong> 15-12-2025</p>
        </div>
    </section>
  </div>
@endsection