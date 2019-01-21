/**
 *
 * please add this libs 
 * --------------------
 * 1 - bootstrap         css/js
 * 2 - select2           css/js
 * 3 - select2-bootstrap css
 *
 * global Js
 * DIR  = "{{ $dir }}",
 * LANG = "{{ $lang }}",
 */

// autocomplete select2

var AUTOCOMPLETE_PACK = {

    autocomplete: {

        init: function (Data) {

            return function () {
                var $this = $(this);
                var data = (typeof Data !== typeof undefined) ? Data : [];
                $this.find('option:selected').each(function (i) {
                    var $this = $(this);
                    data[i] = {id: $this.val(), name: $this.text()};
                });
                var url = $this.data('remote');
                var required = (typeof $this.data('required') !== typeof undefined) ? $this.data('required') : null;
                var placeholder = (typeof $this.data('placeholder') !== typeof undefined) ? $this.data('placeholder') : '';
                var target = (typeof $this.data('target') !== typeof undefined) ? $($this.data('target')) : '';
                var letters = (typeof $this.data('letter') !== typeof undefined) ? $this.data('letter') : 3;
                var tags = (typeof $this.data('tags') !== typeof undefined) ? $this.data('tags') : false;
                var multiple = $this.attr('multiple') ? true : false;
                var linkWith = $this.data('param') || '';
                if (linkWith.charAt(0) == '#') {
                    $(linkWith).change(function () {
                        $this.val('').change();
                    });
                }
                $this.select2({
                    ajax: {
                        url: url,
                        dataType: 'json',
                        delay: 400,
                        method: "GET",
                        data: function (params) {
                            var param = (typeof $this.data('param') !== typeof undefined) ? $this.data('param') : null;

                            //added by basheer
                            var remoteParam = (typeof $this.attr('data-remote-param') !== typeof undefined) ? $this.attr('data-remote-param') : null;

                            if (param && param.charAt(0) === '#') {
                                var name = $(param).attr('name') || $(param).attr('id');
                                var val = $(param).val() ? $(param).val() : 0;
                                param = JSON.parse('{"' + name + '":"' + val + '"}');
                            }
                            var $data = {q: params.term, page: params.page};
                            if (param) {
                                $data = $.extend($data, param);
                            }

                            //added by basheer
                            if (remoteParam)
                                $((remoteParam).split(',')).each(function (i, v) {
                                    $data = $.extend($data, JSON.parse('{"' + (v).split('=')[0] + '" : "' + (v).split('=')[1] + '"}'));
                                });

                            return $data;
                        },
                        processResults: function (data, params) {
                            params.page = params.page || 1;

                            return {
                                results: data.items,
                                pagination: {
                                    more: (params.page * 30) < data.total_count
                                }
                            };
                        },
                        cache: true
                    },
                    escapeMarkup: function (markup) {
                        return markup;
                    },
                    dir: DIR,
                    language: LANG,
                    minimumInputLength: letters,
                    placeholder: placeholder,
                    allowClear: true,
                    templateResult: AUTOCOMPLETE_PACK.autocomplete.formatRepo,
                    templateSelection: AUTOCOMPLETE_PACK.autocomplete.formatRepoSelection,
                    dropdownParent: target,
                    theme: "bootstrap",
                    data: data,

                    tags: tags,
                    multiple: multiple,
                    selectOnClose: !multiple,
                    tokenSeparators: [","],
                    createTag: function(newTag) {

                        var term = $.trim(newTag.term);

                        if (term === '' || term.length < 2 || term.indexOf('@') === -1 || term.indexOf('@') !== 0) {
                            return null;
                        }

                        var newTag = (newTag.term).replace(/@/,'');

                        return {
                            id: 'new:' + newTag,
                            text: newTag,
                            newTag: true
                        };
                    }
                }).off('select2:select').on('select2:select', function (evt) {

                    if(evt.params.data.newTag == false) {
                        return;
                    }

                    if(evt.params.data.newTag == true)
                    {
                        $.post(url,{ text: evt.params.data.text }, function (res) {

                            // add new item to selected object
                            var data = $this.select2('data');
                            data.push({ id: res.id, text: res.text, newTag: true , selected: true, disabled: false });

                            // delete new tag element
                            var index = data.findIndex(function(x){
                                return (x.id.toString()).match(/new:/ig);
                            });
                            data.splice(index ,1);

                            // reload autocomplete with selected
                            AUTOCOMPLETE_PACK.autocomplete.resetAutocomplete($this);
                            AUTOCOMPLETE_PACK.autocomplete.selectedAutocomplete($this ,data);
                        });
                    }
                });
            }
        },

        formatRepo: function (repo) {
            return repo.name || repo.text;
        },

        formatRepoSelection: function (repo) {
            var repoText = repo.text || repo.name;
            var $option = $(repo.element);
            for(var key in repo){
                if(key.startsWith('data-')){
                    $option.attr(key, repo[key]);
                    //$option.data('type')
                }
            }
            return repoText;
        },

        selectedAutocomplete: function (selector, data) {

            $(selector).each(AUTOCOMPLETE_PACK.autocomplete.init(data));
        },

        reloadAutocomplete: function (selector) {

            $(selector).each(AUTOCOMPLETE_PACK.autocomplete.init());
        },

        resetAutocomplete: function (selector) {

            //$('.autocomplete').val(null).trigger("change");
            $(selector).empty().trigger('change');
        },

        initAutocomplete: function (selector, $cont) {
            $cont = $cont || false;
            if(typeof selector == 'object'){
                $obj = selector;
            } else {
                selector = selector || '.autocomplete';

                if($cont){
                    $obj = $cont.find(selector);
                } else {
                    $obj = $(selector);
                }
            }
            $obj.each(AUTOCOMPLETE_PACK.autocomplete.init());
        },

        destroyAutocomplete: function (selector, $cont) {
            $cont = $cont || false;
            if(typeof selector == 'object'){
                $obj = selector;
            } else {
                selector = selector || '.autocomplete';
                if($cont){
                    $obj = $cont.find(selector);
                } else {
                    $obj = $(selector);
                }
            }
            $obj.select2('destroy');
        }
    },

    select: {

        init: function (data) {

            return function () {

                var $this = $(this);
                var placeholder = (typeof $this.data('placeholder') !== typeof undefined) ? $this.data('placeholder') : '';

                $this.select2({
                    dir: DIR,
                    language: LANG,
                    placeholder: placeholder,
                    allowClear: true,
                    theme: "bootstrap",
                    data: data
                });
            }
        },

        reloadSelect: function (selector) {

            $(selector).each(initSelect());
        },

        selectedSelect: function (selector, data) {

            $(selector).each(initSelect(data));
        },

        resetSelect: function (selector) {

            $(selector).val('').trigger("change");
        },

        initSelect: function (selector, $cont) {
            $cont = $cont || false;
            if(typeof selector == 'object'){
                $obj = selector;
            } else {
                selector = selector || '.select';
                if($cont){
                    $obj = $cont.find(selector);
                } else {
                    $obj = $(selector);
                }
            }

            $obj.each(AUTOCOMPLETE_PACK.select.init());
        },

        destroySelect: function (selector, $cont) {
            $cont = $cont || false;
            if(typeof selector == 'object'){
                $obj = selector;
            } else {
                selector = selector || '.select';
                if($cont){
                    $obj = $cont.find(selector);
                } else {
                    $obj = $(selector);
                }
            }
            $obj.select2('destroy');
        }
    },
};

/**
 * init App
 */
$(function () {

    AUTOCOMPLETE_PACK.select.initSelect();
    AUTOCOMPLETE_PACK.autocomplete.initAutocomplete();
});