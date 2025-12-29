<?php

namespace Modules\Wpbox\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Wpbox\Models\Template;
use Modules\Wpbox\Traits\Whatsapp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Modules\Wpbox\Models\WhatsappFlowsModel;
use Modules\Wpbox\Models\FileManager;
use Illuminate\Support\Facades\Storage;

class TemplatesController extends Controller
{
    use Whatsapp;
    /**
     * Provide class.
     */
    private $provider = Template::class;

    /**
     * Web RoutePath for the name of the routes.
     */
    private $webroute_path = 'templates.';

    /**
     * View path.
     */
    private $view_path = 'wpbox::templates.';

    /**
     * Parameter name.
     */
    private $parameter_name = 'templates';

    /**
     * Title of this crud.
     */
    private $title = 'template';

    /**
     * Title of this crud in plural.
     */
    private $titlePlural = 'templates';

    // public function index()
    // {
    //     $this->authChecker();

    //     if ($this->getCompany()->getConfig('whatsapp_webhook_verified', 'no') != 'yes' || $this->getCompany()->getConfig('whatsapp_settings_done', 'no') != 'yes') {
    //         return redirect(route('whatsapp.setup'));
    //     }

    //     $items = $this->provider::orderBy('created_at', 'desc');
    //     if (isset($_GET['name']) && strlen($_GET['name']) > 1) {
    //         $items = $items->where('name', 'like', '%' . $_GET['name'] . '%');
    //     } else {
    //         //If there are 0 template,and there is no filter, load them
    //         try {
    //             $this->loadTemplatesFromWhatsApp();
    //         } catch (\Throwable $th) {
    //             //throw $th;
    //         }
    //     }
    //     $items = $items->paginate(config('settings.paginate'));

    //     //If there is a refresh request
    //     if (isset($_GET['refresh']) && $_GET['refresh'] == 'yes') {
    //         $this->loadTemplatesFromWhatsApp();
    //     }

    //     return view($this->view_path . 'index', [
    //         'setup' => [
    //             'title' => __('crud.item_managment', ['item' => __($this->titlePlural)]),

    //             'action_link' => route($this->webroute_path . 'load'),
    //             'action_name' => __('Sync'),

    //             'action_link5' => 'https://business.facebook.com/wa/manage/message-templates/',
    //             'action_name5' => __('WhatsApp Manager'),

    //             'action_link3' => route($this->webroute_path . 'create'),
    //             'action_name3' => '+ ' . __('Create Template'),
    //             'items' => $items,
    //             'item_names' => $this->titlePlural,
    //             'webroute_path' => $this->webroute_path,
    //             'fields' => [],
    //             'custom_table' => true,
    //             'parameter_name' => $this->parameter_name,
    //             'parameters' => count($_GET) != 0,
    //         ],
    //     ]);
    // }

    // public function index()
    // {
    //     // Check if WhatsApp setup is complete (remove if not needed)
    //     if ($this->getCompany()->getConfig('whatsapp_webhook_verified', 'no') != 'yes' || $this->getCompany()->getConfig('whatsapp_settings_done', 'no') != 'yes') {
    //         return redirect(route('whatsapp.setup'));
    //     }

    //     // Initialize query
    //     $query = Template::query();
    //     $query = $query->where('type', '!=' ,1);
    //     // Search functionality
    //     if (request()->has('name') && strlen(request('name')) > 1) {
    //         $query->where('name', 'like', '%' . request('name') . '%');
    //     } elseif ($query->count() === 0) {
    //         // Load templates if empty and no search filter
    //         try {
    //             $this->loadTemplatesFromWhatsApp();
    //             // Reinitialize query after loading
    //             $query = Template::query();
    //         } catch (\Throwable $th) {
    //             Log::error('Failed to load WhatsApp templates: ' . $th->getMessage());
    //         }
    //     }

