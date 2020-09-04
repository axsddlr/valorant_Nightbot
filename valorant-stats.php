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
    case "time":
        $base = _getJSON('https://api.tracker.gg/api/v2/valorant/standard/profile/riot/' . $player . '%23' . $tag);

        // Valortant stat calls
        $timeplayedCOMP  = $base['data']['segments'][0]['stats']['timePlayed']['value']; // competitive
        $timeplayedDMS   = $base['data']['segments'][1]['stats']['timePlayed']['value']; // deathmatch
        $timeplayedSPKR  = $base['data']['segments'][2]['stats']['timePlayed']['value']; // spikerush
        $timeplayedURTD  = $base['data']['segments'][3]['stats']['timePlayed']['value']; // unrated
        $TTP = $timeplayedCOMP + $timeplayedDMS + $timeplayedSPKR + $timeplayedURTD; // Total Sum of time played between all playlists

        //TimeMilliseconds to Days conversion
        $time = $TTP / 1000;
        $days = floor($time / (24*60*60));
        $hours = floor(($time - ($days*24*60*60)) / (60*60));
        $minutes = floor(($time - ($days*24*60*60)-($hours*60*60)) / 60);
        $seconds = ($time - ($days*24*60*60) - ($hours*60*60) - ($minutes*60)) % 60;

        echo "Total Time Played: " . $days.'d '.$hours.'h '.$minutes.'m ' .$seconds.'s '. " (" . urldecode($riotid) . ")";
    break;
    default:
        echo "need to add &command=stats, &command=rank, or &command=time";
}
