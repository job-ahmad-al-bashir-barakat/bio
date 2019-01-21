
# Blade 

## head meta  
you must add this line inside head for marker to work correctly
```html
    <base href="{{ asset('/') }}">
```

## Input group

#### in input group class
 ```
 input-location
 ```
#### add data-modal = onclick will show modal  
```
data-modal => '#modal-{model}-input-location'
```

``` html
<div id="location_group" class="input-group input-location hand">
    <input id="location" name="location" type="text" placeholder="Location" class="form-control required req" data-modal="#modal-companies-input-location">
    <span class="input-group-addon">
        <span class="fa fa-map-marker"></span>
    </span>
</div>
```

#### blade: add modal map and set default localtion is requierd

```php
{!! autGoogleMap('companies',false,'#datatable-labs-modal .input-location input',10,'Syria ,Aleppo') !!}```
```

# script

``` javascript 
 <script async defer type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyCC3X-thsM5s1FkNqwFtRKTaa1CMFctf1k&language={{$lang}}&libraries=places"></script>
```
# mix

### css

``` javascript
    'Packages/Utilities/GoogleMap/src/Assets/css/GMap.css'
```

### js

``` javascript
    'Packages/Utilities/GoogleMap/src/Assets/plugin/jQuery-gMap/jquery.gmap.min.js',
    'Packages/Utilities/GoogleMap/src/Assets/js/GMap.js',
```

### copy

``` javascript
    mix.copy('Packages/Utilities/GoogleMap/src/Assets/plugin/jQuery-gMap/marker_red.png', 'public/images' ,false);
```

# composer.json

```php
"psr-4": {
    "Aut\\GoogleMap\\": "Packages/Utilities/GoogleMap/src"
}
```

# app provider config

`Aut\GoogleMap\GoogleMapServiceProvider::class,`