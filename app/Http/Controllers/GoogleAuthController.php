<?php

namespace App\Http\Controllers;

use App\Models\Apiary;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                ]);
            } else {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                ]);

                // Crear un apiario por defecto para el nuevo usuario
                Apiary::create([
                    'user_id' => $user->id,
                    'name' => 'Mi primer apiario',
                    'location' => 'Ubicación desconocida',
                ]);
            }

            Auth::login($user);

            return redirect('/dashboard');

        } catch (Exception $e) {
            // A good practice would be to log the exception
            // \Log::error($e);
            return redirect('/')->withErrors(['msg' => 'An error occurred during Google authentication.']);
        }
    }
}
