<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('admin.profile.edit');
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $attributes = [
            'name' => $request->string('name')->toString(),
            'email' => $request->string('email')->toString(),
        ];

        if ($request->filled('password')) {
            $attributes['password'] = $request->string('password')->toString();
        }

        $request->user()->update($attributes);

        return redirect()
            ->route('admin.profile.edit')
            ->with('status', 'Votre profil a été mis à jour.');
    }
}
