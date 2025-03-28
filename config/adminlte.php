<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'Orbe Aduanas S.A.C',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>Orbe</b>Aduanas',
    'logo_img' => 'vendor/adminlte/dist/img/mundoorbe.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Orbe Aduanas Logo',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => true,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/mundoorbe.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => true,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/mundoorbe.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => false,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-secondary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => 'bg-primary',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-light-indigo elevation-4',
    'classes_sidebar_nav' => 'nav-dark',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => true,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'type'         => 'navbar-search',
            'text'         => 'search',
            'topnav_right' => true,
        ],
        [
            'type'         => 'fullscreen-widget',
            'topnav_right' => true,
        ],



        // Sidebar items:
        /*         [
            'type' => 'sidebar-menu-search',
            'text' => 'search',
        ],
        [
            'text' => 'blog',
            'url'  => 'admin/blog',
            'can'  => 'manage-blog',
        ],
         [
            'text'        => 'pages',
            'url'         => 'admin/pages',
            'icon'        => 'far fa-fw fa-file',
            'label'       => 4,
            'label_color' => 'success',
        ], */
        [
            'text' => 'Grupos y usuarios',
            'icon' => 'fas fa-users-cog',
            'can' => 'users.listGroup',
            'submenu' => [
                [
                    'text' => 'Usuarios',
                    'url'  => 'users',
                    'icon'  => 'fa fa-user',
                    'active' => ['users', 'users*', 'regex:@^content/[0-9]+$@'],
                    'can' => 'users.list',
                ],
                [
                    'text' => 'Grupo',
                    'url'  => 'roles',
                    'icon' => 'fas fa-fw fa-users',
                    'active' => ['roles', 'roles*', 'regex:@^content/[0-9]+$@'],
                    'can' => 'users.listGroup',
                ]
            ]
        ],
        [
            'text' => 'Personal y Documento',
            'icon' => 'fas fa-fw fa-users',
            'can' => 'personal.list',
            'submenu' => [
                [
                    'text' => 'Personal',
                    'url'  => 'personal',
                    'icon'  => 'fa fa-user-circle',
                    'active' => ['personal'],

                ],
                [
                    'text' => 'Tipo de Documentos',
                    'url'  => 'personal_document',
                    'icon' => 'fas fa-id-card',
                    'active' => ['personal_document'],

                ]
            ]
        ],
        [
            'text' => 'Origen-Destino',
            'icon' => 'fas fa-fw fa-user-tie',
            
            'submenu' => [
                [
                    'text' => 'Pais',
                    'url' => 'country',
                    'icon'  => 'fa fa-exclamation-circle',
                    'active' => ['country'],
                ],
                [
                    'text' => 'Ciudad',
                    'url'  => 'state_country',
                    'icon' => 'fa fa-check-double',
                    'active' => ['state_country'],
                ],

            ]

        ],
        [
            'text' => 'Conceptos',
            'url'  => 'concepts',
            'icon' => 'fas fa-fw fa-copy',
            'active' => ['concepts', 'concepts*', 'regex:@^content/[0-9]+$@'],
            'can' => 'concept.list'
        ],
        [
            'text' => 'Liquidacion',
            'icon' => 'fas fa-fw fa-laptop',
            'can' => 'liquidacion.list',
            'submenu' => [
                [
                    'text' => 'Puntos pendientes',
                    'url' => 'custom/pending',
                    'icon'  => 'fa fa-exclamation-circle',
                    'active' => ['custom'],
                ],

                [
                    'text' => 'Todos los puntos',
                    'url'  => 'custom',
                    'icon' => 'fa fa-check-double',
                    'active' => ['custom'],
                ],
                [
                    'text' => 'Modalidad',
                    'url'  => 'modality',
                    'icon' => 'fas fa-boxes',
                    'active' => ['modality', 'modality*', 'regex:@^content/[0-9]+$@'],
                    'can' => 'modality.list'
                ],

            ]
        ],
                [
            'text' => 'Operaciones',
            'icon' => 'fas fa-fw fa-user-tie',
            'can' => 'operaciones.list',
            'submenu' => [
                [
                    'text' => 'Puntos pendientes - Flete',
                    'url' => 'freight/pending',
                    'icon'  => 'fa fa-exclamation-circle',
                    'active' => ['freight/pending'],
                ],
                [
                    'text' => 'Todos los puntos - Flete',
                    'url'  => 'freight',
                    'icon' => 'fa fa-check-double',
                    'active' => ['freight'],
                ],
                [
                    'text' => 'Puntos pendientes - Seguro',
                    'url'  => 'insurance/pending',
                    'icon' => 'fa fa-exclamation-circle',
                    'active' => ['insurance/pending'],
                ],
                [
                    'text' => 'Todos los puntos - Seguro',
                    'url'  => 'insurance',
                    'icon' => 'fa fa-check-double',
                    'active' => ['insurance'],
                ],
                [
                    'text' => 'Tipo de Seguro',
                    'url'  => 'type_insurance',
                    'icon' => 'fas fa-list-ul',
                    'active' => ['type_insurance', 'type_insurance*', 'regex:@^content/[0-9]+$@'],
                    'can' => 'operaciones.type_insurance',
                ],
               
            ]

        ],
        [
            'text' => 'Pricing',
            'icon' => 'fas fa-ship',
            'submenu' => [
                /*  [
                    'text' => 'Generar cotizacion',
                    'url' => 'quote/freight/create',
                    'icon'  => 'fas fa-file-invoice-dollar',
                    'active' => ['quote/pricing'],
                ],
                [
                    'text' => 'Listar cotizacion',
                    'url' => 'quote/freight',
                    'icon'  => 'fas fa-file-invoice-dollar',
                    'active' => ['quote/freight'],
                ], */]

        ],
        [
            'text' => 'Flete',
            'icon' => 'fas fa-ship',
            //'can' => 'freight.module',
            'submenu' => [
                [
                    'text' => 'Generar cotizacion',
                    'url' => 'quote/freight/create',
                    'icon'  => 'fas fa-file-invoice-dollar',
                    'active' => ['quote/pricing'],
                ],
                [
                    'text' => 'Listar cotizacion',
                    'url' => 'quote/freight',
                    'icon'  => 'fas fa-file-invoice-dollar',
                    'active' => ['quote/freight'],
                ],
                [
                    'text' => 'Mis Fletes',
                    'url'  => 'freight/personal',
                    'icon' => 'fas fa-ship',
                    'active' => ['freight/personal'],

                ],
            ]
        ],
        [
            'text' => 'Transporte',
            'icon' => 'fas fa-fw fa-truck-moving',
            /* 'can' => 'transporte.module', */
            'submenu' => [
                [
                    'text' => 'Puntos pendientes',
                    'url' => 'transport/pending',
                    'icon'  => 'fa fa-exclamation-circle',
                    'active' => ['transport/pending'],
                    'can' => 'transporte.list.points',
                ],
                [
                    'text' => 'Todos los puntos',
                    'url'  => 'transport',
                    'icon' => 'fa fa-check-double',
                    'active' => ['transport'],
                    'can' => 'transporte.list.points',
                ],
                [
                    'text' => 'Generar una cotizacion',
                    'url'  => 'quote/transport/create',
                    'icon' => 'fas fa-file-invoice-dollar',
                    'active' => ['quote/transport/create'],
                    'can' => 'transporte.quote.generate'


                ],
                [
                    'text' => 'Cotizaciones',
                    'url'  => 'quote/transport',
                    'icon' => 'fas fa-file-import',
                    'active' => ['quote/transport'],
                    /* 'can' => 'transporte.quote.list' */
                ],
                [
                    'text' => 'Mis Cotizaciones',
                    'url'  => 'quote/transport/personal',
                    'icon' => 'fas fa-file-import',
                    'active' => ['quote/transport/personal'],
                    'can' => 'transporte.quote.list.personal'
                ],
                [
                    'text' => 'Mis transportes',
                    'url'  => 'transport/personal',
                    'icon' => 'fas fa-dolly-flatbed',
                    'active' => ['transport/personal'],
                    'can' => 'transporte.list'
                ]
            ]
        ],
        [
            'text' => 'Adicionales',
            'icon' => 'fas fa-fw fa-copy',
            'can' => 'additional.list',
            'submenu' => [
                [
                    'text' => 'Puntos pendientes - Aduanas',
                    'url' => 'additionals/pending/custom',
                    'icon'  => 'fa fa-exclamation-circle',
                    'active' => ['additionals/pending/custom'],
                    'can' => 'additional.custom'
                ],
                [
                    'text' => 'Puntos pendientes - Flete',
                    'url' => 'additionals/pending/freight',
                    'icon'  => 'fa fa-exclamation-circle',
                    'active' => ['additionals/pending/freight'],
                    'can' => 'additional.freight'
                ],
                [
                    'text' => 'Todos los puntos',
                    'url'  => 'additionals',
                    'icon' => 'fa fa-check-double',
                    'active' => ['additionals'],
                    'can' => 'additional.listAll'
                ]
            ]
        ],
        [
            'text' => 'Puntos',
            'icon' => 'fas fa-plus-circle',
            'can' => 'points.module',
            'submenu' => [
                /*                 [
                    'text' => 'Detalle por vendedor',
                    'url'  => 'points/detail',
                    'icon' => 'fa-solid fa-check-double',
                    'active' => ['points/detail', 'points/detail*', 'regex:@^content/[0-9]+$@'],
                ], */
                [
                    'text' => 'Puntos Flete',
                    'url'  => 'points/freight',
                    'icon' => 'fas fa-ship',
                    'active' => ['points/freight', 'points/freight*', 'regex:@^content/[0-9]+$@'],
                ],
                [
                    'text' => 'Puntos Aduana',
                    'url' => 'points/customs',
                    'icon'  => 'fas fa-pallet',
                    'active' => ['points/customs', 'points/customs*', 'regex:@^content/[0-9]+$@'],
                ],
                [
                    'text' => 'Puntos Transporte',
                    'url'  => 'points/transport',
                    'icon' => 'fas fa-shipping-fast',
                    'active' => ['points/transport', 'points/transport*', 'regex:@^content/[0-9]+$@'],
                ],
                [
                    'text' => 'Puntos Seguro',
                    'url'  => 'points/insurance',
                    'icon' => 'fas fa-shield-alt',
                    'active' => ['points/insurance', 'points/insurance*', 'regex:@^content/[0-9]+$@'],
                ],
                [
                    'text' => 'Puntos Adicionales',
                    'url'  => 'points/additionals',
                    'icon' => 'fas fa-plus',
                    'active' => ['points/additionals', 'points/additionals*', 'regex:@^content/[0-9]+$@'],
                ]
            ]
        ],
        [
            'text' => 'Clientes y Proveedores',
            'icon' => 'fas fa-user-friends',
            'can' => 'customer.list',
            'submenu' => [
                [
                    'text' => 'Clientes',
                    'url'  => 'customer',
                    'icon'  => 'fas fa-user-plus',
                    'active' => ['customer'],

                ],
                [
                    'text' => 'Proveedores',
                    'url'  => 'suppliers',
                    'icon'  => 'fas fa-user-edit',
                    'active' => ['suppliers'],
                    'can' => 'supplier.module'

                ],
                [
                    'text' => 'Tipo de Documentos',
                    'url'  => 'customer_supplier_document',
                    'icon' => 'fas fa-id-card',
                    'active' => ['customer_supplier_document'],
                    'can' => ['type_document_customer']

                ]
            ]
        ],
        [
            'text' => 'Tipo de embarque',
            'url'  => 'type_shipment',
            'icon' => 'fas fa-dolly',
            'active' => ['type_shipment', 'type_shipment*', 'regex:@^content/[0-9]+$@'],
            'can' => 'type_shipment.list',
        ],
        [
            'text' => 'Regimen',
            'url'  => 'regimes',
            'icon' => 'fas fa-gavel',
            'active' => ['regimes', 'regimes*', 'regex:@^content/[0-9]+$@'],
            'can' => 'regimes.list',
        ],
        [
            'text' => 'Tipo de carga',
            'url'  => 'type_load',
            'icon' => 'fas fa-pallet',
            'active' => ['type_load', 'type_load*', 'regex:@^content/[0-9]+$@'],
            'can' => 'type_load.list',
        ],
        [
            'text' => 'Contenedores',
            'icon' => 'fas fa-fw fa-box',
            
            'submenu' => [
                [
                    'text' => 'Contenedores',
                    'url' => 'containers',
                    'icon'  => 'fas fa-box-open',
                    'active' => ['containers'],
                ],
                [
                    'text' => 'Tipo de contenedores',
                    'url'  => 'type_containers',
                    'icon' => 'fas fa-cubes',
                    'active' => ['type_containers.*'],
                ],

            ]

        ],
        [
            'text' => 'Incoterms',
            'url'  => 'incoterms',
            'icon' => 'fas fa-list',
            'active' => ['incoterms', 'incoterms*', 'regex:@^content/[0-9]+$@'],
            'can' => 'incoterms.list',
        ],

        [
            'text' => 'Routing',
            'url'  => 'routing',
            'icon' => 'fas fa-folder-open',
            'active' => ['routing', 'routing*', 'regex:@^content/[0-9]+$@'],
            'can' => 'routing.list'
        ],
        [
            'text' => 'Cotizacion Comercial',
            'icon' => 'fas fa-file-invoice-dollar',
            'submenu' => [
                [
                    'text' => 'Generar Cotizacion',
                    'url'  => 'commercial/quote/create',
                    'icon' => 'fas fa-file-medical',
                    'active' => ['commercial/quote/create'],
                ],
                [
                    'text' => 'Lista cotizaciones',
                    'url'  => 'commercial/quote',
                    'icon' => 'fas fa-file-medical',
                    'active' => ['commercial/quote'],
                ],

            ]
        ]
        /*,
         [
            'text'    => 'multilevel',
            'icon'    => 'fas fa-fw fa-share',
            'submenu' => [
                [
                    'text' => 'level_one',
                    'url'  => '#',
                ],
                [
                    'text'    => 'level_one',
                    'url'     => '#',
                    'submenu' => [
                        [
                            'text' => 'level_two',
                            'url'  => '#',
                        ],
                        [
                            'text'    => 'level_two',
                            'url'     => '#',
                            'submenu' => [
                                [
                                    'text' => 'level_three',
                                    'url'  => '#',
                                ],
                                [
                                    'text' => 'level_three',
                                    'url'  => '#',
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'text' => 'level_one',
                    'url'  => '#',
                ],
            ],
        ] ,
        ['header' => 'labels'],
        [
            'text'       => 'important',
            'icon_color' => 'red',
            'url'        => '#',
        ],
        [
            'text'       => 'warning',
            'icon_color' => 'yellow',
            'url'        => '#',
        ],
        [
            'text'       => 'information',
            'icon_color' => 'cyan',
            'url'        => '#',
        ],*/
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Toastr' => [
            'active' => true, // Habilita el plugin
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],

        'DateRangePicker' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/moment/moment.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/daterangepicker/daterangepicker.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/daterangepicker/daterangepicker.css',
                ],
            ],
        ],

        'TempusDominusBs4' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/moment/moment.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css',
                ],
            ],
        ],
        'BsCustomFileInput' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/bs-custom-file-input/bs-custom-file-input.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
