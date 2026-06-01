<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\KulinerPreference;
use App\Models\WisataPreference;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::updateOrCreate(
            [
                'email' => $googleUser->getEmail()
            ],
            [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'password' => bcrypt('password'),
                'avatar' => $googleUser->getAvatar()
            ]
        );

        Auth::login($user);

        return redirect('/');
    }

    public function mergeGuest(Request $request)
    {
        $guestId = $request->guest_id;
        $userId = Auth::id();

        WisataPreference::where('guest_id', $guestId)
            ->update(['user_id' => $userId, 'guest_id' => null]);

        KulinerPreference::where('guest_id', $guestId)
            ->update(['user_id' => $userId, 'guest_id' => null]);

        return response()->json(['success' => true]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
