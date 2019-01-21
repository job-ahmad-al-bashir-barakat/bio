<?php


/**
 *
 *                             Autocompelte Doc ----- >>>  ^_^
 *
 *
 *  |  ------------------------------   |  -----------------------------
 *  |       default withoutLang         |       default withLang
 *  |  ------------------------------   |  -----------------------------
 *  |  'colId'     => 'id',             |  'colId'     => 'id',
 *  |  'colName'   => 'name_{lang}',    |  'colName'   => 'transName->text',
 *  |  'condition' => [                 |  'condition' => [
 *  |      'name_{langs}',              |      'transName' => 'text',
 *  |  ]                                |  ]
 *
 * ----------------------------------------------------------------------------------------------------
 * model     : define model for fetch data from it
 * ----------------------------------------------------------------------------------------------------
 * condition : is array of relation => condition
 *
 * -- (just withLang) type {langs} with col this will loop over all lang to add them as condition
 * -- if you add condition as item key\value in array this will be  $wheteHas => $col condition
 *
 *| 'condition' => [
 *|      //ps: whereHas page => filter on code col
 *|      'page' => 'code',
 *|  ],
 *
 * -- if you add condition as item just value in array this will be traditional where condition
 *
 *| 'condition' => [
 *|      //ps: where code col
 *|      'code',
 *|  ],
 *
 * ps : if you need to make extra custom condition there is class AutocompleteHelperClass inside app/Library you can use it
 *
 *|  this class has function name of tow part
 *|  1: general model route param and
 *|  2: Autocomplete
 *|
 *|  'general' => [
 *|      'model' => APP\Entities\General::class,
 *|  ]
 *|
 *|  function generalAutocomplete(Request $request ,$query) {
 *|
 *|      return $query->where('id' ,'<>' ,$request->input('id'));
 *|  }
 *
 * ----------------------------------------------------------------------------------------------------
 * colId     : id string for autocompelte
 * ----------------------------------------------------------------------------------------------------
 * colName   : is string|array of cols that will display on autocompelte
 * | (just withLang) type {lang} with col this will replace with current lang
 * | you can pass array to show as name title ['name' ,'code']
 * | you can pass custom complex property make on model
 * ----------------------------------------------------------------------------------------------------
 *
 * ps : anywhere you need to get name from relation or make condition on col inside relation
 *      just type your col like this model->relation->name
 *
 * ps : if you use tags create we need to add col inside table user_id for delete reason and approvied to be availible to outside world
 */

return [

    'faq-types' => [
        'model'   => \Modules\Control\Entities\FaqType::class,
    ],

    'tag-lists' => [
        'model'     => \Modules\Control\Entities\TagList::class,
        'colName'   => 'name',
        'tags' => true,
    ],

    'company-employers' => [
        'model' => \Modules\Control\Entities\CompanyEmployer::class,
        'q' => function($request,$object) {

            $q = str_replace(' ', '%', request()->input('q', ''));

            return $object->where('min','like', '%' . $q . '%')
                          ->orWhere('max','like', '%' . $q . '%');
        },
    ],

    'skills' => [
        'model'     => \Modules\Control\Entities\Skill::class,
        'colName'   => 'name',
        'tags' => true,
    ],

    'we-job-title' => [
        'model'     => \Modules\Control\Entities\WorkExpJobTitle::class,
        'colName'   => 'name',
        'tags' => true,
    ],

    'we-company' => [
        'model'     => \Modules\Control\Entities\WorkExpCompany::class,
        'colName'   => 'name',
        'tags' => true,
    ],

    'degree' => [
        'model'     => \Modules\Control\Entities\Degree::class,
        'colName' => 'name_{lang}',
        'colText' => 'name_{lang}',
        'colTitle' => 'name_{lang}',
        'q'         => [
            'name_{langs}',
        ],
    ],

    'majer' => [
        'model'   => \Modules\Control\Entities\Majer::class,
        'colName' => 'name',
        'tags'    => true,
    ],

    'school' => [
        'model'   => \Modules\Control\Entities\School::class,
        'colName' => 'name',
        'tags'    => true,
    ],

    'category' => [
        'model'   => \Modules\Control\Entities\Category::class,
        'colName' => 'name_{lang}',
        'colText' => 'name_{lang}',
        'colTitle' => 'name_{lang}',
        'q'         => [
            'name_{langs}',
        ],
    ],

    'contract' => [
        'model'   => \Modules\Control\Entities\Contract::class,
        'colName' => 'name_{lang}',
        'colText' => 'name_{lang}',
        'colTitle' => 'name_{lang}',
        'q'         => [
            'name_{langs}',
        ],
    ],

    'icon' => [
        'model'    => \Modules\Control\Entities\Icon::class,
        'colName'  => 'icon',
        'colText'  => 'icon',
        'colTitle' => 'icon',
        'q'         => [
            'code',
        ],
    ],
];