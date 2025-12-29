<!DOCTYPE html>
<html>
<head>
    <title>New Contact Form Submission</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f8f9fa; padding: 20px; text-align: center; }
        .content { padding: 20px; background-color: #fff; }
        .footer { margin-top: 20px; padding: 10px; text-align: center; font-size: 12px; color: #777; }
        .detail-row { margin-bottom: 15px; }
        .detail-label { font-weight: bold; color: #555; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New Contact Form Submission</h2>
        </div>
        
        <div class="content">
            <div class="detail-row">
                <span class="detail-label">Name:</span>
                <span>{{ $formData['name'] }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Email:</span>
                <span>{{ $formData['email'] }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Phone:</span>
                <span>{{ $formData['full_phone'] }}</span>
            </div>
            
            @if(!empty($formData['company']))
            <div class="detail-row">
                <span class="detail-label">Company:</span>
                <span>{{ $formData['company'] }}</span>
            </div>
            @endif
            
            <div class="detail-row">
                <span class="detail-label">Subject:</span>
                <span>{{ $formData['subject'] }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Message:</span>
                <p style="margin-top: 5px; white-space: pre-line;">{{ $formData['message'] }}</p>
            </div>
        </div>
        
        <div class="footer">
            <p>This email was sent from the contact form on {{ config('app.name') }}</p>
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>