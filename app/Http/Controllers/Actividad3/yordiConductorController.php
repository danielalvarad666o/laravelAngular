<?php

namespace App\Http\Controllers\Actividad3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;   


use App\Models\Conductor;
use App\Models\Seguro;
use App\Models\Tipo_de_avion;



class yordiConductorController extends Controller
{
    //
    

    //create 
    public function create(Request $request)
    {
         
     //   Log::channel('slack')->info("Algo esta sucediendo en la tabla conductor",[$request]);
        $validacion = Validator::make(
            $request->all(),
            [
                'nombre'=>"required",
                'A_materno'=>"required",
                'A_paterno'=>"required",
                'edad'=>"required",

            ]);
            if ($validacion->fails())
            {
                return response()->json(["status"=>400,"message"=>$validacion->errors(),"data"=>[]],400);
            }
          
        
            $conductor = new Conductor();
            $conductor->nombre=$request->nombre;
            $conductor->A_materno=$request->A_materno;
            $conductor->A_paterno=$request->A_paterno;
            $conductor->edad=$request->edad;
            $conductor->save;
             
          
            if ($conductor->save())
            return response()->json([

"status"=>201,
"message"=>"datos almcenados",
"error"=>[],
"data"=>$request->all()


            ]);
    }
public function index(Request $request)
{
    //ver
    $conductor=DB::table('conductors')->get()->all();
    return response()->json(["table"=>"conductors",$conductor]);
}
public function activar($id)
{
    $conductor = Conductor::findOrFail($id);
    $conductor->status = 1;
    $conductor->save();
    
    return response()->json(['message' => 'Estado del conductor activado']);
}





public function show($id)
{
    $conductor = Conductor::find($id);

    if (!$conductor) {
        return response()->json(['error' => 'Conductor no encontrado'], 404);
    }

    return response()->json($conductor);
}










public function update(Request $request, $id)
{
$validacion = Validator::make($request->all(),[
    'nombre'=>"required",
    'A_materno'=>"required",
    'A_paterno'=>"required",
    'edad'=>"required",
]);
if($validacion->fails()){
return response()->json([
    "Error"=>$validacion->errors()
],400);
}

$conductor = Conductor::find($id);
$conductor->nombre=$request->nombre;
            $conductor->A_materno=$request->A_materno;
            $conductor->A_paterno=$request->A_paterno;
            $conductor->edad=$request->edad;
            $conductor->save;


if ($conductor ->save()){
return response()->json([
    "status"=>201,
    "mgs"=>" Se ha guardado exitosamente",
    "error"=>null,
    "data" =>$conductor
]);
}

}
public function delete(Request $request, int $id)
{
$conductor = Conductor::find($id); 

if ($conductor){
    $conductor ->status = false; 
    $conductor ->save();
    $aviones = Tipo_de_avion::where('id_piloto', $conductor->id)->get();
    foreach ($aviones as $avion) {
        $avion->status = false;
        $avion->save();
    }

    // Desactivar los seguros del conductor
    $seguros = Seguro::where('id_paciente', $conductor->id)->get();
    foreach ($seguros as $seguro) {
        $seguro->status = false;
        $seguro->save();
    }
    return response()->json([
        "status"=>200,
        "msg"=>"Se ha eliminado correctamente",
        "error"=>null,
        "data"=>$conductor,
    ]);
}
}
}
