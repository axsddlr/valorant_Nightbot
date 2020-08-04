<?php
header('Content-type: text/plain');

$request = strtolower($_GET['command']);
if (!$request)
{
    echo '\'&command=\' parameter not defined! (Options: \'rank\', \'stats\')';
    return;
};

$player = $_GET['nick'];
if (!$player)
{
    echo '\'&nick=\' parameter not defined!';
    return;
};
$tag = $_GET['tag'];
if (!$tag)
{
    echo '\'&tag=\' parameter not defined!';
    return;
};

// combine the player name with tag numnber i.e: rehkloos#001
$riotid = $player . '%23' . $tag;

function _getJSON($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json, text/plain, */*', 'Authorization: Ubi_v1 t='.apcu_fetch('uplayconnect_ticket'), 'Ubi-AppId: 39baebad-39e5-4552-8c25-2c9b919064e2', 'Connection: keep-alive', 'Keep-Alive: timeout 0, max 0'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // so curl_exec returns base
    // grab URL and pass it to the browser; store returned base
    $curlRes = curl_exec($ch);

    if (curl_errno($ch))
    {
        echo 'Error:' . curl_error($ch);
    }

    // close cURL resource, and free up system resources
    curl_close($ch);
    // Decode returned JSON so it can be handled as a multi-dimensional associative array
    return json_decode($curlRes, true);
};

switch ($request)
{
    case "stats":
        $base = _getJSON('https://api.tracker.gg/api/v2/valorant/standard/profile/riot/' . $player . '%23' . $tag);

        // Valortant stat calls
        $kills = intval($base['data']['segments'][0]['stats']['kills']['value']);

        echo urldecode($riotid) . " Stats: " . $kills . " ";
    break;
    case "rank":
        $base = _getJSON('https://api.tracker.gg/api/v2/valorant/standard/profile/riot/' . $player . '%23' . $tag);

        // Valortant stat calls
        $rank = $base['data']['segments'][0]['stats']['rank']['value'];

        echo $rank . " (" . urldecode($riotid) . ")";
    break;
    default:
        echo "need to add &command=stats or &command=rank";
}