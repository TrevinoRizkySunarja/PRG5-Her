<?php

namespace App\Policies;

use App\Models\Card;
use App\Models\User;

class CardPolicy
{
    public function update(User $user, Card $card): bool
    {
        return $user->is_admin || $card->user_id === $user->id;
    }

    public function delete(User $user, Card $card): bool
    {
        return $user->is_admin || $card->user_id === $user->id;
    }

    public function toggleStatus(User $user, Card $card): bool
    {
        return $user->is_admin || $card->user_id === $user->id;
    }
}
