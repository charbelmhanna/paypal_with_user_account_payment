class PayPalController extends Controller
{
    public function handlePayment()
    {
        if(env('PAYPAL_MODE') === 'sandbox'){
            $url = "https://api-m.sandbox.paypal.com/v1/oauth2/token";
            $authorizationEncoded = 'Basic ' . base64_encode(env("PAYPAL_CLIENT_ID_SANDBOX") . ':' . env("PAYPAL_SANDBOX_SECRET"));
        }else{
            $url = "https://api-m.paypal.com/v1/oauth2/token";
            $authorizationEncoded = 'Basic ' . base64_encode(env("PAYPAL_CLIENT_ID_PRODUCTION") . ':' . env("PAYPAL_PRODUCTION_SECRET"));
        }



        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Accept: application/json",
            "Accept-Language: en_US",
            "Content-Type: application/x-www-form-urlencoded",
            "Authorization:" . $authorizationEncoded,
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = "grant_type=client_credentials";

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);


        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);

        $resp = json_decode($resp);


        $merchant_id = $supplier->payee_id ? $supplier->payee_id : $supplier->paypal_email;
        $emailOrMerchant = $supplier->payee_id ? 'merchant_id' : 'email_address';
        $access_token = $resp->access_token;

       



        if(env('PAYPAL_MODE') === 'sandbox'){
            $url2 = "https://api-m.sandbox.paypal.com/v2/checkout/orders";
        }else{
            $url2 = "https://api-m.paypal.com/v2/checkout/orders";
        }


        $curl2 = curl_init($url2);
        curl_setopt($curl2, CURLOPT_URL, $url2);
        curl_setopt($curl2, CURLOPT_POST, true);
        curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true);




        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer " . $access_token,
        );
        curl_setopt($curl2, CURLOPT_HTTPHEADER, $headers);


        $data = array (
            'intent' => 'CAPTURE',
            'purchase_units' =>
                array (
                    0 =>
                        array (
                            'amount' =>
                                array (
                                    'currency_code' => 'USD',
                                    'value' => $total,
                                ),
                            'payee' =>
                                array (
                                    $emailOrMerchant => $merchant_id,
                                ),
                        ),
                ),
            'application_context' =>
                array (
                    'return_url' => route('success.payment'),
                    'cancel_url' => route('cancel.payment'),
                ),
        );




        curl_setopt($curl2, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl2, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl2);
        curl_close($curl2);

        $resp = json_decode($resp);
   





        return redirect($resp->links[1]->href);
             }





public function paymentSuccess(Request $request)
    {

        $cart = [your session];

        if($cart){

            if(session()->has([your session]) === false){
                return redirect()->route('payment.error');
            }

            if(env('PAYPAL_MODE') === 'sandbox'){
                $url = "https://api.sandbox.paypal.com/v2/checkout/orders/".$request->token."/capture";
            }else{
                $url = "https://api.paypal.com/v2/checkout/orders/.$request->token./capture";
            }


            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $headers = array([your session]'access_token'),
                "content-type: application/json",
                "Content-Length: 0",
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $resp = curl_exec($curl);
            curl_close($curl);

            $resp = json_decode($resp);




            if ($resp->status === 'COMPLETED') {
                    

                    your code here if response is completed
                    if ou want to update your the order to complete or redirect user to payment success

                }

                $notification = array(
                    'message' => 'Your order is placed successfully !!!',
                    'alert-type' => 'success'
                );
                return redirect()->route('payment.success')->with($notification);
            }
            return redirect()->route('payment.error');
        }
        return redirect()->route('payment.error');
    }
        }


