<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Services\UserService;

class UserController extends Controller
{
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function view()
    {
        $user = $this->service->get(\Auth::id());
        return view('panel.user.view')->withUser($user);
    }

    public function edit()
    {
        $user = $this->service->get(\Auth::id());
        return view('panel.user.edit')->withUser($user);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'redirect_url' => 'required|url',
            'notification_url' => 'required|url',
        ]);
        $this->service->updateSettings(\Auth::id(), $request->all());
        $request->session()->flash('success', 'Dados editados com sucesso.');
        return redirect('panel/settings');
    }

    public function updateToken()
    {
        $token = $this->service->newToken(\Auth::id());
        return response()->json(['token' => $token]);
    }

    public function sendToken()
    {
        $email = $this->service->sendToken(\Auth::id());
        return response()->json(['email' => $email]);
    }
}
