<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Officer',
            'list' => ['DSS Batching Plant', 'User']
        ];

        $page = (object)['title' => 'Daftar AUB yang terdaftar dalam sistem'];
        $activeMenu = 'user';

        // Ambil data langsung dengan filter
        $query = User::select('iduser', 'username', 'nama');

        if ($request->has('username') && !empty($request->username)) {
            $query->where('username', $request->username);
        }

        $user = $query->get();

        // $uniqueCodes = User::select('username')->distinct()->pluck('username');
        return view('user.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'user' => $user, // Kirim data ke view

        ]);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Officer',
            'list' => ['DSS Batching Plant', 'User', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Data Anak Usaha'
        ];

        $user = User::all();
        $activeMenu = 'user';

        return view('user.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3',
            'nama' => 'required|string|max:100',
            'password' => 'required',
            'role' => 'required'
        ]);

        User::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect('/user')->with('success', 'Data user berhasil ditambahkan');
    }

    public function show($id)
    {
        $user = User::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Officer',
            'list' => ['DSS Batching Plant', 'user', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail user'
        ];

        $activeMenu = 'user';

        return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function edit($id)
    {
        $user = User::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Data Officer',
            'list' => ['DSS Batching Plant', 'user', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit user'
        ];

        $activeMenu = 'user';

        return view('user.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|min:3',
            'nama' => 'required|string|max:100',
            'password' => 'required',
            'role' => 'required'
        ]);

        User::find($id)->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect('/user')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        $check = User::find($id);

        if (!$check) {
            return redirect('/user')->with('error', 'Data tidak ditemukan');
        }

        try {
            User::destroy($id);

            return redirect('/user')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
