<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminKelolaakunController extends Controller
{
    //
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.kelolaakun.index', compact('users'));
    }

    public function boot()
    {
    $this->configureRateLimiting();

    $this->routes(function () {
        Route::middleware('web')
            ->namespace($this->namespace) // <— tambahkan ini
            ->group(base_path('routes/web.php'));


        Route::prefix('api')
            ->namespace($this->namespace) // <— tambahkan ini
            ->middleware('api')
            ->group(base_path('routes/api.php'));
    });
    }


    public function create()
    {
        return view('admin.kelolaakun.create');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'image'     => 'required|image|mimes:png,jpg,jpeg',
            'name'     => 'required',
            'email'   => 'required',
            'is_admin'   => 'required',
            'password'   => 'required'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/users', $image->hashName());

        $user = User::create([
            'image'     => $image->hashName(),
            'name'     => $request->name,
            'email'   => $request->email,
            'is_admin'   => $request->is_admin,
            'password'   => $request->password,
        ]);

        if($user){
            //redirect dengan pesan sukses
            return redirect()->route('adminkelolaakun.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('adminkelolaakun.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }



    public function edit(User $user)
{
    return view('admin.kelolaakun.edit', compact('user'));
}


/**
* update
*
* @param  mixed $request
* @param  mixed $user
* @return void
*/
public function update(Request $request, User $user)
{
    $this->validate($request, [
        'name'     => 'required',
        'email'   => 'required',
        'is_admin'   => 'required',
        'password'   => 'required'
    ]);

    //get data Blog by ID
    $user = User::findOrFail($user->first()->id);

    if($request->file('image') == "") {

        $user->update([
            'name'     => $request->name,
            'email'   => $request->email,
            'is_admin'   => $request->is_admin,
            'password'   => $request->password,
        ]);

    } else {

        //hapus old image
        Storage::disk('local')->delete('public/users/'.$user->image);

        //upload new image
        $image = $request->file('image');
        $image->storeAs('public/users', $image->hashName());

        $user->update([
            'image'     => $image->hashName(),
            'name'     => $request->name,
            'email'   => $request->email,
            'is_admin'   => $request->is_admin,
            'password'   => $request->password,
        ]);

    }

    if($user){
        //redirect dengan pesan sukses
        return redirect()->route('adminkelolaakun.index')->with(['success' => 'Data Berhasil Diupdate!']);
    }else{
        //redirect dengan pesan error
        return redirect()->route('adminkelolaakun.index')->with(['error' => 'Data Gagal Diupdate!']);
    }
}




    public function destroy($id)
    {
    $user = User::findOrFail($id);
    Storage::disk('local')->delete('public/users/'.$user->image);
    $user->delete();

    if($user){
        //redirect dengan pesan sukses
        return redirect()->route('adminkelolaakun.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }else{
        //redirect dengan pesan error
        return redirect()->route('adminkelolaakun.index')->with(['error' => 'Data Gagal Dihapus!']);
    }
    }




}
