<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function index()
    {
        $category = $this->request->category;
        $perPage = $this->request->page ? $this->request->page : 1;
        $query = User::select(
            'users.id_user as id',
            'users.username',
            'users.password',
            'users.nama_lengkap',
            'users.email',
            'users.no_telp',
            'users.sector',
            'users.bio',
            'users.userpicture',
            'users.level',
            'users.blokir',
            'users.id_session',
            'users.tgl_daftar',
            'users.forget_key',
            'users.locktype',
            'users.token',
            'users.statuslogin',
            'users.nama_lengkap as created_by',
            'users.nama_lengkap as updated_by',
            DB::raw('DATE_FORMAT(users.created_on,"%d-%M-%Y %H:%m") as created_on'),
            DB::raw('DATE_FORMAT(users.updated_on,"%d-%M-%Y %H:%m") as updated_on'),

        )
            ->leftJoin('users as created_by_user', 'users.created_by', '=', 'created_by_user.id_user')
            ->leftJoin('users as updated_by_user', 'users.updated_by', '=', 'updated_by_user.id_user')
            ->orderBy('users.id_user', 'desc');

        if ($this->request->q) {
            $searchTerm = '%' . $this->request->q . '%';
            $query->where(function ($query) use ($searchTerm) {
                $query->where('users.username', 'LIKE', $searchTerm);
                $query->orWhere('users.nama_lengkap', 'LIKE', $searchTerm);
            });
        }
        if ($this->request->sort) {
            $query->orderBy('users.id_user', $this->request->sort);
        }
        $posts = $query->paginate(7, ['*'], 'page', $perPage);
        return response()->json($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $data = new User();
            $data->id_user = $this->request->id_user;
            $data->username = $this->request->username;
            $data->password = bcrypt($this->request->password);
            $data->nama_lengkap = $this->request->nama_lengkap;
            $data->email = $this->request->email;
            $data->no_telp = ($this->request->no_telp) ? $this->request->no_telp : 0;
            $data->sector = ($this->request->sector) ? $this->request->sector : 0;
            $data->bio = ($this->request->bio) ? $this->request->bio : 0;
            $data->userpicture = ($this->request->userpicture) ? $this->request->userpicture : 0;
            $data->level = ($this->request->user_level) ? $this->request->user_level : 0;
            $data->blokir = ($this->request->blokir) ? $this->request->blokir : 'N';
            $data->id_session = ($this->request->id_session) ? $this->request->id_session : 0;
            $data->tgl_daftar = ($this->request->tgl_daftar) ? $this->request->tgl_daftar : date('Y-m-d');
            $data->forget_key = ($this->request->forget_key) ? $this->request->forget_key : $this->request->forget_key;
            $data->locktype = ($this->request->locktype) ? $this->request->locktype : '';
            $data->created_by = $this->request->user_id ? $this->request->user_id : $this->request->id_user;
            $data->created_on = date('Y-m-d H:i:s');
            $data->save();
            return response()->json(['messages' => 'Data user berhasil dis simpan']);

        } catch (\User $th) {
            return response()->json(['messages' => $th]);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\users  $users
     * @return \Illuminate\Http\Response
     */
    public function show(users $users)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\users  $users
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $data = User::where('id_user', $id)->first();
            return response()->json($data);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\users  $users
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        try {

            $hashedPassword = bcrypt($this->request->password);
            // $user_id = $this->request->user_id;
            User::where('id_user', $id)
                ->update(['password' => $hashedPassword,
                    'nama_lengkap' => $this->request->nama_lengkap,
                    'email' => $this->request->email,
                    'updated_by' => $this->request->user_id ? $this->request->user_id : $this->request->id_user,
                    'updated_on' => date('Y-m-d H:i:s'),
                    'level' => $this->request->user_level,
                ]);
            return response()->json(['message' => 'Password adasasdas diperbarui'], 200);
        } catch (\User $th) {
            return response()->json(['message' => $th->getMessage()], 400);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\users  $users
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            User::where('id_user', $id)->delete();
            return response()->json('berhasil di hapus');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }
}
