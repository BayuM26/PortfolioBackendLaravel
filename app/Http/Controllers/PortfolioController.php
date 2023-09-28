<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use App\Models\portofolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PortfolioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['getPortfolio']]);
    }

    public function storePortfolio(Request $request){
        $validation = Validator::make($request->all(),[
            'name' => 'required',
            'file' => 'required',
        ]);

        if ($validation->fails()) {
            return Response::createResponse(400,'Validasi Gagal',$validation->messages());
        }

        try {
            $file = $request->file('file')[0];
            $imageName = time().'.'.$file->extension();
            $imagePath = $file->store('portfolio','public');
    
            $file->move($imagePath, $imageName);
            
            portofolio::create([
                'portofolioName' => $request->name,
                'imagePortofolio' => $imagePath,
            ]);
    
            return Response::createResponse(200,'Data Portfolio Berhasil di Input',[$request->name,$imagePath]);
        } catch (\Throwable $th) {
            return Response::createResponse(500,$th->getMessage(),$request);
        }
    }

    public function getPortfolio(){
        try {
            $portfolio = portofolio::paginate(10);
    
            if ($portfolio->isEmpty()) {
                return Response::createResponse(400,'Data Portfolio Kosong');
            }
            
            $data = [
                'url' => env('APP_URL').'/storage/',
                'dataPortfolio' => $portfolio,
            ];
    
            return Response::createResponse(200,'Get Data Portfolio',$data);
        } catch (\Throwable $th) {
            return Response::createResponse(500,$th->getMessage());
        }
    }

    public function deletePortFolio(){
        try {
            $portfolio = portofolio::where('id',request('i'))->get();
            foreach ($portfolio as $getValue) {
                Storage::delete([$getValue->imagePortofolio]);
            }
            $deletePortfolio = portofolio::where('id',request('i'))->delete();
            return Response::createResponse(200,'DATA BERHASIL DI HAPUS',$deletePortfolio);   
        } catch (\Throwable $th) {
            return Response::createResponse(500,$th->getMessage());
        }

    }
}
