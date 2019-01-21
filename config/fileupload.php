<?php

/**
 * ------------------------Simple Doc-------------------------
 *
 *
 *
 *
 * -----------------------------------------------------------
 */

return [

    'routeMiddleware' => ['web', 'localeSessionRedirect', 'localizationRedirect'],

    'setting' => [

        'image' => [
            'validate'         => 'required|mimes:jpeg,jpg,png,gif|ratio',
            'upload_directory' => 'upload\image',
        ],

        'relationType' => 'many', // one

        'relationName' => 'image'
    ],

    'company' => [
        'model'  => \Modules\Control\Entities\Company::class,
        'ratio' => [
            'logo'  => [ 'title' => 'control::app.logo', 'width'  => '160', 'height' => '160' ],
        ],
        'relationType' => 'one',
    ],

    'resume' => [
        'model'  => \Modules\Control\Entities\Resume::class,
        'ratio' => [
            'logo'  => [ 'title' => 'control::app.logo', 'width'  => '64', 'height' => '64' ],
        ],
        'relationType' => 'one',
    ],

    'work-experience' => [
        'model'  => \Modules\Control\Entities\WorkExperience::class,
        'ratio' => [
            'logo'  => [ 'title' => 'control::app.logo', 'width'  => '64', 'height' => '64' ],
        ],
        'relationType' => 'one',
    ],

    'gallery' => [
        'model'  => \Modules\Control\Entities\Gallery::class,
        'ratio' => [
            'image'  => [ 'title' => 'control::app.image', 'width'  => '900', 'height' => '900' ],
        ],
        'relationType' => 'one',
    ]
    // 'route_model' => [

        //'model'  => \Modules\Utilities\Entities\Model::class,

        // 'ratio' => [
        //     'first_ratio'  => [ 'title' => 'admin::app.large', 'width'  => '60', 'height' => '60', ],
        //     'second_ratio' => [ 'title' => 'admin::app.large', 'width'  => '480', 'height' => '480', ],
        // ],

        // 'thumps' => [
        //     's' => [ 'width'  => '100', 'height' => '100' ],
        //     'l' => [ 'width'  => '700', 'height' => '700' ],
        // ],

        // 'relationType' => 'one', // 'many'
        // 'stopRelationSave' => true
        // 'relationParam' => ['image_type'],
    // ]
];
