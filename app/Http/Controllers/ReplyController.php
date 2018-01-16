<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReplyRequest;
use App\Reply;
use App\Ticket;
use Mail;
use Auth;
class ReplyController extends Controller
{
  protected function submit(ReplyRequest $request){


        $data = new Reply;
        $ticket = Ticket::find($request['ticket_reply_ticket_id']);
        $ticket_user_id = $ticket->ticket_user_id;
        $authUser = Auth::user();
        $authUser_id = $authUser->user_id;
        //Check if user is the author of initial ticket
        if($ticket_user_id != $authUser_id){
          return response()->json([
            'error' => true,
            'message' => 'You are not allowed to reply on this ticket'
          ], 422);
        }

        if($ticket->ticket_status != 0){
          return response()->json([
            'error' => true,
            'message' => 'This ticket has been closed.'
          ], 422);
        }


        $data->ticket_reply_ticket_id = $request['ticket_reply_ticket_id'];
        $data->ticket_reply_text = $request['ticket_reply_text'];
        $data->ticket_reply_author_id = $authUser_id;


        if($data->save()){
          $mailData['user'] = $authUser;
          $mailData['reply'] = Reply::find($data->ticket_reply_id);
          //print_r(  $mailData['reply']);
          Mail::send('emails.backend.newReply', $mailData, function ($message) use ($data) {
             $message->to('esupport@bluecdf.gr');
             $message->from('esupport@bluecdf.gr');
             $message->subject('New Reply: #'.$data->ticket_reply_ticket_id);
          });

          return response()->json([
            'success' => true,
            'reply' => Reply::find($data->ticket_reply_id)
          ], 200);
        }else{
          return response()->json([
            'error' => true,
            'message' => 'There was some error. Your reply was not submitted.'
          ], 422);
        }






        // if($data->save()) {
        //
        //   $user = DB::table('users')
        //   ->join('offices', 'users.user_office', '=', 'offices.office_id')
        //   ->select('*')
        //   ->where('user_id', $request['ticket_user_id'])
        //   ->get();
        //    unset($user[0]->user_password);
        //   $data->user = $user;
        //   $mailData['data'] = $data;
        //   Mail::send('emails.backend.newTicket', $mailData, function ($message) use ($data) {
        //     $message->to('esupport@bluecdf.gr');
        //     $message->from('esupport@bluecdf.gr');
        //     $message->subject('New Support Ticket: '.$data->user[0]->user_first_name.' '.$data->user[0]->user_last_name.' : '.$data->user[0]->office_name);
        //  });


        // }else{
        //   return response()->json([
        //     'error' => true,
        //     'message' =>  'Something is Wrong. Contact Administrator'
        //   ], 422);
        // }



  }
}
