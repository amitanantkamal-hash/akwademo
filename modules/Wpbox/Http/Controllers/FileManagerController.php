<?php

namespace Modules\Wpbox\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Wpbox\Models\FileManager;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Image;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;


class FileManagerController extends Controller
{

    // Brij MOhan Negi Update
    /**
     * Provide class.
     */
    private $provider = FileManager::class;

    /**
     * Web RoutePath for the name of the routes.
     */
    private $webroute_path = 'file-manager.';

    /**
     * View path.
     */
    private $view_path = 'wpbox::file_manager.';

    /**
     * Parameter name.
     */
    private $parameter_name = 'file';

    /**
     * Title of this crud.
     */
    private $title = 'File manager';

    /**
     * Title of this crud in plural.
     */
    private $titlePlural = 'file manager';

    public function media_info()
    {
        $result = $this->provider::where('is_folder', 0)->get();
        $total_file = 0;
        $total_size = $result->sum('size');

        $data = [
            "image" => [
                "size" => 0,
                "count" => 0,
                "percent" => 0
            ],
            "video" => [
                "size" => 0,
                "count" => 0,
                "percent" => 0
            ],
            "csv" => [
                "size" => 0,
                "count" => 0,
                "percent" => 0
            ],
            "pdf" => [
                "size" => 0,
                "count" => 0,
                "percent" => 0
            ],
            "document" => [
                "size" => 0,
                "count" => 0,
                "percent" => 0
            ],
            "audio" => [
                "size" => 0,
                "count" => 0,
                "percent" => 0
            ],
            "other" => [
                "size" => 0,
                "count" => 0,
                "percent" => 0
            ]
        ];

        $result_group_data = $this->provider::where('is_folder', 0)->groupBy('detect')->get();
        if (!empty($result_group_data)) {
            foreach ($result_group_data as $key => $row) {
                $total_file = 0;
                $size =  $result->where('detect', $row->detect)->sum('size');
                $total_file =  $result->where('detect', $row->detect)->count('id');

                $data[$row->detect]['size'] = $size ?? 0;
                $data[$row->detect]['count'] =  $total_file ?? 0;
                $data[$row->detect]['percent'] = round(($size / $total_size) * 100, 4);
            }
        }

        return (object)[
            "total_size" => $total_size,
            "total_file" => $total_file,
            "info" => $data
        ];
    }

    public function popup($type = "")
    {
        $data = [
            "media_type" => $type == "all" ? '' : $type,
            "media_select" => 0,
            "media_id" => "",
        ];
        return view($this->view_path . 'popup',  $data);
    }

    public function load_selected_files(Request $request)
    {
        $medias = $request->medias;
        $ids = $request->ids;
        // $result = $this->provider::where('ids', $ids)->where('file', $medias)->first();
        $result = $this->provider::where('ids', $ids)->first();
        $data = [
            "result" => $result
        ];

        return view($this->view_path . 'load_selected_files', $data);
    }


    public function load_files(Request $request)
    {
        $page_number = (int)$request->page ?? 0;
        $filter = $request->filter ?? '';
        $is_folder = (int)$request->folder ?? 0;
        $keyword = $request->keyword ?? '';
        $folder_id = $request->folder ?? 0;
        
        if ($keyword && !empty($keyword)) {

            if ($page_number == 0) {
                $result = $this->provider::where('name', 'LIKE', "%{$keyword}%")->orderBy('id', 'desc')->limit(50)->offset(0)->get();
            } else {
                $offset_num = $page_number * 50;
                $result = $this->provider::where('name', 'LIKE', "%{$keyword}%")->orderBy('id', 'desc')->limit(50)->offset($offset_num)->get();
            }
        } else {

            if ($page_number == 0) {
                $result = $this->provider::orderBy('id', 'desc')->limit(50)->offset(0)->get();
            } else {
                $offset_num = $page_number * 50;
                $result = $this->provider::orderBy('id', 'desc')->limit(50)->offset($offset_num)->get();
            }
        }

        if ($filter && !empty($filter)) {
            $result = $result->where('detect', $filter);
        }

        //code commented by amit pawar 18-11-2025
        //for showing files inside folder
        // if ($is_folder && !empty($is_folder)) {
        //     $result = $result->where('is_folder', $is_folder);
        // }
        //commented code end

        //code added by amit pawar 18-11-2025
        //for showing files inside folder
        if ($folder_id != 0) {
            $result = $result->where('folder_id', $folder_id);
        } else {
            // show images inside this folder
            $result = $result->where('folder_id', null);
        }
        //for showing files inside folder end
        
        if ($request->page != 0 && empty($result)) return false;
        $data = [
            'result' => $result,
            'page' => (int)$request->page,
            'folder' => (int)$request->folder
        ];

        return view($this->view_path . 'load_files', ['image_data' => $data]);
    }
    
