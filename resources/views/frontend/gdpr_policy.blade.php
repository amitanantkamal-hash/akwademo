@extends('frontend.layout.master')
@section('title', 'Project Management & Issue Tracking')
@section('content')

<style>
    .page_gdpr {
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
    .page_gdpr {
      max-width: 1100px;
      margin: auto;
      padding: 60px 20px;
    }

    /* ================= HEADER ================= */
    .page_gdpr .GDPR_TOP {
      border-bottom: 2px solid var(--primary);
      padding-bottom: 24px;
      margin-bottom: 40px;
    }

    .page_gdpr .GDPR_TOP h1 {
      font-size: 36px;
      color: var(--primary);
      margin-bottom: 8px;
    }

    .page_gdpr .GDPR_TOP h2 {
      font-size: 18px;
      font-weight: 500;
      color: #065f46;
      margin-bottom: 6px;
    }

    .page_gdpr .GDPR_TOP p {
      font-size: 14px;
      color: var(--muted);
    }

    /* ================= SECTIONS ================= */
    .page_gdpr section {
      margin-bottom: 42px;
    }

    .page_gdpr section h3 {
      font-size: 22px;
      color: var(--primary);
      margin-bottom: 10px;
    }

    .page_gdpr section h4 {
      font-size: 17px;
      margin: 14px 0 6px;
      color: #064e3b;
    }

    .page_gdpr section p {
      margin-bottom: 12px;
    }

    /* ================= DEFAULT ✓ LIST ================= */
    .page_gdpr section ul:not(.dot-list) {
      margin: 14px 0;
      list-style: none;
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      column-gap: 40px;
      row-gap: 10px;
    }

    .page_gdpr section ul:not(.dot-list) li {
      position: relative;
      padding-left: 26px;
    }

    .page_gdpr section ul:not(.dot-list) li::before {
      content: "✓";
      position: absolute;
      left: 0;
      top: 0;
      color: var(--accent);
      font-weight: 700;
    }

    /* ================= DOT LIST (GDPR LEGAL LIST) ================= */
    .page_gdpr section ul.dot-list {
      list-style: disc;
      padding-left: 22px;
      display: block;
    }

    .page_gdpr section ul.dot-list li {
      padding-left: 0;
    }

    .page_gdpr section ul.dot-list li::before {
      content: none;
    }

    /* ================= HIGHLIGHT BOX ================= */
    .page_gdpr .highlight {
      background: var(--soft);
      border-left: 4px solid var(--accent);
      padding: 14px 18px;
      margin-top: 14px;
    }

    .page_gdpr .highlight ul {
      grid-template-columns: 1fr;
    }

    /* ================= FOOTER ================= */
    .page_gdpr footer {
      border-top: 1px solid var(--border);
      padding-top: 20px;
      margin-top: 50px;
      font-size: 14px;
      color: var(--muted);
    }

    /* ================= RESPONSIVE ================= */
    @media(max-width:768px) {
      .page_gdpr .GDPR_TOP h1 {
        font-size: 30px;
      }

      .page_gdpr section ul:not(.dot-list) {
        grid-template-columns: 1fr;
      }
    }
  </style>



  <div class="page_gdpr">

    <div class="GDPR_TOP">
      <h1>GDPR & Data Protection Policy</h1>
      <h2>Anantkamal WADEMO – WhatsApp Business API Platform</h2>
      <p><strong>Last Updated:</strong> December 2025</p>
    </div>

    <section>
      <!-- <p>This GDPR & Data Protection Policy ("Policy") explains how <strong>Anantkamal WADEMO</strong>, operated by <strong>Anantkamal Software Labs</strong>, collects, uses, stores, processes, and protects personal data in compliance with GDPR, Indian IT laws, and Meta (WhatsApp) policies.</p> -->
      <p>This GDPR & Data Protection Policy ("Policy") explains how <strong>Anantkamal WADEMO</strong>, operated by
        <strong>Anantkamal Software Labs</strong>, collects, uses, stores, processes, and protects personal data in
        compliance with:</p>
      <ul class="dot-list">
        <li>General Data Protection Regulation (EU) 2016/679 (GDPR)</li>
        <li>Information Technology Act, 2000 (India)</li>
        <li>IT (Reasonable Security Practices and Procedures and Sensitive Personal Data or Information) Rules, 2011
        </li>
        <li>Processor – Processes data on behalf of controller</li>
        <li>Meta / WhatsApp – Meta Platforms, Inc. & WhatsApp LLC</li>
      </ul>
      <p>This Policy applies to all users, customers, partners, and visitors who use WADEMO services, websites,
        dashboards, APIs, or integrations.</p>
    </section>

    <section>
      <h3>1. About Anantkamal WADEMO</h3>
      <p><strong>Platform:</strong> Anantkamal WADEMO</p>
      <p><strong>Company:</strong> Anantkamal Software Labs</p>
      <p><strong>Role:</strong> Meta Tech Provider / WhatsApp Business API Platform</p>
      <p><strong>Services:</strong> WhatsApp Business API, Chatbots, CRM, Automation, Broadcasts, Payments,
        Integrations, Analytics</p>
      <div class="highlight">
        <p>We act as:</p>
        <ul>
          <li>Data Processor for WADEMO customers</li>
          <li>Data Controller for onboarding, billing, and support data</li>
        </ul>
      </div>
    </section>

    <section>
      <h3>2. Definitions</h3>
      <ul>
        <li>Personal Data – Identifiable individual information</li>
        <li>Data Subject – Individual whose data is processed</li>
        <li>Controller – Determines purpose of processing</li>
        <li>Processor – Processes data on behalf of controller</li>
        <li>Meta / WhatsApp – Meta Platforms, Inc. & WhatsApp LLC</li>
      </ul>
    </section>

    <section>
      <h3>3. Lawful Basis for Processing</h3>
      <ul>
        <li>User consent</li>
        <li>Contractual necessity</li>
        <li>Legal obligation</li>
        <li>Legitimate business interest</li>
        <li>Meta & WhatsApp compliance</li>
      </ul>
    </section>

    <section>
      <h3>4. Data We Collect</h3>
      <h4>Business & Account Information</h4>
      <ul>
        <li>Business name, address, GST details</li>
        <li>Authorized representative details</li>
        <li>Email ID and phone number</li>
        <li>WhatsApp Business Account details</li>
      </ul>

      <h4>End-User Data</h4>
      <ul>
        <li>WhatsApp phone numbers</li>
        <li>User names (if shared)</li>
        <li>Chat messages and media</li>
        <li>Interaction timestamps</li>
      </ul>

      <h4>Technical Data</h4>
      <ul>
        <li>IP address and browser type</li>
        <li>Device and log data</li>
        <li>API usage and error reports</li>
      </ul>

      <h4>Payment & Billing Data</h4>
      <ul>
        <li>Transaction IDs</li>
        <li>Invoices</li>
        <li>Payment gateway references</li>
      </ul>
    </section>

    <section>
      <h3>5. Purpose of Data Processing</h3>
      <ul>
        <li>Message delivery and automation</li>
        <li>CRM and conversation management</li>
        <li>Customer support and onboarding</li>
        <li>Billing and invoicing</li>
        <li>Analytics and reporting</li>
        <li>Fraud prevention and security</li>
      </ul>
    </section>

    <section>
      <h3>6. WhatsApp & Meta Compliance</h3>
      <p>WADEMO strictly follows:</p>
      <ul>
        <li>WhatsApp Business Messaging Policy</li>
        <li>Meta Platform Terms</li>
        <li>Opt-in and consent rules</li>
        <li>Template approval compliance</li>
      </ul>
    </section>

    <section>
      <h3>7. Data Sharing & Disclosure</h3>
      <ul>
        <li>Meta / WhatsApp</li>
        <li>Cloud hosting providers</li>
        <li>Payment gateways</li>
        <li>Legal authorities if required</li>
      </ul>
      <p>We do not sell personal data to third parties.</p>
    </section>

    <section>
      <h3>8. International Data Transfers</h3>
      <p>If data is transferred outside India or the EU:</p>
      <ul>
        <li>Standard contractual clauses</li>
        <li>Encrypted data transfer</li>
        <li>Meta global infrastructure compliance</li>
      </ul>
    </section>

    <section>
      <h3>9. Data Retention</h3>
      <ul>
        <li>Account and billing data as per law</li>
        <li>Conversation data as configured</li>
        <li>Limited log retention</li>
      </ul>
      <p>Data is deleted or anonymized once no longer required</p>
    </section>

    <section>
      <h3>10. Data Security Measures</h3>
      <p>We implement reasonable security practices including:</p>
      <ul>
        <li>SSL/TLS encryption</li>
        <li>Role-based access control</li>
        <li>Secure APIs & authentication</li>
        <li>Regular audits</li>
        <li>Firewall & intrusion detection</li>
      </ul>
    </section>

    <section>
      <h3>11. Rights of Data Subjects</h3>
      <p>Data subjects have the right to:</p>
      <ul>
        <li>Right to access</li>
        <li>Right to rectification</li>
        <li>Right to erasure</li>
        <li>Right to restrict processing</li>
        <li>Right to data portability</li>
        <li>Right to withdraw consent</li>
      </ul>
    </section>

    <section>
      <h3>12. Customer Responsibilities</h3>
      <p>Customers are responsible for:</p>
      <ul>
        <li>Collecting lawful consent from end users</li>
        <li>Providing privacy notices to their users</li>
        <li>Using WADEMO only for permitted purposes</li>
        <li>Complying with local data protection laws</li>
      </ul>
    </section>

    <section>
      <h3>13. Children’s Data</h3>
      <p>WADEMO does not knowingly process data of children under 18 without verified parental consent.</p>
    </section>

    <section>
      <h3>14. Grievance & Contact</h3>
      <p>Data Protection Officer (DPO):</p>
      <p>Anantkamal Software Labs</p>
      <p><strong>Email:</strong> support@anantkamalwademo.online</p>
      <p><strong>Website:</strong> www.anantkamalwademo.online</p>
    </section>

    <section>
      <h3>15. Policy Updates</h3>
      <p>This Policy may be updated due to regulatory or platform changes. Updated versions will be published on the
        website.</p>
    </section>

    <section>
      <h3>16. Acceptance</h3>
      <p>By using Anantkamal WADEMO, you acknowledge and agree to this GDPR & Data Protection Policy.</p>
    </section>

  </div>

@endsection