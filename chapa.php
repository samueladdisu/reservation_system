<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuriftu Resorts - Chapa</title>
</head>
<body>
    
<form method="POST" action="https://api.chapa.co/v1/hosted/pay" >
    <input type="hidden" name="public_key" value="YOUR_PUBLIC_API_KEY" />
    <input type="hidden" name="tx_ref" value="negade-tx-12345678sss9" />
    <input type="hidden" name="amount" value="100" />
    <input type="hidden" name="currency" value="ETB" />
    <input type="hidden" name="email" value="israel@negade.et" />
    <input type="hidden" name="first_name" value="Israel" />
    <input type="hidden" name="last_name" value="Goytom" />
    <input type="hidden" name="logo" value="https://yourcompany.com/logo.png" />
    <input type="hidden" name="callback_url" value="https://example.com/callbackurl" />
    <input type="hidden" name="return_url" value="https://example.com/returnurl" />
    <input type="hidden" name="meta[title]" value="test" />
    <button type="submit">Pay Now</button>
</form>
</body>
</html>