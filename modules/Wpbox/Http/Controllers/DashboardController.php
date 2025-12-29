<?php

namespace Modules\Wpbox\Http\Controllers;

use Akaunting\Module\Facade as Module;
use App\Http\Controllers\Controller;
use App\Models\Plans;
use App\Models\Posts;
use App\Models\Subscription_Info;
use Carbon\Carbon;
use App\Services\ConfChanger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Laravel\Sanctum\PersonalAccessToken;
use Modules\Wpbox\Models\Contact;
use Modules\Wpbox\Models\Campaign;
use Modules\Wpbox\Models\Reply;
use Modules\Wpbox\Models\Template;
use Modules\Wpbox\Traits\Whatsapp;

class DashboardController extends Controller
{
    use Whatsapp;

    public function index()
    {
        if (
            auth()
                ->user()
                ->hasRole(['owner', 'staff'])
        ) {
            //Check if Whatsapp connect is done
            if (($this->getCompany() && $this->getCompany()->getConfig('whatsapp_webhook_verified', 'no') != 'yes') || $this->getCompany()->getConfig('whatsapp_settings_done', 'no') != 'yes') {
                if (config('settings.app_code_name') == 'wpbox') {
                    return redirect(route('whatsapp.setup'));
                }
            }

            if ($this->getCompany()->getConfig('whatsapp_settings_done', 'no') == 'yes' && $this->getCompany()->getConfig('verified_name') == '' && $this->getCompany()->getConfig('display_phone_number') == '' && $this->getCompany()->getConfig('quality_rating') == '') {
                $accessinfo = $this->access_connect($this->getCompany()->getConfig('whatsapp_business_account_id'), $this->getCompany()->getConfig('whatsapp_permanent_access_token'), $this->getCompany()->getConfig('whatsapp_phone_number_id'));

                if (!empty($accessinfo)) {
                    $company = $this->getCompany();
                    $company->setConfig('verified_name', isset($accessinfo['verified_name']) ? $accessinfo['verified_name'] : '');
                    $company->setConfig('code_verification_status', isset($accessinfo['code_verification_status']) ? $accessinfo['code_verification_status'] : '');
                    $company->setConfig('display_phone_number', isset($accessinfo['display_phone_number']) ? $accessinfo['display_phone_number'] : '');
                    $company->setConfig('quality_rating', isset($accessinfo['quality_rating']) ? $accessinfo['quality_rating'] : '');
                    $company->setConfig('profile_picture_url', isset($accessinfo['profile_picture_url']) ? $accessinfo['profile_picture_url'] : '');
                    $company->setConfig('name_status', isset($accessinfo['name_status']) ? $accessinfo['name_status'] : '');
                    $company->setConfig('can_send_message', isset($accessinfo['can_send_message']) ? $accessinfo['can_send_message'] : '');
                }
            }

            return $this->asCompany();
        }
    }

    public function setupEmbedded()
    {
        $token = PersonalAccessToken::where('tokenable_id', auth()->user()->id)
            ->where('tokenable_type', 'App\Models\User')
            ->first();
        $planText = '';
        if (!$token) {
            $token = auth()->user()->createToken('Whatstapp');
            $parts = explode('|', $token->plainTextToken);
            $planText = $parts[1]; // Get the first part after the '|'
            auth()->user()->setConfig('plain_token', $planText);
        } else {
            //Get old config
            $planText = auth()->user()->getConfig('plain_token', '');
        }
        return view('wpbox::setup.setup_admin', ['token' => $planText, 'company' => auth()->user(), 'is_embedded' => true]);
    }

    public function setup()
    {
        //if user is admin
        if (auth()->user()->hasRole('admin')) {
            return $this->setupEmbedded();
        }
        $token = PersonalAccessToken::where('tokenable_id', auth()->user()->id)
            ->where('tokenable_type', 'App\Models\User')
            ->first();
        $planText = '';
        $company = $this->getCompany();

        //In case, we are in company 1, and we are in demo mode, don't allow this
        if ($company->id == 1 && config('settings.is_demo', false)) {
            return redirect(route('campaigns.index'))->withStatus(__('This view is not allowed for the Demo company. Please create your account, so you can see the WhatsApp Cloud Setup view.'));
        }

        if (!$token) {
            $token = auth()->user()->createToken('Whatstapp');
            $parts = explode('|', $token->plainTextToken);
            $planText = $parts[1]; // Get the first part after the '|'
            $company->setConfig('plain_token', $planText);
        } else {
            //Get old config
            $planText = $company->getConfig('plain_token', '');
        }

        //Do we have embedded login module and we have set facebook.config_id
        if (Module::has('embeddedlogin') && config('embeddedlogin.config_id', '') != '') {
            //We have embedded login, and we have set facebook.config_id
            $setupDone = $company->getConfig('whatsapp_settings_done', 'no') == 'yes';
            return view('embeddedlogin::index', ['setupDone' => $setupDone, 'company' => $company]);
        }
        return view('wpbox::setup.index', ['token' => $planText, 'company' => $company]);
    }