    public function load_widget_files(Request $request)
    {
        $page_number = (int)$request->page ?? 0;
        $filter = $request->filter ?? '';
        $is_folder = (int)$request->folder ?? 0;
        $folder_id = $request->folder ?? 0;

        if ($page_number == 0) {
            $result = $this->provider::orderBy('id', 'desc')->limit(50)->offset(0)->get();
        } else {
            $offset_num = $page_number * 50;
            $result = $this->provider::orderBy('id', 'desc')->limit(50)->offset($offset_num)->get();
        }

        if ($filter && !empty($filter)) {
            $result = $result->where('detect', $filter);
        }

        //code commented by amit pawar 18-11-2025
        //for showing files inside folder

        // if ($is_folder && !empty($is_folder)) {
        //     $result = $result->where('is_folder', $is_folder);
        // }

        //commented code end

        //code added by amit pawar 18-11-2025
        //for showing files inside folder

        if ($folder_id != 0) {
            $result = $result->where('folder_id', $folder_id);
        } else {
            // show images inside this folder
            $result = $result->where('folder_id', null);
        }

        //for showing files inside folder end

        if ($request->page != 0 && empty($result)) return false;
        $data = [
            'result' => $result,
            'page' => (int)$request->page,
            'folder' => (int)$request->folder,
            'widget' => true,
        ];

        return view($this->view_path . 'widget_load_files', ['image_data' => $data]);
    }

    public function editor(FileManager $fileManager)
    {

        $media = $this->provider::where('id', $fileManager->id)->first();

        if (!$media) exit;


        $data = array(
            "image" => asset($media->file)
        );

        return view($this->view_path . 'editor', $data);
    }

    public function requested_media_info(FileManager $fileManager)
    {

        $media_item = $this->provider::where('id', $fileManager->id)->first();

        $data = [
            "result" => $media_item
        ];
        return view($this->view_path . 'requested_media_info', ['media_info' => $data]);
    }


    public function show()
    {
    }

    public function index(Request $request)
    {
        if ($this->getCompany()->getConfig('whatsapp_webhook_verified', 'no') != 'yes' || $this->getCompany()->getConfig('whatsapp_settings_done', 'no') != 'yes') {
            return redirect(route('whatsapp.setup'));
        }
        
        $media_info = $this->media_info();

        $setup = [
            'usefilter' => null,
            'title' => __('File manager'), //Brij Mohan Negi
            'fa_icon' => 'fad fa-folders', //Brij Mohan Negi Update
            'item_names' => $this->titlePlural,
            'webroute_path' => $this->webroute_path,
            'custom_table' => true,
            'file_manager' => true,
            'result' => '',
            'result_count' => '',
            "total_size" => $media_info->total_size,
            "total_file" => $media_info->total_file,
            "media_info" => $media_info->info,
            "max_storage" => "250",
            'page' => (int)$request->page,
            'folder' => (int)$request->folder,
            'parameter_name' => $this->parameter_name,
        ];

        return (view($this->view_path . 'index', ['setup' => $setup]));
    }

    public function create()
    {
        return view($this->view_path . 'create');
    }

