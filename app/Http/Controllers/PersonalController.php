<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personals = Personal::all();
        $heads = [
            'ID',
            'Nombre',
            'Apellido',
            'Celular',
            'Email',
            'DNI / Carnet Extranjeria / Pasaporte',
            'Imagen',
            'Acciones'
        ];

        return view("personal/list-personal", compact("personals", "heads"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("personal/register-personal");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // obtenemos y validamos el request enviado del formulario

       $this->validateForm($request, null);

       if($request->hasFile('image')){
           $nameImage =  $this->photoUser($request);
       }

       $personal = new Personal();

       if($request->email && $request->password){

        $user = new User();
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
      
       $personal->name = $request->name;
       $personal->last_name = $request->last_name;
       $personal->dni = $request->dni;
       $personal->immigration_card = $request->immigration_card;
       $personal->passport = $request->passport;
       $personal->cellphone = $request->cellphone;
       $personal->email = $request->email;
       $personal->img_url = $nameImage;
       $personal->id_user = $user->id;
       $personal->save();

       }else{

       $personal->name = $request->name;
       $personal->last_name = $request->last_name;
       $personal->dni = $request->dni;
       $personal->immigration_card = $request->immigration_card;
       $personal->passport = $request->passport;
       $personal->cellphone = $request->cellphone;
       $personal->img_url = $nameImage;
       $personal->save();

       }

       return view("personal/register-personal");

       
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
        // Se busca al usuario

        $personal = Personal::findOrFail($id);
        return view('personal.edit-personal', compact('personal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $requestData = $request->all();

        // Ubicamos primero al personal
        $personal = Personal::findOrFail($id);
        // Validamos que los campos esten completos
        $this->validateForm($request, $id);
        // Editamos el nombre de la imagen

        if($request->hasFile('image')){
            $nameImage =  $this->photoUser($request);
            $requestData['img_url'] = $nameImage;
        }

        if($requestData['email'] != "" && $requestData['password'] != ""){


            $user = User::where('email', $requestData['email'])->first();
            
            $user['email'] = $requestData['email'];
            $user['password'] = bcrypt($requestData['password']);

            $user->save();


        }else{
            $personal->update($requestData);
        }

       

        return view("personal/edit-personal", compact('personal'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        
    }


    public function validateForm($request, $id){
        $request->validate([
            'name' => 'required|string',
            'last_name' => 'required|string',
            'cellphone' => 'required|string',
            'email' => 'nullable|email',
            'dni' => 'nullable|numeric|digits:8|unique:personal,dni,' . $id,
            'immigration_card' => 'nullable|numeric|unique:personal,immigration_card,' . $id,
            'passport' => 'nullable|numeric|max:20|unique:personal,passport,' . $id,
            'img_url' => 'nullable|string'
            
        ]);
    
    }

    public function photoUser( $request ){
        
        $imagen = $request->file('image');

        if($request->dni){
            $nameImage = $request->dni . '.' . $imagen->getClientOriginalExtension();
        }else if($request->immigration_card){
            $nameImage = $request->immigration_card . '.' . $imagen->getClientOriginalExtension();
        }else if ($request->passport){
            $nameImage = $request->passport . '.' . $imagen->getClientOriginalExtension();
        }
       
        Storage::disk('avatars')->put( $nameImage, file_get_contents($request->file('image')->getPathName()) );
        return $nameImage;
    }
}
