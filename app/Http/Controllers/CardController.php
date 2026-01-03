<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $rarity = $request->query('rarity');

        $cardsQuery = Card::query()->with('user')->latest();

        if ($search) {
            $cardsQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($rarity && $rarity !== 'all') {
            $cardsQuery->where('rarity', $rarity);
        }

        $cards = $cardsQuery->paginate(10)->withQueryString();

        // For dropdown
        $rarities = ['Common', 'Rare', 'Legendary'];

        return view('cards.index', [
            'cards' => $cards,
            'rarities' => $rarities,
            'search' => $search,
            'selectedRarity' => $rarity ?? 'all',
        ]);
    }

    public function show(Card $card)
    {
        $card->load('user');

        return view('cards.show', [
            'card' => $card,
        ]);
    }
}
