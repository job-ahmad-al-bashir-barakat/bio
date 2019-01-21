<?php

namespace Aut\FileUpload\Http\Controllers;

use Aut\FileUpload\Http\Requests\UploadFormRequest;
use App\Http\Controllers\Controller;
use Aut\FileUpload\Entities\Image;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Storage;
use Route;

class UploadController extends Controller
{
    public $imageGeneralConfig = [];

    public $imageLocalConfig = [];

    public $uploadDirectory = '';

    public $targetDirectory = '';

    public $stopRelationSave = false;

    public $relationType = '';

    public $relationName = '';

    function __construct()
    {
        if(Route::getCurrentRoute() !== null)
        {
            $routeParam = Route::getCurrentRoute()->parameters();

            $this->imageGeneralConfig = config("fileupload.setting");
            $this->imageLocalConfig   = config("fileupload.{$routeParam['model']}");

            // get config relationType
            $this->relationType = isset($this->imageLocalConfig['relationType'])
                ? $this->imageLocalConfig['relationType']
                : $this->imageGeneralConfig['relationType'];

            // get config relationName
            $this->relationName = isset($this->imageLocalConfig['relationName'])
                ? $this->imageLocalConfig['relationName']
                : $this->imageGeneralConfig['relationName'];

            // get path upload directory storage
            $uploadDirectory = isset($this->imageLocalConfig['upload_directory'])
                ? $this->imageLocalConfig['upload_directory']
                : $this->imageGeneralConfig[$routeParam['type']]['upload_directory'];

            // stop all relation oper
            $this->stopRelationSave = isset($this->imageLocalConfig['stopRelationSave'])
                ? $this->imageLocalConfig['stopRelationSave']
                : false;

            $folderUpload = Str::plural($routeParam['model']);

            $this->targetDirectory = "public\\$uploadDirectory\\$folderUpload";
            $this->uploadDirectory = "app\\public\\$uploadDirectory\\$folderUpload";
        }
    }

    function index(Request $request ,$model ,$type) {

        $ids = $request->input('images_id');

        $images = [];

        if(!empty($ids)) {
            $images = Image::whereIn('id' ,$ids)->get();
        } else {
            // get from config model if is there isn't ids
        }

        return $images;
    }

    function upload(UploadFormRequest $request ,$model ,$type) {

        $file = $request->file($model);
        $file = is_array($file) ? $file[0] : $file;

        $dimensions  = getimagesize($file->getPathname());
        $imageRatio  = number_format($dimensions[0]/$dimensions[1] ,1);

        $paramFromName = explode(',_,' ,$file->getClientOriginalName());

        $clientOriginalName = $paramFromName[0];
        $ratio              = isset($paramFromName[1]) ?  $paramFromName[1] : false;

        if($ratio)
            $getRatio = collect($this->imageLocalConfig['ratio'])->get($ratio);
        else
            foreach ($this->imageLocalConfig['ratio'] as $index => $current_ratio) {

                $loopRatio = number_format($current_ratio['width']/$current_ratio['height'] ,1);

                if($loopRatio === $imageRatio) {

                    $getRatio = $current_ratio;

                    break;
                }
            }

        $path       = storage_path($this->uploadDirectory);
        $hashName   = strtolower(str_random(12))."_{$type}_". $clientOriginalName;

        // make directory if not exists
        Storage::makeDirectory($this->targetDirectory);

        // move with intervention
        $imgRezise = \Image::make($file->getRealPath());
        $imgRezise->resize($getRatio['width'], $getRatio['height'])->save("$path/$hashName");

        // it just move your image
        //$file->move($path ,$hashName);

        $extraParams =  [
            'name'      => $clientOriginalName,
            'hash_name' => $hashName,
            'ext'       => $file->getClientOriginalExtension(),
            'width'     => $getRatio['width'],
            'height'    => $getRatio['height'],
            'size'      => $file->getClientSize(),
        ];

        // save file inside file table
        $partFunc = Str::studly($type);
        $returnParam = $this->{"saveUpload{$partFunc}Db"}($extraParams);

        // set image thumps for image
        if(isset($this->imageLocalConfig['thumps'])) {

            //make thumps directory
            Storage::makeDirectory("$this->targetDirectory/thumps");

            foreach ($this->imageLocalConfig['thumps'] as $index => $thump) {

                //make thumps directory
                Storage::makeDirectory("$this->targetDirectory/thumps/$index");

                //resize thump image directory
                $imgRezise->resize($thump['width'], $thump['height'])->save("$path/thumps/$index/$hashName");
            }
        }

        if(!$this->stopRelationSave)
        {
            // get config model
            $dbModel = $this->imageLocalConfig['model'];

            // relationName image or else
            $relationName = $this->relationName;

            // save relation file
            $dbModel = $dbModel::findOrFail($request->get('id'));

            // relation params or extra update param
            $params = [];
            if(isset($this->imageLocalConfig['relationParam']) && count($this->imageLocalConfig['relationParam']))
                foreach ($this->imageLocalConfig['relationParam'] as $param)
                    $params[$param] = $request->input($param);

            // relationType has to be many or one
            if($this->relationType == 'many') {

                $attach = $returnParam->id;

                if(count($params))
                    $attach = [ $returnParam->id => $params ];

                $dbModel->{$relationName}()->attach($attach);

            } else {

                $dbModel->update(array_merge(["{$type}_id" => $returnParam->id] ,$params));
            }
        }

        return array_merge(["success" => true], [$model => $returnParam]);
    }

    function destroy(Request $request ,$model ,$type) {

        // remove this
        // request()->request->add(['transSaveOper' => false]);

        if(!$this->stopRelationSave)
        {
            // get config model
            $dbModel = $this->imageLocalConfig['model'];

            // relationName image or else
            $relationName = $this->relationName;

            // save relation file
            $dbModel = $dbModel::findOrFail($request->get('id'));

            // relationType has to be many or one
            if($this->relationType == 'many')
                $dbModel->{$relationName}()->detach($request->get('key'));
            else
                $dbModel->update(["{$type}_id" => null]);
        }

        //delete file from db
        $partFunc = Str::studly($type);
        $this->{"destroyUpload{$partFunc}Db"}($request->get('key'));

        // set storage path for file delete
        $path       = $this->targetDirectory;
        $hashName   = $request->get('file_name');
        // delete image from storage .. ps: this accept just file name but i pass full path.
        Storage::delete("$path\\$hashName");

        // delete image thumps for storge
        if(isset($this->imageLocalConfig['thumps'])) {

            //make thumps directory
            foreach ($this->imageLocalConfig['thumps'] as $index => $thump) {

                //resize thump image directory
                Storage::delete("$path\\thumps\\$index\\$hashName");
            }
        }

        return ["success" => true];
    }

    protected function saveUploadImageDb($extraParams) {

        // remove this
        // request()->request->add(['transSaveOper' => false]);

        $image = Image::create($extraParams);

        return $image;
    }

    protected function destroyUploadImageDb($id) {

        Image::destroy($id);
    }
}
