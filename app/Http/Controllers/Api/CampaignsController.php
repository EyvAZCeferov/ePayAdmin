<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CampaignsCollection;
use App\Http\Resources\Campaigns as CampaignsRes;
use App\Models\Campaigns;
use App\Models\Campaigns_Viewer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CampaignsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return new CampaignsCollection(Campaigns::with(['customer', 'views'])->paginate(15));
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
                'pictures.*' => 'required|image|mimes:jpeg,jpg,png,gif',
                'start_date' => 'date',
                'end_date' => 'date',
                'related_products' => 'json',
                'old_price' => 'between:0,99.99',
                'new_price' => 'between:0,99.99',
                'notify' => 'boolean',
                'customer_id' => 'integer'

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
            $seo_urls = [
                'az_seo_url' => Str::slug($request->az_name),
                'ru_seo_url' => Str::slug($request->ru_name),
                'en_seo_url' => Str::slug($request->en_name),
            ];
            $dates = [
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ];
            $prices = [
                'old_price' => $request->old_price,
                'new_price' => $request->new_price,
            ];
            $images = [];
            $ims = $request->file("pictures");
            foreach ($ims as $image) {
                $fileName = 'campaigns_' . $request->customer_id . '_' . $request->az_name . '_' . Str::slug(Str::random(16)) . ".png";
                $image->storeAs('/campaigns', $fileName, 'public');
                array_push($images, $fileName);
            }
            $data = [
                'names' => json_encode($names),
                'descriptors' => json_encode($desciptors),
                'seo_urls' => json_encode($seo_urls),
                'pictures' => json_encode($images),
                'dates' => json_encode($dates),
                'related_products' => json_encode($request->related_products),
                'prices' => json_encode($prices),
                'notify' => $request->notify,
                'customer_id' => $request->customer_id,
                'notify' => $request->notify ?? false
            ];
            Campaigns::create($data);
            return response(['success' => 'Successfully added'], 200);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campaigns  $campaigns
     * @return \Illuminate\Http\Response
     */
    public function show($campaigns)
    {
        try {
            $data = Campaigns::where("id", $campaigns)->first();
            if ($data != null) {
                return new CampaignsRes($data);
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
     * @param  \App\Models\Campaigns  $campaigns
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $campaigns)
    {
        try {
            $validator = Validator::make($request->all(), [
                'az_name' => 'required|string|max:255',
                'ru_name' => 'required|string|max:255',
                'en_name' => 'required|string|max:255',
                'az_description' => 'string|max:150000',
                'ru_description' => 'string|max:150000',
                'en_description' => 'string|max:150000',
                'pictures.*' => 'image|mimes:jpeg,jpg,png,gif',
                'start_date' => 'date',
                'end_date' => 'date',
                'related_products' => 'json',
                'old_price' => 'between:0,99.99',
                'new_price' => 'between:0,99.99',
                'notify' => 'boolean',
                'customer_id' => 'integer'

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
            $seo_urls = [
                'az_seo_url' => Str::slug($request->az_name),
                'ru_seo_url' => Str::slug($request->ru_name),
                'en_seo_url' => Str::slug($request->en_name),
            ];
            $dates = [
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ];
            $prices = [
                'old_price' => $request->old_price,
                'new_price' => $request->new_price,
            ];
            if ($request->file("pictures")) {
                $newImages = [];
                foreach ($request->file("pictures") as $image) {
                    $fileName = 'campaigns_' . $request->customer_id . '_' . $request->az_name . '_' . Str::slug(Str::random(16)) . ".png";
                    $image->storeAs('/campaigns', $fileName, 'public');
                    array_push($newImages, $fileName . '.png');
                }
                $lastDatas = Campaigns::where('id', $campaigns)->first();
                $lastImages = $lastDatas->images;
                $images = array_merge($newImages, $lastImages);
                Campaigns::where('id', $campaigns)->update(['pictures' => $images]);
            }

            $data = [
                'names' => json_encode($names),
                'descriptors' => json_encode($desciptors),
                'seo_urls' => json_encode($seo_urls),
                'pictures' => json_encode($images),
                'dates' => json_encode($dates),
                'related_products' => json_encode($request->related_products),
                'prices' => json_encode($prices),
                'notify' => $request->notify,
                'customer_id' => $request->customer_id,
                'notify' => $request->notify ?? false
            ];
            Campaigns::where("id", $campaigns)->update($data);
            return response(['success' => 'Successfully updated'], 200);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Campaigns  $campaigns
     * @return \Illuminate\Http\Response
     */
    public function destroy($customers)
    {
        try {
            Campaigns::where("id", $customers)->delete();
            return response(['success' => 'Successfully deleted'], 200);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }

    public function recycle()
    {
        try {
            return new CampaignsCollection(Campaigns::with(['customer', 'views'])->onlyTrashed()->paginate(10));
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }

    public function harddelete($customers)
    {
        try {
            Campaigns::where("id", $customers)->onlyTrashed()->forceDelete();
            return response(['success' => 'Successfully deleted'], 200);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }

    public function view_campaign(Request $request, $campaign_id)
    {
        try {
            $data = [
                "user_id" => $request->user()->id,
                "campaign_id" => $campaign_id,
            ];
            Campaigns_Viewer::create($data);
            return response(['success' => 'Successfully Viewed'], 200);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }
}
