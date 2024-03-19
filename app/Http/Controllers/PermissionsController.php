<?php

namespace App\Http\Controllers;

use App\Models\Permissions;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission as ModelsPermission;
use Spatie\Permission\Models\Role;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtenemos todos los permisos

        $permissions = Permissions::all();

        $heads = [
            'ID',
            'Nombre',
            'Acciones'
        ];
        

        return view('permissions/list-permissions', compact('permissions', 'heads'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Redireccionamos al formulario de crear un permisos

        return view('permissions/register-permissions');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       // Guardar el rol enviado desde el form

       try {

        $this->validateForm($request, null );
        
        Permissions::create([
            'name' => $request->name,
            'guard_name' => $request->name
        ]);

        return redirect('permissions');
        
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
        
        $permission = Permissions::findOrFail($id);
        return view('permissions.edit-permissions', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validateForm($request, $id);
        $permission = Permissions::find($id);

        $permission->name = $request->name;
        $permission->guard_name = $request->name;

        $permission->save();
        
        return redirect('permissions');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         //
         $permission = Permissions::find($id);
         $permission->delete();
 
          
         return redirect('permissions')->with('eliminar', 'ok');
    }

    public function templatePermissions($id) {
       
       $rol = Role::find($id);
       $permissions = ModelsPermission::all(['id', 'name', 'alias']);

       $tab = 'permissions';
     

        return view('roles/group-roles', compact('rol', 'tab', 'permissions'));
    }


    public function assingPermission($id_permission, $id_role){
        
        
        $rol = Role::find($id_role);
        $permission = Permissions::find($id_permission);

        $tab = 'permissions';
        $rol->givePermissionTo($permission->name);

        $permissions = Permissions::all(['id', 'name', 'alias']);

        return view('roles/group-roles', compact('rol', 'tab', 'permissions'));

    }


    public function removePermission($id_permission, $id_role){
        
        $rol = Role::find($id_role);
        $permission = Permissions::find($id_permission);

        $tab = 'permissions';
        $rol->revokePermissionTo($permission->name);


        $permissions = Permissions::all(['id', 'name', 'alias']);

        return view('roles/group-roles', compact('rol', 'tab', 'permissions'));

    }


    public function addAllPermissions($id_role, $modulo){
       
        $rol = Role::find($id_role);
        $tab = 'permissions';

        $permissions = Permissions::where('name', 'like', $modulo.'.%')->get();

        foreach ($permissions as $permission) {
            $rol->givePermissionTo($permission->name);
        }

        $permissions = Permissions::all(['id', 'name', 'alias']);

        return view('roles/group-roles', compact('rol', 'tab', 'permissions'));         

    }


    public function removeAllPermissions($id_role, $modulo){
       
        $rol = Role::find($id_role);
        $tab = 'permissions';

        $permissions = Permissions::where('name', 'like', $modulo.'.%')->get();

        foreach ($permissions as $permission) {
            $rol->revokePermissionTo($permission->name);
        }

        $permissions = Permissions::all(['id', 'name', 'alias']);

        return view('roles/group-roles', compact('rol', 'tab', 'permissions'));         

    }


    public function validateForm($request, $id){
        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $id,
            
        ]);
    
    }
}
