<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Shopping_itemsCollection;
use App\Models\Shopping_items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Shopping_itemsController extends Controller
{

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
                'shopping_id' => 'required|integer',
                'product_id' => 'required|integer',
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:100',
                'barcode' => 'required|string|max:120',
                'price' => 'required',
                'qyt' => 'required',
            ]);

            if ($validator->fails()) {
                return response(['error' => $validator->errors()], 422);
            }
            $dat = [
                'user_id' => $request->user()->id,
                'shopping_id' => $request->shopping_id,
                'product_id' => $request->product_id,
                'name' => $request->az_name,
                'code' => $request->code,
                'barcode' => $request->barcode,
                'price' => $request->price,
                'qyt' => $request->qyt,
            ];
            Shopping_items::create($dat);
            return response(['success' => 'Successfully added'], 200);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shopping_items  $shopping_items
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $shopping_items)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|integer',
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:100',
                'barcode' => 'required|string|max:120',
                'price' => 'required',
                'qyt' => 'required',
            ]);

            if ($validator->fails()) {
                return response(['error' => $validator->errors()], 422);
            }
            $dat = [
                'product_id' => $request->product_id,
                'name' => $request->az_name,
                'code' => $request->code,
                'barcode' => $request->barcode,
                'price' => $request->price,
                'qyt' => $request->qyt,
            ];
            Shopping_items::where('id', $shopping_items)->update($dat);
            return response(['success' => 'Successfully updated'], 200);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shopping_items  $shopping_items
     * @return \Illuminate\Http\Response
     */
    public function destroy($shopping_items)
    {
        try {
            Shopping_items::where("id", $shopping_items)->delete();
            return response(['success' => 'Successfully deleted'], 200);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }
}
