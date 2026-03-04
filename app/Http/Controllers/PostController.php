<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Support\Carbon;

class PostController extends Controller
{
    
    public function index(){
        
        return view('Post.show'); 

    }

    public function getJsonData()
    {
        // 1. Consultamos MySQL
        $posts = Post::select('id', 'title', 'categoria', 'content', 'created_at', 'updated_at')->get();
        
        // 2. RETORNAMOS JSON (Esto es lo que Axios entiende)
        return response()->json($posts);
    }

    //Ingresa los datos
    public function store(Request $request){

        try {

            // 1. Validar los datos
            $validatedData = $request->validate([
                'title' => 'required|string|max:255|unique:posts,title',
                'categoria' => 'required|string|max:255',
                'content' => 'required|string|max:255',
            ]);

            $post = Post::create($validatedData); 

            return response()->json([
                'success' => true,
                'message' => 'Post guardado correctamente',
                'data' => $post // Es buena práctica devolver el objeto creado
            ], 201); // 201 significa "Created"

        } catch (QueryException $e) {

            // Error de validación
            return response()->json([
                'success' => false,
                'errors'  => $e->errors() // Devuelve qué campos fallaron
            ], 422); // 422 = Unprocessable Entity

        } catch (\Exception $e) {

            // Error general
            return response()->json([
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage()
            ], 500); // 500 = Server Error

        }

    }

    //Modifica los datos
    public function update(Request $request, Post $post){

        try {

            //Validar datos
            $validated = $request->validate([
                'categoria' => 'required|string|max:255',
                'content' => 'required|string|max:255',
            ]);

            // Agregamos la fecha actual al array antes de actualizar
            $validated['updated_at'] = Carbon::now(); 

            $post->update($validated);

            return response()->json([
                'success' => true, 
                'message' => 'Post actualizado'
            ], 200); // 200 = Todo OK

        } catch (\Illuminate\Validation\ValidationException $e) {

            // Error de validación
            return response()->json([
                'success' => false,
                'errors'  => $e->errors() // Devuelve qué campos fallaron
            ], 422); // 422 = Unprocessable Entity

        }catch (\Exception $e) {

            // Error general
            return response()->json([
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage()
            ], 500); // 500 = Server Error

        }

    }

    //Consulta el registro
    public function show($id){

        $Post = Post::find($id);
        return $Post;

    }

    //Eliminar registros
    public function destroy($id){

        try {

            $item = Post::findOrFail($id);

             if (!$item) {
                return response()->json([
                    'success' => 'error',
                    'message' => 'El registro no existe'
                ], 404); // Código 404: Not Found
            }

            $item->delete();

            return response()->json([
                'success' => true,
                'message' => 'Registro eliminado correctamente',
                'id_eliminado' => $id
            ], 200); // Código 200: OK


        } catch (\Illuminate\Validation\ValidationException $e) {

            // Error de validación
            return response()->json([
                'success' => false,
                'errors'  => $e->errors() // Devuelve qué campos fallaron
            ], 422); // 422 = Unprocessable Entity

        }catch (\Exception $e) {

            // Error general
            return response()->json([
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage()
            ], 500); // 500 = Server Error

        }

    }

}
