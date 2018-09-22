<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use mediaburst\ClockworkSMS\Clockwork;
use App\Data;
use App\Reg_Users;
use App\Temp_Users;
use App\Temp_login_user;
use App\Voting_list1;
use App\Voting_list2;
use App\Results;


class PagesController extends Controller
{
    
    public function index(){
        return view('index');
    }

    public function login_page(){
        
        return view('login')->with('err','');
    }
    
    public function reg_page(){
        DB::delete('truncate temp__users');
        return view('register')->with('nc_err','');
    }

    public function logout(){
        
        return view('login')->with('err','');
    }


    public function formValidation(Request $request){
        $this->validate($request,[

            'username' => 'required|min:5|max:10',
            'password' => 'required|min:7|max:15',
            'cpassword' => 'required|min:7|max:15|same:password',
            'mob#' => 'required|min:12|max:12',
            'nc#' => 'required|min:3|max:4',
            'cnic' => 'required|min:13|max:13'
         ],[
            'username.required' => ' The username field is required.',
            'username.min' => ' The username must be at least of 5 characters.',
            'username.max' => ' The username may not be greater than 10 characters.',
            'mob#.required' => ' Mobile# is required.',
            'mob#.min' => ' Mobile# is not correct.',
            'mob#.max' => ' Mobile# is not correct.',
            'mob#.numeric' => ' Mobile# must be in numbers.',
            'password.required' => ' Password is required.',
            'password.min' => ' Password must be at least of 7 characters.',
            'password.max' => ' Password must be less than 15 characters.',
            'cpassword.required' => ' Confirm Password field is required.',
            'cpassword.same' => ' Confirm Password does not match.',
            'nc#.required' => ' NC# is required.',
            'nc#.numeric' => ' NC# must be in numbers',
            'nc#.min' => ' NC# must be at least of 3 numbers.',
            'nc#.max' => ' NC# must not be greater than 4 numbers.',
            'cnic.required' => 'CNIC is required.',
            'cnic.numeric' => ' CNIC must be in numbers',
            'cnic.min' => ' CNIC must be at least of 13 numbers.',
            'cnic.max' => ' CNIC must not be greater than 13 numbers.'
        ]);

        //Authenticate NC#
        $nc_no = $request->input('nc#');
        $cnic = $request->input('cnic');
        $mob_no = $request->input('mob#');
        $u_name = $request->input('username');
        $nc_err ="";
        $result1=null;
        $results = DB::select('select * from data where nc = :value', ['value' =>$nc_no ]);
        $result1 = DB::select('select * from reg__users where nc = :value', ['value' =>$nc_no ]);
        $result2 = DB::select('select * from reg__users where cnic = :value', ['value' =>$cnic ]);
        $result3 = DB::select('select * from reg__users where mob_no = :value', ['value' =>$mob_no ]);
        $result4 = DB::select('select * from reg__users where username = :value', ['value' =>$u_name ]);
        
        
        if($results[0]->nc!=$nc_no){
            $nc_err = "NC# does not exist";
            return view('register')->with('nc_err',$nc_err);
        }

        //Storing User Data in Temporary DB Table along with SMS Code
         if($result1==null && $result2==null && $result3==null && $result4==null){
            $sms_code = Carbon::now()->timestamp;
            $phone_no =  $request->input('mob#');
            $temp_users = new Temp_Users;

            $temp_users->nc = $nc_no;
            $temp_users->username = $request->input('username');
            $temp_users->password = $request->input('password');
            $temp_users->cnic = $request->input('cnic');
            $temp_users->mob_no = $request->input('mob#');
            $temp_users->sms_code = $sms_code;
            $temp_users->save();

            /*$apiKey = '23d23b9ad40223ff36d5ab7416fcaeb742e0cfe0';
        

            $clockwork = new Clockwork( $apiKey );

            // Setup and send a message
            $message = array( 'to' => $phone_no, 'message' => $sms_code );
            $result = $clockwork->send( $message );*/
            
            return view('verify')->with('err','');

        
        }
        else if($result1!=null || $result2!=null || $result3!=null || $result4!=null){
        
            $nc_err = "User already registered";
            return view('register')->with('nc_err',$nc_err);  
        }
         
    }

