<?php

namespace App\Http\Controllers;

use App\Models\Card;

class AdminController extends Controller
{
    public function index()
    {
        $cards = Card::query()->with('user')->latest()->paginate(15);

        return view('admin.index', [
            'cards' => $cards,
        ]);
    }
}
