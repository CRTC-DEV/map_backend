<?php

return [
    /**
     * Permissions by role
     * 'all' means access to all modules
     */
    'roles' => [
        'admin' => ['all'],
        'staff' => [
            'route-map-item', 'route-map-item-detail', 'group-search', 'group-search-map-item',
            'banner-adv', 'banner-adv-device-touch', 'device-touch-screen', 
            'signage', 'signage-devicetouch', 'signage-mapitem',
            'map-item', 'item-title', 't2-location', 'text-content',
            'main-function', 'group-mainfunction', 'group-function', 'group-function-device-touch',
            'event', 'faq', 'faq-type', 'contact-number', 'contact-number-type',
            'translation', 'item-type', 'item-description', 'language'
        ],
        'kds' => [
            'map-item', 'item-title', 't2-location', 'text-content', 'translations',   'item-description','item-type', 'item-title', 'translation', 'group-search', 'group-search-map-item' ,'key-search', 'signage-mapitem'
        ],
        'toc' => [
            'map-item', 'item-title', 't2-location', 'text-content','language', 'translations', 'item-description','item-type', 'item-title', 'translation', 'signage', 'signage-devicetouch', 'signage-mapitem', 'group-search', 'group-search-map-item', 'key-search'
        ],
    ],
    
    /**
     * Permissions by module
     * Define which roles have access to which modules
     */
    'modules' => [
        // Modules đã có
        'route-map-item' => ['admin', 'staff'],
        'route-map-item-detail' => ['admin', 'staff'],
        'group-search' => ['admin', 'staff'],
        'group-search-map-item' => ['admin', 'staff'],
        'banner-adv' => ['admin', 'staff'],
        'device-touch-screen' => ['admin', 'staff'],
        'signage' => ['admin', 'staff'],
        'signage-devicetouch' => ['admin', 'staff'],
        'signage-mapitem' => ['admin', 'staff'],
        'map-item' => ['admin', 'staff', 'kds', 'toc'],
        'item-title' => ['admin', 'staff', 'kds', 'toc'],
        't2-location' => ['admin', 'staff', 'kds'],
        'text-content' => ['admin', 'staff', 'kds', 'toc'],
        'contact-number-type' => ['admin', 'staff'],
        'language' => ['admin', 'staff'],
        'banner-adv-device-touch' => ['admin', 'staff'],
        'main-function' => ['admin', 'staff'],
        'group-mainfunction' => ['admin', 'staff'],
        'group-function' => ['admin', 'staff'],
        'group-function-device-touch' => ['admin', 'staff'],
        'event' => ['admin', 'staff'],
        'faq' => ['admin', 'staff'],
        'faq-type' => ['admin', 'staff'],
        'contact-number' => ['admin', 'staff'],
        'translation' => ['admin', 'staff'],
        'item-type' => ['admin', 'staff'],
        'item-description' => ['admin', 'staff'],
        'key-search' => ['admin', 'staff', 'kds', 'toc'],
        // Module dành riêng cho admin
        'admin-management' => ['admin']
    ]
];