    //     // Manual refresh
    //     if (request()->has('refresh') && request('refresh') == 'yes') {
    //         try {
    //             $this->loadTemplatesFromWhatsApp();
    //             // Reinitialize query after loading
    //             $query = Template::query();
    //         } catch (\Throwable $th) {
    //             Log::error('Failed to refresh WhatsApp templates: ' . $th->getMessage());
    //         }
    //     }

    //     // Sorting
    //     switch (request('sort')) {
    //         case 'name_asc':
    //             $query->orderBy('name', 'asc');
    //             break;
    //         case 'name_desc':
    //             $query->orderBy('name', 'desc');
    //             break;
    //         case 'date_asc':
    //             $query->orderBy('created_at', 'asc');
    //             break;
    //         case 'date_desc':
    //         default:
    //             $query->orderBy('created_at', 'desc');
    //     }

    //     // Paginate results (5 per page)
    //     $templates = $query->paginate(10)->appends(request()->query());

    //     return view($this->view_path . 'index', [
    //         'templates' => $templates,
    //         'title' => __('crud.item_management', ['item' => __($this->titlePlural)]),
    //         'webroute_path' => $this->webroute_path,
    //         'hasFilters' => request()->query() ? true : false,
    //     ]);
    // }

    
    public function index()
    {
        if ($this->getCompany()->getConfig('whatsapp_webhook_verified', 'no') != 'yes' || $this->getCompany()->getConfig('whatsapp_settings_done', 'no') != 'yes') {
            return redirect(route('whatsapp.setup'));
        }

        $query = Template::query()->where('type', '!=', 1);

        if (request()->has('name') && strlen(request('name')) > 1) {
            $query->where('name', 'like', '%' . request('name') . '%');
        }

        if (request()->filled('category')) {
            $query->where('category', request('category'));
        }

        if (request()->filled('language')) {
            $query->where('language', request('language'));
        }

        if ($query->count() === 0 && !request()->has('name')) {
            try {
                $this->loadTemplatesFromWhatsApp();
                $query = Template::query()->where('type', '!=', 1);
            } catch (\Throwable $th) {
                \Log::error('Failed to load WhatsApp templates: ' . $th->getMessage());
            }
        }

        if (request()->has('refresh') && request('refresh') == 'yes') {
            try {
                $this->loadTemplatesFromWhatsApp();
                $query = Template::query()->where('type', '!=', 1);
            } catch (\Throwable $th) {
                \Log::error('Failed to refresh WhatsApp templates: ' . $th->getMessage());
            }
        }

        switch (request('sort')) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'date_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'date_desc':
            default:
                $query->orderBy('created_at', 'desc');
        }

        // Stats (calculated from DB, not just current page)
        $allItems = (clone $query)->get();
        $approvedTemplates = $allItems->where('status', 'APPROVED')->count();
        $pendingTemplates  = $allItems->where('status', 'PENDING')->count();
        $rejectedTemplates = $allItems->where('status', 'REJECTED')->count();
        $totalTemplates    = $allItems->where('type', '!=', 1)->count();

        $templates = $query->paginate(10)->appends(request()->query());

        // Distinct filters
        $distinctCategories = Template::select('category')->distinct()->pluck('category');
        $distinctLanguages  = Template::select('language')->distinct()->pluck('language');

