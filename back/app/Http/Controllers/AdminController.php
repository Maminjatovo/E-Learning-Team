<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Admin;
use Intervention\Image\Facades\Image;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = Admin::all();
        $admin->map(function ($admin) {
        $admin->photo_admin = $this->format($admin->photo_admin);
        return $admin;
        });
        return response()->json($admin, 201);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_admin' => 'required',
            'prenom_admin' => 'required',
            'adress_admin' => 'required',
            'tel_admin' => 'required',
            'email_admin' => 'required',
            'password_admin'=> 'required',
            'photo_admin' => 'nullable',
        ]);
        if (!$request->hasFile('photo_admin') || !$request->file('photo_admin')->isValid()) {
            $imageName = null;
        } else {
            $imageName = time() . '_' . $request->nom_photo_admin . '.' . $request->file('photo_admin')->extension();
            $request->file('photo_admin')->move(public_path('images'), $imageName);
        }
        $admin = Admin::create(
            [
                'nom_admin' => $request->nom_admin,
                'prenom_admin' => $request->prenom_admin,
                'adress_admin' => $request->adress_admin,
                'tel_admin' => $request->tel_admin,
                'email_admin' => $request->email_admin,
                'password_admin' => $request->password_admin,
                'photo_admin' => $imageName,
            ]
        );

        $admin->photo_admin = $this->format($admin->photo_admin);

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
            $admin->photo_admin = $this->format($admin->photo_admin);
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
    public function update(Request $request, $id_admin)
    {
            $admin = Admin::where('id_admin','=', $id_admin);
            $validatedData = $request->validate([
                'nom_admin' => 'required',
                'prenom_admin' => 'required',
                'adress_admin' => 'required',
                'tel_admin' => 'required',
                'email_admin' => 'required',
                'password_admin'=> 'required',
                'photo_admin' => 'nullable',
                ]);

            if (!$request->hasFile('photo_admin') || !$request->file('photo_admin')->isValid()) {
                $admin->update(
                    [
                        'nom_admin' => $request->nom_admin,
                        'prenom_admin' => $request->prenom_admin,
                        'adress_admin' => $request->adress_admin,
                        'tel_admin' => $request->tel_admin,
                        'email_admin' => $request->email_admin,
                        'password_admin' => $request->password_admin,
                        'photo_admin' => $admin->firstOrFail()->photo_admin,
                    ]
                );
            } else {
                $imageName = time() . '_' . $request->nom_photo_admin . '.' . $request->file('photo_admin')->extension();
                $request->file('photo_admin')->move(public_path('images'), $imageName);
                if(!is_null($admin->firstOrFail()->photo_admin)){
                    unlink(public_path('/images/'.$admin->firstOrFail()->photo_admin));
                }
                $admin->update(
                    [
                        'nom_admin' => $request->nom_admin,
                        'prenom_admin' => $request->prenom_admin,
                        'adress_admin' => $request->adress_admin,
                        'tel_admin' => $request->tel_admin,
                        'email_admin' => $request->email_admin,
                        'password_admin' => $request->password_admin,
                        'photo_admin' => $imageName,
                    ]
                );
            }
            $admin->photo_admin = $this->format($admin->photo_admin);
            return response()->json($admin, 201);
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
        public function format($image_name)
    {
        if(is_null($image_name)){
            $path = public_path().'/images/default-avatar.png';
        }
        else{
            $path = public_path().'/images/'.$image_name;
        }
        $image = Image::make($path)->resize(50, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $data = (string) $image->encode();
        $base64 = 'data:image/' . $image->mime() . ';base64,' . base64_encode($data);


        return $base64;
    }
}
