<?php
$api = $_GET['api'];
if($api == "True"){
global $wpdb;
$results = $wpdb->get_results( "SELECT * FROM `wpsl_wc_order_stats` ORDER BY `wpsl_wc_order_stats`.`order_id` DESC limit 1");
$orderID = "";
if(!empty($results))                        // Checking if $results have some values or not
{
    foreach($results as $row){
        $orderID = $row->order_id;
    }
}
$results = $wpdb->get_results( "SELECT * FROM `wpsl_postmeta` WHERE post_id = $orderID 
ORDER BY `wpsl_postmeta`.`meta_id` ASC");

$userData = array();
if(!empty($results))                        // Checking if $results have some values or not
{

    foreach($results as $row){
        $userData["$row->meta_key"] = $row->meta_value;
    }
}
if(sizeof($userData)>0){
    $customerName = $userData['_billing_first_name'] ." ". $userData['_billing_last_name'];
    $customerEmail = $userData['_billing_email'];
    $customerPhone = $userData['_billing_phone'];
    $customerGender = $userData['_billing_gender'];
    $customerArea = $userData['_shipping_address_1'];
    $customerCity = $userData['_shipping_city'];
    $dateOfBirth = $userData['_billing_dateofbirth'];
    $dateOfBirth = str_replace('/', '-', $dateOfBirth);

    $dateOfBirth = date('Y-m-d', strtotime($dateOfBirth));
    $passportNumber = $userData['_billing_passport'];
    $nationality = $userData['_billing_ethnicity'];
    $ethnicity = $userData['_billing_ethnicity'];
    $totalAmount = $userData['_order_total'];
    $orderNumber = $userData['_alg_wc_custom_order_number'];
    $orderNumber = "OPTIM000"  . $orderNumber;
    $testID = 4534960;
    $date = new DateTime("now", new DateTimeZone('Europe/London') );
    $date =  $date->format(DateTime::ATOM);


    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://staging.livehealth.solutions/LHRegisterBillAPI/149341c4-a81c-11eb-b505-0a801588e00c/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
    "mobile": "' . $customerPhone .'",
    "email": "' . $customerEmail .'",
    "designation": "",
    "fullName": "' . $customerName .'",
    "age": 25,
    "gender": "' . $customerGender .'",
    "area": "' . $customerArea .'",
    "city": "' . $customerCity .'",
    "patientType": "",
    "labPatientId": "",
    "pincode": "",
    "patientId": "",
    "dob": "' . $dateOfBirth .'",
    "passportNo": "' . $passportNumber .'",
    "panNumber": "",
    "aadharNumber": "",
    "insuranceNo": "",
    "nationality": "' . $nationality .'",
    "ethnicity": "' . $ethnicity .'",
    "nationalIdentityNumber": "",
    "workerCode": "",
    "doctorCode": "",
    "isAppointmentRequest": 1,
    "startDate": "' . $date .'",
    "endDate": "' . $date .'",
    "billDetails": {
        "emergencyFlag": "0",
        "totalAmount": "' . $totalAmount .'",
        "advance": "0",
        "billDate": " ' . $date .'",
        "paymentType": "Stripe",
        "referralName": "",
        "otherReferral": "",
        "sampleId": "",
        "orderNumber": "' . $orderNumber .'",
        "referralIdLH": "",
        "organisationName": "",
        "additionalAmount": "",
        "organizationIdLH": 235125,
        "comments": "",
        "testList": [
            {
                "testID": ' . $testID .',
                "testCode": "",
                "integrationCode": "",
                "dictionaryId": ""
            }
        ],
        "paymentList": [
            {
                "paymentType": "Stripe",
                "paymentAmount": "' . $totalAmount .'",
                "issueBank": ""
            }
        ]
    }
}',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);
    $responseArray = json_decode($response, true);
    curl_close($curl);
 echo "<script>console.log('".$responseArray ."')</script>";
    echo $response;
}else{
    echo "Function Not Call";
    return;
}
}
?>