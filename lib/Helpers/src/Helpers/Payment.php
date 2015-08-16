<?php

namespace Helpers;

// Valid PayPal Payments Pro Request Str
// METHOD=DoDirectPayment&amp;amp;USER=sandbo*****e.com&amp;amp;PWD=12***74&amp;amp;SIGNATURE=AiKZ******6W18v&amp;amp;VERSION=85.0&amp;amp;PAYMENTACTION=Sale&amp;amp;IPADDRESS=72.135.111.9&amp;amp;CREDITCARDTYPE=MasterCard&amp;amp;ACCT=5522340006063638&amp;amp;EXPDATE=022013&amp;amp;CVV2=456&amp;amp;FIRSTNAME=Tester&amp;amp;LASTNAME=Testerson&amp;amp;STREET=707+W.+Bay+Drive&amp;amp;CITY=Largo&amp;amp;STATE=FL&amp;amp;COUNTRYCODE=US&amp;amp;ZIP=33770&amp;amp;AMT=100.00&amp;amp;CURRENCYCODE=USD&amp;amp;DESC=Testing+Payments+Pro
// Failed PayPal Payments Pro Response Str
// TIMESTAMP=2012%2d04%2d16T07%3a59%3a36Z&amp;CORRELATIONID=9eb40cd84a7d3&amp;ACK=Success&amp;VERSION=85%2e0&amp;BUILD=2764190&amp;AMT=100%2e00&amp;CURRENCYCODE=USD&amp;AVSCODE=X&amp;CVV2MATCH=M&amp;TRANSACTIONID=160896645A8111040
// Username: wildvaporinc-facilitator_api1.gmail.com
// Password: 1374513219
// Signature: AGOPJbHHU7ZITfuS-vIm3yxR4LHMARJQBnzcZ-HkFUrEFuIlBG9EHRzM

class Payment {
  private $config;

  public function __construct($config) {
    $this->config = $config;
  }

