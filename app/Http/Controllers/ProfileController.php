<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;
use Intervention\Image\Drivers\Gd\Driver;

class ProfileController extends Controller
{
    protected $imageManager;

    public function __construct()
    {
        $this->imageManager = new ImageManager(new Driver());
    }

    /**
     * Show the user's profile.
     */
    public function show(Request $request): View
    {
        $user = Auth::user();
        $posts = $user->diaryEntries()->orderBy('created_at', 'desc')->paginate(5);

        return view('profile.show', compact('user', 'posts'));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request) : RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => ['nullable', 'confirmed', Password::defaults()],  
        ]);

        try {
            if ($request->hasFile('avatar')) {
                $this->updateUserAvatar($user, $request->file('avatar'));
            }

            $user->fill($request->only(['name', 'email']));

            if ($request->password) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            return redirect()->route('profile.show')->with('success', '¡Perfil actualizado!');

        } catch (\Exception $e) {
            Log::error('Error al actualizar perfil: ' . $e->getMessage());
            return back()->with('error', 'Error al actualizar el perfil')->withInput();
        }
    }

    /**
     * Update the user's avatar.
     */
    protected function updateUserAvatar($user, $file): void
    {
        if (!$file->isValid()) {
            throw new \Exception('Archivo de avatar no válido');
        }

        $filename = $user->id.'-'.uniqid().'.'.$file->extension();

        $image = $this->imageManager->read($file)
            ->cover(120, 120)
            ->toJpeg();

        Storage::disk('public')->put("avatars/".$filename, $image);

        if ($user->avatar && Storage::disk('public')->exists("avatars/".basename($user->avatar))) {
            Storage::disk('public')->delete("avatars/".basename($user->avatar));
        }

        $user->avatar = $filename;
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
