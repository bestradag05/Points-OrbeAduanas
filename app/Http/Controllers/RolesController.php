<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use App\Models\Roles;
use App\Models\User;
use App\Models\Permissions;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtenemos todos los roles

        $roles = Roles::all();

        $usersCountByRoles = [];

        foreach ($roles as $role) {
            // Contar la cantidad de usuarios para cada rol

            $userCount =    User::role($role->name)->count();

            // Almacenar la cantidad en el array
            $usersCountByRoles[$role->name] = $userCount;
        }


        $heads = [
            'ID',
            'Nombre',
            'Cant. usuarios',
            'Acciones'
        ];


        return view('roles/list-roles', compact('roles', 'heads', 'usersCountByRoles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Redireccionamos al formulario de crear un rol

        return view('roles/register-roles');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Guardar el rol enviado desde el form

        try {

            $this->validateForm($request, null);

            $role = Roles::create([
                'name' => $request->name,
                'guard_name' => 'web'
            ]);

            // 2. Obtenemos los permisos que inicien con el nombre del rol (en formato slug si usas eso)
            $prefix = $request->name; // o usar Str::slug($request->name) si tus permisos están con guiones
            $permissions = Permissions::where('name', 'like', $prefix . '.%')->get();

            // 3. Asignamos esos permisos automáticamente al nuevo rol
            $role->givePermissionTo($permissions);

            return redirect('roles');
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];

            // Si el código de error es 1062 (violación de índice único), muestra un mensaje personalizado
            if ($errorCode == 1062) {
                return view('roles.register-roles', ['error' => 'Este rol ya ha sido creado']);
            }
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
        // Buscamos el rol a actualizar

        $rol = Roles::findOrFail($id);
        return view('roles.edit-roles', compact('rol'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Buscamos el rol que se va editar

        $this->validateForm($request, $id);
        $rol = Roles::find($id);

        $rol->name = $request->name;
        $rol->guard_name = 'web';

        $rol->save();

        return redirect('roles');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $rol = Roles::find($id);
        $rol->delete();


        return redirect('roles')->with('eliminar', 'ok');
    }

    public function templateRoles($id)
    {
        $rol = Role::find($id);

        $personals = Personal::all();
        $personals->load('user');

        $headsRolUser = [
            'ID',
            'Nombre',
            'Foto',
            'Acciones'
        ];

        $tab = 'usuarios'; // tab actual que se vera

        $userHasRoles =  User::role($rol->name)->get();
        $userHasRoles->load('personal');



        return view('roles/group-roles', compact('rol', 'personals', 'userHasRoles', 'headsRolUser', 'tab'));
    }


    public function addPersonGroup(Request $request, $idRol)
    {
        $user = User::find($request->user);

        $rol = Role::findOrFail($idRol);

        $user->assignRole($rol->name);

        return redirect('roles/grupos/' . $rol->id);
    }

    public function deletePersonGroup(Request $request, $idRol)
    {
        $usuario = User::find($request->id_user);
        $rol = Roles::find($idRol);
        $usuario->removeRole($rol->name);

        return redirect('roles/grupos/' . $rol->id);
    }



    public function validateForm($request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $id,

        ]);
    }
}
