<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\booking_recod as ModelsBooking_record;
use App\Models\room_population as ModelsRoom_population;
use App\Models\room_status as ModelsRoom_status;
use App\Models\history_record as Modelshistory;

class HostelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $bookingrecods=ModelsBooking_record::all();
        $roompopulation=ModelsRoom_population::all();
        $roomsavail2=ModelsRoom_status::all();
        $roomstatus=ModelsRoom_status::where('status','full')->get();
        $roomsavail=ModelsRoom_status::where('status','empty')->get();
        error_log($roomsavail);
        return view('HostelAdmin.index',['bookingrec'=>$bookingrecods,'population'=>$roompopulation,'status'=>$roomstatus,'available'=>$roomsavail,'available2'=>$roomsavail2]);
    }
    public function editprice(){
        $roompopulation=ModelsRoom_population::all();
        $roomsavail=ModelsRoom_status::where('status','empty')->get();
        $roomsavail2=ModelsRoom_status::all();
        return view('HostelAdmin.editPrice',['loadroom'=>$roompopulation,'available'=>$roomsavail,'available2'=>$roomsavail2]);
    }
    public function history(){
        $history=Modelshistory::all();
        $population=ModelsRoom_population::all();
        $roomsavail=ModelsRoom_status::where('status','empty')->get();
        $roomsavail2=ModelsRoom_status::all();
        return view('HostelAdmin.leaseHistory',['history'=>$history,'available'=>$roomsavail,'population'=>$population,'available2'=>$roomsavail2]);
    }
    public function updatestatus($roomnum){
        //$roomstatus=ModelsRoom_status::where('room_num',$roomnum)->first();
        $roomstatus=ModelsRoom_status::where('room_num','=',$roomnum)->first();


        if ($roomstatus->beds>0) {
            $roomstatus->beds=$roomstatus->beds-1;
            error_log($roomstatus->beds);
            if ($roomstatus->beds==0) {
                $roomstatus->status="full";
            }
            $roomstatus->save();

            //ModelsRoom_status::find('room_num',$roomnum)->update('update room_status set beds where room_num = ?', [$roomnum]);
            //$roomstatus->update('update room_status set beds where room_num = ?', [$roomnum]);
        }


    }
    public function storebookroom(){
        $roompop=ModelsRoom_population::where('beds',request('Rtype'))->where('room_type',request('executive','Non-executive'))->first();
        if ($roompop==null) {
            return redirect('/')->with('searchfail','Sorry, Executive type for room is unavailable')->with('roomtype',request('Rtype'));
        }else{

                    if (request('price')>$roompop->price) {
                        return redirect('/')->with('overpay','Invalid input, price input is more than room price');
                    }else{
                            $ent_data=new Modelshistory();
                            $ent_data->id=request('index_number');
                            $ent_data->phone=request('phone');
                            $ent_data->type=request('Rtype');
                            $ent_data->room_number=$roompop->room_num;
                            $ent_data->executive=request('executive','Non-executive');
                            $ent_data->payment_status=request('price');
                            $ent_data->payment_balance=$roompop->price - request('price');
                            $ent_data->start_date=request('start');
                            $ent_data->course_program=request('program');
                            $ent_data->guardian_phone=request('phone_guard');
                            $ent_data->address=request('address');
                            $ent_data->end_date=request('endD');

                            $roompopulation=ModelsRoom_population::all();
                            if ($roompopulation->count()>0) {
                                $ent_data->save();
                            $this->updatestatus($roompop->room_num);
                            return redirect('/');
                            }else{
                                return redirect('/')->with('jsalert',"No Room Available for booking, insert new room to continue");
                            }

                        }

            }

    }
    public function storeeditprice(){
        $roomdtt=new ModelsRoom_population();
         $filename = time().'.'.request()->file->getClientOriginalExtension();
        request()->file->move(public_path('images'), $filename);
        $roomdtt->room_num=request("room_num");
        $roomdtt->price=request("price");
        $roomdtt->beds=request("bedsavail");
        $roomdtt->description=request("txtarea");
        $roomdtt->image=$filename;
        $roomdtt->room_type=request("executive","Non-Executive");

        $roomdtt->save();

        $roomstatus=new ModelsRoom_status();
        $roomstatus->room_num=request("room_num");
        $roomstatus->room_capacity=request("bedsavail");
        $roomstatus->beds=request("bedsavail");
        $roomstatus->status="empty";

        $roomstatus->save();

       return redirect('/editprice');
    }

    public function updatelease(){
        $history=Modelshistory::where('id',request('index_number'))->first();
        if (request('price')>$history->payment_balance) {
            return redirect('/history')->with('overpay','Invalid input, price input is more than room price');
        }else {
                $history->id=request('index_number');
                $history->phone=request('phone');
                $history->type=request('Rtype');
                $history->room_number=request('room_num');;
                $history->executive=request('executive','Non-executive');
                $history->payment_status= $history->payment_status + request('price');
                $history->payment_balance= $history->payment_balance - request('price');
                $history->start_date=request('start');
                $history->course_program=request('program');
                $history->guardian_phone=request('phone_guard');
                $history->address=request('address');
                $history->end_date=request('endD');
                $history->save();
                return redirect('/history');
        }
        error_log(request('index_number'));
    }
}
