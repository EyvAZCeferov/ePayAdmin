<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationsCollection;
use App\Models\Notifications;
use App\Models\NotificationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return new NotificationsCollection(Notifications::with(['user', 'notification_stat'])->get());
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
                'az_name' => 'required|string|max:255',
                'ru_name' => 'required|string|max:255',
                'en_name' => 'required|string|max:255',
                'az_description' => 'string|max:150000',
                'ru_description' => 'string|max:150000',
                'en_description' => 'string|max:150000',
                'image' => 'required|image|mimes:jpeg,jpg,png,gif',
                'site_url' => 'url',
                'facebook_url' => 'url',
                'instagram_url' => 'url',
                'telephone_numb' => 'string',
                'whatsapp_numb' => 'string',
                'email' => 'string|email',
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
            $urls = [
                'site' => $request->site_url ?? '',
                'facebook' => $request->facebook_url ?? '',
                'instagram' => $request->instagram_url ?? '',
                'telephone' => $request->telephone_numb ?? '',
                'whatsapp' => 'https://wa.me/' . $request->whatsapp_numb ?? '',
                'email' => $request->email ?? '',
            ];
            $seo_urls = [
                'az_seo_url' => Str::slug($request->az_name),
                'ru_seo_url' => Str::slug($request->ru_name),
                'en_seo_url' => Str::slug($request->en_name),
            ];
            $data = [
                'names' => json_encode($names),
                'descriptors' => json_encode($desciptors),
                'urls' => json_encode($urls),
                'image' => $fileName,
                'seo_urls' => json_encode($seo_urls)
            ];
            Notifications::create($data);
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
            $data = Notifications::where("id", $id)->first();
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
                'az_name' => 'required|string|max:255',
                'ru_name' => 'required|string|max:255',
                'en_name' => 'required|string|max:255',
                'az_description' => 'string|max:150000',
                'ru_description' => 'string|max:150000',
                'en_description' => 'string|max:150000',
                'image' => 'image|mimes:jpeg,jpg,png,gif',
                'site_url' => 'url',
                'facebook_url' => 'url',
                'instagram_url' => 'url',
                'telephone_numb' => 'string',
                'whatsapp_numb' => 'string',
                'email' => 'string|email',
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
            $urls = [
                'site' => $request->site_url ?? '',
                'facebook' => $request->facebook_url ?? '',
                'instagram' => $request->instagram_url ?? '',
                'telephone' => $request->telephone_numb ?? '',
                'whatsapp' => 'https://wa.me/' . $request->whatsapp_numb ?? '',
                'email' => $request->email ?? '',
            ];
            $seo_urls = [
                'az_seo_url' => Str::slug($request->az_name),
                'ru_seo_url' => Str::slug($request->ru_name),
                'en_seo_url' => Str::slug($request->en_name),
            ];
            if (isset($request->image)) {
                $request->file('image')->storeAs('/', $fileName, 'public');
                $data = [
                    'names' => json_encode($names),
                    'descriptors' => json_encode($desciptors),
                    'urls' => json_encode($urls),
                    'image' => $fileName,
                    'seo_urls' => json_encode($seo_urls)
                ];
            } else {
                $data = [
                    'names' => json_encode($names),
                    'descriptors' => json_encode($desciptors),
                    'urls' => json_encode($urls),
                    'seo_urls' => json_encode($seo_urls)
                ];
            }
            Notifications::where('id', $id)->update($data);
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
            Notifications::where("id", $id)->delete();
            return response(['success' => 'Successfully deleted'], 200);
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

    public function notification_view(Request $request, $id)
    {
        try {
            NotificationStatus::create([
                'notification_id' => $request->notification_id,
                'user_id' => $request->user()->id,
            ]);
            return response(['success' => 'Notification viewed'], 200);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }
}
