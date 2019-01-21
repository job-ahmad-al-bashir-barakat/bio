### ltr css 
'Modules/Admin/Assets/vendor/bootstrap-fileinput/css/fileinput.css',
'Modules/Admin/Assets/vendor/cropper/dist/cropper.css',
### rtl css 
'Modules/Admin/Assets/vendor/bootstrap-fileinput/css/fileinput.css',
'Modules/Admin/Assets/vendor/bootstrap-fileinput/css/fileinput-rtl.css',
'Modules/Admin/Assets/vendor/cropper/dist/cropper.css',
### js 
'Modules/Admin/Assets/vendor/bootstrap-fileinput/js/fileinput.js',
'Modules/Admin/Assets/vendor/bootstrap-fileinput/themes/fa/theme.js',
'Modules/Admin/Assets/vendor/cropper/dist/cropper.js',
### ltr js
'Modules/Admin/Assets/vendor/bootstrap-fileinput/js/locales/en.js',
### rtl js
'Modules/Admin/Assets/vendor/bootstrap-fileinput/js/locales/ar.js',
### copy
mix.copy('resources/assets/theme/control/bootstrap-fileinput/img', 'public/img' ,false);

# Global Js Variable 
var DIR  = "{{ $dir }}",
    LANG = "{{ $lang }}",
        
# composer
"Aut\\FileUpload\\": "Packages/Utilities/FileUpload/src"

# app config

#### ServiceProvider
Aut\FileUpload\FileUploadServiceProvider::class,

#### Facade
"FileUpload" => Aut\FileUpload\FileUploadFacade::class,