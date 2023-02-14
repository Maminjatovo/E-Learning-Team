<?php

namespace App\Http\Controllers;

use App\Models\Ensignant;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class EnseignantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ensignants = Ensignant::all();
        $ensignants->map(function ($ensignant) {
        $ensignant->photo_ens = $this->format($ensignant->photo_ens);
        return $ensignant;
        });
        return response()->json($ensignants);
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
            'nom_ens' => 'required',
            'prenom_ens' => 'required',
            'adresse_ens' => 'required',
            'telephone_ens' => 'required',
            //'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'photo_ens' => 'nullable',
            'specialite_ens' => 'required',
            'email_ens' => 'required',
        ]);


        if (!$request->hasFile('photo_ens') || !$request->file('photo_ens')->isValid()) {
            $imageName = null;
        } else {
            $imageName = time() . '_' . $request->nom_photo_ens . '.' . $request->file('photo_ens')->extension();
            $request->file('photo_ens')->move(public_path('images'), $imageName);
        }


        //$image = new Image;
        //$image->name = $imageName;
        //$image->save();

        $enseignant = Ensignant::create(
            [
                'nom_ens' => $request->nom_ens,
                'prenom_ens' => $request->prenom_ens,
                'adresse_ens' => $request->adresse_ens,
                'telephone_ens' => $request->telephone_ens,
                'photo_ens' => $imageName,
                'specialite_ens' => $request->specialite_ens,
                'email_ens' => $request->email_ens,
            ]
        );

        $enseignant->photo_ens = $this->format($enseignant->photo_ens);

        return response()->json($enseignant, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $enseignant = Ensignant::where('id_ens', '=', $id)->firstOrFail();
        return response()->json($enseignant);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        $enseignant = Ensignant::where('id_ens', '=', $id);

        $request->validate([
            'nom_ens' => 'required',
            'prenom_ens' => 'required',
            'adresse_ens' => 'required',
            'telephone_ens' => 'required',
            //'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'photo_ens' => 'nullable',
            'specialite_ens' =>   'required',
            'email_ens' => 'required',
        ]);

        if (!$request->hasFile('photo_ens') || !$request->file('photo_ens')->isValid()) {
            $enseignant->update(
                [
                    'nom_ens' => $request->nom_ens,
                    'prenom_ens' => $request->prenom_ens,
                    'adresse_ens' => $request->adresse_ens,
                    'telephone_ens' => $request->telephone_ens,
                    'photo_ens' => $enseignant->firstOrFail()->photo_ens,
                    'specialite_ens' => $request->specialite_ens,
                    'email_ens' => $request->email_ens,
                ]
            );
        } else {
            $imageName = time() . '_' . $request->nom_photo_ens . '.' . $request->file('photo_ens')->extension();
            $request->file('photo_ens')->move(public_path('images'), $imageName);
            if(!is_null($enseignant->firstOrFail()->photo_ens)){
                unlink(public_path('/images/'.$enseignant->firstOrFail()->photo_ens));
            }
            $enseignant->update(
                [
                    'nom_ens' => $request->nom_ens,
                    'prenom_ens' => $request->prenom_ens,
                    'adresse_ens' => $request->adresse_ens,
                    'telephone_ens' => $request->telephone_ens,
                    'photo_ens' => $imageName,
                    'specialite_ens' => $request->specialite_ens,
                    'email_ens' => $request->email_ens,
                ]
            );

        }
        $enseignant->firstOrFail()->photo_ens = $this->format($enseignant->firstOrFail()->photo_ens);
        return response()->json($enseignant->firstOrFail());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $enseignant = Ensignant::where('id_ens', '=', $id);
        if(!is_null($enseignant->firstOrFail()->photo_ens)){
            unlink(public_path('/images/'.$enseignant->firstOrFail()->photo_ens));
        }
        $enseignant->delete();
        return response()->json(null, 204);
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
}
