<?php
function _getJSON($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
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

function timeSeconds($secs)
{
    if ($secs >= 86400)
    {
        $days = floor($secs / 86400);
        $secs = $secs % 86400;
        $r = $days . 'd';
        if ($secs > 0)
        {
            $r .= ' ';
        }
    }
    if ($secs >= 3600)
    {
        $hours = floor($secs / 3600);
        $secs = $secs % 3600;
        $r .= $hours . 'h';
        if ($secs > 0)
        {
            $r .= ' ';
        }
    }
    if ($secs >= 60)
    {
        $minutes = floor($secs / 60);
        $secs = $secs % 60;
        $r .= $minutes . 'm';
        if ($secs > 0)
        {
            $r .= ' ';
        }
    }
    return $r;
}
?>