        return view($this->view_path . 'index', [
            'templates' => $templates,
            'title' => __('crud.item_management', ['item' => __($this->titlePlural)]),
            'webroute_path' => $this->webroute_path,
            'hasFilters' => request()->query() ? true : false,
            'distinctCategories' => $distinctCategories,
            'distinctLanguages' => $distinctLanguages,

            // Pass stats to Blade
            'approvedTemplates' => $approvedTemplates,
            'pendingTemplates'  => $pendingTemplates,
            'rejectedTemplates' => $rejectedTemplates,
            'totalTemplates'    => $totalTemplates,
        ]);
    }


    /**
     * Auth checker functin for the crud.
     */
    private function authChecker()
    {
        $this->ownerAndStaffOnly();
    }

    public function loadTemplates()
    {
        if ($this->loadTemplatesFromWhatsApp()) {
            return redirect()
                ->route($this->webroute_path . 'index')
                ->withStatus(__('crud.item_has_been_updated', ['item' => __($this->titlePlural)]));
            // Process $responseData as needed
        } else {
            // Handle error response
            return redirect()
                ->route($this->webroute_path . 'index')
                ->withStatus(__('crud.error', ['error' => 'Error']));
        }
    }

    public function create()
    {
        $this->authChecker();

        $languages = 'Afrikaans,af,Albanian,sq,Arabic,ar,Azerbaijani,az,Bengali,bn,Bulgarian,bg,Catalan,ca,Chinese (CHN),zh_CN,Chinese (HKG),zh_HK,Chinese (TAI),zh_TW,Croatian,hr,Czech,cs,Danish,da,Dutch,nl,English,en,English (UK),en_GB,English (US),en_US,Estonian,et,Filipino,fil,Finnish,fi,French,fr,Georgian,ka,German,de,Greek,el,Gujarati,gu,Hausa,ha,Hebrew,he,Hindi,hi,Hungarian,hu,Indonesian,id,Irish,ga,Italian,it,Japanese,ja,Kannada,kn,Kazakh,kk,Kinyarwanda,rw_RW,Korean,ko,Kyrgyz (Kyrgyzstan),ky_KG,Lao,lo,Latvian,lv,Lithuanian,lt,Macedonian,mk,Malay,ms,Malayalam,ml,Marathi,mr,Norwegian,nb,Persian,fa,Polish,pl,Portuguese (BR),pt_BR,Portuguese (POR),pt_PT,Punjabi,pa,Romanian,ro,Russian,ru,Serbian,sr,Slovak,sk,Slovenian,sl,Spanish,es,Spanish (ARG),es_AR,Spanish (SPA),es_ES,Spanish (MEX),es_MX,Swahili,sw,Swedish,sv,Tamil,ta,Telugu,te,Thai,th,Turkish,tr,Ukrainian,uk,Urdu,ur,Uzbek,uz,Vietnamese,vi,Zulu,zuv';
        $languages = explode(',', $languages);
        $languages = array_chunk($languages, 2);

        $publishedFlows = WhatsappFlowsModel::where('status', 'PUBLISHED')->get();

        return view($this->view_path . 'create', ['languages' => $languages, 'publishedFlows' => $publishedFlows, 'isDemo' => config('settings.is_demo', false)]);
    }

    public function submit(Request $request)
    {
        $this->authChecker();
        $result = $this->submitWhatsAppTemplate($request->all());

        //Check status code
        if ($result['status'] == 200) {
            //Respond with json
            return response()->json(['status' => 'success']);
        } else {
            //Respond with json
            return response()->json(['status' => 'error', 'response' => $result]);
        }
    }

    //uploadImage
    /*public function uploadImage(Request $request){
        $this->authChecker();
        
        $imageURL=$this->saveDocument(
            "media",
            $request->imageupload,
        );

        return response()->json(['status'=>'success','url'=>$imageURL]);

    }*/

    public function uploadFileManager(Request $request)
    {
        $files = $request->file('imageupload');
        $folder = 0;

        $type = [
            'jpg' => 'image',
            'jpeg' => 'image',
            'png' => 'image',
            'svg' => 'image',
            'webp' => 'image',
            'gif' => 'image',
            'mp4' => 'video',
            'mpg' => 'video',
            'mpeg' => 'video',
            'webm' => 'video',
            'ogg' => 'video',
            'avi' => 'video',
            'mov' => 'video',
            'flv' => 'video',
            'swf' => 'video',
            'mkv' => 'video',
            'wmv' => 'video',
            'wma' => 'audio',
            'aac' => 'audio',
            'wav' => 'audio',
            'mp3' => 'audio',
            'zip' => 'archive',
            'rar' => 'archive',
            '7z' => 'archive',
            'doc' => 'document',
            'txt' => 'document',
            'docx' => 'document',
            'pdf' => 'pdf',
            'csv' => 'csv',
            'xml' => 'document',
            'ods' => 'document',
            'xlr' => 'document',
            'xls' => 'document',
            'xlsx' => 'document',
        ];

        $max_storage = 250; //hard coded 250MB max storage allowed and will be change as per user package

        foreach ($files as $key => $file) {
            $upload = new FileManager();

            $file_name = $file->getClientOriginalName();
            $file_extension = strtolower($file->getClientOriginalExtension());
            $file_type = mime2ext($file->getClientMimeType());
            $detect = detect_file_type($file_type);
            $img_info = getimagesize($file);
            $upload_file_size = $file->getSize();

            $storage = $this->provider::get('size');
            $storage = $storage->sum('size');
            if ($max_storage * 1024 < $storage / 1024 + $upload_file_size / 1024) {
                return json_encode([
                    'status' => 'error',
                    'message' => sprintf(__('You have exceeded the storage quota allowed is %sMB'), $max_storage),
                ]);
            }

            $check_allowed_extension = ['png', 'jpg', 'jpeg', 'pdf', 'mp4', 'mp3'];

            $allowed_file_size = 5; //hard coded 5MB max fil size allowed and will be change as per user package

            if ($detect == 'image') {
                $allowed_size = '5';
                $allowed_file_size = 5 * 1024 * 1024; //hard coded 15MB max image file size allowed and will be change as per user package
            } else {
                $allowed_size = '15';
                $allowed_file_size = 15 * 1024 * 1024; //hard coded 15MB max video file size allowed and will be change as per user package
            }

            if ($upload_file_size > $allowed_file_size) {
                return json_encode([
                    'status' => 'error',
                    'message' => __(sprintf('Unable to upload ' . $detect . ' file larger than %sMB', $allowed_size)),
                ]);
            }

            if (!in_array($file_extension, $check_allowed_extension)) {
                return json_encode([
                    'status' => 'error',
                    'message' => __('The filetype you are attempting to upload is not allowed'),
                ]);
            }

            if (!in_array($file_extension, $check_allowed_extension)) {
                return json_encode([
                    'status' => 'error',
                    'message' => __('The filetype you are attempting to upload is not allowed'),
                ]);
            }
            $img_width = 0;
            $img_height = 0;
            if (!empty($img_info)) {
                $img_width = $img_info[0];
                $img_height = $img_info[1];
            }

            if (!empty($file)) {
                if (config('settings.use_do_as_storage', false)) {
                    //DigitalOcean
                    $path = Storage::disk('do')->url($file->storePublicly(config('settings.use_do_folder') . config('settings.use_do_folder_files'), 'do'));
                    $upload->file = $path;
                    //force cdn refrence in sharable url
                    $do_cdn_path = env('DO_CDN_PATH');
                    $do_path = env('DO_PATH');
                    if ($do_cdn_path && $do_path) {
                        $path = str_replace($do_path, $do_cdn_path, $path); //cdn path
                    }
                } elseif (config('settings.use_s3_as_storage', false)) {
                    //S3
                    $path = Storage::disk('s3')->url($file->storePublicly(config('settings.use_do_folder') . config('settings.use_do_folder_files'), 's3'));
                    $upload->file = $path;
                } else {
                    $store_file = $file->store(null, 'public_file_manager');
                    $upload->file = Storage::disk('public_file_manager')->url($store_file);
                    $path = $upload->file;
                }
            }

            if ($path) {
                $media_ids = uniqid();
                $upload->ids = $media_ids;
                $upload->is_folder = $folder;
                $upload->name = $file_name;
                $upload->type = $detect . '/' . $file_type;
                $upload->extension = $file_extension;
                $upload->detect = $detect;
                $upload->size = $file->getSize();
                $upload->is_image = $type[$file_extension] == 'image' ? 1 : 0;
                $upload->width = $img_width;
                $upload->height = $img_height;
                $upload->save();

                return $path;
            }
        }
    }

    // public function uploadImage(Request $request)
    // {
    //     $this->authChecker();
    //     $imageURL = $request->file;
    //     $media_id = $request->media_id;
    //     if ($media_id) {
    //         $file = FileManager::where('ids', $media_id)->first();

    //         if ($file) {
    //             $path = $file->file;
    //             $fileName = $file->name;
    //             $fileSize = $file->size;
    //             $fileType = $file->type;

    //             $metaAppId = env('META_APP_ID');
    //             $accessToken = env('META_APP_TOKEN');

    //             try {
    //                 $startSessionResponse = Http::post("https://graph.facebook.com/v21.0/{$metaAppId}/uploads", [
    //                     'file_name' => $fileName,
    //                     'file_length' => $fileSize,
    //                     'file_type' => $fileType,
    //                     'access_token' => $accessToken,
    //                 ]);
    //                 $responseData = $startSessionResponse->json();
    //                 if ($startSessionResponse->failed()) {
    //                     return response()->json(['status' => 'error', 'message' => 'Failed to start Meta upload session'], 500);
    //                 }

    //                 $uploadSessionId = $responseData['id'];
    //                 $uploadResponse = Http::attach('file', file_get_contents($path), $fileName)
    //                     ->withHeaders([
    //                         'Authorization' => "OAuth {$accessToken}",
    //                         'file_offset' => 0,
    //                     ])
    //                     ->post("https://graph.facebook.com/v21.0/{$uploadSessionId}");

    //                 if ($uploadResponse->failed()) {
    //                     return response()->json(['status' => 'error', 'message' => 'Failed to upload media to Meta'], 500);
    //                 }
    //                 $fileHandle = $uploadResponse['h'];
    //             } catch (\Exception $e) {
    //                 dd($e);
    //                 return response()->json(['status' => 'error', 'message' => 'Error uploading media to Meta'], 500);
    //             }

    //             return response()->json([
    //                 'status' => 'success',
    //                 'url' => $imageURL,
    //                 'meta_handle' => $fileHandle,
    //             ]);
    //         }
    //     }
    // }

    // //uploadVideo
    // public function uploadVideo(Request $request)
    // {
    //     $this->authChecker();

    //     $videoURL = $request->file;
    //     $media_id = $request->media_id;
    //     if ($media_id) {
    //         $file = FileManager::where('ids', $media_id)->first();

    //         if ($file) {
    //             $path = $file->file;
    //             $fileName = $file->name;
    //             $fileSize = $file->size;
    //             $fileType = $file->type;

    //             $metaAppId = env('META_APP_ID');
    //             $accessToken = env('META_APP_TOKEN');

    //             try {
    //                 $startSessionResponse = Http::post("https://graph.facebook.com/v21.0/{$metaAppId}/uploads", [
    //                     'file_name' => $fileName,
    //                     'file_length' => $fileSize,
    //                     'file_type' => $fileType,
    //                     'access_token' => $accessToken,
    //                 ]);
    //                 $responseData = $startSessionResponse->json();
    //                 if ($startSessionResponse->failed()) {
    //                     return response()->json(['status' => 'error', 'message' => 'Failed to start Meta upload session'], 500);
    //                 }

    //                 $uploadSessionId = $responseData['id'];
    //                 $uploadResponse = Http::attach('file', file_get_contents($path), $fileName)
    //                     ->withHeaders([
    //                         'Authorization' => "OAuth {$accessToken}",
    //                         'file_offset' => 0,
    //                     ])
    //                     ->post("https://graph.facebook.com/v21.0/{$uploadSessionId}");

    //                 if ($uploadResponse->failed()) {
    //                     return response()->json(['status' => 'error', 'message' => 'Failed to upload media to Meta'], 500);
    //                 }

    //                 $fileHandle = $uploadResponse['h'];
    //             } catch (\Exception $e) {
    //                 return response()->json(['status' => 'error', 'message' => 'Error uploading media to Meta'], 500);
    //             }

    //             return response()->json([
    //                 'status' => 'success',
    //                 'url' => $videoURL, // URL from your server
    //                 'meta_handle' => $fileHandle, // Meta file handle for future use
    //             ]);
    //         }
    //     }
    // }

    // //uploadPdf
    // public function uploadPdf(Request $request)
    // {
    //     $this->authChecker();
    //     $pdfURL = $request->file;
    //     $media_id = $request->media_id;
    //     if ($media_id) {
    //         $file = FileManager::where('ids', $media_id)->first();

    //         if ($file) {
    //             $path = $file->file;
    //             $fileName = $file->name;
    //             $fileSize = $file->size;
    //             $fileType = $file->type;

    //             $metaAppId = env('META_APP_ID');
    //             $accessToken = env('META_APP_TOKEN');

    //             try {
    //                 $startSessionResponse = Http::post("https://graph.facebook.com/v21.0/{$metaAppId}/uploads", [
    //                     'file_name' => $fileName,
    //                     'file_length' => $fileSize,
    //                     'file_type' => $fileType,
    //                     'access_token' => $accessToken,
    //                 ]);
    //                 $responseData = $startSessionResponse->json();
    //                 if ($startSessionResponse->failed()) {
    //                     return response()->json(['status' => 'error', 'message' => 'Failed to start Meta upload session'], 500);
    //                 }
    //                 $uploadSessionId = $responseData['id'];
    //                 $uploadResponse = Http::attach('file', file_get_contents($path), $fileName)
    //                     ->withHeaders([
    //                         'Authorization' => "OAuth {$accessToken}",
    //                         'file_offset' => 0,
    //                     ])
    //                     ->post("https://graph.facebook.com/v21.0/{$uploadSessionId}");

    //                 if ($uploadResponse->failed()) {
    //                     return response()->json(['status' => 'error', 'message' => 'Failed to upload media to Meta'], 500);
    //                 }
    //                 $fileHandle = $uploadResponse['h'];
    //             } catch (\Exception $e) {
    //                 return response()->json(['status' => 'error', 'message' => 'Error uploading media to Meta'], 500);
    //             }
    //             return response()->json([
    //                 'status' => 'success',
    //                 'url' => $pdfURL,
    //                 'meta_handle' => $fileHandle,
    //             ]);
    //         }
    //     }
    // }

    public function uploadImage(Request $request)
    {
        return $this->uploadMedia($request);
    }

    public function uploadVideo(Request $request)
    {
        return $this->uploadMedia($request);
    }

    public function uploadPdf(Request $request)
    {
        return $this->uploadMedia($request);
    }

    public function uploadMedia(Request $request)
    {
        $this->authChecker();

        $media_id = $request->media_id;
        if (!$media_id) {
            return response()->json(['status' => 'error', 'message' => 'Media ID is required'], 400);
        }

        $file = FileManager::where('ids', $media_id)->first();
        if (!$file) {
            return response()->json(['status' => 'error', 'message' => 'File not found'], 404);
        }

        $fileHandle = $this->uploadDocumentToFacebook($file);
        if (!$fileHandle) {
            return response()->json(['status' => 'error', 'message' => 'Failed to upload media to Meta'], 500);
        }

        return response()->json([
            'status' => 'success',
            'url' => $request->file,
            'meta_handle' => $fileHandle,
        ]);
    }

    //Destroy
    public function destroy($id)
    {
        $this->authChecker();

        // Demo check
        if (config('settings.is_demo', false)) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Disabled in demo',
                ],
                403,
            );
        }

        try {
            $item = $this->provider::findOrFail($id);
            $result = $this->deleteWhatsAppTemplate($item->name);

            if ($result['status'] == 200) {
                
                $this->loadTemplatesFromWhatsApp();
                return response()->json([
                    'status' => 'success',
                    'message' => __('crud.item_has_been_deleted', ['item' => __($this->title)]),
                ]);
            }

            return response()->json(
                [
                    'status' => 'error',
                    'message' => $result['message'] ?? __('crud.error', ['error' => 'API Error']),
                ],
                400,
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => __('crud.error', ['error' => 'Template not found']),
                ],
                404,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => __('crud.error', ['error' => $e->getMessage()]),
                ],
                500,
            );
        }
    }
}
