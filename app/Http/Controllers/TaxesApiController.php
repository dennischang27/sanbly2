<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Taxes;

class TaxesApiController extends Controller
{
    public function index()
    {
        return Taxes::all();
    }
 
    public function show($id)
    {
        return Taxes::find($id);
    }

    public function store(Request $request)
    {
        $request->validate([
			'tax_name'  => 'required',
			'tax_amount'  => 'required'
        ]);

        Taxes::create($request->all());
        return response()->json([
            "message" => "texas record created"
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $taxes = Taxes::findOrFail($id);
        $taxes->update($request->all());

        return [
            'success' => $taxes
        ];
    }

    public function delete(Request $request, $id)
    {
        $taxes = Taxes::findOrFail($id);
        $taxes->delete();

        return 204;
    }
}
