<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\example\EjemploController;
use App\Http\Controllers\Actividad2\ConductoreController;
use App\Http\Controllers\Actividad2\HospitalController;
use App\Http\Controllers\Actividad2\SeguroController;
use App\Http\Controllers\Actividad3\chefController2;
use App\Http\Controllers\Actividad3\SeguroController2;
use App\Http\Controllers\Actividad3\YordiHospitalController2;
use App\Http\Controllers\Actividad3\yordiConductorController;
use Illuminate\Support\Facades\URL;
use App\Jobs\email;
use App\Jobs\sms;

use App\Http\Controllers\Actividad3\ingredienteController2;
use App\Http\Controllers\Actividad3\recetaController2;
use App\Http\Controllers\Actividad3\TipodeavionController2;
use App\Http\Controllers\Actividad3\tipoPlatoController2;
use App\Http\Controllers\ingredienteController;
use App\Http\Controllers\chefController;
use App\Http\Controllers\recetaController;
use App\Http\Controllers\tipoPlatoController;
use App\Http\Controllers\Actividad2\TipodeavionController;
use App\Http\Controllers\User\UsuarioController;
use App\Http\Controllers\SmsController;
use App\Http\Middleware\validacioninfo;


use App\Models\Conductor;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum','role:Administrador'])->group(function(){
Route::get('/api/users', function () {
    $users = \App\Models\User::all();
    return response()->json($users);
});


Route::put('/api/users/{id}', function ($id) {
    $user = \App\Models\User::findOrFail($id);

    // Validar los datos del usuario que se van a actualizar
    $validatedData = request()->validate([
        'name' => 'required|max:255',
        'email' => 'required|email|unique:users,email,'.$user->id,
        'password' => 'nullable|min:8',
    ]);

    $user->update($validatedData);

    return response()->json([
        'message' => 'Usuario actualizado exitosamente.',
        'user' => $user,
    ]);
});
});



Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/conductor",[ConductoreController::class,"index"]);
Route::post("/conductor/crear",[ConductoreController::class,"create"]);
Route::put("/conductor/actualizar/{id?}",[ConductoreController::class,"update"])->where("id","[0-9]+");
Route::delete("/conductor/borrar/{id?}",[ConductoreController::class,"delete"])->where("id","[0-9]+");


Route::get("/validacionConductor", function () {return response()->json(['message' => 'bienvenido','status'=>200], 200);})->middleware(['auth:sanctum','role:Administrador,Usuario']); 
Route::middleware(['auth:sanctum','role:Administrador,Usuario'])->group(function(){



 Route::get("/conductoryordi",[yordiConductorController::class,"index"]);
 Route::post("/conductor/crearyordi",[yordiConductorController::class,"create"]);
 Route::put("/conductoryordi/actualizar/{id?}",[yordiConductorController::class,"update"])->where("id","[0-9]+");
 Route::get('conductor/{id}',[yordiConductorController::class,"show"])->where("id","[0-9]+");

 Route::put('/conductor/activar/{id?}',[yordiConductorController::class,"activar"])->where("id","[0-9]+");

 Route::delete("/conductoryordi/borrar/{id?}",[yordiConductorController::class,"delete"])->where("id","[0-9]+");
});
 //-----------------------------------------------------------------------------------------------------------------------

Route::get("/conductor/info1",[HospitalController::class,"inde3"]);
Route::post("/conductor/crear1",[HospitalController::class,"create"]);
Route::put("/conductor/actualizar1/{id?}",[HospitalController::class,"update"])->where("id","[0-9]+");
Route::delete("/conductor/borrar1/{id?}",[HospitalController::class,"delete"])->where("id","[0-9]+");

Route::middleware(['auth:sanctum','role:Administrador'])->group(function(){
    Route::get("/validacionHospital", function () {
        return response()->json(['message' => 'bienvenido','status'=>200], 200);
    });

Route::get("/conductoryordi/info1",[YordiHospitaController2::class,"inde3"]);
Route::post("/conductoryordi/crear1",[YordiHospitalController2::class,"create"]);
Route::put("/conductoryordi/actualizar1/{id?}",[YordiHospitalController2::class,"update"])->where("id","[0-9]+");
Route::delete("/conductoryordi/borrar1/{id?}",[YordiHospitalController2::class,"delete"])->where("id","[0-9]+");

});

//-------------------------------------------------------------------------------------------------------------------

Route::get("/conductor/info2",[SeguroController::class,"index3"]);
Route::post("/conductor/crear2",[SeguroController::class,"create"]);
Route::put("/conductor/actualizar2/{id?}",[SeguroController::class,"update"])->where("id","[0-9]+");
Route::delete("/conductor/borrar2/{id?}",[SeguroController::class,"delete"])->where("id","[0-9]+");

Route::middleware(['auth:sanctum','role:Administrador,Usuario'])->group(function() {
    Route::get("/validacionseguro", function (Request $request) {
        return response()->json(['message' => 'bienvenido','status'=>200], 200);
    });


Route::get("/conductoryordi/info2",[SeguroController2::class,"inde3"]);
Route::post("/conductoryordi/crear2",[SeguroController2::class,"create"]);
Route::put("/conductoryordi/actualizar2/{id?}",[SeguroController2::class,"update"])->where("id","[0-9]+");
Route::delete("/conductoryordi/borrar2/{id?}",[SeguroController2::class,"delete"])->where("id","[0-9]+");
});
//----------------------------------------------------------------------------------------------------------------------
Route::get("/conductor/info3",[TipodeavionController::class,"index3"]);

