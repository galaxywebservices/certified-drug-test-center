<?php

return [
    'title' => 'Conference Banner',
    'category' => 'Header',
    'settings' => [
        'title' => [
            'label' => 'Conference Title',
            'type' => 'text',
            'value' => 'THE NATIONAL DRUG TESTING LEADERSHIP CONFERENCE',
        ],
        'date_location' => [
            'label' => 'Date & Location',
            'type' => 'text',
            'value' => 'SEPTEMBER 19, 2026 | HOUSTON, TX',
        ],
        'button_text' => [
            'label' => 'Button Label',
            'type' => 'text',
            'value' => 'Register for Conference',
        ],
        'button_url' => [
            'label' => 'Button Link URL',
            'type' => 'text',
            'value' => '/courses',
        ],
        'banner_image' => [
            'label' => 'Banner Image URL',
            'type' => 'text',
            'value' => asset('assets/images/leadership-conference-banner-final.png'),
        ],
    ]
];
