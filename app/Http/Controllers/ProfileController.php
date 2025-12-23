<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function update(ProfileUpdateRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validated();

        $user->name = $validated['name'];

        if ($user->email !== $validated['email']) {
            $user->email = $validated['email'];
        }

        $user->save();

        return redirect()->back()->with('success', 'Perfil actualizado');
    }

    public function updateImage(Request $request)
{
    $request->validate([
        'profile_image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    /** @var \App\Models\User $user */
    $user = Auth::user();
    $uploadPath = public_path('images/profile-images');

    // Crear el directorio si no existe
    if (!file_exists($uploadPath)) {
        mkdir($uploadPath, 0755, true);
    }

    // Eliminar imagen anterior solo si no es la imagen por defecto
    if (
        $user->profile_image &&
        $user->profile_image !== User::DEFAULT_PROFILE_IMAGE && // Comparar sin asset()
        file_exists(public_path($user->profile_image))
    ) {
        unlink(public_path($user->profile_image));
    }

    // Guardar nueva imagen
    $imageName = 'profile-' . $user->id . '-' . time() . '.' . $request->file('profile_image')->extension();
    $request->file('profile_image')->move($uploadPath, $imageName);

    $user->profile_image = 'images/profile-images/' . $imageName; // Sin "/" inicial para consistencia
    $user->save();

    return response()->json([
        'success' => true,
        'profile_image_url' => asset($user->profile_image)
    ]);
}

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

        return Redirect::to('/')->with('account_deleted', true);
    }
}
