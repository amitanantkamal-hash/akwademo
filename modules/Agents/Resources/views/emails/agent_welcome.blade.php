<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ $company->name ?? config('app.name') }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
            padding: 20px;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }
        
        .email-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .email-header p {
            font-size: 16px;
            opacity: 0.9;
        }
        
        .email-body {
            padding: 40px 30px;
        }
        
        .welcome-section {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .welcome-section h2 {
            color: #2d3748;
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .credentials-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 25px;
            margin: 25px 0;
        }
        
        .credential-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .credential-item:last-child {
            border-bottom: none;
        }
        
        .credential-label {
            font-weight: 600;
            color: #4a5568;
        }
        
        .credential-value {
            font-weight: 700;
            color: #2d3748;
            background: #edf2f7;
            padding: 6px 12px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
        }
        
        .login-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            transition: transform 0.2s;
        }
        
        .login-button:hover {
            transform: translateY(-2px);
        }
        
        .security-notice {
            background: #fffaf0;
            border: 1px solid #fed7aa;
            border-radius: 6px;
            padding: 20px;
            margin: 25px 0;
        }
        
        .security-notice h4 {
            color: #c05621;
            margin-bottom: 10px;
        }
        
        .steps-section {
            margin: 30px 0;
        }
        
        .step {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        
        .step-number {
            background: #667eea;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .step-content h4 {
            color: #2d3748;
            margin-bottom: 5px;
        }
        
        .support-section {
            text-align: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #e2e8f0;
        }
        
        .email-footer {
            background: #f7fafc;
            padding: 25px 30px;
            text-align: center;
            color: #718096;
            font-size: 14px;
        }
        
        @media (max-width: 600px) {
            .email-body {
                padding: 25px 20px;
            }
            
            .credential-item {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .credential-value {
                margin-top: 5px;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>Welcome Aboard! 🎉</h1>
            <p>Your agent account has been created successfully</p>
        </div>
        
        <!-- Body -->
        <div class="email-body">
            <!-- Welcome Section -->
            <div class="welcome-section">
                <h2>Hello, {{ $agent->name }}!</h2>
                <p>You've been added as an agent to <strong>{{ $company->name ?? config('app.name') }}</strong></p>
            </div>
             
            <!-- Credentials Card -->
            <div class="credentials-card">
                <h3 style="color: #2d3748; margin-bottom: 20px; text-align: center;">Your Login Credentials</h3>
                
                <div class="credential-item">
                    <span class="credential-label">Login URL:</span>
                    <span class="credential-value">{{ $loginUrl }}</span>
                </div>
                
                <div class="credential-item">
                    <span class="credential-label">Email Address:</span>
                    <span class="credential-value">{{ $email }}</span>
                </div>
                
                <div class="credential-item">
                    <span class="credential-label">Password:</span>
                    <span class="credential-value">{{ $plainPassword }}</span>
                </div>
            </div>
            
            <!-- Login Button -->
            <div style="text-align: center;">
                <a href="{{ $loginUrl }}" class="login-button">Login to Your Account</a>
            </div>
            
            <!-- Security Notice -->
            <div class="security-notice">
                <h4>🔒 Security Notice</h4>
                <p>For your security, we recommend:</p>
                <ul style="margin-left: 20px; margin-top: 10px;">
                    <li>Change your password after first login</li>
                    <li>Enable two-factor authentication</li>
                    <li>Do not share your credentials with anyone</li>
                </ul>
            </div>
            
            <!-- Getting Started Steps -->
            <div class="steps-section">
                <h3 style="color: #2d3748; margin-bottom: 20px;">Getting Started</h3>
                
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h4>Login to Your Account</h4>
                        <p>Use the credentials above to access your agent dashboard</p>
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h4>Complete Your Profile</h4>
                        <p>Add your profile picture and update your contact information</p>
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h4>Explore Features</h4>
                        <p>Familiarize yourself with the agent tools and customer management system</p>
                    </div>
                </div>
            </div>
            
            <!-- Support Section -->
            <div class="support-section">
                <h4>Need Help?</h4>
                <p>Our support team is here to help you get started</p>
                <p>
                    <strong>Email:</strong> support@anantkamalsoftwarelab.com <br>
                    <strong>Hours:</strong> Monday-Friday, 9AM-6PM
                </p>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} {{ $company->name ?? config('app.name') }}. All rights reserved.</p>
            <p>This is an automated message. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html> 