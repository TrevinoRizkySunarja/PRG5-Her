<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCardRequest;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


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

        // Diepere validatie: track unieke "details views" per user
        if (auth()->check()) {
            \Illuminate\Support\Facades\DB::table('card_views')->updateOrInsert(
                [
                    'user_id' => auth()->id(),
                    'card_id' => $card->id,
                ],
                [
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        return view('cards.show', [
            'card' => $card,
        ]);
    }


    public function create()
    {
        $viewsCount = \Illuminate\Support\Facades\DB::table('card_views')
            ->where('user_id', auth()->id())
            ->count();

        if ($viewsCount < 3) {
            return redirect()->route('cards.index')
                ->with('error', 'Je mag pas een card uploaden nadat je minimaal 3 verschillende cards hebt bekeken (Details).');
        }

        return view('cards.create', [
            'rarities' => ['Common', 'Rare', 'Legendary'],
        ]);
    }


    public function store(StoreCardRequest $request)
    {
        $data = $request->validated();

        $viewsCount = \Illuminate\Support\Facades\DB::table('card_views')
            ->where('user_id', $request->user()->id)
            ->count();

        if ($viewsCount < 3) {
            return redirect()->route('cards.index')
                ->with('error', 'Je mag pas een card uploaden nadat je minimaal 3 verschillende cards hebt bekeken (Details).');
        }


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

        return redirect()->route('cards.show', $card)
            ->with('success', 'Card uploaded successfully.');

    }
    public function edit(Card $card)
    {
        $this->authorize('update', $card);

        return view('cards.edit', [
            'card' => $card,
            'rarities' => ['Common', 'Rare', 'Legendary'],
        ]);
    }

    public function update(StoreCardRequest $request, Card $card)
    {
        $this->authorize('update', $card);

        $data = $request->validated();

        // If a new image is uploaded, replace the old image file
        if ($request->hasFile('image')) {
            if ($card->image_path) {
                Storage::disk('public')->delete($card->image_path);
            }
            $card->image_path = $request->file('image')->store('cards', 'public');
        }

        $card->name = $data['name'];
        $card->rarity = $data['rarity'];
        $card->description = $data['description'] ?? null;
        $card->save();

        return redirect()->route('cards.show', $card)
            ->with('success', 'Card updated successfully.');

    }

    public function destroy(Card $card)
    {
        $this->authorize('delete', $card);

        // Delete the image file first (if it exists), then delete the database record
        if ($card->image_path) {
            Storage::disk('public')->delete($card->image_path);
        }

        $card->delete();

        return redirect()->route('cards.index')
            ->with('success', 'Card deleted successfully.');

    }


}
