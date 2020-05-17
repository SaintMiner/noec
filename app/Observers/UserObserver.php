<?php

namespace App\Observers;

use App\User;

class UserObserver
{
    public function saving(User $user) {
        $user->password = bcrypt($user->password);
    }
}
