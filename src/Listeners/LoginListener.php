<?php

namespace Hexters\Ladmin\Listeners;

use Hexters\Ladmin\Exceptions\LadminException;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Hexters\Ladmin\Models\LadminLogable;

class LoginListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Login $event) {
        
        $user = $event->user;
            
        $instance = app(config('ladmin.user'));
        if(! ($user instanceof $instance)) {
            return;
        }

        try {

            $new_data = [
                'ip' => $_SERVER['REMOTE_ADDR'],
                'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            ];
            
            LadminLogable::create([
                'user_id' => $user->id,
                'new_data' => $new_data,
                'logable_type' => get_class($user),
                'logable_id' => $user->id,
                'old_data' => [],
                'type' => 'login',
            ]);
        } catch (LadminException $e) {}
    }
}
