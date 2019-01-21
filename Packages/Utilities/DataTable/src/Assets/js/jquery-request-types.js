// Set PUT,DELETE
jQuery.each( [ "put" , "delete" ], function( i, method ) {
    jQuery[ method ] = function( url, data, callback, type ) {
        var setMethod = {"_method":method};
        if (jQuery.isFunction( data ) ) {
            type = type || callback;
            callback = data;
            data = setMethod;
        }
        else{
            if(typeof data == 'string') {
                data = data + '&_method='+method;
            }else {
                data = $.extend(data, setMethod)
            }
        }
        return jQuery.ajax({
            type: "POST",
            url: url,
            data: data,
            dataType: type,
            success: callback
        });
    };
});