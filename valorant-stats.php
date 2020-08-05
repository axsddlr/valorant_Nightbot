<?php
include('./utils/functions.php');
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

switch ($request)
{
    case "stats":
        $base = _getJSON('https://api.tracker.gg/api/v2/valorant/standard/profile/riot/' . $player . '%23' . $tag);

        // Valortant stat calls
        $kills = $base['data']['segments'][0]['stats']['kills']['value'];
        $mKills = intval($base['data']['segments'][0]['stats']['mostKillsInAGame']['value']);
        $deaths = intval($base['data']['segments'][0]['stats']['deaths']['value']);
        $kdr = intval($base['data']['segments'][0]['stats']['kDRatio']['value']);
        $wins = intval($base['data']['segments'][0]['stats']['wins']['value']);
        $winr  = intval($base['data']['segments'][0]['stats']['wlratio']['value']);
        //timePlayedTotal
        $timeplayed  = $base['data']['segments'][0]['stats']['timePlayedTotal']['value'];


        echo "Time Played: " . timeSeconds($timeplayed) . " | Wins: " . $wins . " | Win/Loss: " . $winr . "% | Kills: " . $kills . " | Most Kills in Game: " . $mKills . " | KDR: " . round($kdr) . " | Deaths: " . $deaths ." (" . urldecode($riotid) . ")";
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
