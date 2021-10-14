<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TermOfUse as ResourcesTermOfUse;
use App\Models\TermOfUse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TermOfUseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = TermOfUse::latest()->first();
            return new ResourcesTermOfUse($data);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'az_name' => 'required|string|max:255',
                'ru_name' => 'required|string|max:255',
                'en_name' => 'required|string|max:255',
                'az_description' => 'string|max:150000',
                'ru_description' => 'string|max:150000',
                'en_description' => 'string|max:150000',
            ]);
            if ($validator->fails()) {
                return response(['error' => $validator->errors()], 422);
            }
            $names = [
                'az_name' => $request->az_name,
                'ru_name' => $request->ru_name,
                'en_name' => $request->en_name,
            ];
            $desciptors = [
                'az_description' => $request->az_description,
                'ru_description' => $request->ru_description,
                'en_description' => $request->en_description,
            ];
            $data = [
                'names' => json_encode($names),
                'descriptors' => json_encode($desciptors),
            ];
            TermOfUse::create($data);
            return response(['success' => 'Successfully added'], 200);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'az_name' => 'required|string|max:255',
                'ru_name' => 'required|string|max:255',
                'en_name' => 'required|string|max:255',
                'az_description' => 'string|max:150000',
                'ru_description' => 'string|max:150000',
                'en_description' => 'string|max:150000',
            ]);
            if ($validator->fails()) {
                return response(['error' => $validator->errors()], 422);
            }
            $names = [
                'az_name' => $request->az_name,
                'ru_name' => $request->ru_name,
                'en_name' => $request->en_name,
            ];
            $desciptors = [
                'az_description' => $request->az_description,
                'ru_description' => $request->ru_description,
                'en_description' => $request->en_description,
            ];
            $data = [
                'names' => json_encode($names),
                'descriptors' => json_encode($desciptors),
            ];
            TermOfUse::where('id', $id)->update($data);
            return response(['success' => 'Successfully updated'], 200);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }
}
