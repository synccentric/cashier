<?php

namespace Synccentric\Cashier\Tests\Fixtures;

use Synccentric\Cashier\Billable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Model;

class User extends Model
{
    use Billable, Notifiable;
}