Route::post("/conductor/crear3",[TipodeavionController::class,"create"]);
Route::put("/conductor/actualizar3/{id?}",[TipodeavionController::class,"update"])->where("id","[0-9]+");
Route::delete("/conductor/borrar3/{id?}",[TipodeavionController::class,"delete"])->where("id","[0-9]+");

Route::middleware(['auth:sanctum','role:Administrador,Usuario'])->group(function(){
    Route::get("/validaciontipoavion ", function () {
        return response()->json(['message' => 'bienvenido','status'=>200], 200);
    });

Route::get("/conductoryordi/info3",[TipodeavionController2::class,"index3"]);
Route::get('avion/{id}',[TipodeavionController2::class,"show"])->where("id","[0-9]+");
Route::post("/conductoryordi/crear3",[TipodeavionController2::class,"create"]);
Route::put("/conductoryordi/actualizar3/{id?}",[TipodeavionController2::class,"update"])->where("id","[0-9]+");
Route::delete("/conductoryordi/borrar3/{id?}",[TipodeavionController2::class,"delete"])->where("id","[0-9]+");
});
//----------------------------------------------------------------------------------------


Route::post("/chef",[chefController::class,"create"]);
Route::get("/chef/info",[chefController::class,"info"]);
Route::put("/chef/update/{id}",[chefController::class,"update"])->where('id',"[0-9]+");
Route::delete("/chef/delete/{id}",[chefController::class,"delete"]);

Route::middleware(['auth:sanctum','role:Administrador,Usuario'])->group(function(){
    
    Route::get("/validacioncheef ", function () {
        return response()->json(['message' => 'bienvenido','status'=>200], 200);
    });
Route::post("/chefyordi",[chefController2::class,"create"]);
Route::get("/chef/infoyordi",[chefController2::class,"info"]);
Route::put("/chef/updateyordi/{id}",[chefController2::class,"update"])->where('id',"[0-9]+");
Route::delete("/chef/deleteyordi/{id}",[chefController2::class,"delete"]);

});

//---------------------------------------------------------------------------------------------

Route::post("/receta",[recetaController::class,"create"]);
Route::get("/receta/info",[recetaController::class,"info"]);
Route::put("/receta/update/{id}",[recetaController::class,"update"])->where('id',"[0-9]+");

Route::middleware(['auth:sanctum','role:Administrador,Usuario'])->group(function(){
    Route::get("/validacionreceta ", function () {
        return response()->json(['message' => 'bienvenido','status'=>200], 200);
    });

Route::post("/recetayordi",[recetaController2::class,"create"]);
Route::get("/receta/infoyordi",[recetaController2::class,"info"]);
Route::put("/receta/updateyordi/{id}",[recetaController2::class,"update"])->where('id',"[0-9]+");
});

//------------------------------------------------------------------------------------------------

Route::post("/ingrediente",[ingredienteController::class,"create"]);
Route::get("/ingrediente/info",[ingredienteController::class,"info"]);
Route::put("/ingrediente/update/{id}",[ingredienteController::class,"update"])->where('id',"[0-9]+");

Route::middleware(['auth:sanctum','role:Administrador,invitado,Usuario'])->group(function(){
    
    Route::get("/validacionIngredinet ", function () {
        
        return response()->json(['message' => 'bienvenido','status'=>200], 200);

    });
Route::post("/ingredienteyordi",[ingredienteController2::class,"create"]);
Route::get("/ingredienteyordi/info",[ingredienteController2::class,"info"]);
Route::put("/ingredienteyordi/update/{id}",[ingredienteController2::class,"update"])->where('id',"[0-9]+");
});

//------------------------------------------------------------------------------------------------------
//mi propia enviar datos a yordi

Route::post("/tipo_plato",[tipoPlatoController::class,"create"]);
Route::put("/tipo_plato/update/{id}",[tipoPlatoController::class,"update"])->where('id',"[0-9]+");
Route::get("/tipo_plato/info",[tipoPlatoController::class,"info"]);


//tipo plato para mi base de datos
Route::middleware(['auth:sanctum','role:Administrador,invitado'])->group(function(){

    Route::get("/validaciontipoplato ", function () {
        return response()->json(['message' => 'bienvenido','status'=>200], 200);
    });
    Route::post("/tipo_platoyordi",[tipoPlatoController2::class,"create"]);
Route::put("/tipo_platoyordi/update/{id}",[tipoPlatoController2::class,"update"])->where('id',"[0-9]+");
Route::get("/tipo_platoyoerdi/info",[tipoPlatoController2::class,"info"]);

});

Route::post("/user/regis",[UsuarioController::class,'crearusuario']);
Route::delete("/cerrar",[UsuarioController::class,'logout'])->middleware('auth:sanctum');


Route::post("/user/registraryordi",[UsuarioController::class,'irayordi']);
Route::post("/user/registro",[UsuarioController::class,'InicioSesion']);

   
   Route::post("/telefonoregistr",[UsuarioController::class,"registrarSMS"])->name('telefonoregistr');
   Route::get("/validarnumero/{url}",[UsuarioController::class,"numerodeverificacionmovil"])->name('validarnumero');

   //Route::Post