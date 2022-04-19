<?php

namespace WipeOutInc\Seat\SeatBuyback\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Seat\Web\Http\Controllers\Controller;
use WipeOutInc\Seat\SeatBuyback\Models\BuybackContract;

class BuybackContractController extends Controller {

    /**
     * @return \Illuminate\View\View
     */
    public function getHome()
    {
        return view('buyback::buyback_contract', [
            'contracts' => BuybackContract::all()
        ]);
    }

    public function insetContract(Request $request) {

        $request->validate([
            'contractId' => 'required',
            'contractData' => 'required'
        ]);

        $contract = new BuybackContract();
        $contract->contractId = $request->get('contractId');
        $contract->contractIssuer = "H4zz4rd";
        $contract->contractData = $request->get('contractData');
        $contract->save();

        return redirect()->back()
            ->with('success', 'Contract with ID: ' . $request->get('contractId') . ' successfully submitted.');
    }

}
