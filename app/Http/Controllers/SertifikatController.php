<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use App\Models\setifikat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SertifikatController extends Controller
{
    public function storeSertifikat(Request $request){
        $validator = Validator::make($request->all(),[
            'file' => 'required',
            'link' => 'required|url',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::createResponse(400,'Validasi Gagal',$validator->messages());
        }
        
        try {
            $file = $request->file('file');
            foreach($file as $files){
                $imageName = time().'.'.$files->extension();
                $imagePath = $files->store('sertifikat','public');
        
                $files->move($imagePath, $imageName);
            }
            
            setifikat::create([
                'link' => $request->link,
                'nameCertificate' => $request->name,
                'image' => $imagePath,
            ]);
    
            return Response::createResponse(201,'Data Portfolio Berhasil di Input',[$request->name,$imagePath]);
        } catch (\Throwable $th) {
            return Response::createResponse(500,$th->getMessage());
        }
    }
}