    public function store(Request $request)
    {
        $files = $request->file('files');
        $folder = $request->post('folder');
    
        $type = array(
            "jpg" => "image",
            "jpeg" => "image",
            "png" => "image",
            "svg" => "image",
            "webp" => "image",
            "gif" => "image",
            "mp4" => "video",
            "mpg" => "video",
            "mpeg" => "video",
            "webm" => "video",
            "ogg" => "video",
            "avi" => "video",
            "mov" => "video",
            "flv" => "video",
            "swf" => "video",
            "mkv" => "video",
            "wmv" => "video",
            "wma" => "audio",
            "aac" => "audio",
            "wav" => "audio",
            "mp3" => "audio",
            "zip" => "archive",
            "rar" => "archive",
            "7z" => "archive",
            "doc" => "document",
            "txt" => "document",
            "docx" => "document",
            "pdf" => "pdf",
            "csv" => "csv",
            "xml" => "document",
            "ods" => "document",
            "xlr" => "document",
            "xls" => "document",
            "xlsx" => "document"
        );

        $max_storage = 250; //hard coded 250MB max storage allowed and will be change as per user package

        foreach ($files as $key => $file) {

            $upload = new FileManager;

            $file_name = $file->getClientOriginalName();
            $file_extension = strtolower($file->getClientOriginalExtension());
            $file_type = mime2ext($file->getClientMimeType());
            $detect = detect_file_type($file_type);
            $img_info = getimagesize($file);
            $upload_file_size = $file->getSize();

            $storage = $this->provider::get('size');
            $storage = $storage->sum("size");
            if ($max_storage * 1024 < $storage / 1024 + $upload_file_size / 1024) {
                return json_encode([
                    'status' => 'error',
                    'message' => sprintf(__('You have exceeded the storage quota allowed is %sMB'), $max_storage)
                ]);
            }

            $check_allowed_extension = ['png', 'jpg', 'jpeg', 'pdf', 'mp4', 'mp3'];

            $allowed_file_size =  5; //hard coded 5MB max fil size allowed and will be change as per user package

            if ($detect == 'image') {
                $allowed_size = "5";
                $allowed_file_size =  5 * 1024 * 1024; //hard coded 15MB max image file size allowed and will be change as per user package
            } else {
                $allowed_size = "15";
                $allowed_file_size =  15 * 1024 * 1024; //hard coded 15MB max video file size allowed and will be change as per user package
            }

            if ($upload_file_size > $allowed_file_size) {
                return json_encode([
                    "status" => "error",
                    "message" => __(sprintf("Unable to upload " . $detect . " file larger than %sMB", $allowed_size))
                ]);
            }

            if (!in_array($file_extension, $check_allowed_extension)) {
                return json_encode([
                    "status" => "error",
                    "message" => __("The filetype you are attempting to upload is not allowed")
                ]);
            }

            if (!in_array($file_extension, $check_allowed_extension)) {
                return json_encode([
                    "status" => "error",
                    "message" => __("The filetype you are attempting to upload is not allowed")
                ]);
            }
            $img_width = 0;
            $img_height = 0;
            if (!empty($img_info)) {
                $img_width = $img_info[0];
                $img_height = $img_info[1];
            }

            if (!empty($file)) {
                // If folder is provided → store inside that folder
                if (!empty($folder)) {

                    // store in /public/uploads/{folder_id}/
                    $storePath = $file->store("{$folder}", 'public_file_manager');

                    // Generate public URL
                    $path = Storage::disk('public_file_manager')->url($storePath);
                    $upload->file = $path;

                } else {

                    // Otherwise use your original storage logic
                    if (config('settings.use_do_as_storage', false)) {

                        // DigitalOcean
                        $store = $file->storePublicly(config('settings.use_do_folder') . config('settings.use_do_folder_files'), 'do');
                        $path = Storage::disk('do')->url($store);
                        $upload->file = $path;

                        // CDN force
                        $do_cdn_path = env('DO_CDN_PATH');
                        $do_path = env('DO_PATH');
                        if ($do_cdn_path && $do_path) {
                            $path = str_replace($do_path, $do_cdn_path, $path);
                        }

                    } elseif (config('settings.use_s3_as_storage', false)) {

                        // AWS S3
                        $store = $file->storePublicly(config('settings.use_do_folder') . config('settings.use_do_folder_files'), 's3');
                        $path = Storage::disk('s3')->url($store);
                        $upload->file = $path;

                    } else {

                        // Public file manager storage (local)
                        $store_file = $file->store(null, 'public_file_manager');
                        $path = Storage::disk('public_file_manager')->url($store_file);
                        $upload->file = $path;

                    }
                }
                //comment by amit pawar 17-11-2025
                //for original code refer below
                // if (config('settings.use_do_as_storage', false)) {
                //     //DigitalOcean
                //     $path = Storage::disk('do')->url($file->storePublicly(config('settings.use_do_folder') . config('settings.use_do_folder_files'), 'do'));
                //     $upload->file = $path;
                //     //force cdn refrence in sharable url
                //     $do_cdn_path = env('DO_CDN_PATH');
                //     $do_path = env('DO_PATH');
                //     if ($do_cdn_path && $do_path) {
                //         $path = str_replace($do_path, $do_cdn_path, $path); //cdn path
                //     }
                // } elseif (config('settings.use_s3_as_storage', false)) {
                //     //S3
                //     $path = Storage::disk('s3')->url($file->storePublicly(config('settings.use_do_folder') . config('settings.use_do_folder_files'), 's3'));
                //     $upload->file = $path;
                // } else {

                //     $store_file = $file->store(null, 'public_file_manager',);
                //     $upload->file = Storage::disk('public_file_manager')->url($store_file);
                //     $path = $upload->file;
                // }
            }

            // if ($path) {
            //     $media_ids = uniqid();
            //     $upload->ids = $media_ids;
            //     $upload->is_folder = $folder;
            //     $upload->name = $file_name;
            //     $upload->type = $detect . '/' . $file_type;
            //     $upload->extension = $file_extension;
            //     $upload->detect = $detect;
            //     $upload->size =  $file->getSize();
            //     $upload->is_image =  $type[$file_extension] == "image" ? 1 : 0;
            //     $upload->width = $img_width;
            //     $upload->height = $img_height;
            //     $upload->save();
            // }

            //change by amit pawar 15-11-2025
            //for saving folder id in to database
            if ($path) {
                $media_ids = uniqid();
                $upload->ids = $media_ids;
                $upload->is_folder = 0;
                $upload->folder_id = $folder;
                $upload->name = $file_name;
                $upload->type = $detect . '/' . $file_type;
                $upload->extension = $file_extension;
                $upload->detect = $detect;
                $upload->size =  $file->getSize();
                $upload->is_image =  $type[$file_extension] == "image" ? 1 : 0;
                $upload->width = $img_width;
                $upload->height = $img_height;
                $upload->save();
            }
        }

        return json_encode([
            "status" => "success",
            "file" => $path,
            "ids" => $media_ids,
            "detect" => $detect,
            "message" => __('Success')
        ]);
    }


