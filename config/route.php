<?php
$routes = [
    "login"    => [
        "route" => [
            "post" => [
                "controller" => "App\\Auth\\AuthController",
                "method"     => "login",
            ],
            "get"  => [
                "controller" => "App\\Auth\\AuthController",
                "method"     => "loginPage",
            ],
        ],
    ],
    "register" => [
        "route" => [
            "post" => [
                "controller" => "App\\Auth\\AuthController",
                "method"     => "register",
            ],
            "get"  => [
                "controller" => "App\\Auth\\AuthController",
                "method"     => "registerPage",
            ],
        ],

    ],
    "logout"   => [
        "route" => [
            "post" => [
                "controller" => "App\\Auth\\AuthController",
                "method"     => "logout",
            ],
        ],
    ],
    "home"     => [
        "route" => [
            "get" => [
                "controller" => "App\\Blogs\\BlogsController",
                "method"     => "index",
            ],
        ],
    ],

    "create" => [
        "route" => [
            "post" => [
                "controller" => "App\\Blogs\\BlogsController",
                "method"     => "create",
            ],
        ],
    ],

    "view_post" => [
        "route" => [
            "get" => [
                "controller" => "App\\Blogs\\BlogsController",
                "method"     => "show",
            ],
        ],
        "arg"   => "id",
    ],
    "edit_post" => [
        "route" => [
            "get" => [
                "controller" => "App\\Blogs\\BlogsController",
                "method"     => "edit",
            ],
        ],
        "arg"   => "id",

    ],

    "update_post" => [
        "route" => [
            "post" => [
                "controller" => "App\\Blogs\\BlogsController",
                "method"     => "update",
            ],
        ],
        "arg"   => "id",
    ],

    "delete_post" => [
        "route" => [
            "post" => [
                "controller" => "App\\Blogs\\BlogsController",
                "method"     => "delete",
            ],
        ],
        "arg"   => "id",
    ],

    "search" => [
        "route" => [
            "get" => [
                "controller" => "App\\Blogs\\BlogsController",
                "method"     => "search",
            ],
        ],
    ],

];

return $routes;