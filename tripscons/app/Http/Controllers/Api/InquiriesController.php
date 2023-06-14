<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\InquiryProposal;
use finfo;
use Illuminate\Http\Request;
// use App\Http\Controllers\Admin\BookingsController;

class InquiriesController extends Controller
{
    public function index(Request $request)
    {
        return response([
            'message' => 'success',
            'success' => true,
            'data' => Inquiry::all()
        ], 200);
    }

    public function byId(Request $request)
    {
        return response([
            'message' => 'success',
            'success' => true,
            'data' => Inquiry::find($request->id)
        ], 200);
    }

    public function saveProposal(Request $request)
    {

       return $input=$request->all();
        $input['user_id']=auth()->user()->id;
        $input['activities']=json_encode($request->activities);
        $input['cancellation_policies']=json_encode($request->cancellation_policies);
        $input['excluded']=json_encode($request->excluded);
        $input['included']=json_encode($request->included);
        $input['inquiry_id']=$request->inquiry_id;
        $input['itinerary']=json_encode($request->itinerary);
        $input['notes']=$request->notes;
        $input['payment_term']=$request->payment_term;
        $input['purposedBudget']=$request->purposedBudget;
        $input['rules']=json_encode($request->rules);
        $input['terms']=$request->terms;
        $input['title']=$request->title;

       // return $input;
        $purposal=InquiryProposal::create($input);
        // return $input=$request->all();
        return response([
            'message' => 'success',
            'success' => true,
            'data' => $purposal
        ], 200);
    }

    public function getInquiries(Request $request){

        return response([
            'message' => 'success',
            'success' => true,
            'data' => Inquiry::with('purposals')->where('user_id',auth()->user()->id)->where('status',Inquiry::ACTIVE_INQUIRY)->orderBy('id', 'DESC')->get(),
        ], 200);
    }

    public function getInquiryProposals(Request $request){

        return response([
            'message' => 'success',
            'success' => true,
            'data' => InquiryProposal::with('user','inquiry')->where('inquiry_id',$request->id)->get(),
        ], 200);
    }
    public function getProposalDetail(Request $request){

        return response([
            'message' => 'success',
            'success' => true,
            'data' => InquiryProposal::with('user','inquiry')->find($request->id),
        ], 200);
    }
    // public function createBooking(Request $request){
    //     return 'sadsa';
    //     $booking=new BookingsController();
    //     return $booking=$booking->book($request->all());
      
    // }
    
}
