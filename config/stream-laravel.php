<?php

return [

    /*
    |-----------------------------------------------------------------------------
    | Your GetStream.io API credentials (you can them from getstream.io/dashboard)
    |-----------------------------------------------------------------------------
    |
    */

    'api_key' => '5t3spcwck23a',
    'api_secret' => 'qunynxzvy4vm26a9nee5d4vjcf8y3gerqnjr2a7mu36y99kh68gjub725adwvq5z',
    'api_app_id' => '10919',
    /*
    |-----------------------------------------------------------------------------
    | Client connection options
    |-----------------------------------------------------------------------------
    |
    */
    'location' => 'eu-central',
    'timeout' => 3,
    /*
    |-----------------------------------------------------------------------------
    | The default feed manager class
    |-----------------------------------------------------------------------------
    |
    */

    'feed_manager_class' => 'GetStream\StreamLaravel\StreamLaravelManager',

    /*
    |-----------------------------------------------------------------------------
    | The feed that keeps content created by its author
    |-----------------------------------------------------------------------------
    |
    */
    'user_feed' => 'user',
    /*
    |-----------------------------------------------------------------------------
    | The feed containing notification activities
    |-----------------------------------------------------------------------------
    |
    */
    'notification_feed' => 'notification',
    /*
    |-----------------------------------------------------------------------------
    | The feeds that shows activities from followed user feeds
    |-----------------------------------------------------------------------------
    |
    */
    'news_feeds' => array(
        'flat' => 'flat',
        'aggregated' => 'aggregated',
    )
];
