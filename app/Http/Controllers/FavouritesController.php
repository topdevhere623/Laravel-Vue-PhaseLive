<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavouritesController extends Controller
{
    public function index($id)
    {
        $user = User::find($id);

        return $user->likes()
            ->latest()
            ->paginate(10)->each(function ($item) {
            return $item->likeable;
        });
    }
}
