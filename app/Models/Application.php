<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Application extends Model
{
    use Notifiable;

    /**
     * Guarded attributes.
     *
     * @var array
     */
    protected $guarded = [];
}