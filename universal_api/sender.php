<?php

// Allow CORS (optional)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");

// Allow only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Only POST requests are allowed."]);
    exit;
}

// Read JSON input
$inputRaw = file_get_contents("php://input");
$inputData = json_decode($inputRaw, true) ?? $_POST;

// Sanitize helper functions
function sanitize_text($value) {
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

function validate_url($url) {
    return filter_var($url, FILTER_VALIDATE_URL);
}

function validate_phone($phone) {
    return preg_match('/^\d{10,15}$/', $phone);
}

// Extract & sanitize
$phone = sanitize_text($inputData['phone'] ?? '');
$template_name = sanitize_text($inputData['template_name'] ?? '');
$template_language = sanitize_text($inputData['template_language'] ?? 'en');
$header = sanitize_text($inputData['header'] ?? '');
$file_name = sanitize_text($inputData['file_name'] ?? '');
$token = sanitize_text($inputData['token'] ?? '');
$type = sanitize_text($inputData['type'] ?? '');
$otp_code = sanitize_text($inputData['otp_code'] ?? '');

// Validate required parameters
if (empty($phone) || empty($template_name) || empty($template_language) || empty($token)) {
    echo json_encode(["error" => "Missing required parameters: phone, template_name, template_language, and token"]);
    exit;
}
if (!validate_phone($phone)) {
    echo json_encode(["error" => "Invalid phone number format."]);
    exit;
}

// Determine header type
function getHeaderType($value) {
    $extension = strtolower(pathinfo($value, PATHINFO_EXTENSION));

    $videoTypes = ['mp4'];
    $documentTypes = ['pdf'];
    $imageTypes = ['jpg', 'jpeg', 'png'];

    if (in_array($extension, $documentTypes)) {
        return ['type' => 'document', 'value' => $value];
    } elseif (in_array($extension, $videoTypes)) {
        return ['type' => 'video', 'value' => $value];
    } elseif (in_array($extension, $imageTypes)) {
        return ['type' => 'image', 'value' => $value];
    } else {
        return ['type' => 'text', 'value' => $value];
    }
}

$headerComponent = [];
if (!empty($header) && validate_url($header)) {
    $headerInfo = getHeaderType($header);
    $headerType = $headerInfo['type'];
    $headerValue = $headerInfo['value'];

    if ($headerType === 'document') {
        $headerComponent = [
            "type" => "header",
            "parameters" => [[
                "type" => "document",
                "document" => [
                    "link" => $headerValue,
                    "filename" => $file_name ?: basename($headerValue)
                ]
            ]]
        ];
    } elseif ($headerType === 'video') {
        $headerComponent = [
            "type" => "header",
            "parameters" => [[
                "type" => "video",
                "video" => [
                    "link" => $headerValue
                ]
            ]]
        ];
    } elseif ($headerType === 'image') {
        $headerComponent = [
            "type" => "header",
            "parameters" => [[
                "type" => "image",
                "image" => [
                    "link" => $headerValue
                ]
            ]]
        ];
    } elseif ($headerType === 'text') {
        $headerComponent = [
            "type" => "header",
            "parameters" => [[
                "type" => "text",
                "text" => $headerValue
            ]]
        ];
    }
}

// Handle dynamic body parameters (text1 to text6)
$bodyParameters = [];
foreach ($inputData as $key => $value) {
    if (preg_match('/^text\d+$/', $key) && !empty($value)) {
        $bodyParameters[] = ["type" => "text", "text" => sanitize_text($value)];
        if (count($bodyParameters) >= 18) break; // limit to 6 parameters
    }
}

// OTP component
$otpComponents = [];
if (!empty($otp_code) && $type == "otp") {
    $otpComponents[] = [
        "type" => "otp",
        "otp" => [
            "code" => $otp_code
        ]
    ];
}

// Flow component
$typeComponents = [];
if (!empty($type) && $type == "flow") {
    $typeComponents[] = [
        "type" => "flow"
    ];
}

// Button URLs
$buttonComponents = [];
if (!empty($type) && $type == "coupon") {
     $buttonComponents[] = [
                "type" => "button",
                "sub_type" => "copy_code",
                "index" => 0,
                "parameters" => [
                    [
                        "type" => "coupon_code",
                        "coupon_code" => sanitize_text($inputData['buttonURL1'] ?? '')
                    ]
                ]
            ];
} else {
    for ($i = 1; $i <= 2; $i++) {
        $key = "buttonURL$i";
        if (!empty($inputData[$key])) {
            $buttonComponents[] = [
                "type" => "button",
                "sub_type" => "url",
                "index" => (string)($i - 1),
                "parameters" => [
                    [
                        "type" => "text",
                        "text" => sanitize_text($inputData[$key])
                    ]
                ]
            ];
        }
    }
}
// Build full payload
$payload = [
    "token" => $token,
    "phone" => $phone,
    "template_name" => $template_name,
    "template_language" => $template_language,
    "components" => []
];

// Add components
if (!empty($headerComponent)) $payload["components"][] = $headerComponent;
if (!empty($otpComponents)) $payload["components"] = array_merge($payload["components"], $otpComponents);
if (!empty($typeComponents)) $payload["components"] = array_merge($payload["components"], $typeComponents);
if (!empty($bodyParameters)) {
    $payload["components"][] = [
        "type" => "body",
        "parameters" => $bodyParameters
    ];
}
if (!empty($buttonComponents)) $payload["components"] = array_merge($payload["components"], $buttonComponents);

        
// WhatsApp API URL
$url = 'https://wa.tryowbot.com/api/wpbox/sendtemplatemessage';

// Send cURL request
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$response = curl_exec($ch);
curl_close($ch);

// Format response
$data = json_decode($response, true) ?? [];
if (empty($data['message_wamid'])) $data['status'] = "fail";

echo json_encode($data, JSON_PRETTY_PRINT);

?>
