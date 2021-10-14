<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShopBagsCollection;
use App\Models\ShopBags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShopBagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            return new ShopBagsCollection($request->user()->bags);
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
                'user_id' => 'required|integer',
                'type' => 'required|integer',
                'product_id' => 'required|integer',
                'qyt' => 'required'
            ]);

            if ($validator->fails()) {
                return response(['error' => $validator->errors()], 422);
            }

            if (ShopBags::where("user_id", $request->user()->id)->where("product_id", $request->product_id)->first() != null) {
                $this->update($request, ShopBags::where("user_id", $request->user()->id)->where("product_id", $request->product_id)->first()->id);
            } else {
                $data = [
                    'user_id' => $request->user()->id,
                    'type' => $request->type,
                    'product_id' => $request->product_id,
                    'qyt' => floatval($request->qyt)
                ];
                ShopBags::create($data);

                return response(['success' => 'Successfully added'], 200);
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

            $oldQyt = ShopBags::where("user_id", $request->user()->id)->where("product_id", $request->product_id)->first()->qyt;

            $data = [
                'user_id' => $request->user()->id,
                'type' => $request->type,
                'product_id' => $request->product_id,
                'qyt' => floatval($oldQyt) + floatval($request->qyt),
            ];
            ShopBags::where('id', $id)->update($data);

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
    public function destroy(Request $request, $id)
    {
        try {
            ShopBags::where("id", $id)->where("user_id", $request->user()->id)->delete();
            return response(['success' => 'Successfully deleted'], 200);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }
}
