<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Contact;
use App\Models\Campaigns;
use App\Models\CampaignUse;
use App\Models\Charts;
use Auth;
use DB;


class DashboardController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total=Contact::select(DB::raw('count(id) as total'))->get();
        $campaigns = Campaigns::all();
        $data=[];
        return view('dashboard/dashboard')->with('total', $total)->with('campaigns',$campaigns);  
    }

    public function getCampaignTotals()
    {
        $campaignid = $_REQUEST['campaignid'];
        if($campaignid==0 || !isset($campaignid) || $campaignid=="undefined"){
            $total=Contact::select(DB::raw('count(id) as total'))->get();
        }
        else{
            $overalltotal=Contact::select(DB::raw('count(id) as total'))->get();
            $total=Contact::select(DB::raw('count(id) as total'))->where('contacts.campaign_id',"$campaignid")->get();
        }
        return $total[0]->total;
    }
    public function leadschart()
    {
        $campaignid = $_REQUEST['campaignid'];
        //DB::enableQueryLog();
        /*$leads=CampaignUse::select(DB::raw('CONCAT(campaign.CampaignName,"(",count(campaign_use.id),")") as CampaignName'),DB::raw('count(campaign_use.id) as total'))
        ->leftjoin('campaign','campaign_use.CampaignID','campaign.id')->groupby('campaign_use.CampaignID')->get();
        */
        //dd(DB::getQueryLog());

       if($campaignid==0 || !isset($campaignid) || $campaignid=="undefined"){
            $data=Charts::where('chart_type',1)->orderBy('label')->select(DB::raw('label as CampaignName'),'total')->get();
        }
        else{
            $data=Contact::select(DB::raw('CONCAT(campaign.CampaignName,"(",count(contacts.id),")") as CampaignName'),DB::raw('count(contacts.id) as total'))
                ->leftjoin('campaign','contacts.campaign_id','campaign.id')->where('contacts.campaign_id',"$campaignid")->groupby('contacts.campaign_id')->get();
           
        }
        
        return response()->json($data);
    }

    public function blankchart()
    {
        $campaignid = $_REQUEST['campaignid'];
        //DB::enableQueryLog();        
        /*$landline=Contact::select(DB::raw('count(id) as total'))
        ->whereNull('LandlineNum')
        ->orwhere('LandlineNum',"=","")->get();
        $mobile=Contact::select(DB::raw('count(id) as total'))
        ->whereNull('MobileNum')
        ->orwhere('MobileNum',"=","")->get();
        $email=Contact::select(DB::raw('count(id) as total'))
        ->whereNull('Email')
        ->orwhere('Email',"=","")->get();
        $firstname=Contact::select(DB::raw('count(id) as total'))
        ->whereNull('FirstName')
        ->orwhere('FirstName',"=","")->get();
        $lastname=Contact::select(DB::raw('count(id) as total'))
        ->whereNull('LastName')
        ->orwhere('LastName',"=","")->get();
        $data=array();
        $data[0] = array('Label' => 'No Mobile ('.$mobile[0]->total.')','totals' =>$mobile[0]->total);
        $data[1] = array('Label' => 'No Landline ('.$landline[0]->total.')','totals' => $landline[0]->total);
        $data[2] = array('Label' => 'No Email ('.$email[0]->total.')','totals' => $email[0]->total);
        $data[3] = array('Label' => 'No Firstname ('.$firstname[0]->total.')','totals' => $firstname[0]->total);
        $data[4] = array('Label' => 'No Lastname ('.$lastname[0]->total.')','totals' => $lastname[0]->total);
        
        //dd(DB::getQueryLog());
        */
        if($campaignid==0 || !isset($campaignid) || $campaignid=="undefined"){
            
            $data=Charts::where('chart_type',3)->orderBy('label')->select(DB::raw('label as Label'),DB::raw('total as totals'))->get();
        }
        else{
            $landline=Contact::select(DB::raw('count(id) as total'))
                ->where(function($q) {
                    $q->whereNull('LandlineNum')
                    ->orwhere('LandlineNum',"=","");
                })
                ->where('contacts.campaign_id',"$campaignid")->get();

            $mobile=Contact::select(DB::raw('count(id) as total'))
                ->where(function($q) {
                    $q->whereNull('MobileNum')
                    ->orwhere('MobileNum',"=","");
                })
                ->where('contacts.campaign_id',"$campaignid")->get();

            $email=Contact::select(DB::raw('count(id) as total'))
                ->where(function($q) {
                    $q->whereNull('Email')
                    ->orwhere('Email',"=","");
                })
                ->where('contacts.campaign_id',"$campaignid")->get();

            $firstname=Contact::select(DB::raw('count(id) as total'))
                ->where(function($q) {
                    $q->whereNull('FirstName')
                    ->orwhere('FirstName',"=","");
                })
                ->where('contacts.campaign_id',"$campaignid")->get();

            $lastname=Contact::select(DB::raw('count(id) as total'))
                ->where(function($q) {
                    $q->whereNull('LastName')
                    ->orwhere('LastName',"=","");
                })->where('contacts.campaign_id',"$campaignid")->get();
            $data=array();
            $data[0] = array('Label' => 'No Mobile ('.$mobile[0]->total.')','totals' =>$mobile[0]->total);
            $data[1] = array('Label' => 'No Landline ('.$landline[0]->total.')','totals' => $landline[0]->total);
            $data[2] = array('Label' => 'No Email ('.$email[0]->total.')','totals' => $email[0]->total);
            $data[3] = array('Label' => 'No Firstname ('.$firstname[0]->total.')','totals' => $firstname[0]->total);
            $data[4] = array('Label' => 'No Lastname ('.$lastname[0]->total.')','totals' => $lastname[0]->total);
        }
        return response()->json($data);
    }

    public function supplierchart()
    {
        $campaignid = $_REQUEST['campaignid'];
        //DB::enableQueryLog();
        /*$leads=Contact::select(DB::raw('CONCAT(users.name,"(",count(contacts.id),")") as supplier'),DB::raw('count(contacts.id) as totals'))
        ->leftjoin('users','contacts.supplier_id','users.id')->groupby('contacts.supplier_id')->get();
        //dd(DB::getQueryLog());
        return response()->json($leads);*/
        
        if($campaignid==0 || !isset($campaignid) || $campaignid=="undefined"){
            $data=Charts::where('chart_type',2)->orderBy('label')->select(DB::raw('label as supplier'),DB::raw('total as totals'))->get();
        }
        else{
            $data=Contact::select(DB::raw('CONCAT(users.name,"(",count(contacts.id),")") as supplier'),DB::raw('count(contacts.id) as totals'))
                ->leftjoin('users','contacts.supplier_id','users.id')->where('contacts.campaign_id',"$campaignid")->groupby('contacts.supplier_id')->get();
        }
        return response()->json($data);
    }

    public function noblankchart()
    {
        
        $campaignid = $_REQUEST['campaignid'];
        if($campaignid==0 || !isset($campaignid) || $campaignid=="undefined"){
            $data=Charts::where('chart_type',4)->orderBy('label')->select(DB::raw('label as Label'),DB::raw('total as totals'))->get();            
        }
        else{
            $landline=Contact::IndexRaw('FORCE INDEX (contacts_landlinenum_index)')->select(DB::raw('count(id) as total'))
                    ->where(function($q) {
                        $q->whereNotNull('LandlineNum')
                        ->orwhere('LandlineNum',"!=","");
                    })->where('contacts.campaign_id',"$campaignid")->get();

            $mobile=Contact::select(DB::raw('count(id) as total'))
                    ->where(function($q) {
                        $q->whereNotNull('MobileNum')
                        ->orwhere('MobileNum',"!=","");
                    })
                    ->where('contacts.campaign_id',"$campaignid")->get();


            $email=Contact::select(DB::raw('count(id) as total'))
                    ->where(function($q) {
                        $q->whereNotNull('Email')
                        ->orwhere('Email',"!=","");
                    })
                    ->where('contacts.campaign_id',"$campaignid")->get();
            $firstname=Contact::select(DB::raw('count(id) as total'))
                    ->where(function($q) {
                        $q->whereNotNull('FirstName')
                        ->orwhere('FirstName',"!=","");
                    })->where('contacts.campaign_id',"$campaignid")->get();
           
            $lastname=Contact::select(DB::raw('count(id) as total'))
                    ->where(function($q) {
                        $q->whereNotNull('LastName')
                        ->orwhere('LastName',"!=","");
                    })->where('contacts.campaign_id',"$campaignid")->get();
            $data=array();
            $data[0] = array('Label' => 'Mobile ('.$mobile[0]->total.')','totals' =>$mobile[0]->total);
            $data[1] = array('Label' => 'Landline ('.$landline[0]->total.')','totals' => $landline[0]->total);
            $data[2] = array('Label' => 'Email ('.$email[0]->total.')','totals' => $email[0]->total);
            $data[3] = array('Label' => 'Firstname ('.$firstname[0]->total.')','totals' => $firstname[0]->total);
            $data[4] = array('Label' => 'Lastname ('.$lastname[0]->total.')','totals' => $lastname[0]->total);
        }
        return response()->json($data);
    }

    public function dncchart()
    {
        $data=Charts::where('chart_type',5)->orderBy('label')->select(DB::raw('label as Label'),DB::raw('total as totals'))->get();  
        return response()->json($data);
        /*
            $fivedays = DB::select("SELECT count(id) as totals FROM (SELECT id,CASE WHEN LastDNCWashing IS NULL THEN created_at ELSE STR_TO_DATE(LastDNCWashing,'%m/%d/%Y')
                        END AS z
                FROM
                    dnc) AS a
                WHERE
                z BETWEEN CURDATE() - INTERVAL 5 DAY AND CURDATE()");

            $thirtydays = DB::select("SELECT count(id) as totals FROM (SELECT id,CASE WHEN LastDNCWashing IS NULL THEN created_at ELSE STR_TO_DATE(LastDNCWashing,'%m/%d/%Y')
                                        END AS z
                                FROM
                                    dnc) AS a
                            WHERE
                                z BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() - INTERVAL 5 DAY");

            $sixty = DB::select("SELECT count(id) as totals FROM (SELECT id,CASE WHEN LastDNCWashing IS NULL THEN created_at ELSE STR_TO_DATE(LastDNCWashing,'%m/%d/%Y')
                                                END AS z
                                        FROM
                                            dnc) AS a
                                    WHERE
                                        z BETWEEN CURDATE() - INTERVAL 60 DAY AND CURDATE() - INTERVAL 30 DAY");

            $sixtyup = DB::select("SELECT count(id) as totals FROM (SELECT id,CASE WHEN LastDNCWashing IS NULL THEN created_at ELSE STR_TO_DATE(LastDNCWashing,'%m/%d/%Y')
                                                END AS z
                                        FROM
                                            dnc) AS a
                                    WHERE
                                        z < CURDATE() - INTERVAL 60 DAY");
            
           
            $data=array();
            $data[0] = array('Label' => '5 days and below ('.$fivedays[0]->totals.')','totals' =>$fivedays[0]->totals);
            $data[1] = array('Label' => '5 days to 30 days ('.$thirtydays[0]->totals.')','totals' =>$thirtydays[0]->totals);
            $data[2] = array('Label' => '30 days to 60 days ('.$sixty[0]->totals.')','totals' => $sixty[0]->totals);
            $data[3] = array('Label' => '60 days and up ('.$sixtyup[0]->totals.')','totals' => $sixtyup[0]->totals);
        return response()->json($data);*/
    }

    
    

}
