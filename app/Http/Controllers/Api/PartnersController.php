<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Partners;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PartnersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return  Partners::all();
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
            $fileName = 'notification_' . $request->az_name . ".png";
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'string|max:150000',
                'image' => 'required|image|mimes:jpeg,jpg,png,gif',
                'url' => 'url',
            ]);
            if ($validator->fails()) {
                return response(['error' => $validator->errors()], 422);
            }

            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'image' => $fileName,
                'url' => $request->url,
            ];
            Partners::create($data);
            $request->file('image')->storeAs('/', $fileName, 'public');
            return response(['success' => 'Successfully added'], 200);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = Partners::where("id", $id)->first();
            if ($data != null) {
                return $data;
            } else {
                return response(['error' => 'Data is not found'], 404);
            }
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
            $fileName = 'notification_' . $request->az_name . ".png";
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'string|max:150000',
                'image' => 'image|mimes:jpeg,jpg,png,gif',
                'url' => 'url',
            ]);
            if ($validator->fails()) {
                return response(['error' => $validator->errors()], 422);
            }
            if (isset($request->image)) {
                $request->file('image')->storeAs('/', $fileName, 'public');

                $data = [
                    'name' => $request->name,
                    'description' => $request->description,
                    'image' => $fileName,
                    'url' => $request->url,
                ];
            } else {
                $data = [
                    'name' => $request->name,
                    'description' => $request->description,
                    'url' => $request->url,
                ];
            }
            Partners::where('id', $id)->update($data);
            return response(['success' => 'Successfully updated'], 200);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Partners::where("id", $id)->delete();
            return response(['success' => 'Successfully deleted'], 200);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }
}
