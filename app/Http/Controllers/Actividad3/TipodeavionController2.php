<?php

namespace App\Http\Controllers\Actividad3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Tipo_de_avion;
use Illuminate\Support\Facades\Http;

class TipodeavionController2 extends Controller
{
    //
       //
       public function create(Request $request)
       {
           Log::channel('slack')->info("Algo esta sucediendo en la tabla conductor",[$request]);
           $validacion = Validator::make(
               $request->all(),
               [
                   'id_piloto'=>"required",
                   'Airolinea'=>"required"
                   
                   
   
               ]);
               if ($validacion->fails())
               {
                   return response()->json(["status"=>400,"message"=>$validacion->errors(),"data"=>[]],400);
               }
            //    if($request->ip()=="25.63.10.104"){
            //        $response = Http::post('http://25.62.178.77:8000/api/conductor/crear3',
            //        [
            //           "id_piloto"=>$request->id_piloto,
            //           "Airolinea"=>$request->Airolinea
            //        ] );
            //        }
               $aviom = new Tipo_de_avion();
               $aviom->id_piloto=$request->id_piloto;
               $aviom->Airolinea=$request->Airolinea;
               
               
               $aviom->save;
   
               if ($aviom->save())
               return response()->json([
   
   "status"=>200,
   "message"=>"datos almcenados",
   "error"=>[],
   "data"=>$request->all()
   
   
               ]);
       }
   public function index3(Request $request)
   {
       //ver
       $aviom=DB::table('tipo_de_avions')->get()->all();
       return response()->json(["table"=>"CONDUCTORES",$aviom]);
   }
   
   public function update(Request $request, $id)
   {
   $aviom = Validator::make($request->all(),[
       'id_piloto'=>"required",
       'Airolinea'=>"required"
   ]);
   if($aviom->fails()){
   return response()->json([
       "Error"=>$aviom->errors()
   ],400);
   }
   
   
   $aviom = Tipo_de_avion::find($id);
//    if($request->ip()=="25.63.10.104"){
//        $response = Http::put('http://25.62.178.77:8000/api/conductor/actualizar3/'.$id,
//        [
//            "id_piloto"=>$request->id_piloto,
//            "Airolinea"=>$request->Airolinea,
           
           
         
//        ] );
//        }
      
   $aviom->id_piloto=$request->id_piloto;
   $aviom->Airolinea=$request->Airolinea;
   $aviom->status=1;
   $aviom->save;
   
   if ($aviom ->save()){
   return response()->json([
       "status"=>201,
       "mgs"=>" Se ha guardado exitosamente",
       "error"=>null,
       "data" =>$aviom
   ]);
   }
   
   }
   public function delete(Request $request, int $id)
   {
   $aviom = Tipo_de_avion::find($id); 
//    if($request->ip()=="25.63.10.104"){
//        $response = Http::delete('http://25.62.178.77:8000/api/conductor/borrar3/'.$id);
//    }
   if ($aviom){
       $aviom ->status = false; 
       $aviom ->save();
       return response()->json([
           "status"=>200,
           "msg"=>"Se ha eliminado correctamente",
           "error"=>null,
           "data"=>$aviom,
       ]);
   }
   }

   
public function show($id)
{
    $conductor = Tipo_de_avion::find($id);

    if (!$conductor) {
        return response()->json(['error' => 'Conductor no encontrado'], 404);
    }

    return response()->json($conductor);
}

}
