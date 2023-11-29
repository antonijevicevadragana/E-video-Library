<?php

namespace App\Http\Controllers;

use App\Models\Copy;
use App\Models\Film;
use App\Models\Record;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class CopyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // za koriscenje search
        if ($request->isMethod('GET')) {
            //$film = Film::orederBy('name_en')->get(); isto kao i $film = Film::all()->sortBy('name');
            $film = Film::all();
            //dd($film);
            $f = $request->search;
            $a=$request->search1;
            $copyData = Copy::when($f, function (Builder $query) use ($f) {
                $query->whereHas('film', function (Builder $query) use ($f) {
                    $query->where('code', 'LIKE', '%' . $f . '%')
                        ->orWhere('active', 'LIKE', '%' . $f . '%')
                        ->orWhere('rating', 'like', '%' . $f . '%')
                        ->orWhere('name', 'like', '%' . $f . '%')
                        ->orWhere('status', 'LIKE', $f);
                });
            })->latest()->paginate(4);

            $populateData = $request->all();
            $films = Film::all();
            return view('copy.index', compact('copyData', 'films'));
        } else {
            // nece ni uci u else granu posto je sve get metodom
            return view('copy.index', [
                'copyData' => Copy::latest()->paginate(4)
            ]);
        }
     
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $film = Film::all()->sortBy('name');



        return view('copy.create', compact('film'));
    }

    /**
     * Store a newly created resource in storage.
     */

    private function generateUniqueCode()
    {
        //return $uniqueCode;
        return Copy::max('code') + 1; //generise cod za kopiju
    }

    public function store(Request $request)
    {
        $formFilds = $request->validate([
            'film_id' => 'required|exists:films,id',
            'active' => 'in:Yes,No', // validacija za aktiv (u rasponu da,ne)
        ]);


        if ($formFilds['active'] == "No") {
            $formFilds['status'] = "No active";
        }


        if ($formFilds['active'] == 'Yes') {
            $formFilds['status'] = "Available";
        } 

        //ako je table copis prazna prvi unos ima kod 100, svaki sledeci +1 u odnosu na prethodni
        $members = DB::table('copies')->get();

        if ($members->isEmpty()) {
            $formFilds['code'] = 100;
        } else {
            $formFilds['code'] = $this->generateUniqueCode();
        }

        Copy::create($formFilds);
        session()->flash('alertType', 'success');
        session()->flash('alertMsg', 'Copy successfully created!');

        return redirect()->route('copy.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Copy $copy)
    {
        //
        //dd($copy->film);
        $record=Record::where('copy_id', $copy->id)->get();

        return view('copy.show', ['copy' => $copy, 'record'=>$record]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Copy $copy)
    {
        //

        $film = Film::all()->sortBy('name');
        return view('copy.edit', compact('copy', 'film'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Copy $copy)
    {
        $formFilds = $request->validate([
            'film_id' => 'required|exists:films,id',
            'active' => 'in:Yes,No', 
        ]);
        if ($formFilds['active'] == "Yes") {
            $formFilds['status'] = "Available"; //ako je kopija koja je neaktivna(izgubljena, ostecena  sada SREDJENA, nadjena) onda je slobodna za izdavanje. Bice no, kada se izda
        }
        if ($formFilds['active'] == "No") { //ako je kaseta bila aktivna i sad je neaktivna status mora biti promenjen
            $formFilds['status'] = "No active";
        }
        $formFilds['code'] = $this->generateUniqueCode();
        $copy->update($formFilds);
        session()->flash('alertType', 'success');
        session()->flash('alertMsg', 'Copy successfully updated!');

        return redirect()->route('copy.index');
        //return view('copy.show', ['copy' => $copy]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Copy $copy)
    {
        //ako kopija nije slobodna za izdavanja ne moze biti izbrisana
        if ($copy['status'] == "Not Available") {
            session()->flash('alertType', 'danger');
            session()->flash('alertMsg', 'Cannot be deleted.');
        }
        else{
            $copy->delete();

            session()->flash('alertType', 'success');
            session()->flash('alertMsg', 'Successfully deleted.');
        }

        

        return redirect()->route('copy.index');
    }
}
