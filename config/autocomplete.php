<?php

return [

    'routeMiddleware' => ['web', 'localeSessionRedirect', 'localizationRedirect' ],

    'isLangs' => false,

    'AutocompleteHelperClass' => \App\Library\AutocompleteHelper::class,

    // 'version'    => '5.5',

    'default'   => [

        'withoutLang' => [
            'colId'     => 'id',
            'colName'   => 'name',
            'colText'   => 'name',
            'colTitle'  => 'name',
            'q'         => [
                'name',
            ],
        ],

        /*
         * Langs Way
         */
        'withLang' => [
            'colId'     => 'id',
            'colName'   => 'transName->text',
            'q'         => [
                'transName' => 'text',
            ],
        ]
    ],
];