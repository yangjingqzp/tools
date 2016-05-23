<?php
function iso_receipt_validate($base64_encode_receipt_data)
{
    $receipt = json_encode(
            ['receipt-data' => $base64_encode_receipt_data]
        );

    $options = [
       'http' => [
           'header'  => "Content-type: application/x-www-form-urlencoded",
           'method'  => 'POST',
           'content' => $receipt
       ],
   ];
   $context = stream_context_create($options);
   $endpoint = 'https://sandbox.itunes.apple.com/verifyReceipt';
   // $endpoint = 'https://buy.itunes.apple.com/verifyReceipt';
   $result = file_get_contents($endpoint, false, $context);
   if ($result === false)
   {
       return false;
   }

   // Decode json object (TRUE variable decodes as an associative array)
   return json_decode($result, true);
}