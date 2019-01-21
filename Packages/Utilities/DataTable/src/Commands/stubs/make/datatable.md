    ##--------------------------------------------------
                      install process
    ##--------------------------------------------------
    
    ## if you need to map your col database use this lib 
    composer install sofa/eloquence
    
    ##  laravel-localization is require for datatable to work 
    -- composer require mcamara/laravel-localization
    
    -- add providers
    Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider::class,
    -- aliases
    "LaravelLocalization" => Mcamara\LaravelLocalization\Facades\LaravelLocalization::class,

    ## you must add this lib to make datatable working 
    -- install package
    composer require yajra/laravel-datatables-oracle
    -- add providers
    Yajra\Datatables\DatatablesServiceProvider::class
    -- aliases
    'Datatables' => Yajra\Datatables\Facades\Datatables::class
    -- make command
    php artisan vendor:publish --tag=datatables
    
    ## after add datatable in vendor folder you must add psr-4 namespace for this folder 
    
    "psr-4": {
        "Aut\\DataTable\\": "vendor/Aut/DataTable/src",
    }
    
    ## add in your app config file your package service provider and alias
    
    -- providers
        Aut\DataTable\DataTableServiceProvider::class,
    -- aliases
        'Datatable' => Aut\DataTable\DataTableFacade::class,
    
    -- after that make this command to reload your project (composer dump-autoload)

    -- php artisan make:datatable (make this command for publish package file)
    
    -- to publish your assets and config make this command 
    php artisan vendor:publish --provider="Aut\DataTable\DataTableServiceProvider"
    
    
    <!-- for here doc check  -->
    ##--------------------------------------------------
                      using datatable 
    ##--------------------------------------------------
    
    visit this website to lean how to use query.
    https://yajrabox.com/docs/laravel-datatables/6.0
    https://datatables.yajrabox.com/
    
    -- to make new table you must do this step :
    
    1 - add item inside datatableModels
    
    'example' => [
        'model'            => \Modules\Admin\Entities\Example::class,
        'dataTableFunc'    => 'example_table',
        'request'          => \Modules\Admin\Http\Requests\CityRequest::class
    ],
    
    << description >>
    'city'          :: this will be the param modal for route datatable 
    'dataTableFunc' :: this directly will have 2 function in datatableMaker Class
    a - get_example_table for getting data -- this will be call second
    b - build_example_table for draw table -- this will be call first
    
    2 - add maker function for this item 
    
    << to work with datatable you can use this function >>
    
    // to draw table
    <<< config >>> 
    $tableId | must be unique
    $caption | caption for dialog and button
    $option [
        'dialogWidth'   => set dialog width,
        'disableDialog' => disable dialog,
        'scrollX'       => enable scroll inside table but this will auto disable responsive,
        'filter'        => enable filter for each col,
        'fixedStart'    => set fixed col from left table,  // this required fixedColumns lib
        'fixedEnd'      => set fixed col from right table, // this required fixedColumns lib
        'removeElement' => remove header and footer (search/length/info...et)
    ]
    
    <<< onAdd | onUpdate | onDelete | onLoad | onModalOpen | onModalClose >>>
    on this function you can add script to exec with datatable 
    
    <<< addIndex | addHiddenInput | addInputText | addInputGroup | 
    addTextArea | addInputNumber | addActionButton | addAutocomplete |
    addSelect | addViewField >>>
    
    $title          
    | title for dialog label and header col table
    
    $data            
    | alias col name_pl or id
    | this will display data inside table and used as name attr for dialog 
    | if you type data like : employees.name_pl I will cut the first part and place second part inside dialog as name
    
    $name            
    | example.example_name_pl this is programe name for col and will used inside query filter and search
    $colClass        | look for section class  
    $dialogAttr      | attr for dialog
    $colWidth        | with col in table
    $visible         | for hide/show col
    $orderable       | boolean make it false if you don't need to order this col
    $searchable      | boolean make it false if you don't need to search throw this col
    $choosen = true  | boolean make it false if you don't need to show col in choosen plugin
    
    <<< addHiddenInput >>>
    $value      
    | set value for input
    $primaryKey 
    | if set true this hidden will be primaryKey and if not dialog will take his primaryKey form button you clicked on 
    <<< addInputGroup >>>
    $groupIcon | $groupClass 
    
    <<< addAutocomplete >>> 
    $url | route to your auto action
    
    
    <<< addSelect >>>
    $obj | pass array to select
    
    <<< addAutocomplete | addSelect | addViewField >>> 
    $colLabel 
    | this is working with data
    ex:
    | data     = city_id      ---> this will used as name for dialog and id for autocomplete
    | colLabel = city_name_en ---> this will used for show col data and value for autocomplete
    
    // to buid query table
    <<< queryConfig >>>
    $tableId  | must be unique
    
    <<< queryIndexColumn >>> 
    | this is required when you add addIndex function in get_example_table method 
    
    <<< queryCustomButton >>>
    $colKey  
    | name of col that will added to query 
    |-- this key will be used as data and name when you draw custom button inside table
    
    $rowId   | this is the row id like example_id 
    $icon    | add icon button 
    $class   | to add class to button
    $attr    
    | -- note : if you type {col_name_en} inside attr this will transform to his actual data
    | to add attr to button 
    
    <<< queryCombineColumn >>>
    ->queryCombineColumn('full_name_en',['first_name_en','last_name_en'])
    
    <<< queryFilterColumn >>>
    ->queryFilterColumn('full_name_en',"CONCAT(employees.employee_first_name_en,' ',employees.employee_last_name_en)")
    
    <<< queryDatatable >>>
    $query    | pass obj query Builder or Eloquent
    
    <<<  queryUpdateButton | queryDeleteColumn  >>>
    -note the key query for queryUpdateButton is update // this key will used when you draw update button inside table
    -note the key query for queryDeleteColumn is delete // this key will used when you draw delete button inside table
    $id       | pass col primarykey
    
    <<< queryRender >>>
    $bool     | true result of query will be key:value or false result of query will be value
    
    ## section class
    
    << to work with datatable you can use this class >>
    req|required|number|pl|sl|autocomplete|spinner --> this classes will add automaticly to dialog ,
    any class you add to function will added by default to table unless you add this extention d: befor calss then this class will added to dialog
    
    3 - add view and add this blade temp inside @datatable('model') 
    | like @datatable('city')  this will be datatableLocalizeURL("city/table/create?id=1&name=fofo")
    | ?id=1&name=fofo this param you can take it from request in get_ and build_ function
    
    ##------------------------------------------
                     css and js
    ##------------------------------------------
    
    -- you must add this lib to your app
    -- if you don't have this lib please tell me.
    
    //--------------------------------------------
                          css
    ----------------------------------------------//
    
    // not required but if you don't include it wou will need wo change icon from config file with your icon
    font-awesome.css            (plugin font-awesome)  v4.3.0
    // not required but if you don't include it wou will need wo change icon and font into your font lib 
    simple-line-icons.css       (plugin simple-line-icons) 
    
    // not req when you use autocomplete
    select2.css                 (plugin select2) v4.0.3 
    select2-bootstrap.css       (plugin select2 bootstrap) v0.1.0
    
    // required for display loader
    loaders.css                 (plugin loaders)
    -- note : there is gray background show behind loader if you put table inside panel
    // required
    bootstrap.css               (plugin bootstrap)
    
    // you can use minify from js file but you can make you own 
    <!-- DataTable-->
    // required
    dataTables.bootstrap.css    (plugin dataTables)
    buttons.bootstrap.css       (plugin dataTables)
    responsive.bootstrap.css    (plugin dataTables)
    fixedColumns.bootstrap.css  (plugin dataTables) if needed
    datatables-custom-rtl.css   (css) with rtl
    datatables-custom-ltr.css   (css) with ltr
    datatables-custom.css       (css)   
    
    //--------------------------------------------
                          js
    ----------------------------------------------//
    <!-- JQUERY-->
    jquery.js                   (plugin) v2.1.3
    jquery-request-types.js     (plugin)
    <script>
        //used inside control.js
        var DIR  = "{{ $dir }}";
        var LANG = "{{ $lang }}";
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });
        });
    </script>
    
    //required
    bootstrap.js                (plugin) v3.3.5
    
    // required for autocomplete
    select2.js                  (plugin) v4.0.3 
    
    // required for validation
    jquery.validate.js          (plugin) v1.15.0
    
    // required lodash and jspath
    lodash.js                   (plugin) v4.17.2
    jspath.js                   (plugin) v0.3.3
    
    // you can use minify from js file but you can make you own 
    <!-- DataTable-->           (plugin) v1.10.12
    // required
    jquery.dataTables.js   
    // required for bootstrap
    dataTables.bootstrap.js
    // required for display button
    dataTables.buttons.js
    buttons.bootstrap.js
    buttons.flash.js
    // required for excel
    jszip.js                    (plugin) v2.5.0
    // required for pdf
    pdfmake.js                  (plugin) v0.1.18
    vfs_fonts.js                
    // required for print
    buttons.print.js
    //--required for choosen
    buttons.colVis.js
    // required for display button
    buttons.html5.js
    // required for fixed col
    dataTables.fixedColumns.min.js
    //--required for responsive
    dataTables.responsive.js
    responsive.bootstrap.js
    //--required for exec datatable
    datatable.js
    
    //required for arabic message -- rtl (plugin)
    jquery-validation/localization/messages_ar.js
    select2/js/i18n/ar.js
    
    ###-----------------------------------------------------------------------------------------------------------------
    attention :: after you finish all work please make command : composer dump-autoload to make sure your project work.
    ###-----------------------------------------------------------------------------------------------------------------
     
    //--------------------------------------------
               upgrate to laravel 5.4
    ----------------------------------------------//
    
    1 - in console Class change referencing Illuminate\Console\AppNamespaceDetectorTrait 
                                        To  Illuminate\Console\DetectsApplicationNamespace instead. 
    
    2 - fire function on Factory Make has implement changed in laravel 5.4 