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