  public function set_express_checkout($app, $cart) {
    $paypal_data = '';

    $i = $subtotal = $total = 0;
    foreach ($cart['cart_items'] as $row) {
      $price = \Helpers\Util::get_just_price($row['price'], $row['sale_price']);
      $paypal_data .= '&L_PAYMENTREQUEST_0_QTY'.$i.'='. urlencode($row['quantity']);
      $paypal_data .= '&L_PAYMENTREQUEST_0_AMT'.$i.'='. urlencode(number_format($price, 2));
      $paypal_data .= '&L_PAYMENTREQUEST_0_NAME'.$i.'='.urlencode($row['name']);
      $paypal_data .= '&L_PAYMENTREQUEST_0_NUMBER'.$i.'='.urlencode($row['id']);

      $subtotal = $price * $row['quantity'];
      $total = $total + $subtotal;
      $i += 1;
    }
    $padata = '&PAYMENTREQUEST_0_PAYMENTACTION=Sale'.
              '&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode('USD').
              '&PAYMENTREQUEST_0_AMT='.urlencode(number_format($cart['total'], 2)).
              '&PAYMENTREQUEST_0_TAXAMT='.urlencode(number_format($cart['tax'], 2)).
              '&PAYMENTREQUEST_0_ITEMAMT='.urlencode(number_format($total, 2)).
              '&ALLOWNOTE=1'.
              $paypal_data.
              '&RETURNURL='.urlencode($app->view()->url_secure('/shop/expresscheckout/return')).
              '&CANCELURL='.urlencode($app->view()->url_secure('/shop/expresscheckout/cancel'));
    $httpParsedResponseAr = $this->pp_http_post('SetExpressCheckout', $padata);

    if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
      $paypalmode = ($this->config['paypal.environment'] == 'sandbox') ? '.sandbox' : '';

      //Redirect user to PayPal store with Token received.
      $paypalurl = 'https://www'.$paypalmode.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr["TOKEN"].'';
      header('Location: '.$paypalurl);
      exit();
    } else {
      throw new \Exception('SetExpressCheckout failed: ' . print_r($httpParsedResponseAr, true));
    }
  }

  public function do_express_checkout($token, $payerid, $cart) {
    $padata = '&TOKEN='.urlencode($token).
              '&PAYERID='.urlencode($payerid).
              '&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode('SALE').
              '&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode('USD').
              '&PAYMENTREQUEST_0_AMT='.urlencode(number_format($cart['total'], 2)).
              '&PAYMENTREQUEST_0_TAXAMT'.urlencode(number_format($cart['tax'], 2)).
              '&PAYMENTREQUEST_0_ITEMAMT='.urlencode(number_format($cart['subtotal'], 2));
              // $paypal_data;
    $httpParsedResponseAr = $this->pp_http_post('DoExpressCheckoutPayment', $padata);

    if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
      $mails = array(
        'customer' => array(),
        'merchant' => array()
      );

      $mails['customer']['body'] = 'Successful Transaction. Here is your transactin ID: ' . urldecode($httpParsedResponseAr['PAYMENTINFO_0_TRANSACTIONID']);
      $mails['merchant']['body'] = 'Successful Transaction. The transaction id of the customer is ID: ' .  urldecode($httpParsedResponseAr['PAYMENTINFO_0_TRANSACTIONID']);

      if('Completed' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"]) {
        $mails['customer']['body'] .= '<br />Payment Received! Your product will be sent to you very soon! Thank you for buying.';
        $mails['merchant']['body'] .= '<br />Payment Received! Your really need to send the products.';
      } elseif('Pending' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"]) {
        $mails['customer']['body'] .= '<br />Transaction Complete, but payment is still pending! You need to manually authorize this payment in your Paypal Account.';
        $mails['merchant']['body'] .= '<br />Transaction Complete, but payment is still pending! The customer needs to manually authorize this payment on his Paypal Account.';
      }

      $transactionID = urlencode($httpParsedResponseAr["PAYMENTINFO_0_TRANSACTIONID"]);
      $nvpStr = "&TRANSACTIONID=".$transactionID;
      $httpParsedResponseAr = $this->pp_http_post('GetTransactionDetails', $nvpStr);

      if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
        $mails['customer']['to'] = urldecode($httpParsedResponseAr['EMAIL']);
        $mails['customer']['name'] = urldecode($httpParsedResponseAr['FIRSTNAME']) . ' ' . urldecode($httpParsedResponseAr['LASTNAME']);

        $mails['merchant']['body'] .= '<br /><br /><h2>CART DATA</h2>';
        foreach ($cart['cart_items'] as $row) {
          $mails['merchant']['body'] .= '<br />' . $row['quantity'] . ' X ' . $row['name'];
        }
        $mails['merchant']['body'] .= '<br /><br /><strong>Total Price: </strong>' . number_format($cart['total'], 2);

        $mails['merchant']['body'] .= '<br /><br /><h2>Customer Data</h2>';
        foreach ($httpParsedResponseAr as $k => $v) {
          $mails['merchant']['body'] .= '<br /><strong>' . $k . ': </strong>' . urldecode($v);
        }

        $result = $this->send_express_checkout_mails($mails);
        if (!is_array($result)) {
          return $result;
        } else {
          throw new \Exception($result['error']);
        }
      } else  {
        throw new \Exception('GetTransactionDetails failed: ' . print_r($httpParsedResponseAr, true));
      }
    } else {
      throw new \Exception('DoExpressCheckoutPayment failed: ' . print_r($httpParsedResponseAr, true));
    }

    return $result;
  }

  public function direct_payment($order_total, $data) {
    // Set request-specific fields.
    $paymentType = urlencode('SALE');
    $firstName = urlencode($data['first_name']);
    $lastName = urlencode($data['last_name']);
    // $creditCardType = urlencode('customer_credit_card_type');
    $creditCardNumber = urlencode($data['cc_number']);
    $expDateMonth = urlencode($data['cc_exp_month']);
    // Month must be padded with leading zero
    $padDateMonth = urlencode(str_pad($expDateMonth, 2, '0', STR_PAD_LEFT));
    $expDateYear = urlencode($data['cc_exp_year']);
    $cvv2Number = urlencode($data['cc_cvv']);

    $address1 = urlencode($data['billing_address1']);
    $address2 = urlencode($data['billing_address2']);
    $city = urlencode($data['billing_city']);
    $state = urlencode($data['billing_state']);
    $zip = urlencode($data['billing_zip_code']);
    $country = urlencode('US'); // US or other valid country code
    $amount = urlencode(number_format($order_total, 2));
    $currencyID = urlencode('USD'); // or other currency ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')
    $ipAddress = urlencode($_SERVER['REMOTE_ADDR']);
    // $ipAddress = urlencode('255.255.255.255');
    $desc = urlencode('Payment for order at WildVapor');

    $nvpStr ="&PAYMENTACTION=$paymentType&AMT=$amount".
      "&ACCT=$creditCardNumber&EXPDATE=$padDateMonth$expDateYear&CVV2=$cvv2Number".
      "&FIRSTNAME=$firstName&LASTNAME=$lastName&STREET=$address1&STREET2=$address2&CITY=$city".
      "&STATE=$state&ZIP=$zip&COUNTRYCODE=$country&CURRENCYCODE=$currencyID".
      "&IPADDRESS=$ipAddress&DESC=$desc";

    if ($this->config['live']) {
      try {
        $httpParsedResponseAr = $this->pp_http_post('DoDirectPayment', $nvpStr);

        if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
          return $httpParsedResponseAr;
        } else {
          throw new \Exception('DoDirectPayment failed: ' . print_r($httpParsedResponseAr, true));
        }
      } catch (\Exception $e) {
        throw $e;
      }
    } else {
      return array(
        'TRANSACTIONID' => rand(20, 200),
        'AMT' => $order_total,
        'AVSCODE' => 'A',
        'CVV2MATCH' => 'OK',
        'L_FMFfilterIDn' => 0,
        'L_FMFfilterNAMEn' => 0
      );
    }
  }

  private function send_express_checkout_mails($mails) {
    if ($this->config['live']) {
      $body = file_get_contents(BASE_URI . DS . 'views' . DS . 'mail_template.html');
      $body = str_replace('{{title}}', 'Order Confirmation at WildVapor Inc', $body);
      $body = str_replace('{{message}}', $mails['customer']['body'], $body);
      $data_customer = array(
        'live' => $this->config['live'],
        'mail_username' => $this->config['mail_username'],
        'mail_password' => $this->config['mail_password'],
        'mail_to_address' => $mails['customer']['to'],
        'mail_to_name' => $mails['customer']['name'],
        'subject' => 'Order confirmation at WildVapor Inc.',
        'body' => $body,
        'mail_from' => $this->config['mail_from'],
      );

      $body = file_get_contents(BASE_URI . DS . 'views' . DS . 'mail_template.html');
      $body = str_replace('{{title}}', 'New Order at WildVapor Inc', $body);
      $body = str_replace('{{message}}', $mails['merchant']['body'], $body);
      $data_merchant = array(
        'live' => $this->config['live'],
        'mail_username' => $this->config['mail_username'],
        'mail_password' => $this->config['mail_password'],
        'mail_to_address' => $this->config['mail_from'],
        'mail_to_name' => 'Marcos Escandell',
        'subject' => 'New Order at WildVapor Inc.',
        'body' => $body,
        'mail_from' => $this->config['mail_from'],
      );

      $m1 = new \Helpers\Mailer($data_customer);
      $m2 = new \Helpers\Mailer($data_merchant);
      if ($m1->sendMail() && $m2->sendMail()) {
        return $mails['customer']['body'];
      } else {
        return array('error' => $m1->getError() . '\\n\\n' . $m2->getError());
      }
    } else {
      return print_r($mails, true);
    }
  }

  public function send_direct_payment_mails($order_id, $cart, $data) {
    if ($this->config['live']) {
      $mails = array(
        'customer' => array(),
        'merchant' => array()
      );

      $mails['customer']['body'] = "Thank you for your order. Your order number is {$order_id}. All orders are processed on the next business day. You will be contacted in case of any delays.";
      $mails['merchant']['body'] = 'New Order. The order number is ' . $order_id;

      $mails['customer']['body'] .= '<br />Payment Received! Your product will be sent to you very soon! Thank you for buying.';
      $mails['merchant']['body'] .= '<br />Payment Received! Your really need to send the products.';

      $mails['merchant']['body'] .= '<br /><br /><h2>CART DATA</h2>';
      foreach ($cart['cart_items'] as $row) {
        $mails['merchant']['body'] .= '<br />' . $row['quantity'] . ' X ' . $row['name'];
      }
      $mails['merchant']['body'] .= '<br /><br /><strong>Total Price: </strong>' . number_format($cart['total'], 2);

      $mails['merchant']['body'] .= '<br /><br /><h2>Customer Data</h2>';
      $mails['merchant']['body'] .= '<br /><strong>First Name: </strong>' . $data['first_name'];
      $mails['merchant']['body'] .= '<br /><strong>Last Name: </strong>' . $data['last_name'];
      $mails['merchant']['body'] .= '<br /><strong>Email Address: </strong>' . $data['email'];
      $mails['merchant']['body'] .= '<br /><strong>Phone Number: </strong>' . $data['phone'];
      $mails['merchant']['body'] .= '<br /><strong>Shipping Address1: </strong>' . $data['shipping_address1'];
      $mails['merchant']['body'] .= '<br /><strong>Shipping Address2: </strong>' . $data['shipping_address2'];
      $mails['merchant']['body'] .= '<br /><strong>Shipping City: </strong>' . $data['shipping_city'];
      $mails['merchant']['body'] .= '<br /><strong>Shipping State: </strong>' . $data['shipping_state'];
      $mails['merchant']['body'] .= '<br /><strong>Shipping Zip Code: </strong>' . $data['shipping_zip_code'];
      $mails['merchant']['body'] .= '<br /><strong>Billing Address1: </strong>' . $data['billing_address1'];
      $mails['merchant']['body'] .= '<br /><strong>Billing Address2: </strong>' . $data['billing_address2'];
      $mails['merchant']['body'] .= '<br /><strong>Billing City: </strong>' . $data['billing_city'];
      $mails['merchant']['body'] .= '<br /><strong>Billing State: </strong>' . $data['billing_state'];
      $mails['merchant']['body'] .= '<br /><strong>Billing Zip Code: </strong>' . $data['billing_zip_code'];

      $body = file_get_contents(BASE_URI . DS . 'views' . DS . 'mail_template.html');
      $body = str_replace('{{title}}', 'Order Confirmation at WildVapor Inc', $body);
      $body = str_replace('{{message}}', $mails['customer']['body'], $body);
      $data_customer = array(
        'live' => $this->config['live'],
        'mail_username' => $this->config['mail_username'],
        'mail_password' => $this->config['mail_password'],
        'mail_to_address' => $data['email'],
        'mail_to_name' => $data['first_name'] . ' ' . $data['last_name'],
        'subject' => 'Order confirmation at WildVapor Inc.',
        'body' => $body,
        'mail_from' => $this->config['mail_from'],
      );

      $body = file_get_contents(BASE_URI . DS . 'views' . DS . 'mail_template.html');
      $body = str_replace('{{title}}', 'New Order at WildVapor Inc', $body);
      $body = str_replace('{{message}}', $mails['merchant']['body'], $body);
      $data_merchant = array(
        'live' => $this->config['live'],
        'mail_username' => $this->config['mail_username'],
        'mail_password' => $this->config['mail_password'],
        'mail_to_address' => $this->config['mail_from'],
        'mail_to_name' => 'Marcos Escandell',
        'subject' => 'New Order at WildVapor Inc.',
        'body' => $body,
        'mail_from' => $this->config['mail_from'],
      );

      $m1 = new \Helpers\Mailer($data_customer);
      $m2 = new \Helpers\Mailer($data_merchant);
      if ($m1->sendMail() && $m2->sendMail()) {
        return true;
      } else {
        return array('error' => $m1->getError() . '\\n\\n' . $m2->getError());
      }
    } else {
      return true;
    }
  }

  private function pp_http_post($methodName, $nvpStr) {
    // Set up your API credentials, PayPal end point, and API version.
    $API_UserName = urlencode($this->config['paypal.username']);
    $API_Password = urlencode($this->config['paypal.password']);
    $API_Signature = urlencode($this->config['paypal.signature']);
    $API_Endpoint = "https://api-3t.paypal.com/nvp";
    if("sandbox" === $this->config['paypal.environment']) {
      $API_Endpoint = 'https://api-3t.sandbox.paypal.com/nvp';
    }
    $version = urlencode($this->config['paypal.version']);

    // Set the curl parameters.
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);

    // Turn off the server and peer verification (TrustManager Concept).
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);

    // Set the API operation, version, and API signature in the request.
    $nvpreq = "METHOD=$methodName&VERSION=$version&PWD=$API_Password&USER=$API_UserName".
      "&SIGNATURE=$API_Signature$nvpStr";

    // Set the request as a POST FIELD for curl.
    curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

    // Get response from the server.
    $httpResponse = curl_exec($ch);

    if(!$httpResponse) {
      throw new \Exception("$methodName failed: ".curl_error($ch).'('.curl_errno($ch).')');
    }
    curl_close($ch);

    // Extract the response details.
    $httpResponseAr = explode("&", $httpResponse);

    $httpParsedResponseAr = array();
    foreach ($httpResponseAr as $i => $value) {
      $tmpAr = explode("=", $value);
      if(sizeof($tmpAr) > 1) {
        $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
      }
    }

    if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
      throw new \Exception("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
    }

    return $httpParsedResponseAr;
  }
}
