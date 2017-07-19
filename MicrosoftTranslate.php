<?php
    $azure_key = "fb5e866046de4193bd91b9154475515b";
    $fromLanguage = "en";
    $toLanguage = "uk";
    $inputStr = $_POST["text"];

    function getToken($azure_key)
    {
        $url = 'https://api.cognitive.microsoft.com/sts/v1.0/issueToken';
        $ch = curl_init();
        $data_string = json_encode('{body}');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string),
                'Ocp-Apim-Subscription-Key: ' . $azure_key
            )
        );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $strResponse = curl_exec($ch);
        curl_close($ch);

        return $strResponse;
    }

    function curlRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $curlResponse = curl_exec($ch);
        curl_close($ch);

        return $curlResponse;
    }

    $accessToken = getToken($azure_key);
    $params = "text=" . urlencode($inputStr) . "&to=" . $toLanguage . "&from=" . $fromLanguage . "&appId=Bearer+" . $accessToken;
    $translateUrl = "http://api.microsofttranslator.com/v2/Http.svc/Translate?$params";
    $curlResponse = curlRequest($translateUrl);
    $translatedStr = simplexml_load_string($curlResponse);

    echo $translatedStr;
