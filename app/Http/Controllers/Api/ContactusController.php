<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ContactUsMail;
use App\Models\Contactus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return Contactus::paginate(15);
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
                'username' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'subject' => 'required|string|max:255|min:3',
                'description' => 'required|max:100000|min:8',
            ]);

            if ($validator->fails()) {
                return response(['error' => $validator->errors()], 422);
            }

            $data = [
                'username' => $request->username,
                'email' => $request->email,
                'subject' => $request->subject,
                'description' => $request->description,
            ];
            Contactus::create($data);
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
            return Contactus::where('id', $id)->first();
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
                'description' => 'required|max:100000|min:8',
            ]);

            if ($validator->fails()) {
                return response(['error' => $validator->errors()], 422);
            }

            new ContactUsMail(Contactus::where('id', $id)->first());

            return response(['success' => 'Successfully sended email'], 200);
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
            Contactus::where("id", $id)->delete();
            return response(['success' => 'Successfully deleted'], 200);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }

    public function recycle()
    {
        try {
            return  Contactus::onlyTrashed()->paginate(10);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }

    public function harddelete($id)
    {
        try {
            Contactus::where("id", $id)->onlyTrashed()->forceDelete();
            return response(['success' => 'Successfully deleted'], 200);
        } catch (\Exception $e) {
            return response(["error" => $e->getMessage()], 422);
        }
    }
}