    public function store(Request $request){
        $sms_code = $request->input('verify');
        $results=null;
        $results = DB::select('select * from temp__users where sms_code = :value', ['value' =>$sms_code ]);
       if($results!=null){
            if($results[0]->sms_code==$sms_code){
                //Storing User Data in Temporary DB Table along with SMS Code
            
                $reg_users = new Reg_Users;

                $reg_users->nc = $results[0]->nc;
                $reg_users->username = $results[0]->username;
                $reg_users->password = $results[0]->password;
                $reg_users->cnic = $results[0]->cnic;
                $reg_users->mob_no = $results[0]->mob_no;
            
                $reg_users->save();
                DB::delete('delete from temp__users where sms_code = :value', ['value' =>$sms_code ]);
                return view('index');
                

            }
        }
        else{
            return view('verify')->with('err','Invalid code');
        }
        
        
    }

    public function user_auth(Request $request){
        $username = $request->input('username');
        $password = $request->input('password');
        $result_admin = DB::select('select * from admins where username = :value1 AND password = :value2', ['value1' =>$username ,'value2' =>$password]);
        $result = DB::select('select * from reg__users where username = :value1 AND password = :value2', ['value1' =>$username ,'value2' =>$password]);
        $result_candi = DB::select('select * from candidates');
        $result_table = DB::select('select * from results');
        if($result==null&&$result_admin==null){
            return view('login')->with('err','Username or Password is incorrect.');
        }
        if($result!=null&&$result_admin==null){
            
            if($result_candi==null || $result_table!=null){
                $data = [
                    'name1'=>'',
                    'party_name1'=>'',
                    'cover_img1'=>'',
                    'name2'=>'',
                    'party_name2'=>'',
                    'cover_img2'=>'',
                    'style'=>'',
                    'nc_no_user'=>'',
                    'btn'=>'',
                    'vote_style'=>'display:none;'
                ];
                return view('user')->with('data',$data);
            }
            else if($result_candi!=null){
                $vote1 = DB::select('select * from Voting_list1s where nc = :value1', ['value1' =>$result[0]->nc]);
                $vote2 = DB::select('select * from Voting_list2s where nc = :value1', ['value1' =>$result[0]->nc]);
                if($vote1!=null && $vote2==null || $vote2!=null && $vote1==null){
                $data = [
                    'name1'=>$result_candi[0]->name,
                    'party_name1'=>$result_candi[0]->party_name,
                    'cover_img1'=>$result_candi[0]->cover_img,
                    'name2'=>$result_candi[1]->name,
                    'party_name2'=>$result_candi[1]->party_name,
                    'cover_img2'=>$result_candi[1]->cover_img,
                    'nc_no_user'=>$result[0]->nc,
                    'style'=>'display:none;',
                    'btn'=>'disabled',
                    'vote_style'=>''
                ];
                DB::delete('truncate temp_login_users');
                return view('user')->with('data',$data);
                }
                else{
                    $data = [
                        'name1'=>$result_candi[0]->name,
                        'party_name1'=>$result_candi[0]->party_name,
                        'cover_img1'=>$result_candi[0]->cover_img,
                        'name2'=>$result_candi[1]->name,
                        'party_name2'=>$result_candi[1]->party_name,
                        'cover_img2'=>$result_candi[1]->cover_img,
                        'nc_no_user'=>$result[0]->nc,
                        'style'=>'display:none;',
                        'btn'=>'',
                        'vote_style'=>'display:none;'
                    ];
                    DB::delete('truncate temp_login_users');
                    return view('user')->with('data',$data);
                }

            }
            
            //print_r($result_candi);
        }
        if($result==null&&$result_admin!=null){
            $form_data;
            if($result_candi==null){
                $form_data = [
                    'style' => '',
                    'result_table'=>DB::select('select * from results')

                ];
                return view('admin')->with('form_data',$form_data);
            }
            else if($result_candi!=null){
                $form_data = [
                    'style' => 'display:none;',
                    'result_table'=>DB::select('select * from results')

                ];
                return view('admin')->with('form_data',$form_data);
            }
            
        }
        
    }


