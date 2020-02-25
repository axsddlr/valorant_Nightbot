<?php
header('Content-type: text/plain');
/*
        AUTHOR: Andre "Ayysir" S.
        FILE: rainbowsix7.php
*/

$request = strtolower($_GET['command']);
if (!$request)
{
    echo '\'&command=\' parameter not defined! (Options: \'rank\', \'stats\')';
    return;
};

$platform = strtolower($_GET['platform']);
if (!in_array($platform, array(
    'uplay',
    'xbl',
    'psn'
)))
{
    echo '\'&platform=\' parameter not correct! (Options: \'xbl\', \'psn\' or \'uplay\')';
    return;
};

if ($platform == 'uplay')
{
    $machine = 'uplay';
};
if ($platform == 'xbl')
{
    $machine = 'xb1';
};
if ($platform == 'psn')
{
    $machine = 'psn';
};

$player = $_GET['nick'];
if (!$player)
{
    echo '\'&nick=\' parameter not defined!';
    return;
};

function _getJSON($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json, text/plain, */*', 'Authorization: Ubi_v1 t='.apcu_fetch('uplayconnect_ticket'), 'Ubi-AppId: 39baebad-39e5-4552-8c25-2c9b919064e2', 'Connection: keep-alive', 'Keep-Alive: timeout 0, max 0'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // so curl_exec returns data
    // grab URL and pass it to the browser; store returned data
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

if ($request == 'stats')
{

    $data = _getJSON('https://r6tab.com/api/search.php?platform=' . $machine . '&search=' . $player);

    $kills = intval($data['results']);

    // R6s API index
    // Current R6s Level
    $lvl = intval($data['results'][0]['p_level']);
    // Total Apex Kills
    /*$kills = intval($data['total']['kills']['value']);
    // Total Apex Dmg
    $dmg = intval($data['total']['damage']['value']);
    // Total Apex Games Played
    $games_played = intval($data['total']['games_played']['value']);
    // Kill/Death Ratio
    $adr = round($dmg / $games_played, 2);*/

    //echo "$player Stats: Lv. " . $lvl . " | Lifetime Kills: " . $kills . " | Lifetime Damage " . $dmg . " | Games Played: " . $games_played . " | ADR: " . $adr . " ";
    echo "$player R6s Stats: Lv. " . $lvl . " ";

};
//23 TIERS
$RSIX7_tiers = ['Copper ᴠ', 'Copper ɪᴠ', 'Copper ɪɪɪ', 'Copper ɪɪ', 'Copper ɪ', 'Bronze ᴠ', 'Bronze ɪᴠ', 'Bronze ɪɪɪ', 'Bronze ɪɪ', 'Bronze ɪ', 'Silver ᴠ', 'Silver ɪᴠ', 'Silver ɪɪɪ', 'Silver ɪɪ', 'Silver ɪ', 'Gold ɪɪɪ', 'Gold ɪɪ', 'Gold ɪ', 'Platinum ɪɪɪ', 'Platinum ɪɪ', 'Platinum ɪ', 'Diamond ♢', 'Champion ✰'];

$RSIX7_regions = ['EU' => 'emea', 'NA' => 'ncsa', 'ASIA' => 'apac'];

/**
 *	Command query: &command=rank
 *	Optional query: &region=EU|NA|ASIA
 *	Description: Returns current season placement and matchmaking rating of the player.
 */
if ($request == 'rank')
{

    if ($_GET['region'] && in_array(strtoupper($_GET['region']) , array_keys($RSIX7_regions)))
    {
        $RSIX7_regions = array(
            strtoupper($_GET['region']) => $RSIX7_regions[strtoupper($_GET['region']) ]
        );
    };
    for ($i = 0;$i < count(array_values($RSIX7_regions));$i++)
    {
        $data = _getJSON('https://r6tab.com/api/search.php?platform=' . $machine . '&search=' . $player);
        $pid = intval($data['results'][0]['p_id']);
        $pdata = _getJSON('https://r6tab.com/api/player.php?p_id=' . $pid);

        $rank = intval($data['results'][0]['p_currentrank']);
        $mmr = intval($data['results'][0]['p_currentmmr']);

        if ($rank > 0 && $rank < 22)
        {
            //$nextRank = intval($data['players'][$profileId]['next_rank_mmr']);
            //if ($rank === 22) { $nextRank = 4400; } //fix: Diamond returns 0 in API.
            //$mmrLeft = ($nextRank < $mmr) ? ($mmr - $nextRank) : ($nextRank - $mmr);
            echo " $player R6s Rank: " . $RSIX7_tiers[$rank + 1] . " 「" . $mmr . " ᴍᴍʀ」";
            //echo $mmrLeft.' ᴍᴍʀ needed for '.$RSIX7_tiers[$rank].' ';
            return;
        }
        elseif ($rank !== 0)
        {
            echo $RSIX7_tiers[$rank + 1] . ' ( ' . $mmr . 'ᴍᴍʀ ). ';
            return;
        }
    };
    echo 'Player still has to do ranked placement matches OR the profile doesn\'t exist on the specified platform.';

};
?>
