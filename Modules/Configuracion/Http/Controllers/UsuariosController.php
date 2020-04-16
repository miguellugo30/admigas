<?php

namespace Modules\Configuracion\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
/**
 * Modelos
 */
use App\User;
use App\AdmigasCatModulos;
use Modules\Configuracion\Http\Requests\UsuariosRequest;
use Spatie\Permission\Models\Role;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        /**
         * Obtenemos todos los usuarios dados de alta
         */
        $users = User::all();

        return view('configuracion::usuarios.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        /**
         * Obtenemos todos los roles del sistema
         */
        $roles = Role::all();
        /**
         * Obtenemos todas los modulos del sistema
         */
        $modulos = AdmigasCatModulos::active()->with('Menus')->get();

        return view('configuracion::usuarios.create', compact('roles', 'modulos'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(UsuariosRequest $request)
    {
        /**
         * Obtenemos todos los datos del formulario de alta
         */
        $input = $request->all();
        /**
         * Encriptamos la contrasenia
         */
        $input['password'] = Hash::make($input['password']);
        /**
         * Insertamos la informacion del formulario
         */
        $user = User::create($input);
        /**
         * Asignamos el rol elegido
         */
        $user->assignRole( $request->input('rol') );
        /**
         * Asignamos las categorias al usuario
         */
        $user->syncPermissions( $request->input('arr'));
        /**
         * Limpiamos la cache
         */
        Artisan::call('cache:clear');
       /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('usuarios.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('configuracion::usuarios.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        /**
         * Obtenemos la información del usuario a editar
         */
        $user = User::findOrFail( $id );
        /**
         * Obtenemos todos los roles
         */
        $roles = Role::all();
        /**
         * Obtenemos todas los modulos del sistema
         */
        $modulos = AdmigasCatModulos::active()->with('Menus')->get();

        return view('configuracion::usuarios.edit', compact('roles', 'user', 'modulos'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(UsuariosRequest $request, $id)
    {
        /*
         * Si el pass, viene vacio no lo actualizamos
         */
         if ($request->password != NULL )
         {
            $user = User::where( 'id', $id )
                                            ->update([
                                                'name' => $request->name,
                                                'email'   => $request->email,
                                                'password' => Hash::make( $request->password )
                                                ]);
        }
        else
        {
            $user = User::where( 'id', $id )
                                            ->update([
                                                'name' => $request->name,
                                                'email'   => $request->email
                                                ]);
        }
        /**
         * Se valida si el usuario ya cuenta con ese rol,
         * Si no se renueve el rol y se le asigna el nuevo
         */
        $user = User::find( $id );
        $user->syncRoles([ $request->rol ]);

        /**
         * Eliminamos los menus que tiene el usuario
         * y le asignamos las nuevas seleccionada
         */
        $user->syncPermissions( $request->input('arr'));
        /**
         * Limpiamos la cache
         */
        Artisan::call('cache:clear');
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('usuarios.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        /**
         * Eliminadmos el usuarios
         */
        User::destroy($id);
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('usuarios.index');
    }
}
