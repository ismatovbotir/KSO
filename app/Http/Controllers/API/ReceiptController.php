<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReceiptResource;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // {
    //     "no":"174670",
    //     "barcode":"7000000167644",
    //     "shift":901,
    //     "dateOpen":"30.04.26 11:29:20",
    //     "dateClose":"",
    //     "type":"sell",
    //     "cashier":"Admin Uchko'prik",
    //     "consultant":"",
    //     "shop":1,"pos":7,"status":true,
    //     "client_id":"",
    //     "client_card":"",
    //     "client_name":"",
    //     "client_phone":"",
    //     "sub_total":500,
    //     "discount":0,
    //     "total":500,"fiscal":"",
    //     "items":[{"item":17166,"status":true,"qty":1,"price":500,"sub_total":500,"discount":0,"round":0,"total":500}],
    //     "payments":[{"type":"cash","value":500}]
    // }

    public function store(Request $request)
    {
        $data=$request->all();
        try{
            $receipt=Receipt::firstOrCreate([
                'no' => $data['no'],
                'barcode' => $data['barcode'],
                'type' => $data['type'],
                'total' => $data['total'],
                'data' => json_encode($data)
            ]);
           $resBody=[
                'status' => 'success',
                'message' => 'Receipt stored successfully',
                'data' => new ReceiptResource($receipt)
            ];
            $resCode=201;
        } catch (\Exception $e) {
            $resBody=[
                'status' => 'error',
                'message' => 'Failed to store receipt',
                'data' => null
            ];
            $resCode=500;
        }

        //if ($resCode === 201) {
            Artisan::call('upload:receipt', ['--limit' => 5]);
        //}

        return response()->json($resBody, $resCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $receipt=Receipt::find($id);
        return response()->json(new ReceiptResource($receipt));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
