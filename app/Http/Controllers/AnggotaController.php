<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $anggotas = User::where('role', '!=', 'admin')
            ->when($request->search, function ($q, $s) {
                $q->where(fn ($w) => $w->where('name', 'like', "%{$s}%")
                    ->orWhere('username', 'like', "%{$s}%")
                    ->orWhere('email', 'like', "%{$s}%"));
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $totalAnggota = User::where('role', '!=', 'admin')->count();

        return view('admin.anggota.index', compact('anggotas', 'totalAnggota'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'email'    => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:6',
        ], [
            'username.unique' => 'NISN / Username ini sudah terdaftar.',
            'email.unique'    => 'Email ini sudah digunakan.',
            'password.min'    => 'Kata sandi minimal harus 6 karakter.',
        ]);

        $data['password'] = Hash::make($data['password']);
        
        // DIUBAH MENJADI 'siswa' AGAR BISA LOGIN DAN MUNCUL DI DROPDOWN PEMINJAMAN
        $data['role'] = 'siswa'; 

        User::create($data);

        return redirect()->route('admin.anggota.index')->with('success', 'Data siswa/anggota berhasil ditambahkan.');
    }

    public function update(Request $request, User $anggota)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username,' . $anggota->id,
            'email'    => 'required|email|max:100|unique:users,email,' . $anggota->id,
            'password' => 'nullable|string|min:6',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $anggota->update($data);

        return redirect()->route('admin.anggota.index')->with('success', 'Data siswa/anggota berhasil diperbarui.');
    }

    public function destroy(User $anggota)
    {
        if ($anggota->role === 'admin') {
            return back()->with('error', 'Akun admin tidak bisa dihapus.');
        }

        $anggota->delete();

        return redirect()->route('admin.anggota.index')->with('success', 'Data siswa/anggota berhasil dihapus.');
    }
    public function export()
    {
        $filename = 'data_anggota_' . date('Y-m-d_H-i-s') . '.csv';
        $anggotas = User::where('role', '!=', 'admin')->get(['name', 'username', 'email']);

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($anggotas) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['name', 'username', 'email']);

            foreach ($anggotas as $anggota) {
                fputcsv($file, [$anggota->name, $anggota->username, $anggota->email]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:2048',
        ], [
            'file.required' => 'Pilih file CSV terlebih dahulu.',
            'file.mimes' => 'Format file harus berupa CSV.',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));
        
        // Lewati baris header pertama
        array_shift($data);
        
        $importedCount = 0;
        foreach ($data as $row) {
            if (count($row) >= 3) {
                $name = trim($row[0]);
                $username = trim($row[1]);
                $email = trim($row[2]);

                // Pastikan username/NISN dan email belum terdaftar
                if (!User::where('username', $username)->exists() && !User::where('email', $email)->exists()) {
                    User::create([
                        'name' => $name,
                        'username' => $username,
                        'email' => $email,
                        'password' => Hash::make('password123'), // Password default untuk akun import
                        'role' => 'siswa',
                    ]);
                    $importedCount++;
                }
            }
        }

        return redirect()->route('admin.anggota.index')->with('success', "Berhasil mengimpor $importedCount data siswa baru (Password default: password123).");
    }
}
    