    public function savesetup(Request $request)
    {
        $company = $this->getCompany();

        $setupDone = true;
        if ($request->has('whatsapp_permanent_access_token') && strlen($request->whatsapp_permanent_access_token) > 10) {
            $company->setConfig('whatsapp_permanent_access_token', $request->whatsapp_permanent_access_token);
        } else {
            $company->setConfig('whatsapp_permanent_access_token', '');
            $setupDone = false;
        }
        if ($request->has('whatsapp_phone_number_id') && strlen($request->whatsapp_phone_number_id) > 4) {
            $company->setConfig('whatsapp_phone_number_id', $request->whatsapp_phone_number_id);
        } else {
            $company->setConfig('whatsapp_phone_number_id', '');
            $setupDone = false;
        }

        if ($request->has('whatsapp_business_account_id') && strlen($request->whatsapp_business_account_id) > 4) {
            $company->setConfig('whatsapp_business_account_id', $request->whatsapp_business_account_id);
        } else {
            $company->setConfig('whatsapp_business_account_id', '');
            $setupDone = false;
        }

        $accessinfo = $this->access_connect($request->whatsapp_business_account_id, $request->whatsapp_permanent_access_token, $request->whatsapp_phone_number_id);

        if ($setupDone) {
            if (!empty($accessinfo)) {
                $company->setConfig('verified_name', isset($accessinfo['verified_name']) ? $accessinfo['verified_name'] : '');
                $company->setConfig('code_verification_status', isset($accessinfo['code_verification_status']) ? $accessinfo['code_verification_status'] : '');
                $company->setConfig('display_phone_number', isset($accessinfo['display_phone_number']) ? $accessinfo['display_phone_number'] : '');
                $company->setConfig('quality_rating', isset($accessinfo['quality_rating']) ? $accessinfo['quality_rating'] : '');
                $company->setConfig('profile_picture_url', isset($accessinfo['profile_picture_url']) ? $accessinfo['profile_picture_url'] : '');

                if (isset($accessinfo['verified_name'])) {
                    $company->setConfig('whatsapp_settings_done', 'yes');
                }
            }
        } else {
            $company->setConfig('whatsapp_settings_done', 'no');
        }
        return redirect(route('whatsapp.setup'))->withStatus(__('Settings updated'));
    }

