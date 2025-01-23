<?php

namespace App\Http\Controllers\Admin;

use App\Exports\GelombangExport;
use App\Http\Controllers\Controller;
use App\Imports\GelombangImport;
use App\Models\Gelombang;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class GelombangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.gelombang.index');
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.gelombang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            Gelombang::create([
                'name' => $request->name,
            ]);
            return redirect()->route('admin.gelombangs.index')->with('success', "Gelombang telah ditambahkan");
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dataGelombang = Gelombang::findOrFail($id);
        return view('admin.gelombang.edit', compact('dataGelombang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $dataGelombang = Gelombang::find($id);

            $dataGelombang->update([
                'name' => $request->name,
            ]);
            return redirect()->route('admin.gelombangs.index')->with('success', "Gelombang telah diedit");
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dataGelombang = Gelombang::findorfail($id);
        $dataGelombang->delete();
        return redirect()->route('admin.gelombangs.index')->with('success', 'Gelombang telah dihapus');
    }

    public function dtGelombang()
    {
        $data = Gelombang::query();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('Action', function ($data) {
                $button = '<form action=" ' . route('admin.gelombangs.destroy', $data->id)  . '" method="POST">
                    ' . @csrf_field() . '
                    ' . @method_field('DELETE') . '
                    <a class="btn btn-primary btn-sm" href=" ' . route('admin.gelombangs.edit', $data->id)  . '"><i class="fa fa-edit"></i> Edit</a>

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModal' . $data->id . '"><i class="fa fa-trash"></i> Delete</button>
                    <!-- Modal -->
                    <div id="myModal' . $data->id . '" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title mt-0" id="myModalLabel">Delete Confirmation</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure want to delete this ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>';
                return $button;
            })
            ->rawColumns(['Action'])
            ->toJson();
    }

    public function export()
    {
        try {
            return Excel::download(new GelombangExport, 'Gelombang.xlsx');
        } catch (\Throwable $th) {
            return back()->with('error', 'Failed to export data.');
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        // If validation passes, process the file
        Excel::import(new GelombangImport, $request->file('file'));

        return redirect()->route('admin.gelombangs.index')->with('success', 'Data imported successfully!');
    }
}
