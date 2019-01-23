<div class="cropper {{ $cropperClass ?? '' }}">
    <div>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-xs-12 pull-right">

                <div>
                    @component('fileupload::component.panel' ,['id' => 'crop-detail', 'title' => trans('fileupload::fileupload.crop_detail') ,'active' => false])
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" id="dataWidth" class="form-control" placeholder="Image Width" readonly>
                                <span class="input-group-addon">
                                    <b>W</b>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" id="dataHeight" class="form-control" placeholder="Image Height" readonly>
                                <span class="input-group-addon">
                                <b>H</b>
                            </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" id="dataX" class="form-control" placeholder="Image X" readonly>
                                <span class="input-group-addon">
                                <b>X</b>
                            </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" id="dataY" class="form-control" placeholder="Image Y" readonly>
                                <span class="input-group-addon">
                                <b>Y</b>
                            </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" id="dataRotate" class="form-control" placeholder="Image Rotate" readonly>
                                <span class="input-group-addon">
                                <b>Rotate</b>
                            </span>
                            </div>
                        </div>
                    @endcomponent
                </div>

                <div class="crop-ratio hide">
                    @component('fileupload::component.panel' ,['id' => 'crop-ratio', 'title' => trans('fileupload::fileupload.crop_ratio') ,'active' => true])
                        <button type="button" id="cropResize" name="cropResize" data-method="cropResize" data-ratio="index" data-width="width" data-height="height" data-pixel="{{ trans('fileupload::fileupload.pixel') }}" class="btn btn-info btn-block mt crop-ratio-button-hidden hide">title</button>
                        <div class="ratio-button form-group"></div>
                    @endcomponent
                </div>

                @if($showType)
                    @component('fileupload::component.panel' ,['id' => 'crop-type','title' => trans('fileupload::fileupload.crop_type') ,'active' => false])
                        <div class="form-group">
                            @foreach(config('cropper.cropType') as $index => $item)
                                <button type="button" data-method="cropResize" data-width="{{ $item['width'] }}" data-height="{{ $item['height'] }}" class="btn btn-info btn-block mt">{{ trans("app.{$item['title']}") }}</button>
                            @endforeach
                        </div>
                    @endcomponent
                @endif

                <div>
                    <button type="button" class="btn btn-success btn-block mt" data-method="getCroppedCanvas" data-type="crop">{{ trans('fileupload::fileupload.crop') }}</button>

                    @if($single)
                        <button type="button" class="btn btn-success btn-block mt" data-method="getCroppedCanvas" data-type="upload">{{ trans('fileupload::fileupload.upload') }}</button>
                    @endif

                    @if($showManager)
                    <div class="btn-group btn-block btn-group-sm mt">
                        <button type="button" class="btn btn-primary" style="width: 85%;">{{ trans('fileupload::fileupload.file_manager') }}</button>
                        <button type="button" data-toggle="dropdown" style="width: 15%;" class="btn dropdown-toggle btn-primary">
                            <span class="caret"></span>
                            <span class="sr-only">primary</span>
                        </button>
                        <ul role="menu" class="dropdown-menu" style="width: 100%;">
                            <li>
                                <a for="inputImageManager" title="{{ trans('fileupload::fileupload.open_manager') }}" href="javascript:open_popup('{{ fileUploadLocalizeURL('filemanager/dialog?type=1&popup=1&field_id=inputImageManagerUrl') }}')">
                                    <span>{{ trans('fileupload::fileupload.open_manager') }}</span>
                                </a>
                            </li>
                            <li>
                                <a for="inputImageManager" title="{{ trans('fileupload::fileupload.apply_file_to_cropper') }}" data-method="getCroppedCanvas" data-type="applyFilemanager" href="javascript:void(0)">
                                    <span>{{ trans('fileupload::fileupload.apply_file_to_cropper') }}</span>
                                </a>
                            </li>
                        </ul>
                        <input id="inputImageManagerUrl" name="inputImageManagerUrl" type="hidden">
                    </div>
                    @endif

                </div>

                @if($showToggleOption)
                    <div class="docs-toggles mt">
                    <div class="mb dropdown dropup docs-options">
                        <button id="toggleOptions" type="button" data-toggle="dropdown" aria-expanded="true" class="btn btn-info btn-block dropdown-toggle">
                            {{ trans('fileupload::fileupload.toggle_options') }}
                            <span class="caret"></span>
                        </button>
                        <ul role="menu" aria-labelledby="toggleOptions" class="dropdown-menu p">
                            <li role="presentation" class="pv-sm">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="option" value="strict" checked="checked">strict</label>
                            </li>
                            <li role="presentation" class="pv-sm">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="option" value="responsive" checked="checked">responsive</label>
                            </li>
                            <li role="presentation" class="pv-sm">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="option" value="checkImageOrigin" checked="checked">checkImageOrigin</label>
                            </li>
                            <li role="presentation" class="pv-sm">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="option" value="modal" checked="checked">modal</label>
                            </li>
                            <li role="presentation" class="pv-sm">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="option" value="guides" checked="checked">guides</label>
                            </li>
                            <li role="presentation" class="pv-sm">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="option" value="highlight" checked="checked">highlight</label>
                            </li>
                            <li role="presentation" class="pv-sm">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="option" value="background" checked="checked">background</label>
                            </li>
                            <li role="presentation" class="pv-sm">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="option" value="autoCrop" checked="checked">autoCrop</label>
                            </li>
                            <li role="presentation" class="pv-sm">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="option" value="dragCrop" checked="checked">dragCrop</label>
                            </li>
                            <li role="presentation" class="pv-sm">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="option" value="movable" checked="checked">movable</label>
                            </li>
                            <li role="presentation" class="pv-sm">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="option" value="rotatable" checked="checked">rotatable</label>
                            </li>
                            <li role="presentation" class="pv-sm">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="option" value="zoomable" checked="checked">zoomable</label>
                            </li>
                            <li role="presentation" class="pv-sm">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="option" value="touchDragZoom" checked="checked">touchDragZoom</label>
                            </li>
                            <li role="presentation" class="pv-sm">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="option" value="mouseWheelZoom" checked="checked">mouseWheelZoom</label>
                            </li>
                            <li role="presentation" class="pv-sm">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="option" value="cropBoxMovable" checked="checked">cropBoxMovable</label>
                            </li>
                            <li role="presentation" class="pv-sm">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="option" value="cropBoxResizable" checked="checked">cropBoxResizable</label>
                            </li>
                            <li role="presentation" class="pv-sm">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="option" value="doubleClickToggle" checked="checked">doubleClickToggle</label>
                            </li>
                            <li role="presentation" class="pv-sm">
                                <label data-method="resetOption" type="button" title="Reset" class="btn btn-info btn-block">
                                    <span class="fa fa-refresh"></span>
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
                @endif

            </div>

            <div class="col-lg-9 col-md-9 col-xs-12 pull-left">

                @unless($showName && $showOption)
                    <div>

                        @if($showName)
                            <div class="form-group">
                                <input type="text" id="ImageName" name="ImageName" class="form-control" placeholder="{{ trans('fileupload::fileupload.image_name') }}">
                            </div>
                        @endif

                        @if($showOption)
                            <div class="docs-buttons">
                                <div class="mb btn-group btn-group-justified btn-group-sm">
                                    <label data-method="setRatio" data-option="ratio" type="button" title="Ratio" class="btn btn-info">
                                        <span class="fa fa-magnet"></span>
                                    </label>
                                    <label data-method="setDragMode" data-option="move" type="button" title="Move" class="btn btn-info">
                                        <span class="fa fa-arrows"></span>
                                    </label>
                                    <label data-method="setDragMode" data-option="crop" type="button" title="Crop" class="btn btn-info">
                                        <span class="fa fa-crop"></span>
                                    </label>
                                    <label data-method="zoom" data-option="0.1" type="button" title="Zoom In" class="btn btn-info">
                                        <span class="fa fa-plus-square"></span>
                                    </label>
                                    <label data-method="zoom" data-option="-0.1" type="button" title="Zoom Out" class="btn btn-info">
                                        <span class="fa fa-minus-square"></span>
                                    </label>
                                    <label data-method="rotate" data-option="-45" type="button" title="Rotate Left" class="btn btn-info">
                                        <span class="fa fa-arrow-left"></span>
                                    </label>
                                    <label data-method="rotate" data-option="45" type="button" title="Rotate Right" class="btn btn-info">
                                        <span class="fa fa-arrow-right"></span>
                                    </label>
                                    <label data-method="crop" type="button" title="Crop" class="btn btn-info">
                                        <span class="fa fa-check"></span>
                                    </label>
                                    <label data-method="clear" type="button" title="Clear" class="btn btn-info">
                                        <span class="fa fa-times"></span>
                                    </label>
                                    <label data-method="disable" type="button" title="Disable" class="btn btn-info">
                                        <span class="fa fa-lock"></span>
                                    </label>
                                    <label data-method="enable" type="button" title="Enable" class="btn btn-info">
                                        <span class="fa fa-unlock"></span>
                                    </label>
                                    <label data-method="reset" type="button" title="Reset" class="btn btn-info">
                                        <span class="fa fa-refresh"></span>
                                    </label>
                                    <label for="inputImage" title="Upload image file" class="btn btn-info btn-upload">
                                        <input id="inputImage" name="file" type="file" accept="image/*" class="sr-only">
                                        <span class="fa fa-upload"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="docs-toggles">
                            <div data-toggle="buttons" class="mb btn-group btn-group-justified btn-group-sm">
                                <label data-method="setAspectRatio" data-option="1.7777777777777777" title="Set Aspect Ratio" class="btn btn-info ratio active">
                                    <input id="aspestRatio1" name="aspestRatio" value="1.7777777777777777" type="radio" class="sr-only">
                                    <span>16:9</span>
                                </label>
                                <label data-method="setAspectRatio" data-option="1.3333333333333333" title="Set Aspect Ratio" class="btn btn-info ratio">
                                    <input id="aspestRatio2" name="aspestRatio" value="1.3333333333333333" type="radio" class="sr-only">
                                    <span>4:3</span>
                                </label>
                                <label data-method="setAspectRatio" data-option="1" title="Set Aspect Ratio" class="btn btn-info ratio">
                                    <input id="aspestRatio3" name="aspestRatio" value="1" type="radio" class="sr-only">
                                    <span>1:1</span>
                                </label>
                                <label data-method="setAspectRatio" data-option="0.6666666666666666" title="Set Aspect Ratio" class="btn btn-info ratio">
                                    <input id="aspestRatio4" name="aspestRatio" value="0.6666666666666666" type="radio" class="sr-only">
                                    <span>2:3</span>
                                </label>
                                <label data-method="setAspectRatio" data-option="NaN" title="Set Aspect Ratio" class="btn btn-info ratio">
                                    <input id="aspestRatio5" name="aspestRatio" value="NaN" type="radio" class="sr-only">
                                    <span>Free</span>
                                </label>
                            </div>
                        </div>
                        @endif

                    </div>
                @endunless

                <div class="img-container mb-lg">
                    <img src="{{ asset('img/mb-sample.jpg') }}" alt="Picture">
                </div>

                @if($showPreview)
                    <div class="docs-preview clearfix">
                        @foreach($previewType as $type)
                            <div class="img-preview preview-{{ $type }}"></div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>