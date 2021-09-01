<?php

namespace App\Policies\Concerns;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;

trait ComparesModelAuthority
{
    /**
     * Check if the user has the authority to perform the action on the model.
     *
     * @param User $user
     * @param Model $model
     * @return Response
     */
    protected function belongsToUser(User $user, Model $model): Response
    {
        return $user->id == $model->user_id
            ? $this->allow()
            : $this->deny(__('You do not have permission to perform this action.'));
    }
}