    public function asCompany()
    {
        $company = $this->getCompany();

        //Change Language
        ConfChanger::switchLanguage($company);

        //Change currency
        ConfChanger::switchCurrency($company);

        $data = [
            'all_contacts' => Contact::all(),

            'campaign' => [
                'title' => 'Campaigns',
                'color_bg' => '#ffffff',
                'color_elements' => '#f87060',
                'icon' => 'ni-notification-70',
                'icon_color' => 'bg-gradient-info',
                'main_value' => 0,
                'sub_value' => 0,
                'sub_value_color' => 'text-success',
                'sub_title' => 'Read rate',
                'href' => route('campaigns.index'),
            ],

            'last_template' => [
                'title' => 'Last campaign',
                'color_bg' => '#ffffff',
                'color_elements' => '#f87060',
                'icon' => 'ni-bell-55',
                'icon_color' => 'bg-gradient-info',
                'main_value' => null,
                'sub_value' => '',
                'sub_value_color' => 'text-success',
                'sub_title' => 'Read rate',
            ],

            'single_send' => [
                'title' => 'Single send templates',
                'color_bg' => '#ffffff',
                'color_elements' => '#f87060',
                'icon' => 'ni-send',
                'icon_color' => 'bg-gradient-info',
                'main_value' => '',
                'sub_value' => '',
                'sub_value_color' => 'text-success',
                'sub_title' => 'Open rate',
            ],

            'templates' => [
                'title' => 'Templates',
                'color_bg' => '#ffffff',
                'color_elements' => '#f87060',
                'icon' => 'ni-single-copy-04',
                'icon_color' => 'bg-gradient-info',
                'main_value' => '',
                'sub_value' => '',
                'sub_value_color' => 'text-success',
                'sub_title' => 'Approved',
                'href' => route('templates.index'),
            ],

            'contacts' => [
                'title' => 'Contacts',
                'color_bg' => '#ffffff',
                'color_elements' => '#f87060',
                'icon' => 'ni-single-02',
                'icon_color' => 'bg-gradient-info',
                'main_value' => '',
                'sub_value' => '',
                'sub_value_color' => 'text-success',
                'sub_title' => 'new this month',
                'href' => route('contacts.index'),
            ],

            'chats' => [
                'title' => 'Open chats',
                'color_bg' => '#ffffff',
                'color_elements' => '#f87060',
                'icon' => 'ni-chat-round',
                'icon_color' => 'bg-gradient-info',
                'main_value' => '',
                'sub_value' => '',
                'sub_value_color' => 'text-success',
                'sub_title' => 'Resolved conversations',
                'href' => route('chat.index'),
            ],

            'bot' => [
                'title' => 'Reply bots',
                'color_bg' => '#ffffff',
                'color_elements' => '#f87060',
                'icon' => 'ni-curved-next',
                'icon_color' => 'bg-gradient-info',
                'main_value' => '',
                'sub_value' => '',
                'sub_value_color' => 'text-success',
                'sub_title' => 'Messages send',
                'href' => route('replies.index'),
            ],
        ];

        if (Module::has('flowiseai')) {
            $data['aibots'] = [
                'title' => 'AI Bots',
                'color_bg' => '#ffffff',
                'color_elements' => '#f87060',
                'icon' => 'ni-atom',
                'icon_color' => 'bg-gradient-info',
                'main_value' => null,
                'sub_value' => '',
                'sub_value_color' => 'text-success',
                'sub_title' => 'Custom',
                'href' => route('flowisebots.indexcompany'),
            ];
        }

        $startOfMonth = Carbon::now()->startOfMonth();

        //campaign
        $campaigns = Campaign::where('send_to', '>', 1);
        if ($campaigns->count() > 0 && $campaigns->sum('delivered_to') > 0) {
            $data['campaign']['main_value'] = $campaigns->count();
            $data['campaign']['sub_value'] = round(($campaigns->sum('read_by') / $campaigns->sum('delivered_to')) * 100, 2) . '%';
        }

        //last_template
        $last_template = Campaign::where('send_to', '>', 1)->orderBy('id', 'desc')->first();
        if ($last_template && $last_template->delivered_to > 0) {
            $data['last_template']['main_value'] = $last_template->send_to . ' ' . __('Recipients');
            $data['last_template']['sub_value'] = round(($last_template->read_by / $last_template->delivered_to) * 100, 2) . '%';
        }

        //single_send
        $single_send = Campaign::whereNotNull('contact_id');
        if ($single_send->count() > 0 && $single_send->sum('delivered_to') > 0) {
            $data['single_send']['main_value'] = $single_send->count();
            $data['single_send']['sub_value'] = round(($single_send->sum('read_by') / $single_send->sum('delivered_to')) * 100, 2) . '%';
        }

        //templates
        $data['templates']['main_value'] = Template::count();
        $data['templates']['sub_value'] = Template::where('status', 'APPROVED')->count();

        //contacts
        $data['contacts']['main_value'] = Contact::count();
        $data['contacts']['sub_value'] = Contact::where('created_at', '>=', $startOfMonth)->count();

        //chats
        $data['chats']['main_value'] = Contact::where('has_chat', 1)->where('resolved_chat', 0)->count();
        $data['chats']['sub_value'] = Contact::where('has_chat', 1)->where('resolved_chat', 1)->count();

        //bot
        $data['bot']['main_value'] = Reply::count();
        $data['bot']['sub_value'] = Reply::sum('used');

        //aibots
        try {
            $data['aibots']['main_value'] = \Modules\Flowiseai\Models\Bot::whereNull('company_id')->orWhere('company_id', $company->id)->count();
            $data['aibots']['sub_value'] = \Modules\Flowiseai\Models\Bot::where('company_id', $company->id)->count();
        } catch (\Throwable $th) {
        }

        $data['active_subscription'] = Subscription_Info::where('company_id', $company->id)->where('status', 1)->first();

        $data['company']  = $company;
        
        return $data;
    }

    public function landing()
    {
        //Change Language
        $locale = Cookie::get('lang') ? Cookie::get('lang') : config('settings.app_locale');
        if (isset($_GET['lang'])) {
            //this is language route
            $locale = $_GET['lang'];
        }

        if ($locale != 'android-chrome-256x256.png') {
            App::setLocale(strtolower($locale));
            session(['applocale_change' => strtolower($locale)]);
        }

        //Landing page content
        $features = Posts::where('post_type', 'feature')->get();
        $testimonials = Posts::where('post_type', 'testimonial')->get();
        $faqs = Posts::where('post_type', 'faq')->get();
        $mainfeatures = Posts::where('post_type', 'mainfeature')->get();

        $colCounter = [1, 2, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4];
        $plans = config('settings.forceUserToPay', false) ? Plans::where('id', '!=', intval(config('settings.free_pricing_id')))->get() : Plans::get();
        $data = [
            'col' => count($plans) > 0 ? $colCounter[count($plans) - 1] : 4,
            'plans' => $plans,
            'features' => $features,
            'processes' => $features,
            'mainfeatures' => $mainfeatures,
            'locale' => strtolower($locale),
            'faqs' => $faqs,
            'testimonials' => $testimonials,
            'hasAIBots' => Module::has('flowiseai'),
        ];

        try {
            $response = new \Illuminate\Http\Response(view('wpboxlanding::landing.index', $data));
        } catch (\Throwable $th) {
            dd('Please read the update guide for version 3.2.0. You need to upload the landing page module');
        }

        App::setLocale(strtolower($locale));
        $response->withCookie(cookie('lang', $locale, 120));
        App::setLocale(strtolower($locale));

        return $response;
    }
}
