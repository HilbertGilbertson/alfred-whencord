<?php

require 'func.php';

$tz = @date_default_timezone_set(getTZ());
if (!$tz) {
    listError([
        listItem("localTimezone was configured incorrectly", null, false, false),
        listItem("Set it to a supported timezone or reset it to blank",
            "See a list of supported timezones here", "https://www.php.net/manual/en/timezones.php",
            true, "url", "url")
    ]);
}

if (substr($argv[1], 0, 1) == ':' && count($argv) <= 2 && strlen($argv[1]) <= 12 &&
    ctype_digit(substr($argv[1], 1))) {
    $t = substr($argv[1], 1);
} else {
    $s = implode(' ', array_slice(array_diff($argv, ['at']), 1));
    $t = strtotime($s);
}
if ($t === false) {
    listError([
        listItem("Invalid Time", "Please provide a valid time string.", false, false),
        listItem("See supported time formats", null,
            "https://www.php.net/manual/en/datetime.formats.php", true, "url", "url")
    ]);
}

$node = getenv('nodePath');
if (!$node) {
    if (!$node = findNode()) {
        listError([
            listItem("NodeJS could not be located", "Please set the path to node in the workflow config.",
                false, false),
            listItem("Installing NodeJS", null,
                "https://github.com/HilbertGilbertson/alfred-whencord#install-nodejs-if-you-dont-already-have-it",
                true, "url", "url"),
            listItem("Configuring Whencord", null,
                "https://github.com/HilbertGilbertson/alfred-whencord#configuration", true, "url",
                "url")
        ]);
    }
    setConf('nodePath', $node);
}

$l = getLocale($node, 'en');

$moment = shell_exec("$node run.js $t $l");
$formats = json_decode($moment);
if (json_last_error() !== JSON_ERROR_NONE) {
    setConf('nodePath', null, true);
    listError([
        listItem("Moment.js could not be called",
            "Please try again and also ensure you have installed nodeJS.", false, false)
    ]);
}

echo json_encode(['items' =>
    [
        listItem($formats->formats[0], "<t:$t:d>", "<t:$t:d>", true, 'date'),
        listItem($formats->formats[1], "<t:$t:D>", "<t:$t:D>", true, 'date'),
        listItem($formats->formats[2], "<t:$t:t>", "<t:$t:t>", true, 'time'),
        listItem($formats->formats[3], "<t:$t:T>", "<t:$t:T>", true, 'time'),
        listItem($formats->formats[4], "<t:$t:f>", "<t:$t:f>", true, 'datetime'),
        listItem($formats->formats[5], "<t:$t:F>", "<t:$t:F>", true, 'datetime'),
        listItem($formats->formats[6], "<t:$t:R>", "<t:$t:R>", true, 'user-clock'),
        listItem($t, $t, $t, true, 'unix')
    ]
]);
