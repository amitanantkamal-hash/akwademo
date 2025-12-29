<?php

namespace Modules\Flowmaker\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Contacts\Models\Field;
use Modules\Flowmaker\Models\Flow;
use Modules\Flowmaker\Models\Flowdocument;
use Modules\Wpbox\Models\Reply;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Wpbox\Models\Template;

class Main extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function edit(Flow $flow)
    {
        //Get the company custom fields
        $customFields=Field::where('company_id',$flow->company_id)->get();

        $variables=[
            ["label" => "Contact Name", "value" => "contact_name", "category" => "Contact"],
            ["label" => "Contact Phone", "value" => "contact_phone", "category" => "Contact"],
            ["label" => "Email", "value" => "contact_email", "category" => "Contact"],
            ["label" => "Country", "value" => "contact_country", "category" => "Contact"],
            ["label" => "Last Message", "value" => "contact_last_message", "category" => "Contact"]
        ];

        //Now add the custom fields to the variables
        foreach ($customFields as $customField) {
            $variables[]=[
                "label" => $customField->name,
                "value" => $customField->name,
                "category" => "Custom Field"
            ];
        }

        //Get the company templates
        $templates=Template::where('company_id',$flow->company_id)->get();
        //Loop throught all the templates anc convert the components from string to object
        foreach($templates as $template){
            $template->components=json_decode($template->components);
        }

        //Get staff users (agents) for this company
        $agents = \App\Models\User::role('staff')->where('company_id', $flow->company_id)->get(['id', 'name', 'email']);

        //Get contact groups for this company
        $groups = \Modules\Contacts\Models\Group::where('company_id', $flow->company_id)->get(['id', 'name']);

        // Get flowdocuments for this flow and format for frontend
        $flowdocuments = Flowdocument::where('flow_id', $flow->id)->get();
        
        $faqs = [];
        $trainedWebsites = [];
        $trainedFiles = [];
        
        foreach ($flowdocuments as $document) {
            $formattedData = $document->getFormattedData();
            
            switch ($document->source_type) {
                case 'faq':
                    $faqs[] = $formattedData;
                    break;
                    
                case 'website':
                    $trainedWebsites[] = $formattedData;
                    break;
                    
                case 'pdf':
                case 'txt':
                case 'docx':
                case 'doc':
                case 'xls':
                case 'xlsx':
                    $trainedFiles[] = $formattedData;
                    break;
            }
        }

        $data=[
            'flow'=>$flow,
            'variables'=>$variables,
            'templates'=>$templates,
            'faqs'=>$faqs,
            'trainedWebsites'=>$trainedWebsites,
            'trainedFiles'=>$trainedFiles,
            'agents'=>$agents,
            'groups'=>$groups
        ];
        return view('flowmaker::index')->with('data', json_encode($data));
    }
   

    public function script()
    {
        // Find the first .js file in the public/build/assets directory
        $files = glob(__DIR__.'/../../public/build/assets/*.js');
        
        if (empty($files)) {
            abort(404, 'JavaScript file not found');
        }
        
        try {
            $script = file_get_contents($files[0]);
            return response($script)->header('Content-Type', 'application/javascript');
        } catch (\Exception $e) {
            abort(500, 'Error loading JavaScript file');
        }
    }

    //CSS
    public function css()
    {
        $files = glob(__DIR__.'/../../public/build/assets/*.css');
        
        if (empty($files)) {
            abort(404, 'CSS file not found');
        }
        
        try {
            $css = file_get_contents($files[0]);
            return response($css)->header('Content-Type', 'text/css');
        } catch (\Exception $e) {
            abort(500, 'Error loading CSS file');
        }
    }

    public function updateFlow(Request $request, Flow $flow)
    {
        //Set the flow data
        $flow->flow_data = $request->all();

        //Respond ok
        $flow->save();
        return response()->json(['status'=>'ok']);
    }

    /**
     * Upload media files (images, videos, PDFs)
     * @param Request $request
     * @return Response
     */
    public function uploadMedia(Request $request)
{
    try {
        $type = $request->input('type');
        Log::info('Upload media', ['type' => $type]);

        // Validate request
        $request->validate([
            'file' => 'required|file|max:50000', // Max 50MB
            'type' => 'required|in:image,video,pdf,document',
        ]);

        $file = $request->file('file');

        // Set validation rules + directory
        switch ($type) {
            case 'image':
                $request->validate([
                    'file' => 'mimes:jpeg,png,jpg,gif,webp|max:10000',
                ]);
                $directory = 'flowmaker/images';
                break;
            case 'video':
                $request->validate([
                    'file' => 'mimes:mp4,webm,ogg,avi,mov|max:50000',
                ]);
                $directory = 'flowmaker/videos';
                break;
            case 'pdf':
            case 'document':
                $request->validate([
                    'file' => 'mimes:pdf,txt,docx,doc|max:20000',
                ]);
                $directory = 'flowmaker/documents';
                break;
            default:
                return response()->json(['error' => 'Invalid file type'], 400);
        }

        // Unique filename
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

        // Upload
        if (config('settings.use_s3_as_storage', false)) {
            // store on S3
            $path = $file->storePubliclyAs($directory, $fileName, 's3');

            // build full S3 URL
            $bucket = config('filesystems.disks.s3.bucket');
            $region = config('filesystems.disks.s3.region');
            $full_url = "https://{$bucket}.s3.{$region}.amazonaws.com/{$path}";
        } else {
            // store in local "public_uploads" disk
            $path = $file->storeAs($directory, $fileName, 'public_uploads');

            // build URL
            $full_url = url('uploads/' . $path);
        }

        return response()->json([
            'status' => 'success',
            'url' => $full_url,
            'type' => $type
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}
