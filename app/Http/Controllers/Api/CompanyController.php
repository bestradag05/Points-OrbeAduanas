<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Company\CompanyCollection;
use App\Http\Resources\Company\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $ruc = $request->search;

        $companys = Company::where("ruc","like","%".$ruc."%")->orderBy("id","desc")->get();

        return response()->json([
            "companys" => CompanyCollection::make($companys),
        ]);

        // return response()->json([
        //     "companys" => $companys->map(function($company) {
        //         return [
        //             "id" => $company->id,
        //             "ruc" => $company->ruc,
        //             "business_name" => $company->business_name,
        //             "manager" => $company->manager,
        //             "phone" => $company->phone,
        //             "email" => $company->email,
        //             "imagen" => $company->imagen,
        //             "user_register" => $company->user_register,
        //             "date_register" => $company->date_register,
        //             "user_update" => $company->user_update,
        //             "date_update" => $company->date_update,
        //             "estate" => $company->estate,
        //         ];
        //     }),
        // ]);
    }

    public function create()
    {

    }
    public function store(Request $request)
    {
        $exist_company = Company::where("ruc", $request->ruc)->first();

        if($exist_company){
            return response()->json([
                "message" => 403,
                "message_text" => "EL RUC DE LA EMPRESA YA EXISTE"
            ]);
        }

        if($request->hasFile("imagen")){
            $path = Storage::putFile("companys",$request->file("imagen"));
            $request->request->add(["avatar" => $path]);
        }

        $company = Company::create($request->all());
        //$company->update($request->all());
        //Company::create([
            //"ruc" => $request->ruc,
            //"business_name" => $request->business_name,
            //"manager" => $request->manager,
            //"phone" => $request->phone,
            //"email" => $request->email,
            //"imagen" => $request->imagen,
            //"user_register" => $request->user_register,
            //"date_register" => $request->date_register,
            //"user_update" => $request->user_update,
            //"date_update" => $request->date_update,
            //'state' => 'Activo'
        //]);

        return response()->json([
            "message" => 200,
        ]);
    }
    public function show(string $id)
    {
        $company = Company::findOrFail($id);
        return response()-> json ([
            "company" => CompanyResource::make($company),
        ]);
        //return response()->json([
            //"id" => $company->id,
            //"ruc" => $company->ruc,
            //"business_name" => $company->business_name,
            //"manager" => $company->manager,
            //"phone" => $company->phone,
            //"email" => $company->email,
            //"imagen" => $company->imagen,
            //"user_register" => $company->user_register,
            //"date_register" => $company->created_at->format("Y-m-d h:i:s"),
            //"user_update" => $company->user_update,
            //"date_update" => $company->date_update,
            //"state" => $company->state
        //]);
    }
    public function edit(string $id)
    {

    }
    public function update(Request $request, string $id)
    {
        $is_company = Company::where("id","<>",$id)->where("ruc",$request->ruc)->first();

        if($is_company){
            return response()->json([
                "message" => 403,
                "message_text" => "EL RUC DE LA EMPRESA YA EXISTE"
            ]);
        }

        $company = Company::findOrFail($id);

        if($request->hasFile("imagen")){
            if($company->avatar){
                Storage::delete($company->avatar);
            }
            $path = Storage::putFile("companys",$request->file("imagen"));
            $request->request->add(["avatar" => $path]);
        }

        $company->update($request->all());
        return response()->json([
            "message" => 200,
        ]);
    }
    public function destroy(string $id)
    {
        $company = Company::findOrFail($id);
        if($company->avatar){
            Storage::delete($company->avatar);
        }
        $company->delete();
        return response()->json([
            "message" => 200,
        ]);
    }
}
