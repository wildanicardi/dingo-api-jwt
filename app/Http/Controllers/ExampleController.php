<?php

namespace App\Http\Controllers;

use App\Example;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as IlluminateValidator;

class ExampleController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $example = Example::all();
        return $this->response->array($example->toArray());
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
            $validator = IlluminateValidator::make($request->all(), Example::$rule);
            if ($validator->fails()) {
                return response()->json($validator->errors());
            } else {
                Example::create($request->all());
                return $this->response->created();
            }
        } catch (\Exception $ex) {
            return response()->json($ex);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Example  $example
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Example::findOrFail($id);
        return $this->response->array($data->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Example  $example
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $example  = Example::findOrFail($id);
            $validator = IlluminateValidator::make($request->all(), Example::$rule);
            if ($validator->fails()) {
                return response()->json($validator->errors());
            } else {
                $example->update($request->all());
                return response()->json([
                    "status" => 202,
                    "message" => "success",
                ]);
            }
        } catch (\Exception $ex) {
            return response()->json([
                "status" => 202,
                "message" => $ex,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Example  $example
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $example = Example::findOrFail($id);
            $example->delete();
            return response()->json([
                "status" => 202,
                "message" => "success",
            ]);
        } catch (\Exception $ex) {
            return $this->response->noContent();
        }
    }
}
