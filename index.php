<?php

echo 'Hello, this is a Valorant API for Twitchbot (Nightbot, etc..) developed by made by <a href="https://github.com/Rehkloos" target="_self">Andre Saddler</a> using <a href="TRN" target="_self">Valorant TRN</a> API '."<br>";
echo 'Website: <a href="https://rehkloos.com" target="_self">CLICK HERE</a> '."<br><br>";

echo 'How-To: $(urlfetch https://valorant-nightbot.herokuapp.com/valorant-stats.php?region=(Available regions: eu, ap, na, kr)&nick=(in-game name)&tag=(tag)&command=(stats,rank,tracker,time);' ."<br><br>";

echo 'Example: $(urlfetch https://valorant-nightbot.herokuapp.com/valorant-stats.php?region=na&nick=Rehkloos&tag=001&command=rank);'."<br><br>";

echo 'For LATAM/BR OR UNSUPPORTED COUNTRIES YOU HAVE TO USE OVERWOLF/VALORANT TRACKER APPLICATION ON PC TO UPDATE STATS FOR BOT THEN USE: $(urlfetch https://valorant-nightbot.herokuapp.com/valorant-stats.php?region=na)&nick=(in-game name)&tag=(tag)&&command=tracker);';
