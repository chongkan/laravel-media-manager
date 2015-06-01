<?php
namespace Chongkan\MediaManager\Controllers;

use Chongkan\MediaManager\Models\MediaPositions;

class MediasController extends \BaseController
{

    public $log = [];

    //-----------------------------------
    public function __construct()
    {
        $this->beforeFilter('admin.auth');

    }
    /**
     * Display a listing of medias
     *
     * @return Response
     */

    public function index()
    {
        $routeCollection = \Route::getRoutes();
        $paths = [];
        foreach ($routeCollection as $value) {
            $path = $value->getPath();
            if(strpos($path, 'admin') === false && strpos($path, 'api') === false && strpos($path, 'http') === false)
            {
                // Exclude routes we don't want to show by pattern
                $paths[] = $path;
            }
        }
        // Remove duplicate entries
        $paths = array_unique($paths);
        // Sort alphabetically, make / be first
        sort($paths);
        $data = new \stdClass();
        $data->paths = $paths;
        return \View::make('media-manager::admin.medias.index', compact('data', $data));
    }

    /**
     * Validates POST fields
     * @return mixed
     */
    private function validatePost()
    {
        $messages = array(
            'required' => 'The :attribute field is required.',
            'in' => 'The :attribute must be one of the following types: :values',
            'not_in' => 'FB :attribute is empty',
        );
        $validator = Validator::make($this->formData,
            array(
                'file' => 'required'
            ), $messages);
        return $validator;
    }

    /**
     * @param $success
     * @param $message
     * @return mixed
     */
    private function respond($success, $message)
    {
        return \Response::json(['success' => $success, 'messages' => $message]);
    }

    /**
     * @return mixed
     */
    public function upload()
    {
        $this->formData = Input::only('file');
        // Validate Form Data
        $formDataValidator = $this->validatePost();
        if (!$formDataValidator->fails()) {
            $this->log['UploadedFile']['step'] = 'Processing..';
            $fileLocation = $this->processMediaFile($this->formData["file"]);
            if ($fileLocation) {
                return $this->respond(true, $this->log);
            } else {
                $this->log['UploadedFile']['error'] = 'No File location returned';
                return $this->respond(false, $this->log);
            }
        } else {
            // what failed?
            $messages = $formDataValidator->messages();
            return $this->respond(false, $messages);
        }
    }

    /**
     * |--------------------------------------------------------------------------
     * | Process media file
     * |--------------------------------------------------------------------------
     * | Receives a file encoded in form-data format.
     * | http://stackoverflow.com/questions/18083496/how-to-encode-a-file-from-the-file-system-as-multipart-form-data
     * | */

    private
    function processMediaFile($file)
    {
        //Validate File is image
        $fileExtension = strtolower($file->getClientOriginalExtension());
        $input = array('file' => $file);
        $rules = array('file' => 'image');
        $validator = Validator::make($input, $rules);
        $filename = $file->getClientOriginalName();

        if ($validator->fails()) {
            $this->log['UploadedFile']['processMediaFile_URL'] = 'Unsupported Video Extension -> ' . $this->fileExtension;
            return false;
        } else {
            // File is an image
            $fileLocalPath = 'media/' . $filename;
            $file->move('media/', $filename);
            $this->log['UploadedFile']['processMediaFile_URL'] = asset($fileLocalPath, Config::get('app.https'));
            return $fileLocalPath;
        }

    }

    public function getData(){

        $file = \Input::get('file');
        $positions = MediaPositions::where('file_path', '=', $file)->get();
        echo json_encode($positions);
    }

    private function validateSave()
    {
        $messages = array(
            'required' => 'The :attribute ield is required.',
            'in' => 'The :attribute must be one of the following types: :values',
            'not_in' => 'FB :attribute is empty',
        );
        $validator = \Validator::make($this->formData,
            array(
                'fileName' => 'required',
            ), $messages);
        return $validator;
    }

    public function save(){

        $this->formData = \Input::all();
        // Validate Form Data
        $formDataValidator = $this->validateSave();
        if (!$formDataValidator->fails()) {
            $assignment = MediaPositions ::where('file_path', '=', $this->formData["fileName"])->first();

            if (count($assignment) == 0){
                $assignment = new MediaPositions;
            }
            $assignment->url = $this->formData["pathSelect"];
            $assignment->file_path = $this->formData["fileName"];
            $assignment->position = $this->formData["positionTxt"];
            $assignment->start_date = date('Y-m-d h:i', strtotime($this->formData["start_date"]));
            $assignment->end_date = date('Y-m-d h:i', strtotime($this->formData["end_date"]));
            $assignment->order = $this->formData["orderTxt"];
            $assignment->attr_class = $this->formData["attr_classTxt"];
            $assignment->attr_id = $this->formData["attr_idTxt"];
            $assignment->other_atts = $this->formData["other_attsTxt"];

            if ($assignment->position == ''){

                if ($this->formData["operation"] == 'delete'){
                    unlink('media/' . $assignment->file_path);
                }
                $this->destroy($assignment->id);
            }else{
                $assignment->save();
            }

            return $this->respond(true, $this->log);
        } else {
            // what failed?
            $messages = $formDataValidator->messages();
            return $this->respond(false, $messages);
        }
    }

    public static function render($response, $path){

        $urlMedia = self::getMediaByURL($path);
        $positions = self::getPositionsByURL($path);
        $ckView =  $response->getOriginalContent();
        $today = time();

        //echo json_encode($positions);
        foreach($positions as $position){
            $positionsHTML = '';
            foreach($urlMedia as $media){
                if ($media->position == $position->position){
                    $asset = asset('media/'. $media->file_path);
                    $publish_date = strtotime($media->start_date);
                    $unpublish_date = strtotime($media->end_date);
                    if ($publish_date <= $today && $unpublish_date > $today){
                        $positionsHTML .= '<img id="'. $media->attr_id .'" class="'. $media->attr_class .'" src="' . $asset . '" alt="'. $media->attr_alternate .'" '. $media->other_atts .'/>';
                    }
                }

            }
            $ckView = str_replace('[[mediaPosition '. $position->position .']]', $positionsHTML, $ckView);
        }


        $response->setContent($ckView);
        return $response;
    }

    public static function getMediaByURL($path){
        $media = MediaPositions::where('url', '=', $path)->orderBy('order', 'asc')->get();
        return $media;
    }

    public static function getPositionsByURL($path){
        $media = MediaPositions::where('url', '=', $path)->distinct('position')->select('position')->get();
        return $media;
    }


    public function destroy($id){
        MediaPositions::destroy($id);
    }


}
