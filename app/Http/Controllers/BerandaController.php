<?php
    
namespace App\Http\Controllers;

use App\Models\aboutme;
use App\Helpers\Response;
use App\Models\portofolio;
use App\Models\setifikat;

class BerandaController extends Controller
{
    public function beranda(){
        try {
            $data = [
                'url' => env('APP_URL').'/storage/',
                'dataPortfolio' => portofolio::paginate(6),
                'aboutMe' => aboutme::all()->take(1),
                'dataSertifikat' => setifikat::paginate(6),
            ];
            return Response::createResponse(200,'PENGAMBILAN DATA',$data);
        } catch (\Throwable $th) {
            return Response::createResponse(500,$th->getMessage());
        }
    }
}
