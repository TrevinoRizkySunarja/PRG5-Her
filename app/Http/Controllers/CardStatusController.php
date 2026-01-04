<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\RedirectResponse;

class CardStatusController extends Controller
{
    public function toggle(Card $card): RedirectResponse
    {
        $this->authorize('toggleStatus', $card);

        $card->is_active = !$card->is_active;
        $card->save();

        return redirect()->route('cards.index')
            ->with('success', 'Status van de card is aangepast.');
    }
}
