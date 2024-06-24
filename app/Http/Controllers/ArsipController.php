<?php

namespace App\Http\Controllers;

use App\Models\arsip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArsipController extends Controller
{

    function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function index(Request $request)
    {
        $level = $this->request->level;
        $search = $this->request->search;

        $query = DB::table('arsip as a')
            ->select(
                'a.id_arsip',
                'a.id_jenis',
                'a.id_pejabat',
                'a.nama_arsip',
                'a.file_arsip',
                'a.jumlah',
                'a.id_satuan',
                'a.lokasi',
                'a.ket_isi',
                'a.tanggal',
                'a.permision',
                'b.id_jenis',
                'b.jenis_arsip',
                'b.create_id',
                'b.create_date',
                'c.id_user',
                'c.username',
                'c.nama',
                'c.level',
                'c.email',
                'c.log',
                'd.id_satuan',
                'd.nama_satuan',
                'd.keterangan',
                'e.id_lokasi',
                'e.nama_lokasi',
                DB::raw('DATE_FORMAT(e.tanggal, "%Y-%M-%d") as tgl')
            )
            ->leftJoin('jenis_arsip as b', 'b.id_jenis', '=', 'a.id_jenis')
            ->leftJoin('login as c', 'c.id_user', '=', 'a.id_pejabat')
            ->leftJoin('m_satuan as d', 'a.id_satuan', '=', 'd.id_satuan')
            ->leftJoin('lokasi as e', 'e.id_lokasi', '=', 'a.lokasi');

        // if (auth()->user()->level != 'admin') {
        //     $query->where('a.id_pejabat', auth()->user()->id_user);
        // }

        if (request()->input('id_jenis') != '') {
            $query->where('a.id_jenis', request()->input('id_jenis'));
        }

        // $query->addSelect(DB::raw('<a href="#" data-id="$1" id="download" class="btn btn-success btn-xs"><i class="fa fa-download"></i></a> as file_arsip'));
        // $query->addSelect(DB::raw('$1 as nama_satuan'));
        // $query->addSelect(DB::raw('$1 as nama'));
        // $query->addSelect(DB::raw('$1 as jenis_arsip'));
        // $query->addSelect(DB::raw('$1 as lokasi'));
        // $query->addSelect(DB::raw('$1 as nama_satuan'));

        // if ($level == 'admin') {
        //     if (request()->input('permision') != '') {
        //         $level = request()->input('permision');
        //         $query->whereRaw('LOCATE("' . $level . '", a.permision) > 0');
        //     }
        // } else {
        //     $query->whereRaw('LOCATE("' . $level . '", a.permision) > 0');
        // }
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('a.nama_arsip', 'like', '%' . $search . '%')
                    ->orWhere('a.ket_isi', 'like', '%' . $search . '%')
                    ->orWhere('c.nama', 'like', '%' . $search . '%')
                    ->orWhere('d.nama_satuan', 'like', '%' . $search . '%')
                    ->orWhere('e.nama_lokasi', 'like', '%' . $search . '%');
            });
        }
        return $query->paginate(10);
    }
    public function pengajuan()
    {
        $data = DB::table('pengajuan_arsip as a')
            ->select(
                'a.id_pengajuan',
                'a.id_pejabat',
                'a.id_satuan',
                'a.nama_arsip',
                'a.jumlah',
                'a.satuan',
                'a.tanggal',
                'a.tujuan',
                'a.file_arsip',
                'a.id_jenis',
                'a.nonaktif',
                'b.id_jenis',
                'b.jenis_arsip',
                'b.create_id',
                'b.create_date',
                'c.id_user',
                'c.username',
                'c.nama as nama_staff',
                'c.level',
                'c.email',
                'c.log',
                'd.id_satuan',
                'd.nama_satuan',
                'd.keterangan'
            )
            ->leftJoin('jenis_arsip as b', 'a.id_jenis', '=', 'b.id_jenis')
            ->leftJoin('login as c', 'a.id_pejabat', '=', 'c.id_user')
            ->leftJoin('m_satuan as d', 'a.id_satuan', '=', 'd.id_satuan')
            ->where('a.nonaktif', 'n')
            ->paginate(10); // You can adjust the number of items per page as needed

        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $permision = '1.2.2'; //implode('.', $request->post('permision[]'));
            $data = array(
                'jumlah' => $request->input('jumlah'),
                'id_satuan' => $request->input('id_satuan'),
                'id_jenis' => $request->input('id_jenis'),
                'id_pejabat' => auth()->id(), // Assuming you're using Laravel's built-in authentication
                'nama_arsip' => $request->input('nama'),
                'file_arsip' => $request->input('file_arsipxx'),
                'lokasi' => $request->input('lokasi'),
                'ket_isi' => $request->input('ket_isi'),
                'tanggal' => now()->format('Y-m-d'),
                // 'permission' => $permision // Assuming $permission is defined somewhere
            );
            DB::table('arsip')->insert($data);
            $response = array(
                'ket' => 1,
                'respon' => 'data berhasil disimpan'
            );
            return response()->json($response);
        } catch (\Throwable $th) {
            return response()->json([
                'messages' => $th->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\arsip  $arsip
     * @return \Illuminate\Http\Response
     */
    public function show(arsip $arsip)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\arsip  $arsip
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = DB::table('arsip')->where('id_arsip', $id)->get();
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\arsip  $arsip
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $permision = '1.2.2'; //implode('.', $request->post('permision[]'));
            $data = array(
                'jumlah' => $request->input('jumlah'),
                'id_satuan' => $request->input('id_satuan') ?  $request->input('id_satuan') : 1,
                'id_jenis' => $request->input('id_jenis') ? $request->input('id_jenis') : 8,
                'id_pejabat' => auth()->id(), // Assuming you're using Laravel's built-in authentication
                'nama_arsip' => $request->input('nama'),
                'file_arsip' => $request->input('file_arsip'),
                'lokasi' => $request->input('lokasi'),
                'ket_isi' => $request->input('ket_isi'),
                'tanggal' => now()->format('Y-m-d'),
            );
            DB::table('arsip')->where('id_arsip', $id)->update($data);
            $response = array(
                'ket' => 1,
                'respon' => 'data berhasil disimpan'
            );
            return response()->json($response);
        } catch (\Throwable $th) {
            return response()->json([
                'messages' => $th->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\arsip  $arsip
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::table('arsip')->where('id_arsip', $id)->delete();
            $response = array(
                'ket' => 1,
                'respon' => 'data berhasil hapus'
            );
            return response()->json($response);
        } catch (\Throwable $th) {
            return response()->json([
                'messages' => $th->getMessage(),
            ]);
        }
    }
}
