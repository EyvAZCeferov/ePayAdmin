<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LocationsCollection;
use App\Models\Locations;
use Illuminate\Http\Request;
use App\Http\Resources\Locations as LocatRes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return new LocationsCollection(Locations::with(['customer'])->paginate(10));
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()]);
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
                'address' => 'string|max:255',
                'latitude' => 'string',
                'longitude' => 'string',
                'customer_id' => 'required|integer'
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
            $geolocations = [
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ];
            $images = [];
            $ims = $request->file("pictures");
            foreach ($ims as $image) {
                $fileName = 'locations_' . $request->customer_id . '_' . Str::slug(Str::random(10)) . ".png";
                $image->storeAs('/' . $request->customer_id . '/', $fileName, 'public');
                array_push($images, $fileName);
            }
            $data = [
                'names' => json_encode($names),
                'descriptors' => json_encode($desciptors),
                'pictures' => json_encode($images),
                'geolocations' => json_encode($geolocations),
                'customers_id' => $request->customer_id
            ];
            Locations::create($data);
            return response(['success' => 'Successfully added'], 200);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Locations  $locations
     * @return \Illuminate\Http\Response
     */
    public function show($locations)
    {
        try {
            $location_n = Locations::where("id", $locations)->first();
            return new LocatRes($location_n);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Locations  $locations
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $locations)
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
                'address' => 'string|max:255',
                'latitude' => 'string',
                'longitude' => 'string',
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
            $geolocations = [
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ];
            if ($request->file("pictures")) {
                $newImages = [];
                foreach ($request->file("pictures") as $image) {
                    $fileName = 'locations_' . $request->customer_id . '_' . Str::slug(Str::random(10)) . ".png";
                    $image->storeAs('/', $fileName, 'public');
                    array_push($newImages, $fileName . '.png');
                }
                $lastDatas = Locations::where('id', $locations)->first();
                $lastImages = $lastDatas->images;
                $images = array_merge($newImages, $lastImages);
                Locations::where('id', $locations)->update(['pictures' => $images]);
            }
            $data = [
                'names' => json_encode($names),
                'descriptors' => json_encode($desciptors),
                'geolocations' => json_encode($geolocations),
            ];
            Locations::where('id', $locations)->update($data);
            return response(['success' => 'Successfully updated'], 200);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Locations  $locations
     * @return \Illuminate\Http\Response
     */
    public function destroy($locations)
    {
        try {
            Locations::where("id", $locations)->delete();
            return response(['success' => 'Successfully deleted']);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()]);
        }
    }
}
