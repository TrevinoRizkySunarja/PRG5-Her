<?php

namespace App\Policies;

use App\Models\Card;
use App\Models\User;

class CardPolicy
{
    // Allow update only when the logged-in user owns the card
    public function update(User $user, Card $card): bool
    {
        return $card->user_id === $user->id;
    }

    // Allow delete only when the logged-in user owns the card
    public function delete(User $user, Card $card): bool
    {
        return $card->user_id === $user->id;
    }
}
