<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\cradits;
use App\Models\User;
use DB;

class ReportController extends Controller
{

    public function index()
    {
        
        
        $cradits = DB::table('users')
        ->join('cradits', 'users.id', '=', 'cradits.user_id')
        ->select('users.f_name','users.id as u_id', 'users.company','cradits.*')
        ->paginate(10);
        
        $users = User::all();
        
        $Total_credit = DB::table('cradits')->where('credit','=','Credit')->sum('cost');
        
       
        $Tolat_debit = DB::table('cradits')->where('credit','=','Debit')->sum('cost');
        
        $Avalible = $Total_credit - $Tolat_debit;
        
        
       
        return view('admin.report.list',compact('cradits','users','Avalible'));
        
        
        
        
    }
    
    
    
    
    
    
     function fetch(Request $request)
    {
        
     $select = $request->get('select');
     
     $value = $request->get('value');
     $dependent = $request->get('dependent');
     $data = DB::table('cradits')
      ->leftjoin('users','users.id' ,'=' ,'cradits.user_id')
       ->where('cradits.user_id',$select)
      // ->select('users.id','users.f_name','users.l_name','users.company','cradits.*')
       ->get();
       
       $u_id = $data['0']->user_id;
    
       
       $Total_credit = DB::table('cradits')->where([['credit','=','Credit'],['user_id','=',$u_id]])->sum('cost');
        
      // dd($Total_credit);
        $Totat_debit = DB::table('cradits')->where([['credit','=','Debit'],['user_id','=',$u_id]])->sum('cost');
         //dd($Totat_debit);
        $Avalible = $Total_credit - $Totat_debit;
        //dd($Avalible);
        
       $collection = [];
       $collection['data'] = $data;
       $collection['available'] = $Avalible;
      // dd($collection);
      
     
     return response()->json($collection);
    }
   
    
}