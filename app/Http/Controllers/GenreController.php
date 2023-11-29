<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\App;
use Exception;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locale = App::currentLocale(); // en/sr
        
        //en -> sort po name_en
        //sr -> sort po name_sr

        if($locale=='en'){
            $data = Genre::orderBy('name_en')->filter(request(['search']))->paginate(4);
        }elseif($locale=='sr'){
            $data = Genre::orderBy('name_sr')->filter(request(['search']))->paginate(4);
        }else{
            //all dovlaci sve podatke iz tabele genres
            $data = Genre::paginate(4);
        }        
        return view('genre.index', ['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('genre.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            //'name_en' => 'required|unique:genres,name_en|alpha',
            'name_en' => 'required|unique:genres,name_en|alpha|in:action,adventure,biography,cartoon,crimi,comedy,romance,documentary,drama,fantasy,history,mistery,music,scienceFiction,triler,war,western',
            'name_sr' => 'nullable|unique:genres,name_sr|alpha'
        ]);
    

        //kod ispod se izvrsava u slucaju da je forma prosla validaciju

        Genre::create($request->all()); 
       session()->flash('alertType', 'success');
       session()->flash('alertMsg', 'Successfully added.');

        return redirect()->route('genre.index');
            
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    //$genre = Genre::find($request->input('id'))
    public function edit(Genre $genre)
    {
        
        return view('genre.edit', compact('genre')); // isto i // return view('genre.edit', ['genre'=>$genre]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'name_en' => [
                'required', 
                //'unique:genres,name_en', 
                Rule::unique('genres', 'name_en')->ignore($genre->id),
                'alpha'],
            'name_sr' => [
                'nullable', 
                //'unique:genres,name_sr', 
                Rule::unique('genres', 'name_sr')->ignore($genre->id),
                'alpha']
        ]);

        $genre->update($request->all());

        session()->flash('alertType', 'success');
        session()->flash('alertMsg', 'Successfully updated.');

        return redirect()->route('genre.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        try{
            $genre->delete();

            session()->flash('alertType', 'success');
            session()->flash('alertMsg', 'Successfully deleted.');

            return redirect()->route('genre.index');
        }
        catch(Exception $e) {
            //echo 'Message: ' .$e->getMessage();
            session()->flash('alertType', 'danger');
            session()->flash('alertMsg', 'Cannot be deleted.');

            return redirect()->route('genre.index');
        }
    }

    public function destroy2(Genre $genre)
    {
        if($genre->films->count()){
            session()->flash('alertType', 'danger');
            session()->flash('alertMsg', 'Cannot be deleted. Films='.$genre->films->count());

            return redirect()->route('genre.index');
        }else{
            $genre->delete();
    
            session()->flash('alertType', 'success');
            session()->flash('alertMsg', 'Successfully deleted.');
    
            return redirect()->route('genre.index');        
        }
    }
}