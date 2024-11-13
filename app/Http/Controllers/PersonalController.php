<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Personal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personals = Personal::with('document')->get();

        $heads = [
            'ID',
            'Nombres',
            'Apellido',
            'Celular',
            'Tipo de Documento',
            'Numero de documento',
            'Email',
            'Estado',
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

        $documents = Document::all();

        //
        return view("personal/register-personal", compact('documents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // obtenemos y validamos el request enviado del formulario

        $this->validateForm($request, null);

        $nameImage = 'personals/user_default.png';

        if ($request->hasFile('imagen')) {
            $nameImage =  $this->photoUser($request);
        }

        //Consultamos si tiene usuario

        if ($request->password && $request->user) {

            $exist_usuario = User::where("email", $request->user)->first();

            if ($exist_usuario) {
                return redirect()->back()->withErrors(['user' => 'El usuario ya esta asignado.'])->withInput();
            }

            $user = User::create([
                'email' => $request->user,
                'password' => $request->password,
                'state' => 'Activo'
            ]);
        }


        $date_clean = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '', $request->birthdate);

        // Formatear la fecha sin la hora
        $request->birthdate = Carbon::parse($date_clean)->format("Y-m-d");


        $personal = Personal::create([
            'document_number' => $request->document_number,
            'id_document' => $request->id_document,
            'names' => $request->names,
            'last_name' => $request->last_name,
            'mother_last_name' => $request->mother_last_name,
            'birthdate' => $request->birthdate,
            'civil_status' => $request->civil_status,
            'sexo' => $request->sexo,
            'cellphone' => $request->cellphone,
            'email' => $request->email,
            "address" => $request->address,
            'img_url'  => $nameImage,
            'state'  => 'ACTIVO',
            'id_user'  => (isset($user)) ? $user->id : null,
        ]);

        return redirect("personal");
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
        $documents = Document::all();

        return view('personal.edit-personal', compact('personal', 'documents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $this->validateForm($request, $id);

        $is_personal = Personal::where("id", "<>", $id)->where("document_number", $request->document_number)->first();
        $exist_email = Personal::where("id", "<>", $id)->where("email", $request->email)->first();

        if ($is_personal) {

            return redirect()->back()->withErrors(['document_number' => 'Ya existe este personal con este numero de identificacion.'])->withInput();
        }

        if ($exist_email) {

            return redirect()->back()->withErrors(['email' => 'Este email ya esta registrado para otro personal.'])->withInput();
        }


        $personal = Personal::findOrFail($id);



        // si el usuario no existe pero se manda almenos el password o el user, se valida hasta que se manden ambos o ninguno
        if (!$personal->user && ($request->user || $request->password)) {
            $this->createUser($personal, $request);
        } else if ($personal->user && ($request->user || $request->password)) {
            $this->updateUser($personal, $request);
        }

        $date_clean = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '', $request->birthdate);

        $dateFormat =  Carbon::parse($date_clean)->format("Y-m-d");

        $request->merge(["birthdate" => $dateFormat]);


        if ($request->hasFile("imagen")) {
            if ($personal->img_url) {
                Storage::delete($personal->img_url);
            }

            $path = $request->file('imagen')->store('personals');

            $request->request->add(["img_url" => $path]);
        }


        $personal->update($request->all());


        return redirect("personal");
    }


    public function createUser($personal, $request)
    {

        // Si el personal no tiene usuario, lo creamos
        if (!$personal->user && $request->user && $request->password) {

            $exist_usuario = User::where("email", $request->user)->first();

            if ($exist_usuario) {
                return redirect()->back()->withErrors(['user' => 'El usuario ya esta asignado.'])->withInput();
            }

            $this->validate($request, [
                'password' => 'required|string|min:6|confirmed', // Asegúrate de tener un campo de confirmación de contraseña
            ]);

            $user = User::create([
                'email' => $request->user,
                'password' => bcrypt($request->password), // Asegúrate de cifrar la contraseña
                'state' => 'Activo'
            ]);

            // Asignamos el usuario al personal
            $personal->user()->associate($user);
            $personal->save();
        }
    }

    public function updateUser($personal, $request)
    {

        // Verificar si el campo 'user' (correo) fue modificado
        if ($request->has('user') && $request->user !== $personal->user->email) {
            $exist_usuario = User::where("id", "<>", $personal->id_user)
                ->where("email", $request->user)
                ->first();

            if ($exist_usuario) {
                return redirect()->back()->withErrors(['user' => 'Este correo ya esta asignado a otro usuario.'])->withInput();
            }

            // Actualizar el usuario solo si el correo ha cambiado
            $user = $personal->user;
            $user->update(['email' => $request->user]);
        }


        // Verificar si se está actualizando la contraseña
        if ($request->has('password') && !empty($request->password)) {
            // Si se va a cambiar la contraseña, puedes validarla y luego actualizar
            // Ejemplo de validación de la contraseña (puedes agregar reglas según sea necesario)
            $this->validate($request, [
                'password' => 'required|string|min:6|confirmed', // Asegúrate de tener un campo de confirmación de contraseña
            ]);

            $user = $personal->user;
            $user->update(['password' => bcrypt($request->password)]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $personal = Personal::find($id);
        $personal->update(['state' => 'CESADO']);

        return redirect('personal')->with('eliminar', 'ok');

    }


    public function validateForm($request, $id)
    {

        $document = Document::find($request->id_document);
        $digits = $document ? $document->number_digits : null;

        $request->validate([
            'names' => 'required|string',
            'last_name' => 'required|string',
            'mother_last_name' => 'required|string',
            'birthdate' => 'nullable',
            'civil_status' => 'nullable',
            'sexo' => 'nullable',
            'cellphone' => 'required|string',
            'email' => 'nullable|email',
            'address' => 'nullable',
            'id_document' => 'required',
            'document_number' => [
                'nullable',
                'numeric',
                'unique:personal,document_number,' . $id,
                $digits ? 'digits:' . $digits : 'nullable' // Agrega la regla de dígitos si existe
            ],
            'img_url' => 'nullable|string',

        ]);
    }

    public function photoUser($request)
    {

        $path = Storage::putFile("personals", $request->file("imagen"));

        return $path;
    }
}
