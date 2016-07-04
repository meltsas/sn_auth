<?php
define('CONFIG',
    [
        "base_url"   => "http://snauth.esy.es/",
        "providers"  => [
            "google"   => [
                "enabled" => true,
                "keys"    => [ "id" => "", "secret" => "" ],
            ],
            "facebook" => [
                "enabled"        => true,
                "keys"           => [ "id" => "", "secret" => "" ],
                "trustForwarded" => false
            ],
            "twitter"  => [
                "enabled" => true,
                "keys"    => [ "key" => "", "secret" => "" ]
            ],
        ],
        "debug_mode" => true,
        "debug_file" => "bug.txt",
    ]

);