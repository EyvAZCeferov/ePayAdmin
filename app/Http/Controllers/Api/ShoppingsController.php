<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Shoppings as ResourcesShoppings;
use App\Http\Resources\ShoppingsCollection;
use App\Models\Products;
use App\Models\ShopBags;
use App\Models\Shopping_items;
use App\Models\Shoppings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShoppingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            return new ShoppingsCollection(Shoppings::with([
                'user', 'customer', 'location', 'card',
                'products'
            ])->where("user_id", $request->user()->id)->where('payed', true)->get());
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
                'type' => 'integer|required',
                'payed' => 'boolean',
                'shopping_address' => 'string',
                'pay_type' => 'boolean',
                'qrcode' => 'string',
                'barcode' => 'string',
                'customer_id' => 'integer|required',
                'location_id' => 'integer|required',
                'card_id' => 'integer|required',
                'user_id' => 'integer|required',
            ]);
            if ($validator->fails()) {
                return response(['error' => $validator->errors()], 422);
            }

            $data = [
                'type' => $request->type,
                'payed' => $request->payed,
                'shipping_address' => $request->shipping_address,
                'pay_type' => $request->pay_type,
                'qrcode' => $request->qrcode,
                'barcode' => $request->barcode,
                'user_id' => $request->user()->id ?? null,
                'customer_id' => $request->customer_id ?? null,
                'location_id' => $request->location_id ?? null,
                'card_id' => $request->card_id ?? null,
            ];

            Shoppings::create($data);

            $shopping_items = ShopBags::where('user_id', $request->user()->id)->where("type", 1)->get();
            foreach ($shopping_items as $item) {
                $pro = Products::where('id', $item->id)->first();
                $names = json_decode($pro->names);
                $dat = [
                    'user_id' => $request->user()->id,
                    'shopping_id' => Shoppings::latest()->first()->id,
                    'product_id' => $item->id,
                    'name' => $names->az_name,
                    'code' => $pro->code,
                    'barcode' => $pro->barcode,
                    'price' => $pro->price,
                    'qyt' => $item->qyt,
                ];
                Shopping_items::create($dat);
            }

            return response(['success' => 'Successfully created Shopping'], 200);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shoppings  $shoppings
     * @return \Illuminate\Http\Response
     */
    public function show(Shoppings $shoppings)
    {
        try {
            $data = Shoppings::where("id", $shoppings)->with([
                'user', 'customer', 'location', 'card',
                'products'
            ])->first();
            if ($data != null) {
                return new ResourcesShoppings($data);
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
     * @param  \App\Models\Shoppings  $shoppings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $shoppings)
    {
        try {
            $validator = Validator::make($request->all(), [
                'type' => 'integer|required',
                'payed' => 'boolean',
                'shopping_address' => 'string',
                'pay_type' => 'boolean',
                'qrcode' => 'string',
                'barcode' => 'string',
                'customer_id' => 'integer|required',
                'location_id' => 'integer|required',
                'card_id' => 'integer|required',
                'user_id' => 'integer|required',
            ]);
            if ($validator->fails()) {
                return response(['error' => $validator->errors()], 422);
            }

            $data = [
                'type' => $request->type,
                'payed' => $request->payed,
                'shipping_address' => $request->shipping_address,
                'pay_type' => $request->pay_type,
                'qrcode' => $request->qrcode,
                'barcode' => $request->barcode,
                'user_id' => $request->user_id ?? null,
                'customer_id' => $request->customer_id ?? null,
                'location_id' => $request->location_id ?? null,
                'card_id' => $request->card_id ?? null,
            ];

            Shoppings::where('id', $shoppings)->update($data);
            return response(['success' => 'Successfully updated Shopping'], 200);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shoppings  $shoppings
     * @return \Illuminate\Http\Response
     */
    public function destroy($shoppings)
    {
        try {
            Shoppings::where("id", $shoppings)->delete();
            return response(['success' => 'Successfully deleted'], 200);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }

    public function recycle()
    {
        try {
            return new ShoppingsCollection(Shoppings::with([
                'user', 'customer', 'location', 'card',
                'products'
            ])->onlyTrashed()->paginate(10));
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }

    public function harddelete($shoppings)
    {
        try {
            Shoppings::where("id", $shoppings)->onlyTrashed()->forceDelete();
            return response(['success' => 'Successfully deleted'], 200);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }
}
