<?php

namespace App\Observers;

use App\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param \App\User $user
     * @return void
     */
    public function created(User $user): void
    {
        $this->createLog($user, 'creó');
    }

    /**
     * Handle the User "updated" event.
     *
     * @param \App\User $user
     * @return void
     */
    public function updated(User $user): void
    {
        $this->createLog($user, 'actualizó');
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param \App\User $user
     * @return void
     */
    public function deleted(User $user): void
    {
        $this->createLog($user, 'eliminó');
    }

    /**
     * @param User $user
     * @param string $textAction
     */
    private function createLog(User $user, string $textAction): void
    {
        if ($login_user = auth()->user()) {
            $login_user->logs()->create([
                'event' => "$textAction (ID:" . $user->id . ")",
                'description' => 'App\User',
                'ip' => request()->ip(),
                'attr' => $user
            ]);
        }
    }
}
