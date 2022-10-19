<?php

namespace App\Providers;

use Illuminate\Auth\Passwords\PasswordBroker as BasePasswordBroker;    

class CustomPasswordBroker extends BasePasswordBroker    
{    
	public function sendResetLink(array $credentials)
    {
        // First we will check to see if we found a user at the given credentials and
        // if we did not we will redirect back to this current URI with a piece of
        // "flash" data in the session to indicate to the developers the errors.
        $user = $this->getUser($credentials);

        if (is_null($user)) {
            return static::INVALID_USER;
        }

        // Once we have the reset token, we are ready to send the message out to this
        // user with a link to reset their password. We will then redirect back to
        // the current URI having nothing set in the session to indicate errors.
        $credentials['token'] = $this->tokens->create($user);
        $user->sendPasswordResetNotification( $credentials
        );

        return static::RESET_LINK_SENT;
    }
}      