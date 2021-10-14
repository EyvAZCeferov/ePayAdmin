<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductsCollection;
use App\Models\Product_Viewer;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return new ProductsCollection(Products::with(['customer',])->paginate(10));
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
            $fileName = 'product_' . $request->az_name . ".png";
            $validator = Validator::make($request->all(), [
                'az_name' => 'required|string|max:255',
                'ru_name' => 'required|string|max:255',
                'en_name' => 'required|string|max:255',
                'az_description' => 'string|max:150000',
                'ru_description' => 'string|max:150000',
                'en_description' => 'string|max:150000',
                'picture' => 'required|image|mimes:jpeg,jpg,png,gif',
                'code' => 'string|max:100',
                'barcode' => 'required|string|max:120',
                'price' => 'required',
                'customer_id' => 'required|integer',
                'enabled' => 'required|boolean'
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
                'az_description' => $request->az_description ?? '',
                'ru_description' => $request->ru_description ?? '',
                'en_description' => $request->en_description ?? '',
            ];
            $category = [
                'home_cat' => $request->home_cat ?? '',
                'first_child_cat' => $request->first_child_cat ?? '',
                'second_child_cat' => $request->second_child_cat ?? '',
                'three_child_cat' => $request->three_child_cat ?? '',
            ];
            $seo_urls = [
                'az_seo_url' => Str::slug($request->az_name),
                'ru_seo_url' => Str::slug($request->ru_name),
                'en_seo_url' => Str::slug($request->en_name),
            ];
            $data = [
                'names' => json_encode($names),
                'descriptors' => json_encode($desciptors),
                'picture' => $fileName,
                'seo_urls' => json_encode($seo_urls),
                'code' => $request->code,
                'barcode' => $request->barcode,
                'category' => json_encode($category),
                'price' => floatval($request->price),
                'seo_urls' => json_encode($seo_urls),
                'customer_id' => $request->customer_id,
                'enabled' => $request->enabled
            ];
            Products::create($data);
            $request->file('picture')->storeAs('/', $fileName, 'public');
            return response(['success' => 'Successfully added'], 200);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()]);
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
            $data = Products::where("id", $id)->first();
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
            $fileName = 'product_' . $request->az_name . ".png";
            $validator = Validator::make($request->all(), [
                'az_name' => 'required|string|max:255',
                'ru_name' => 'required|string|max:255',
                'en_name' => 'required|string|max:255',
                'az_description' => 'string|max:150000',
                'ru_description' => 'string|max:150000',
                'en_description' => 'string|max:150000',
                'picture' => 'image|mimes:jpeg,jpg,png,gif',
                'code' => 'string|max:100',
                'barcode' => 'required|string|max:120',
                'price' => 'required',
                'customer_id' => 'required|integer',
                'enabled' => 'required|boolean'
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
                'az_description' => $request->az_description ?? '',
                'ru_description' => $request->ru_description ?? '',
                'en_description' => $request->en_description ?? '',
            ];
            $category = [
                'home_cat' => $request->home_cat ?? '',
                'first_child_cat' => $request->first_child_cat ?? '',
                'second_child_cat' => $request->second_child_cat ?? '',
                'three_child_cat' => $request->three_child_cat ?? '',
            ];
            $seo_urls = [
                'az_seo_url' => Str::slug($request->az_name),
                'ru_seo_url' => Str::slug($request->ru_name),
                'en_seo_url' => Str::slug($request->en_name),
            ];
            if (isset($request->picture)) {
                $request->file('picture')->storeAs('/', $fileName, 'public');

                $data = [
                    'names' => json_encode($names),
                    'descriptors' => json_encode($desciptors),
                    'picture' => $fileName,
                    'seo_urls' => json_encode($seo_urls),
                    'code' => $request->code,
                    'barcode' => $request->barcode,
                    'category' => json_encode($category),
                    'price' => floatval($request->price),
                    'seo_urls' => json_encode($seo_urls),
                    'customer_id' => $request->customer_id,
                    'enabled' => $request->enabled
                ];
            } else {
                $data = [
                    'names' => json_encode($names),
                    'descriptors' => json_encode($desciptors),
                    'seo_urls' => json_encode($seo_urls),
                    'code' => $request->code,
                    'barcode' => $request->barcode,
                    'category' => json_encode($category),
                    'price' => floatval($request->price),
                    'seo_urls' => json_encode($seo_urls),
                    'customer_id' => $request->customer_id,
                    'enabled' => $request->enabled
                ];
            }
            Products::where('id', $id)->update($data);
            return response(['success' => 'Successfully updated'], 202);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()]);
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
            Products::where("id", $id)->delete();
            return response(['success' => 'Successfully deleted'], 200);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }

    public function recycle()
    {
        try {
            return new ProductsCollection(Products::with(['customer'])->onlyTrashed()->paginate(50));
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }

    public function harddelete($id)
    {
        try {
            Products::where("id", $id)->onlyTrashed()->forceDelete();
            return response(['success' => 'Successfully deleted'], 200);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }

    public function view_product(Request $request, $campaign_id)
    {
        try {
            $data = [
                "user_id" => $request->user()->id,
                "campaign_id" => $campaign_id,
            ];
            Product_Viewer::create($data);
            return response(['success' => 'Successfully Viewed'], 200);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }
}
