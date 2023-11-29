<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Copy;
use App\Models\Film;
use App\Models\Member;
use App\Models\Record;
use App\Models\Finance;
use Illuminate\Http\Request;



class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataFin=Finance::latest()->paginate(4);
       
      
       //$dataFin = Finance::all();
        $distinctMembers = $dataFin->unique('member_id'); //da se prikazuju samo jednom imena, da se ne ponavljaju
        
        return view('finance.index', compact('dataFin'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('finance.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Finance $finance)
    {
        //

        $film=Film::all();
        $copy=Copy::all();
        
        $member=Member::where('id', $finance->member_id)->get();
        return view('finance.show', ['finance'=>$finance,'member' => $member,  'copy'=>$copy, 'film'=>$film]);
        }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Finance $finance)
    {
        //
        return view('finance.edit',['finance'=>$finance]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Finance $finance)
    {
        //
        $formFields = $request->validate([
           
            'PaidCostLate' => 'in:Yes,No',
            'DatePaidCostLate'=> 'nullable|date',
           
        ]);

        if ($formFields['PaidCostLate'] == 'Yes' && empty($formFields['DatePaidCostLate'])) {
            $formFields['DatePaidCostLate'] = now();
        }

        $finance->update($formFields);

         // Flash success message
         session()->flash('alertType', 'success');
         session()->flash('alertMsg', 'Finance successfully updated!');
    
        return redirect()->route('finance.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Finance $finance)
    {
        //
        try{
            $finance->delete();

            session()->flash('alertType', 'success');
            session()->flash('alertMsg', 'Successfully deleted.');

            return redirect()->route('finance.index');
        }
        catch(Exception $e) {
            //echo 'Message: ' .$e->getMessage();
            session()->flash('alertType', 'danger');
            session()->flash('alertMsg', 'Cannot be deleted.');

            return redirect()->route('finance.index');
        }
    }
}
