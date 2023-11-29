<?php

namespace App\Http\Controllers;

use App\Models\Copy;
use App\Models\Film;
use App\Models\Member;
use App\Models\Record;
use App\Models\Finance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //$dataMember = Member::paginate(4);
        $dataMember=Member::latest()->filter(request(['search']))->paginate(4);
        return view('member.index', ['dataMember' => $dataMember]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('member.create');
    }

    private function memberUniqueCode()
    {

        return Member::max('Membercode') + 1;
        // return $maxNumber !== null ? $maxNumber + 1 : 1;

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $formFilds = $request->validate([
            'gender' => 'in:male,female,other', // Validate that the active value is either "Yes" or "No"
            'name' => 'required|alpha:members,name',
            'surname' => 'required|alpha:members,surname',
            'b_date' => 'required',
            'image' => 'image|between:1,2048'

        ]);

        if ($request->hasFile('image')) {
            $formFilds['image'] = $request->file('image')->store('MemberImage', 'public'); //ako ima slike da se cuva u img u public folderu(store)
        }

//Membercode se automatski definise kao kod kopija filma. Ako je tablea members prazna prvi memeber ima kod 100, svaki sledeci +1 u odnosu na prethodni
        $members = DB::table('members')->get();

        if ($members->isEmpty()) {
            $formFilds['Membercode'] = 100;
        } else {
            $formFilds['Membercode'] = $this->memberUniqueCode();
        }


        Member::create($formFilds);
        session()->flash('alertType', 'success');
        session()->flash('alertMsg', 'Member successfully created!');

        return redirect()->route('member.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    
    {
     // return view('member.show', ['member' => $member]);
    $film=Film::all();
    $copy=Copy::all();
    $records=Record::all();
    $finances=Finance::all();
    
    $record=Record::where('member_id', $member->id)->get();
    return view('member.show', ['member' => $member, 'record'=>$record, 'copy'=>$copy, 'film'=>$film, 'records'=>$records,'finances'=>$finances]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        //
        return view('member.edit',['member'=>$member]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        //
        $formFilds = $request->validate([
            'gender' => 'in:male,female,other', 
            'name' => 'required|alpha:members,name',
            'surname' => 'required|alpha:members,surname',
            'b_date' => 'required',
           'image'=>'image'
            

        ]);
        if ($request->hasFile('image')) {
            $formFilds['image'] = $request->file('image')->store('MemberImage', 'public'); //ako ima slike da se cuva u img u public folderu(store)
        }
        $member->update($formFilds);

        // if ($request->hasFile('image') && $request->file('image')->isValid()) {
        //     if ($member->image && Storage::disk('public')->exists($member->image)) {
        //         Storage::disk('public')->delete($member->image);
        //     }
        //     $imgName = $member->id . '.' . $request->file('image')->extension();
        //     Storage::disk('public')
        //         ->putFileAs('MemberImage', $request->file('image'), $imgName);
        //     $member->image = 'MemberImage/' . $imgName;
        //     $member->save();
        // } 


        session()->flash('alertType', 'success');
        session()->flash('alertMsg', 'Member successfully updated!');

        return redirect()->route('member.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        //
        $member->delete();

        session()->flash('alertType', 'success');
        session()->flash('alertMsg', 'Successfully deleted.');

        return redirect()->route('member.index');
    }
}
