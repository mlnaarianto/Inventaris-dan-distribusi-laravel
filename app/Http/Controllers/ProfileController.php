<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Perbarui nama, foto, dan (bila punya permission) email serta username.
     * Peran hanya bisa diubah administrator lewat Kelola Akun.
     * Foto lama selalu dihapus dari storage saat diganti atau dihapus.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->safe()->only(['name', 'email', 'username']);
        $fotoLama = $user->foto;

        $pesan = 'Profil berhasil diperbarui.';

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto-profil', 'public');
            $pesan = 'Profil dan foto berhasil diperbarui.';
        } elseif ($request->boolean('hapus_foto')) {
            $data['foto'] = null;
            $pesan = 'Profil diperbarui dan foto berhasil dihapus.';
        }

        $user->update($data);

        // Hapus file lama hanya setelah database berhasil diperbarui
        if (array_key_exists('foto', $data) && $fotoLama) {
            Storage::disk('public')->delete($fotoLama);
        }

        return redirect()->route('profile.edit')->with('success', $pesan);
    }
}
