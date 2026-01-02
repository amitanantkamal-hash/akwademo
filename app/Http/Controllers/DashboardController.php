<?php

namespace App\Http\Controllers;

use Modules\Wpbox\Models\Contact;
use Illuminate\Support\Facades\DB;
use Modules\Wpbox\Models\Campaign;
use Illuminate\Support\Facades\App;
use Illuminate\Http\RedirectResponse;
use Akaunting\Module\Facade as Module;
use Illuminate\Support\Facades\Cookie;

class DashboardController extends Controller
{
    public function dashboard($lang = null)
    {

        //Check if there is special admin for owners
        if (config('settings.ownerAdmin', 'default') != 'default' && auth()->user()->hasRole('owner')) {
            return redirect()->route(config('settings.ownerAdmin'));
        }

        $locale = Cookie::get('lang') ? Cookie::get('lang') : config('settings.app_locale');
        if ($lang != null) {
            //this is language route
            $locale = $lang;
        }
        if ($locale != 'android-chrome-256x256.png') {
            App::setLocale(strtolower($locale));
            session(['applocale_change' => strtolower($locale)]);
        }

        $dataToDisplay = [
            'locale' => $locale,
        ];
        foreach (config('global.modulesWithDashboardInfo') as $moduleWithDashboardInfo) {
            $generatedClass = Module::get($moduleWithDashboardInfo)->get('nameSpace') . "\Http\Controllers\DashboardController";
            $dataFromModule = (new $generatedClass())->index();
            if ($dataFromModule != null) {
                if ($dataFromModule instanceof RedirectResponse) {

                    return $dataFromModule;
                }
                $dataToDisplay[$moduleWithDashboardInfo] = $dataFromModule;
            }
        } //esto se tiene que retirar
        // if (!session('first_login')) {
        //     session(['first_login' => true]);
        // }

        //The current logged in user
        $currentUser = auth()->user();
        
        //Finish tasks
        if (isset($_GET['task_done'])) {
            $currentUser->setConfig('task_done_' . $_GET['task_done'], true);
        }

        //Get the task to be done for admins
        $taskToBeDone = [];

        if ($currentUser->hasRole('admin')) {
            for ($i = 1; $i < 7; $i++) {
                if (config('settings.task_' . $i, null)) {
                    if (! $currentUser->getConfig('task_done_' . $i, false)) {

                        array_push($taskToBeDone, [
                            'task' => config('settings.task_' . $i, ''),
                            'id' => $i,
                            'task_docs' => config('settings.task_' . $i . '_docs', ''),
                            'task_info' => str_replace('{url}', config('app.url'), config('settings.task_' . $i . '_info', '')),
                        ]);
                    }
                }
            }
        } else {
            //Check if current user company is active
            if ($currentUser->company->active == 0) {
                //Logout and redirect to home page
                auth()->logout();
                return redirect()->route('home')->withError(__('Your account is not active. Please contact the administrator.'));
            }
        }
        $dataToDisplay['tasks'] = $taskToBeDone;

        $view = 'dashboard::index';

        if (auth()->user()->hasRole(['owner'])) {
            $view = 'dashboard::index-client';
        }

        //don't show world map data on admin user
        $dataToSend = [];
        $auth_user_id = auth()->user()->id;
        if ($auth_user_id != 1) {

            // SET VALUES FOR THE WORLD MAP WITH THE CAMPAIGN
            $campaign = Campaign::where('company_id', auth()->user()->company->id)
                ->orderBy('updated_at', 'desc')
                ->first();

            $webroute_path = 'campaigns.';

            if ($campaign) {
                $contact_ids = $campaign->messages()->select(['contact_id'])->pluck('contact_id')->toArray();
                $countriesCount = DB::table('contacts')
                    ->join('countries', 'contacts.country_id', '=', 'countries.id')
                    ->selectRaw('count(contacts.id) as number_of_messages, country_id, countries.name, countries.lat, countries.lng')
                    ->whereIn('contacts.id', $contact_ids)
                    ->groupBy('contacts.country_id')
                    ->get()->toArray();


                $dataToSend = [
                    'total_contacts' => Contact::count(),
                    'item' => $campaign,
                    'contacts' => Contact::all(),
                    'setup' => [
                        'countriesCount' => $countriesCount,
                        'title' => __('Campaign') . " " . $campaign->name,
                        'action_link' => route($webroute_path . 'index'),
                        'action_name' => "" . __('Back'),
                        'items' => $campaign->messages()->paginate(config('settings.paginate')),
                        'item_names' => 'campaigns',
                        'webroute_path' => $webroute_path,
                        'fields' => [],
                        'custom_table' => true,
                        'parameter_name' => 'campaigns',
                        'parameters' => count($_GET) != 0
                    ]
                ];

                if ($campaign->is_bot) {
                    $dataToSend['setup']['title'] = __('Bot') . " " . $campaign->name;
                    $dataToSend['setup']['action_name'] = __('Back to bots') . "";
                    $dataToSend['setup']['action_link'] = route('replies.index', ['type' => 'bot']);
                } else if ($campaign->is_api) {
                    $dataToSend['setup']['title'] = __('API') . " " . $campaign->name;
                    $dataToSend['setup']['action_name'] = __('Back to Api');
                    $dataToSend['setup']['action_link'] = route('wpbox.api.index', ['type' => 'api']);
                } else {
                    //Regular campaign
                    //If there is at lease 1 pending message, show action to pause campaign
                    $pendingMessages = $campaign->messages()->where('status', 0)->count();
                    if ($pendingMessages > 0 && $campaign->is_active) {
                        $dataToSend['setup']['action_link2'] = route($webroute_path . 'pause', $campaign->id);
                        $dataToSend['setup']['action_name2'] = "" . __('Pause campaign');
                    } else if ($pendingMessages > 0) {
                        $dataToSend['setup']['action_link2'] = route($webroute_path . 'resume', $campaign->id);
                        $dataToSend['setup']['action_name2'] = "" . __('Resume campaign');
                    }

                    $dataToSend['setup']['action_link3'] = route($webroute_path . 'report', $campaign->id);
                    $dataToSend['setup']['action_name3'] = "" . __('Download report');
                }
            }
            // END OF DATA TO SEND MAP
            // dd($dataChart['0']['company_id'], auth()->user()->company->id);
        }

        if ($currentUser->hasRole(['staff'])) {
            $view = 'dashboard::index-agent';
        }

        $response = new \Illuminate\Http\Response(view($view, $dataToDisplay, $dataToSend));
        $response->withCookie(cookie('lang', $locale, 120));
        App::setLocale(strtolower($locale));

        return $response;
    }
}
