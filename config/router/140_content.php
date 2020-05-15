<?php
/**
 * guess controller
 */
return [
    // Path where to mount the routes, is added to each route path.
    //"mount" => "sample",

    // All routes in order
    "routes" => [
        [
            "info" => "Content",
            "mount" => "content",
            "handler" => "\GB\Content\ContentController",
        ],
    ]
];
