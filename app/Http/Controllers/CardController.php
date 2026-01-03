<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCardRequest;
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

        $rarities = ['Common', 'Rare', 'Legendary'];

        return view('cards.index', [
            'cards' => $cards,
            'rarities' => $rarities,
            'search' => $search ?? '',
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

    public function create()
    {
        return view('cards.create', [
            'rarities' => ['Common', 'Rare', 'Legendary'],
        ]);
    }

    public function store(StoreCardRequest $request)
    {
        $data = $request->validated();

        $imagePath = null;
        if ($request->hasFile('image')) {
            // stores in storage/app/public/cards
            $imagePath = $request->file('image')->store('cards', 'public');
        }

        $card = Card::create([
            'user_id' => $request->user()->id,
            'name' => $data['name'],
            'rarity' => $data['rarity'],
            'description' => $data['description'] ?? null,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('cards.show', $card);
    }
}
