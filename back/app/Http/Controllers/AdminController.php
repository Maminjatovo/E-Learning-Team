<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Admin;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Admin::all();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $admin = Admin::create($request->all());

        return response()->json($admin, 201);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show($id_admin)
    {
        try {
            $admin = Admin::where('id_admin', $id_admin)->firstOrFail();
            return response()->json($admin);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Admin not found'], 404);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id_admin)
    {
        try {
            $admin = Admin::where('id_admin','=', $id_admin);

            $validatedData = $request->validate([
                'nom_admin' => 'required|max:255',
                'prenom_admin' => 'required|max:255',
                'tel_admin' => 'required|max:255',
                'email_admin' => 'required',
                'password_admin' => 'required'
            ]);
            $admin->update($validatedData);
            return response()->json($admin->firstOrFail());
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Admin not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_admin)
        {

            try {
                $admin = Admin::where('id_admin', $id_admin)->delete();
                return response()->json(['message' => 'Admin deleted successfully']);
            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'Admin not found'], 404);
            }
        }
}
