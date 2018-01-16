<?php

namespace App;


use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasApiTokens, Notifiable;

    const CREATED_AT = 'ticket_created_at';
    const UPDATED_AT = 'ticket_updated_at';

    protected $primaryKey = 'ticket_id';


    protected $fillable = [
        'ticket_user_id',
        'ticket_category',
        'ticket_description',
        'ticket_created_at',
        'ticket_updated_at',
        'ticket_completed_at',
        'ticket_status'
    ];
}
