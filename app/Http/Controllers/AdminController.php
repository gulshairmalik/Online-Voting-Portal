<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mediaburst\ClockworkSMS\Clockwork;
use App\Data;
use App\Reg_Users;
use App\Temp_Users;
use App\Candidates;
use App\Results;

class AdminController extends Controller
{
    public function organize(Request $request){

        if($request->hasfile('cover_img1') && $request->hasfile('cover_img2')){
            $filenamewithext1 = $request->file('cover_img1')->getClientOriginalName();
            $filenamewithext2 = $request->file('cover_img2')->getClientOriginalName();
            $filename1 = pathinfo($filenamewithext1,PATHINFO_FILENAME);
            $filename2 = pathinfo($filenamewithext2,PATHINFO_FILENAME);
            $ext1 = $request->file('cover_img1')->getClientOriginalExtension();
            $ext2 = $request->file('cover_img2')->getClientOriginalExtension();
            $filename_store1 = $filename1.'_'.time().'.'.$ext1;
            $filename_store2 = $filename2.'_'.time().'.'.$ext2;
            $path1 = $request->file('cover_img1')->storeAs('public/cover_images',$filename_store1);
            $path2 = $request->file('cover_img2')->storeAs('public/cover_images',$filename_store2);
        }
        else{
            $filename_store1 = 'noimage.jpg';
            $filename_store2 = 'noimage.jpg';
        }

        $candi1 = new Candidates;
        $candi1->nc = $request->input('nc_no1');
        $candi1->name = $request->input('name1');
        $candi1->party_name = $request->input('party_name1');  
        if($request->hasfile('cover_img1')){
            $candi1->cover_img = $filename_store1;
        }
        $candi1->save();       

        $candi2 = new Candidates;
        $candi2->nc = $request->input('nc_no2');
        $candi2->name = $request->input('name2');
        $candi2->party_name = $request->input('party_name2');  
        if($request->hasfile('cover_img2')){
            $candi2->cover_img = $filename_store2;
        }
        $candi2->save();
        $result_candi = DB::select('select * from candidates');
        if($result_candi==null){
            $form_data = [
                'style' => '',
                'result_table'=> DB::select('select * from results')
    
            ];
    
            return view('admin')->with('form_data',$form_data);
        }
        else if($result_candi!=null){
            $form_data = [
                'style' => 'display:none;',
                'result_table'=> DB::select('select * from results')
    
            ];
    
            return view('admin')->with('form_data',$form_data);
        }
    }
}
