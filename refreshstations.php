<?php
date_default_timezone_set('Europe/Bratislava');
function checkResponseCode($domain)
{
    $headers = get_headers($domain);
    return substr($headers[0], 9, 3);
}

function refreshStations()
{
    $options = array('http' => array('user_agent' => 'RadioRPi-ra1g-eu/1.0'));
    $context = stream_context_create($options);
    // KONFIGURACIA:
    $order = "votes"; //zoradenie (name, url, homepage, favicon, tags, country, state, language, votes, codec, bitrate, lastcheckok, lastchecktime, clicktimestamp, clickcount, clicktrend, changetimestamp, random)
    $reverse = "true"; // smer zoradenia (true, false)
    $hidebroken = "true"; //schovat pokazene radia (true, false)
    $limit = "80"; //ciselny limit na pocet radii

    $czStations = "https://de1.api.radio-browser.info/json/stations/bycountrycodeexact/cz?order=" . $order . "&reverse=" . $reverse . "&hidebroken=" . $hidebroken . "&limit=" . $limit;
    if (checkResponseCode($czStations) == 200) {
        $json = file_get_contents($czStations, false, $context);
        $json_data = json_decode($json, true);
        //var_dump($json_data);
        file_put_contents('czStations.json', json_encode($json_data));
    } else {
        echo 'CZErrorTryAgain';
        exit();
    }
    $skStations = "https://de1.api.radio-browser.info/json/stations/bycountrycodeexact/sk?order=" . $order . "&reverse=" . $reverse . "&hidebroken=" . $hidebroken . "&limit=" . $limit;
    if (checkResponseCode($skStations) == 200) {
        $skJson = file_get_contents($skStations, false, $context);
        $skjson_data = json_decode($skJson, true);
        //var_dump($json_data);
        file_put_contents('skStations.json', json_encode($skjson_data));
    } else {
        echo 'SKErrorTryAgain';
        exit();
    }
}

function generateTags($json_decoded)
{
    $tags_array = array();
    foreach ($json_decoded as $key => $jsondata) {
        if (!empty($jsondata['tags'])) {
            $tags = explode(',', $jsondata['tags']);
            foreach ($tags as $tag) {
                if (!in_array($tag, $tags_array)) {
                    array_push($tags_array, $tag);
                }
            }
        }
    }
    file_put_contents('allTags.json', json_encode($tags_array));
}

function lastRefresh($timeInterval = 43200): bool
{
    $unixTimeNow = time();
    $json = file_get_contents("lastRefresh.json");
    $json_data = json_decode($json, true);
    $lastRefresh = $json_data[0]['unixtime'];
    if (($unixTimeNow - $lastRefresh) >= $timeInterval) { //12 hodin
        $json_data[0]['unixtime'] = $unixTimeNow;
        file_put_contents('lastRefresh.json', json_encode($json_data));
        return true;
    } else {
        return false;
    }
}

if (isset($_POST['refreshStationsALL200'])) {
    if (lastRefresh()) {
        refreshStations();
        echo 'RefreshSuccess';
        $json = file_get_contents("czStations.json");
        $json_data = json_decode($json, true);
        $skJson = file_get_contents("skStations.json");
        $skjson_data = json_decode($skJson, true);
        $mergeStations = array_merge($skjson_data, $json_data);
        file_put_contents('allStations.json', json_encode($mergeStations));
        generateTags($mergeStations);
    } else {
        echo 'RefreshFailNotLongEnough';
    }
    exit();
}