    public function cast_vote(Request $request){
        
        $candidate = $request->input('user');
        $nc_no = $request->input('nc_no_user');
        $sms_code = Carbon::now()->timestamp;
        $result = DB::select('select * from reg__users where nc = :value', ['value' =>$nc_no ]);
        $phone_no = $result[0]->mob_no;
        $temp = new Temp_login_user;

            $temp->nc_no = $nc_no;
            $temp->sms_code = $sms_code;
            $temp->candi_no = $candidate;
            $temp->save();

            /*$apiKey = '1236024d835613e886d3ab59b622fac43f27a8a8';
	

            $clockwork = new Clockwork( $apiKey );

            // Setup and send a message
            $message = array( 'to' => $phone_no, 'message' => $sms_code );
            $result = $clockwork->send( $message );*/

            return view('verify_vote')->with('err','');
        
    }

    public function verify_vote(Request $request){
        $sms_code = $request->input('verify');
        $results = null;
        $results = DB::select('select * from temp_login_users where sms_code = :value', ['value' =>$sms_code ]);
        $result_candi = DB::select('select * from candidates');
        if($results!=null){
            if($results[0]->sms_code==$sms_code){

                $data = [
                    'name1'=>$result_candi[0]->name,
                    'party_name1'=>$result_candi[0]->party_name,
                    'cover_img1'=>$result_candi[0]->cover_img,
                    'name2'=>$result_candi[1]->name,
                    'party_name2'=>$result_candi[1]->party_name,
                    'cover_img2'=>$result_candi[1]->cover_img,
                    'nc_no_user'=>$results[0]->nc_no,
                    'style'=>'display:none;',
                    'btn'=>'disabled',
                    'vote_style'=>''
                ];

                if($results[0]->candi_no == 1){
                    $vote  = new Voting_list1;
                    $vote->nc = $results[0]->nc_no;
                    $vote->save();
                    DB::delete('delete from temp_login_users where sms_code = :value', ['value' =>$sms_code ]);
                    return view('user')->with('data',$data);
                }
                if($results[0]->candi_no == 2){
                    $vote  = new Voting_list2;
                    $vote->nc = $results[0]->nc_no;
                    $vote->save();
                    DB::delete('delete from temp_login_users where sms_code = :value', ['value' =>$sms_code ]);
                    return view('user')->with('data',$data);

                }
            }
        }
        else{
            return view('verify_vote')->with('err','Invalid code');
        }
    }

    public function end_election(){
        
        $cand1_votes = Voting_list1::count();
        $cand2_votes = Voting_list2::count();
        $result = DB::select('select * from candidates');

        $result_table1 = new Results;
        $result_table1->name = $result[0]->name;
        $result_table1->party_name = $result[0]->party_name;
        $result_table1->no_of_votes = $cand1_votes;
        $result_table1->save();

        $result_table2 = new Results;
        $result_table2->name = $result[1]->name;
        $result_table2->party_name = $result[1]->party_name;
        $result_table2->no_of_votes = $cand2_votes;
        $result_table2->save();


        $form_data = [
            'style' => 'display:none;',
            'result_table'=> DB::select('select * from results')

        ];

        return view('admin')->with('form_data',$form_data);
        
    }

    public function show_result(){
        $result = DB::select('select * from results');
        $data = [

            'name1'=>$result[0]->name,
            'name2'=>$result[1]->name,
            'party1'=>$result[0]->party_name,
            'party2'=>$result[1]->party_name,
            'vote1'=>$result[0]->no_of_votes,
            'vote2'=>$result[1]->no_of_votes

        ];
        return view('result')->with('data',$data);
        //Redirect::away('result')->with('data',$data);
        
    }

    public function new_election(){
        DB::delete('truncate candidates');
        DB::delete('truncate voting_list1s');
        DB::delete('truncate voting_list2s');
        DB::delete('truncate results');
        $form_data = [
            'style' => '',
            'result_table'=> DB::select('select * from results')

        ];

        return view('admin')->with('form_data',$form_data);
    }

    
}
