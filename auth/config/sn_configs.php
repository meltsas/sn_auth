<?php
define('CONFIG',
    [
        "base_url"   => "https://net.era.ee/auth/", //redirect URI
        "providers" => [
            "google" => [
                "enabled" => true,
                "keys" => ["id" => "YOUR_APP_ID", "secret" => "YOUR_APP_SECRET"],
                "permissions" => ['email', 'profile']
            ],
            "facebook" => [
                "enabled" => true,
                "keys" => ["id" => "YOUR_APP_ID", "secret" => "YOUR_APP_SECRET", "version" => 'v2.6'],
                "permissions" => ['email', 'public_profile', 'user_friends'],
                "trustForwarded" => false
            ],
            "twitter" => [
                "enabled" => true,
                "keys" => ["id" => "YOUR_APP_ID", "secret" => "YOUR_APP_SECRET"],
                "permissions" => ['r_basicprofile', 'r_emailaddress']
            ],
            "linkedin" => [
                "enabled" => true,
                "keys" => ["id" => "YOUR_APP_ID", "secret" => "YOUR_APP_SECRET"],
                "permissions" => ['r_basicprofile', 'r_emailaddress']
            ],
            "github" => [
                "enabled" => true,
                "keys" => ["id" => "YOUR_APP_ID", "secret" => "YOUR_APP_SECRET"],
                "permissions" => ['user', 'user:email', 'repo']
            ],
        ],
    ]
);
