<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Mail\NewUserIntroduction;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, Mailer $mailer): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $newUser = User::create([ // 新しいユーザーを作成
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($newUser));

        Auth::login($newUser);

        // メールを送信
        //$mailer->to(config('mail.from.address'))->send(new NewUserIntroduction($user->email));

        $allUser = User::get(); // 全ユーザーを取得
        foreach ($allUser as $user) {
            $mailer->to($user->email)->send(new NewUserIntroduction($user, $newUser)); // 全ユーザーにメールを送信
        }

        return redirect(RouteServiceProvider::HOME);
    }
}
