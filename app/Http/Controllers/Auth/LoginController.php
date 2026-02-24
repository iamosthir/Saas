<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Custom login page.
     */
    public function loginPage()
    {
        return view('pages.login');
    }

    /**
     * Use phone instead of email for login.
     */
    public function username()
    {
        return 'phone';
    }

    /**
     * Redirect users based on their role after login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return \Illuminate\Http\Response
     */
    protected function authenticated($request, $user)
    {
        if (in_array($user->role, ['pos_only', 'cashier'])) {
            return redirect('/dashboard/pos');
        }

        if ($user->role === 'accountant') {
            return redirect('/dashboard/sales/report');
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
