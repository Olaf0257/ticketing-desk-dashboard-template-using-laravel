<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CannedResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;
use App\Helpers\Logger;
use App\Helpers\Uuid;
use DB;
use App\Http\Resources\CannedResponseResource;


class CannedResponseController extends Controller
{
    public function __construct()
    {
        /*
        make sure only logged in and verified user has access
        to this controller
         */
        $this->middleware(['auth', 'verified']);
    }
    public function index()
    {
        $cannedresponses = CannedResponse::all();
        return view('canned_responses.index', compact('cannedresponses'));
    }

    public function create()
    {
        return view('canned_responses.create');
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
                   'name' => 'required',
                   'body' => 'required'
            ]);
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator);
            }

            $cannedresponses = new CannedResponse();
            $cannedresponses->uuid = Uuid::getUuid();
            $cannedresponses->name= $request->name;
            $cannedresponses->body = $request->body;
            $cannedresponses->save();
            return redirect()->route('canned_responses.index')
                ->with('success', __('Canned response added'));
         } catch (\Exception $e) {
              Logger::error($e->getMessage());
             return redirect()
              ->back()
             ->withInput()
             ->with('error', __('Something went wrong'));
          }
    }


    public function edit(Request $request, $uuid)
    {
        $cannedresponse = CannedResponse::find($uuid);
        return view('canned_responses.edit', $cannedresponse);
    }


    public function update(Request $request, $uuid)
    {

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'body' => 'required'
            ]);
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator);
            }

            $cannedresponse = CannedResponse::find($uuid);
            $cannedresponse ->update($request->all());
            return redirect()->route('canned_responses.index')
                ->with('success', __('Canned response updated'));

        } catch (\Exception $e) {
            Logger::error($e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('Something went wrong'));
        }

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        $cannedresponses = CannedResponse::find($uuid);
        $cannedresponses->delete();
        return redirect()->route('canned_responses.index')
            ->with('success', __('Canned response deleted'));
    }


    public function getCannedResponsesApi(Request $request){
        $canned_responses = DB::table('canned_responses')->get()->toJson(JSON_PRETTY_PRINT);
        return response($canned_responses, 200);
        //TODO: how to use CannedResponseResource without any error ?
        // return  CannedResponseResource::collection(CannedResponse::all());
    }

}
