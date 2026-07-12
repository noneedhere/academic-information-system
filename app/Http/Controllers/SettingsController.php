<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class SettingsController extends Controller
{
    /**
     * Show the settings form (change password).
     */
    public function edit(): View
    {
        return view('settings.edit');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(PasswordUpdateRequest $request): RedirectResponse
    {
        $request->user()->update([
            'password' => Hash::make($request->validated('password')),
        ]);

        // Invalidate other sessions for security
        Auth::logoutOtherDevices($request->validated('password'));

        return redirect()->route('settings.edit')
            ->with('success', 'Password changed successfully.');
    }
}
