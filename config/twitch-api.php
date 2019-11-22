<?php

return [
    'client_id' => env('TWITCH_CLIENT_ID', ''),
    'client_secret' => env('TWITCH_CLIENT_SECRET', ''),
    'redirect_url' => env('TWITCH_REDIRECT', ''),
    'type' => env('TWITCH_TYPE', 'helix'),
    'webhooks_callback' => env('TWITCH_WEBHOOKS_CALLBACK', 'http://dev.donatesupp.com/api/twitch/webhook'),
    'scopes' => [
        // 'channel_check_subscription',
        // 'channel_commercial',
        // 'channel_editor',
        'channel_subscriptions',
        // 'channel_feed_edit',
        // 'channel_feed_read',
        // 'channel_read',
        // 'channel_stream',
        // 'channel_subscriptions',
        // 'chat_login',
        // 'collections_edit',
        // 'communities_edit',
        // 'communities_moderate',
        // 'openid',
        // 'user_blocks_edit',
        // 'user_blocks_read',
        // 'user_follows_edit',
        'user_read',
        // 'user_subscriptions',
        // 'viewing_activity_read'
    ],
];