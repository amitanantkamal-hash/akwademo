<?php

namespace App\Http\Controllers;

use App\Models\CompanyCampaign;
use App\Models\FacebookLeads;
use Illuminate\Http\Request;

class FacebookLeadsController extends Controller
{
    public function index() {
         try{
            if (auth()->user()->company_id != null) {

            $company_campaign = CompanyCampaign::where('company_id',auth()->user()->company_id)->pluck('campaign_id')->toArray();


            $campaignData = FacebookLeads::select('*');

            if(isset($_GET['campaign']) && !empty($_GET['campaign'])):
                $campaignData = $campaignData->where('campaign_id',$_GET['campaign']);
            endif;

            $campaignData = $campaignData->whereIn('campaign_id',$company_campaign)->orderBy('created_time','desc')->paginate(10)->appends($_GET);


            return view('facebookleads.index', [
                'fbLeads'=>$campaignData,
                'parameters'=>count($_GET) != 0,
            ]);
            }
         }catch(\Exception $e){
            echo '<pre>';
            print_r($e->getMessage());
            die;
            return redirect()->route('dashboard')->withErrors($e->getMessage());
         }
    }
}
