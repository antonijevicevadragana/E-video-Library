<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Copy;
use App\Models\Film;
use App\Models\Member;
use App\Models\Record;
use App\Models\Finance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Charts\RecordChart;
use Illuminate\Database\Eloquent\Builder;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            
            $search = $request->search;
            $member = Member::all();
            $copy=Copy::all();
            $film=Film::all();
            $p = $request->people;
            $dataRecord = Record::when($search, function (Builder $query) use ($search) {
                $query->whereHas('copy', function (Builder $query) use ($search) {
                    $query->where('code', 'LIKE', '%' . $search . '%')
                        ->orWhere('date_take', 'LIKE', '%' . $search . '%')
                        ->orWhere('returned', 'LIKE', '%' . $search . '%');
            
                    // Sadrzi podatke iz tabele film (veza preko copy tabele)
                    $query->orWhereHas('film', function (Builder $query) use ($search) {
                        $query->where('name', 'LIKE', '%' . $search . '%');
                    });
                });
            
                // Sadrzi podatke iz tabele member (veza u modelu Record)
                $query->orWhereHas('member', function (Builder $query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search . '%')
                        ->orWhere('surname', 'LIKE', '%' . $search . '%');
                });
            
            })->latest()->paginate(4);
            

            $populateData = $request->all();
            $member = Member::all();
            $copy=Copy::all();
            $film=Film::all();
            return view('record.index', compact('dataRecord', 'populateData', 'copy','member'));
        } else {
            // nece uci u else granu posto je sve get metodom
            return view('record.index', [
                'dataRecord' => Record::latest()->paginate(4)
            ]);
        }
    }
    // public function index()
    // {
    //     //
    //     // $dataRecord = Record::paginate(4);
    //     $dataRecord = Record::latest()->paginate(4);
    //     //$copy=Copy::where('id', $dataRecord->copy_id)->get();
        
    //     $member=Member::all();
    //     return view('record.index', ['dataRecord' =>  $dataRecord] );
    // }
    // 
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $member = Member::all()->sortBy('name');
       // $copy = Copy::all();
       // $copy_id=Copy::pluck('id');
       $copy_id = $request->query('copy_id'); //da se dobije id iz urla

        return view('record.create', compact('copy_id', 'member'));
    }

public function store(Request $request)
{
    $formFields = $request->validate([
        'member_id' => 'required|exists:members,id',
        'date_take' => 'required|date',
        'copy_id' => 'required',
        'RentPrice' => 'required',
       
    ]);

    $copy_id = $request->copy_id;  //id dobijen iz url // poslato u create 
    $formFields['copy_id'] = $copy_id;
    $dateTake = Carbon::parse($formFields['date_take']); //radi se carbon da bi moglo da se radi sa datumom
    $date_expect_return = $dateTake->addDays(10);   
    $formFields['date_expect_return'] = $date_expect_return;//dodaje se 10 dana i automatski se popunjava polje
   

    $returned = 'No';
    if ($returned == 'No') {
        $status = "Not Available";
    }

    Copy::where('id', $copy_id)->update(['status' => $status]);  //upis u tabelu copy nakon izdavanja
    $record = Record::create($formFields);

    // Kreiranje Finansija
    $finance = Finance::create([
        'RentPrice' => $formFields['RentPrice'],
        'DatePaidRentPrice' => $dateTake->subDays(10),//posto pamti poslednji $dateTake, potrebno je oduzeti 10 dana, da bi dan zaduzenja kopije i naplate bio isti
        'member_id'=>$formFields['member_id'],
        'record_id'=>$record->id
         
    ]);
 // Update  finance_id u records table
 $record->update(['finance_id' => $finance->id]);

    session()->flash('alertType', 'success');
    session()->flash('alertMsg', 'Record successfully created!');

    return redirect()->route('copy.index');
}

    /**
     * Display the specified resource.
     */
    public function show(Record $record)
    {
        //
       return view('record.show', compact('record'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Record $record)
    {
        $member = Member::all()->sortBy('name');
        // $copy = Copy::all();
        $copy_id=$record->copy_id;
         return view('record.edit', compact('record', 'member', 'copy_id'));
    }

   
    public function update(Request $request, Record $record)
    {
         // Validate form fields
     $formFilds = $request->validate([
           
            'member_id' => 'required|exists:members,id',
            'date_take' => 'required|date', 
            'returned'=>'in:Yes,No',
            'returnDate'=> 'nullable|date',
           
        ]);

       
        $copy_id = $record->copy_id; //podatak iz tabele, treba za status u copy tabeli
       // $formFilds['copy_id']=$copy_id;
        $dateTake=Carbon::parse($formFilds['date_take']);
        $date_expect_return=$dateTake->addDays(10);
    
        $formFilds['date_expect_return']= $date_expect_return;

        if ($formFilds['returned'] == 'No') {
            $status = "Not Available";
        } else {
            $status = "Available";
        }


        if ($formFilds['returned'] == 'Yes' && empty($formFilds['returnDate'])) {
            $formFilds['returnDate'] = now();
        }
       

        Copy::where('id', $copy_id)->update(['status' => $status]);
        $record->update($formFilds);
    
        if ($formFilds['returned'] == 'Yes' && $formFilds['returnDate'] !== null) {
             // Calculate delayInDays and costLate if returnDate is not null
         $dateTake = Carbon::parse($formFilds['date_take']);
            $date_expect_return = $dateTake->addDays(10);
            $delayInDays = $formFilds['returnDate']->diffInDays($date_expect_return, false);
             $costLate = $delayInDays < 0 ? $delayInDays * 0.1 : 0;
             $costLate=abs($costLate);

        // Finance::where('member_id', $formFilds['member_id'])->update([ 'deleyInDays' => $delayInDays,
        //        'costLate' => $costLate,]);

        Finance::where('record_id', $record['id'])->update([ 'deleyInDays' => $delayInDays,
        'costLate' => $costLate,  'member_id' => $formFilds['member_id'] ]);
        }

        // u slucaju da je pogresan clan unet, da se promena belezi i u tablei finansije
        Finance::where('record_id', $record['id'])->update(['member_id' => $formFilds['member_id'] ]);
    
         // Flash success message
         session()->flash('alertType', 'success');
         session()->flash('alertMsg', 'Record successfully updated!');
    
        return redirect()->route('record.index');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Record $record)
    {
        //
        if ($record['returned'] == "No") {
            session()->flash('alertType', 'danger');
            session()->flash('alertMsg', 'Cannot be deleted.');
        }
        else{
            $record->delete();

            session()->flash('alertType', 'success');
            session()->flash('alertMsg', 'Successfully deleted.');
        }

        

        return redirect()->route('record.index');
    }
    


    

}