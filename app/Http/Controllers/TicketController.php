<?php

namespace App\Http\Controllers;


use App\Ticket;
use App\Reply;
//use App\User;
use App\Http\Requests\TicketRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;
use Auth;
class TicketController extends Controller
{
    protected function getTicket($ticket_id){
      $user = Auth::user();
      $ticket = Ticket::find($ticket_id);
      //s$replies = Reply::where('ticket_reply_ticket_id', $ticket->ticket_id)->get();

      $replies = DB::table('ticket_replies')
      ->leftJoin('membership', 'ticket_replies.ticket_reply_author_id', '=', 'membership.id')
      ->select('membership.first_name', 'membership.last_name', 'ticket_replies.*')
      ->where('ticket_reply_ticket_id', $ticket->ticket_id)
      ->get();

      if ($user && $ticket && $user->user_id == $ticket->ticket_user_id && $user->user_id == $ticket->ticket_user_id)
       {
         return response()->json([
           'success' => true,
           'ticket' => $ticket,
           'replies' => (count($replies) > 0 ? $replies : [])
         ], 200);
       }else{
         return response()->json([
           'error' => true,
           'message' =>  'Δεν μπορείτε να δείτε αυτό το αίτημα'
         ], 422);
       }

    }
    protected function submit(TicketRequest $request){


          $data = new Ticket;

          $data->ticket_user_id = $request['ticket_user_id'];
          $data->ticket_category = $request['ticket_category'];
          $data->ticket_description = $request['ticket_description'];

          if($data->save()) {

            $user = DB::table('users')
            ->join('offices', 'users.user_office', '=', 'offices.office_id')
            ->select('*')
            ->where('user_id', $request['ticket_user_id'])
            ->get();
             unset($user[0]->user_password);
            $data->user = $user;
            $mailData['data'] = $data;
            Mail::send('emails.backend.newTicket', $mailData, function ($message) use ($data) {
              $message->to('esupport@bluecdf.gr');
              $message->from('esupport@bluecdf.gr');
              $message->subject('Νέο Αίτημα Υποστήριξης: '.$data->user[0]->user_first_name.' '.$data->user[0]->user_last_name.' : '.$data->user[0]->office_name);
           });




            return response()->json([
              'success' => true,
              'ticket_id' =>   $data->ticket_id
            ], 200);
          }else{
            return response()->json([
              'error' => true,
              'message' =>  'Something is Wrong. Contact Administrator'
            ], 422);
          }



    }

    protected function getPendingTickets($ticket_user_id){

      $pending_tickets = Ticket::where('ticket_user_id', $ticket_user_id)
      ->where('ticket_status', 0)
      ->orderBy('ticket_id', 'asc')
      ->get();
      return response()->json([
        'success' => true,
        'pending_tickets' =>   $pending_tickets
      ], 200);

    }

    protected function getCompletedTickets($ticket_user_id){

      $completed_tickets = DB::table('tickets')
      ->where('ticket_user_id', $ticket_user_id)
      ->join('membership', 'tickets.ticket_technician_id', '=', 'membership.id')
      ->where('tickets.ticket_status', 1)
      ->orderBy('tickets.ticket_id', 'desc')
      ->get();
      unset($completed_tickets[0]->password);
      return response()->json([
        'success' => true,
        'completed_tickets' =>   $completed_tickets
      ], 200);

    }
}
