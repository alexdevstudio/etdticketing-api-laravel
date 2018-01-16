<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Reply extends Model
{
  use HasApiTokens, Notifiable;


  const CREATED_AT = 'ticket_reply_created_at';

  protected $table = 'ticket_replies';
  protected $primaryKey = 'ticket_reply_id';


  protected $fillable = [
      'ticket_reply_id',
      'ticket_reply_ticket_id',
      'ticket_reply_author_id',
      'ticket_reply_text',
      'ticket_reply_created_at'
  ];
}
