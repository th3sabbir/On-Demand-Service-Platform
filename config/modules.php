<?php

return [


   'modules' => [
        'global-setting' => [
            'active' => true,
            'providers' => [
                Modules\GlobalSetting\Providers\GlobalSettingServiceProvider::class,
            ],
        ],
        'communication' => [
            'active' => true,
            'providers' => [
                Modules\Communication\Providers\CommunicationServiceProvider::class,
            ],
        ],
        'product' => [
            'active' => true,
            'providers' => [
                Modules\Product\Providers\ProductServiceProvider::class,
            ],
        ],
        'service' => [
            'active' => true,
            'providers' => [
                Modules\service\Providers\ServiceServiceProvider::class,
            ],
        ],
        'chat' => [
            'active' => true,
            'providers' => [
                Modules\Chat\Providers\ChatServiceProvider::class,
            ]
        ],
        'page' => [
            'active' => true,
            'providers' => [
                Modules\Page\Providers\PageServiceProvider::class,
            ],
        ],
        'leads' => [
            'active' => true,
            'providers' => [
                Modules\Leads\Providers\LeadsServiceProvider::class,
            ],
        ],
        'testimonials' => [
            'active' => true,
            'providers' => [
                Modules\Testimonials\Providers\TestimonialsServiceProvider::class,
            ],
        ],
        'faq' => [
            'active' => true,
            'providers' => [
                Modules\Faq\Providers\FaqServiceProvider::class,
            ],
        ],
        'newsletter' => [
            'active' => true,
            'providers' => [
                Modules\Newsletter\Providers\NewsletterServiceProvider::class,
            ],
        ],
        'roles-permissions' => [
            'active' => true,
            'providers' => [
                Modules\RolesPermissions\Providers\RolesPermissionsServiceProvider::class,
            ],
        ],
        'menu-builder' => [
            'active' => true,
            'providers' => [
                Modules\MenuBuilder\Providers\MenuBuilderServiceProvider::class,
            ],
        ],
    // Other modules...
    ],
];