    public function destroy(Request $request)
    {
        $result = $this->provider::orderBy('id', 'desc')->get();

        if (is_array($request->ids)) {
            foreach ($request->ids as $id) {

                $id_data = $result->where('ids', $id)->first();
                //if file contain url digitalocean / amazonaws or else
                if (strpos($id_data->file, "digitaloceanspaces.com") !== FALSE) {
                    $file_name = basename($id_data->file);
                    Storage::disk('do')->delete(config('settings.use_do_folder') . config('settings.use_do_folder_files') . '/' . $file_name);
                    $id_data->delete();
                } elseif (strpos($id_data->file, "amazonaws.com") !== FALSE) {
                    $file_name = basename($id_data->file);
                    Storage::disk('s3')->delete(config('settings.use_do_folder') . config('settings.use_do_folder_files') . $file_name);
                    $id_data->delete();
                } else {
                    if ($id_data->file) {
                        try {
                            unlink($id_data->file);
                            $id_data->delete();
                        } catch (\Exception $e) {
                            $id_data->delete();
                        }
                    }
                }
            }
        }
        return json_encode([
            "status" => "success",
            "message" => __('Success')
        ]);
    }

    # changes made by amit pawar - 14-11-2025
    # controller create for creat new folder in drive section
    
    public function createFolder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
    
        // Check if folder exists already
        $exists = FileManager::where('name', $request->name)
                    ->where('is_folder', 1)
                    ->first();
    
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Folder already exists'
            ]);
        }
    
        $folder = new FileManager();
        $folder->ids = uniqid();
        $folder->name = $request->name;
        $folder->is_folder = 1;
        $folder->detect = 'folder';
        $folder->type = 'folder';
        $folder->extension = 'folder';
        $folder->is_image = 0;
        $folder->size = 0;
        $folder->file = 'folder';
        $folder->width = 0;
        $folder->height = 0;
        $folder->save();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Folder created successfully',
            'folder' => $folder
        ]);
    }

    //added by amit pawar 18-11-2025
    //function to get files by folder id
    public function getFilesByFolder($folderId)
    {
        $files = FileManager::where('folder_id', $folderId)->get();

        // Format data exactly as front-end needs
        $response = $files->map(function ($file) {
            return [
                "media"        => $file->file,
                "media_name"   => $file->name,
                "media_id"     => $file->id,
                "media_detect" => $file->type,
            ];
        });
        return response()->json($response);
    }
    //function end by amit pawar 18-11-2025

}
