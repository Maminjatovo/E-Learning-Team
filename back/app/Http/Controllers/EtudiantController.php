<?php

namespace App\Http\Controllers;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class EtudiantController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return response()->json(Etudiant::all());

        $etudiants = Etudiant::all();
        $etudiants->map(function ($etudiant) {
        $etudiant->photo_etu = $this->format($etudiant->photo_etu);

        return $etudiant;
        });

        return response()->json($etudiants);
    }

    public function format($image_name)
    {
        if(is_null($image_name)){
            $path = public_path().'/images/default-avatar.png';
        }
        else{
            $path = public_path().'/images/'.$image_name;
        }


/*
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
*/
        $image = Image::make($path)->resize(50, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $data = (string) $image->encode();
        $base64 = 'data:image/' . $image->mime() . ';base64,' . base64_encode($data);


        return $base64;
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


        $request->validate([
            'nom_etu' => 'required',
            'prenom_etu' => 'required',
            'adresse_etu' => 'required',
            'telephone_etu' => 'required',
            'email_etu' => 'required',
            //'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'file' => 'nullable',
        ]);


        if (!$request->hasFile('file') || !$request->file('file')->isValid()) {
            $imageName = null;
        } else {
            $imageName = time() . '_' . $request->photo_etu . '.' . $request->file('file')->extension();
            $request->file('file')->move(public_path('images'), $imageName);
        }


        //$image = new Image;
        //$image->name = $imageName;
        //$image->save();

        $etudiant = Etudiant::create(
            [
                'nom_etu' => $request->nom_etu,
                'prenom_etu' => $request->prenom_etu,
                'adresse_etu' => $request->adresse_etu,
                'telephone_etu' => $request->telephone_etu,
                'email_etu' => $request->email_etu,
                'photo_etu' => $imageName,

            ]
        );

        $etudiant->photo_etu = $this->format($etudiant->photo_etu);

        return response()->json($etudiant, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_etu)
    {
        $etudiant = Etudiant::findOrFail($id_etu);
        return response()->json($etudiant);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_etu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_etu)
    {
        //$student = Student::where('name', 'John')->first();
        $etudiant = Etudiant::where('id_etu')->firtOrFail($id_etu);

        $request->validate([
            'nom_etu' => 'required',
            'prenom_etu' => 'required',
            'adresse_etu' => 'required',
            'telephone_etu' => 'required',
            'email_etu' => 'required',
            //'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'file' => 'nullable',
        ]);

        if (!$request->hasFile('file') || !$request->file('file')->isValid()) {
            $etudiant->update(
                [
                    'nom_etu' => $request->nom_etu,
                    'prenom_etu' => $request->prenom_etu,
                    'adresse_etu' => $request->adresse_etu,
                    'telephone_etu' => $request->telephone_etu,
                    'email_etu' => $request->email_etu,
                    'photo_etu' => $etudiant->photo_etu,

                ]
            );
        } else {
            $imageName = time() . '_' . $request->image . '.' . $request->file('file')->extension();
            $request->file('file')->move(public_path('images'), $imageName);
            if(!is_null($etudiant->photo_etu)){
                unlink(public_path('/images/'.$etudiant->photo_etu));
            }
            $etudiant->update(
                [
                    'nom_etu' => $request->nom_etu,
                    'prenom_etu' => $request->prenom_etu,
                    'adresse_etu' => $request->adresse_etu,
                    'telephone_etu' => $request->telephone_etu,
                    'email_etu' => $request->email_etu,
                    'photo_etu' => $imageName,
                ]
            );

        }
        $etudiant->photo_etu = $this->format($etudiant->photo_etu);
        return response()->json($etudiant);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_etu)
    {
        //$etudiant = Etudiant::where('id_etu')->findOrFail($id_etu);
        $etudiant = Etudiant::where('id_etu')->firtdOrFail($id_etu);
        if(!is_null($etudiant->photo_etu)){
            unlink(public_path('/images/'.$etudiant->photo_etu));
        }
        $etudiant->delete();
        return response()->json(null, 204);
    }
}
