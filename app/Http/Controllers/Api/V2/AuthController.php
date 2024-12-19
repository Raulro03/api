<?php


namespace App\Http\Controllers\Api\V2;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Realizar el login y devolver el token con habilidades personalizadas.
     */
    public function login(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);


        // Buscar el usuario por email
        $user = User::where('email', $request->email)->first();


        // Verificar la contraseña
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }


        // Obtener el nombre del rol, se asegura que no sea null
        $roleName = $user->role?->rol ?? 'guest';


        // Definir las habilidades para cada rol
        $roleAbilities = [
            'admin' => ['admin', 'crear_pedido', 'ver_pedidos', 'gestionar_taller'],
            'guest' => ['ver_pedidos'],
        ];


        // Asignar habilidades según el rol (si no existe, se asignan habilidades vacías)
        $abilities = $roleAbilities[$roleName] ?? [];


        // Eliminar tokens anteriores para asegurarse de que solo haya un token válido
        $user->tokens()->delete();


        // Crear el token con las habilidades personalizadas
        $token = $user->createToken('access-token', $abilities)->plainTextToken;


        return response()->json([
            'message' => 'Inicio de sesión exitoso',
            'token' => $token,
            'abilities' => $abilities,
            'user' => $user
        ]);
    }


    public function logout(Request $request)
    {
        // Verificar si el usuario está autenticado
        abort_if(!auth()->user(), 401, 'No se pudo cerrar la sesión. Usuario no autenticado.');


        // Eliminar todos los tokens de este usuario
        auth()->user()->tokens()->delete();


        return response()->json([
            'message' => 'Sesión cerrada con éxito'
        ], 200);
    }
}
