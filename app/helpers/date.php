<?php

function date_mois_court_fr(string $dateSql): string
{
    $mois = [
        1 => "janv.",
        2 => "févr.",
        3 => "mars",
        4 => "avr.",
        5 => "mai",
        6 => "juin",
        7 => "juil.",
        8 => "août",
        9 => "sept.",
        10 => "oct.",
        11 => "nov.",
        12 => "déc."
    ];

    $ts = strtotime($dateSql);
    if (!$ts) return $dateSql;

    $num = (int)date("n", $ts);

    return date("d", $ts) . " " . ($mois[$num] ?? "") . " " . date("Y", $ts);
}
