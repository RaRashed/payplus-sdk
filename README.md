# Payplus Payment SDK

This PHP SDK allows you to integrate Payplus payment gateway easily, enabling payment link generation and payment processing.

## Installation

### Prerequisites

Make sure that you have PHP 7.4 or higher installed on your system, along with Composer for dependency management.

1. **Install Composer** if you haven't already:

   Follow the official [Composer installation guide](https://getcomposer.org/download/) for your system.

2. **Install the SDK**:

   In your project directory, run the following command to install the SDK via Composer:

   ```bash
   composer require rarashed/payplus-sdk
   ```
   #OR
   ```bash
   composer require rarashed/payplus-sdk --no-plugins
   ```
   #To configure the SDK, provide your Payplus API credentials and set the appropriate URLs for testing or production environments.

   ```bash
   use RaRashed\PayplusSdk\Payplus;
   ```
   
#Define constants for currency and URLs
```bash
const CURRENCY = "ILS"; // Payment currency
const TEST = "https://restapidev.payplus.co.il/api/v1.0/PaymentPages/generateLink"; // Test URL
const PRODUCTION = "https://restapi.payplus.co.il/api/v1.0/PaymentPages/generateLink"; // Production URL
```

# Configuration array
```bash
$config = [
    'payment_page_uid' => 'your_payment_page_uid', # Your unique Payment Page ID
    'api_key' => 'your_api_key',                    # Your Payplus API Key
    'secret_key' => 'your_secret_key',              # Your Payplus Secret Key
    'payment_url' => PRODUCTION                     # API Endpoint URL (use TEST for sandbox environment)
];
```
# Instantiate the Payplus SDK with the configuration
```bash
$payplus = new Payplus($config);
```
#After configuring the SDK, you can send payment data to the Payplus API to generate a payment link. Here's an example:
```bash
$paymentData = [
    "payment_page_uid" => $config['payment_page_uid'], // Required: Payment Page UID
    "expiry_datetime" => "30",                        // Payment link expiry time (in minutes)
    "refURL_success" => "https://webhook.site",       // Redirect URL upon successful payment
    "refURL_failure" => "https://webhook.site",       // Redirect URL upon failed payment
    "refURL_callback" => "https://webhook.site",      // Callback URL for payment status updates
    "customer" => [
        "customer_name" => "John Doe",                // Customer's full name
        "email" => "john.doe@example.com",            // Customer's email address
        "phone" => "1234567890"                       // Customer's phone number
    ],
    "items" => [
        [
            "name" => "Transaction Item",             // Item description
            "quantity" => 1,                          // Quantity of the item
            "price" => 100,                           // Item price
            "vat_type" => 0                           // VAT type (0 = no VAT)
        ]
    ],
    "amount" => 100,                                  // Total transaction amount
    "payments" => 1,                                  // Number of payments to be processed
    "currency_code" => CURRENCY,                      // Payment currency (e.g., ILS for Israeli Shekel)
    "sendEmailApproval" => true,                      // Whether to send an approval email
    "sendEmailFailure" => false                       // Whether to send a failure email
];
```
#Process the payment request and receive a response
```bash
$response = $payplus->processPayment($paymentData);
```

# Handle the response
```bash
if (is_string($response)) {
    // Redirect the user to the generated payment page link
    header("Location: " . $response);
    exit;
} elseif (is_array($response) && $response['status'] === 'error') {
    // Handle error (e.g., display or log the error)
    echo json_encode($response);
}
```

#success and callback url will pass status and transaction id


   
