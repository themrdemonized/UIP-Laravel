<?php

namespace App\Http\Controllers;

use App\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    private $bank;

    public function __construct(Bank $bank)
    {
        $this->bank = $bank;
    }

    public function index()
    {
        $banks = $this->bank->get();

        return response()->json([
            'banks' => $banks
        ],200);
    }

    public function show($id)
    {
        $bank = $this->bank->with('houses')->findOrFail($id);

        return response()->json([
            'bank' => $bank
        ],200);
    }

    public function create(Request $request)
    {
        $this->bank->create($request->all());

        return response()->json([
            'msg' => 'Банк был успешно создан.'
        ],200);
    }

    public function update(Request $request, $id)
    {
        $bank = $this->bank->findOrFail($id);

        $bank->houses()->detach();
        $bank->houses()->attach($request->houses);

        $bank->update($request->except('houses'));

        return response()->json([
            'msg' => 'Банк был успешно изменен.'
        ],200);
    }

    public function destroy($id)
    {
        $this->bank->findOrFail($id)->delete();

        return response()->json([
            'msg' => 'Банк был успешно удален'
        ],200);
    }
}
