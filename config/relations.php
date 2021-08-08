<?php

return [
    "relationTypes" => [
        "1-1" => "One to One",
        "1-n" => "One To Many",
        "n-1" => "Many To One",
        "m-n" => "Many To Many"
    ],

    "inverse" => [
        "1-1" => "1-1",
        "1-n" => "n-1",
        "n-1" => "1-n",
        "m-n" => "m-n"
    ]
];
