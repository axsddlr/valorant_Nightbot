<?php
include('./utils/functions.php');
header('Content-type: text/plain');

$request = strtolower($_GET['command']);
if (!$request)
{
    echo '\'&command=\' parameter not defined! (Options: \'rank\', \'stats\')';
    return;
};

$region = $_GET['region'];
if (!$region)
{
    echo '\'&region=\' parameter not defined!';
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

switch ($request)
{
    case "stats":
        $base = _getJSON('https://api.henrikdev.xyz/valorant/v1/profile/' . $player . '/' . $tag);

        // Valortant stat calls
        $kills = $base['stats']['kills'];
        $deaths = $base['stats']['deaths'];
        $kdr = $base['stats']['kdratio'];
        $wins = $base['stats']['wins'];
        $winr  = $base['stats']['winpercentage'];
        $TTP = $base['stats']['playtime']['playtimepatched'];


        echo "Total Time Played: " . $TTP . " | Wins: " . $wins . " | Win/Loss: " . $winr . " | Kills: " . $kills . " | KDR: " . $kdr . " | Deaths: " . $deaths ." (" . urldecode($riotid) . ")";
    break;
    case "rank":
        $base = _getJSON('https://api.henrikdev.xyz/valorant/v1/mmr/' . $region . '/' . $player . '/' . $tag);

        // Valortant stat calls
        $rank = $base['data']['currenttierpatched'];
        $elo = $base['data']['elo'];

        echo "Current Rank: " . $rank . " | Elo: " . $elo . " (" . urldecode($riotid) . ")";
    break;
    case "time":
        $base = _getJSON('https://api.henrikdev.xyz/valorant/v1/profile/' . $player . '/' . $tag);

        // Valortant stat calls
        $TTP = $base['stats']['playtime']['playtimepatched'];


        echo "Total Time Played: " . $TTP . " (" . urldecode($riotid) . ")";
    break;
    default:
        echo "need to add &command=stats, &command=rank, or &command=time";
}
