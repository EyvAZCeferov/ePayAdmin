<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Cards as CardsRes;
use App\Http\Resources\CardsCollection;
use App\Models\Cards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            return new CardsCollection($request->user()->cards);
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
                'card_number' => 'required|string|min:15|max:17',
                'card_type' => 'required|max:30|string',
                'category' => 'required|max:12|string',
                'expiry_date' => 'required',
                'user_id' => 'integer|required',
            ]);
            if ($validator->fails()) {
                return response(['error' => $validator->errors()], 422);
            }

            $card = new Cards();
            $card->card_number = $request->card_number;
            $card->card_type = $request->card_type;
            $card->category = $request->category;
            $card->expiry_date = $request->expiry_date;
            $card->user_id = $request->user_id;
            $card->save();

            return new CardsCollection($request->user()->cards);
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
            return new CardsRes(Cards::where("id", $id)->first());
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
                'card_number' => 'required|string|min:15|max:17',
                'card_type' => 'required|max:30|string',
                'category' => 'required|max:12|string',
                'expiry_date' => 'required',
                'user_id' => 'integer|required',
            ]);
            if ($validator->fails()) {
                return response(['error' => $validator->errors()], 422);
            }

            $data = [
                'card_number' => $request->card_number,
                'card_type' => $request->card_type,
                'category' => $request->category,
                'expiry_date' => $request->expiry_date,
                'user_id' => $request->user_id,
            ];

            Cards::where('id', $id)->update($data);

            return response(['success' => 'Successfully Updated'], 200);
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
            Cards::where("id", $id)->delete();
            return response(['success' => 'Successfully deleted'], 200);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }

    public function recycle()
    {
        try {
            return new CardsCollection(Cards::with(['user'])->onlyTrashed()->paginate(10));
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }

    public function harddelete($id)
    {
        try {
            Cards::where("id", $id)->onlyTrashed()->forceDelete();
            return response(['success' => 'Successfully deleted'], 200);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }
}
