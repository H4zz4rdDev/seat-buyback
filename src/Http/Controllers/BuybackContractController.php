<?php

namespace WipeOutInc\Seat\SeatBuyback\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Seat\Web\Http\Controllers\Controller;
use WipeOutInc\Seat\SeatBuyback\Models\BuybackContract;

class BuybackContractController extends Controller {

    /**
     * @return \Illuminate\View\View
     */
    public function getHome()
    {
        $contracts = BuybackContract::where('contractStatus', '=', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('buyback::buyback_contract', [
            'contracts' => $contracts
        ]);
    }

    public function insetContract(Request $request) {

        $request->validate([
            'contractId' => 'required',
            'contractData' => 'required'
        ]);

        $contract = new BuybackContract();
        $contract->contractId = $request->get('contractId');
        $contract->contractIssuer = Auth::user()->name;
        $contract->contractData = $request->get('contractData');
        $contract->save();

        return redirect()->back()
            ->with('success', 'Contract with ID: ' . $request->get('contractId') . ' successfully submitted.');
    }

    public function deleteContract (Request $request, string $contractId)
    {
        if(!$request->isMethod('get') || empty($contractId))
        {
            return redirect()->back()
                ->with(['error' => "An error occurred!"]);
        }

        BuybackContract::destroy($contractId);

        return redirect()->back()
            ->with('success', 'Contract with ID: ' . $contractId . ' successfully deleted.');
    }

    public function succeedContract (Request $request, string $contractId)
    {
        if(!$request->isMethod('get') || empty($contractId))
        {
            return redirect()->back()
                ->with(['error' => "An error occurred!"]);
        }

        $contract = BuybackContract::where('contractId', '=', $contractId)->first();
        if(!$contract->contractStatus) {

            $contract->contractStatus = 1;
            $contract->save();

            return redirect()->back()
                ->with('success', 'Contract with ID: ' . $contractId . ' successfully marked as succeeded.');
        }

        return redirect()->back()
            ->with(['error' => "An error occurred!"]);
    }
}
