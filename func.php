<?php

function getTZ()
{
    $tzf = getenv('localTimezone');
    if (!$tzf) {
        $tzf = readlink('/etc/localtime');
        $tzf = substr($tzf, strpos($tzf, '/zoneinfo/') + 10);
        // setConf('localTimezone', $tzf);
        // We could save this with setConf, but it would create a problem for those who travel between timezones a lot
    }
    return $tzf;
}

function findNode()
{
    $node = shell_exec("/usr/bin/which node");
    if (!$node || substr($node, 0, 1) != "/") return false;
    return trim($node);
}

function getLocale($node, $default)
{
    $l = getenv('locale');
    if ($l) return $l;
    $l = strtolower(preg_replace("/[^A-Za-z\-]/", "",
        shell_exec('langs=(`defaults read NSGlobalDomain AppleLanguages`); echo ${langs[1]/,/}')));
    $supported = shell_exec("$node list-locales.js");
    $supported = json_decode($supported);
    if (json_last_error() !== JSON_ERROR_NONE || !in_array($l, $supported->list)) return $default;
    setConf('locale', $l);
    return $l;
}

function setConf($var, $val, $remove = false)
{
    shell_exec('/usr/bin/osascript -e \'tell application id "com.runningwithcrayons.Alfred" to ' .
        ($remove ? 'remove' : 'set') . ' configuration "' . $var . '"' . (!$remove ? ' to value "' . $val . '"' : '') .
        ' in workflow "com.hilbertgilbertson.whencord" with exportable\'');
}

function listItem($title, $subtitle = null, $arg = false, $valid = true, $icon = null, $launch = false)
{
    $item = [
        'valid' => $valid,
        'title' => (string)$title
    ];
    if ($subtitle) $item['subtitle'] = (string)$subtitle;
    if ($arg !== false) $item['arg'] = (string)$arg;
    if ($icon) $item['icon'] = is_array($icon) ? $icon : ['path' => "icons/$icon.png"];
    if ($launch) $item['variables']['launch'] = $launch;
    return $item;
}

function listError($items)
{
    die(json_encode(['items' => $items]));
}
