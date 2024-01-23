<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Copy;
use App\Models\Film;
use App\Models\Genre;
use App\Models\Member;
use App\Models\Person;
use App\Models\Record;
use App\Models\Finance;
use App\Charts\RecordChart;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;




class FilmController extends Controller
{



    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            $genres = Genre::all();
            $search = $request->search;
            $people = Person::all();
            $p = $request->people;
            $datas = Film::when($search, function (Builder $query) use ($search) {
                $query->whereHas('genres', function (Builder $query) use ($search) {
                    $query->where('name_en', 'LIKE', '%' . $search . '%')
                        ->orWhere('name_sr', 'LIKE', '%' . $search . '%')
                        ->orWhere('rating', 'like', '%' . $search . '%')
                        ->orWhere('name', 'like', '%' . $search . '%')
                        ->orWhere('year', 'like', '%' . $search . '%');
                });

                // Sadrzi podatke iz tabele stars (veza u modelu Film,sa people)
                $query->orWhereHas('stars', function (Builder $query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('surname', 'like', '%' . $search . '%');
                });
                // Sadrzi podatke iz tabele writers (veza u modelu Film,sa people)
                $query->orWhereHas('writers', function (Builder $query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('surname', 'like', '%' . $search . '%');
                });
                // Sadrzi podatke iz tabele directors (veza u modelu Film,sa people)
                $query->orWhereHas('directors', function (Builder $query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('surname', 'like', '%' . $search . '%');
                });
            })->latest()->paginate(4);

            $populateData = $request->all();
            $genres = Genre::all();
            $people = Person::all();

            $numbFilm = Film::count();
            if ($numbFilm ==0) {
                $msg = trans('Before adding a movie/film, you should add genre and people in Settings');
            }
            else {
                $msg = '';
            }
            return view('film.index', compact('datas', 'populateData', 'genres', 'msg'));
        } else {
            // nece uci u else granu posto je sve get metodom
            return view('film.index', [
                'datas' => Film::latest()->paginate(4)
            ]);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //dd(Genre::all()->sortBy('name'));  //$genres = Genre::orederBy('name_en')->get();
        $genres = Genre::all()->sortBy('name');
        $people = Person::all()->sortBy('fullName');

        $numbFilm = Film::count();
        if ($numbFilm ==0) {
            $msg = trans('Before adding a movie/film, you should add genre and people in Settings');
        }
        else {
            $msg = '';
        }

        return view('film.create', compact('genres', 'people', 'msg'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //1. validacija podataka
        $request->validate([
            'name' => 'required',
            'running_h' => 'nullable|numeric|min:1|integer',
            'running_m' => 'nullable|numeric|between:1,59|integer',
            'year' => 'required|date_format:Y|before_or_equal:today',
            'rating' => 'required|decimal:1|between:1,10',
            'directors' => 'required|array',
            'writers' => 'required|array',
            'stars' => 'required|array',
            'genres' => 'required|array',
            'image' => 'image|between:1,2048'
        ]);

        //2. upis u tabelu Film
        $film = Film::create($request->only('name', 'running_h', 'running_m', 'year', 'rating'));
        //3. upis u tabelu film_genre
        $film->genres()->attach($request->genres);
        //4. upis u tabelu film_director, film_writer, film_star
        $film->directors()->attach($request->directors);
        $film->writers()->attach($request->writers);
        $film->stars()->attach($request->stars);

        //proveravamo da li forma ima sliku i da li je slika validno otpremljena
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            //generisemo naziv slike id filma i ekstenzija fajla
            $imgName = $film->id . '.' . $request->file('image')->extension();
            //smestamo fajl u folder public/film_images
            Storage::disk('public')
                ->putFileAs('film_images', $request->file('image'), $imgName);

            //u bazi belezimo putanju od public foldera
            $film->image = 'film_images/' . $imgName;
            $film->save();
        }

        session()->flash('alertType', 'success');
        session()->flash('alertMsg', 'Successfully added.');

        $copy=Copy::all();
        $status=Copy::where('film_id', $film->id)->where('status', 'Available')->get();
        return view('film.show', ['film' => $film, 'copy'=>$copy, 'status'=>$status]);
        // return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Film $film)
    {

        //ideja je da sort zanrova bude po abecedi
        $zanrovi = $film->genres; //OVO VRACA KOLEKCIJU moze odmah da se koristi za prolazak
        $upit = $film->genres(); //OVO VRACA UPIT
        $zanrovi2 = $upit->get(); //TEK SADA IMATE KOLEKCIJU ZA PROLAZAK

        $zanroviSort = $film->genres->sortBy('name'); //dozvoljeno je da se navedu vestacki atributi
        //$upit = $film->genres()->orderBy('name'); //OVO NE MOZE JER NAME NEMA U BAZI
        $zanroviOreder = $film->genres()->orderBy('name_en')->get(); //ovo moze 

        $copy=Copy::all();
         $status=Copy::where('film_id', $film->id)->where('status', 'Available')->get();

        //dd($copy);
        $count = Copy::where('film_id', $film->id)->count(); //ukupan broj kopija filma ovo ce se modifikovati i pozvati u show


        //dd($film->genres);
        return view('film.show', ['film' => $film, 'copy' =>$copy, 'status'=>$status]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Film $film)
    {
        $copy=Copy::all();
        $genres = Genre::all()->sortBy('name');
        $people = Person::all()->sortBy('fullName');



        return view('film.edit', compact('film', 'genres', 'people','copy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Film $film)
    {
        $request->validate([
            'name' => 'required',
            'running_h' => 'nullable|numeric|min:1|integer',
            'running_m' => 'nullable|numeric|between:1,59|integer',
            'year' => 'required|date_format:Y|before_or_equal:today',
            'rating' => 'required|decimal:1|between:1,10',
            'directors' => 'required|array',
            'writers' => 'required|array',
            'stars' => 'required|array',
            'genres' => 'required|array',
          
        ]);

        $film->update($request->only('name', 'running_h', 'running_m', 'year', 'rating'));
        $film->genres()->sync($request->genres);
        $film->directors()->sync($request->directors);
        $film->writers()->sync($request->writers);
        $film->stars()->sync($request->stars);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($film->image && Storage::disk('public')->exists($film->image)) {
                Storage::disk('public')->delete($film->image);
            }
            $imgName = $film->id . '.' . $request->file('image')->extension();
            Storage::disk('public')
                ->putFileAs('film_images', $request->file('image'), $imgName);
            $film->image = 'film_images/' . $imgName;
            $film->save();
        } elseif ($request->image_remove == "yes") {
            if ($film->image && Storage::disk('public')->exists($film->image)) {
                Storage::disk('public')->delete($film->image);
            }
            $film->image = null;
            $film->save();
        }

        session()->flash('alertType', 'success');
        session()->flash('alertMsg', 'Successfully updated.');
        $copy=Copy::all();
        $status=Copy::where('film_id', $film->id)->where('status', 'Available')->get();
        return view('film.show', ['film' => $film, 'copy'=>$copy, 'status'=>$status]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Film $film)
    {
        try {
            $film->delete();

            session()->flash('alertType', 'success');
            session()->flash('alertMsg', 'Successfully deleted.');

            return redirect()->route('film.index');
        } catch (Exception $e) {
            session()->flash('alertType', 'danger');
            session()->flash('alertMsg', 'Cannot be deleted.');

            return redirect()->route('film.index');
        }
    }



//////////////STATISTIKA 

public function statistic(Request $request)
{

    //5 najcesce iznajmljivanih filmova

    $filmsWithRecords = Film::with('copies.records')->get(); //Filmovi sa rekords preko modela copies  //zato je u modelu film dodata relacija records
    $filmsData = []; //trenutno prazan niz i u njega dodajemo filmove

    foreach ($filmsWithRecords as $film) {
        $recordsCount = $film->copies->sum(function ($copy) { //prolazimo kroz filmove i sabiramo samo kopije odredjenog filma koje su izdate/izdavane
            return $copy->records->count();
        });

        $filmsData[] = [
            'title' => $film->name,  // ime filma se preuzima
            'recordsCount' => $recordsCount, //preuzima se broj izdatih kopija
        ];
    }

    // Sort films by records count in descending order
    usort($filmsData, function ($a, $b) {
        return $b['recordsCount'] - $a['recordsCount'];
    });

    $top5Films = array_slice($filmsData, 0, 5); //od svih filmova uzima prvih pet

    // kreiranje grafikona
    $chart = new RecordChart;
    $chart->labels(array_column($top5Films, 'title'));
    $chart->dataset('Most Rented Movies', 'bar', array_column($top5Films, 'recordsCount'))
        ->backgroundColor([
            '#FF5733',
            '#F46C31',
            '#E88329',
            '#D99D20',
            '#C9B51D',
        ]);

    // Legenda filma
    $chart->options([
        'legend' => [
            'display' => true,
            'position' => 'left',
            'labels' => [
                'generateLabels' => function ($chart) use ($top5Films) {
                    $legendItems = [];
                    foreach ($top5Films as $film) {
                        $legendItems[] = [
                            'text' => $film['title'],
                            'fillStyle' => $chart->getDatasetMeta(0)->backgroundColor[array_search($film['title'], array_column($top5Films, 'title'))],
                        ];
                    }
                    return $legendItems;
                },
            ],
        ],
    ]);

/////////////////////////////////////////
//5 clanova sa najvise iznajmljivanja


$MembersWithRecords = Member::withCount('records')->orderBy('records_count', 'desc')->take(5)->get();
$top5Members = [];

foreach ($MembersWithRecords as $member) {
    $top5Members[] = [
        'title' => $member->FullNameMemeber, //atribut iz modela Member
        'recordsCount' => $member->records_count,
    ];
}

// Create a new bar chart
$chart1 = new RecordChart;
$chart1->labels(array_column($top5Members, 'title'));
$chart1->dataset('Top 5 Members by Records', 'bar', array_column($top5Members, 'recordsCount'))
    ->backgroundColor([
        '#FF5733',
        '#F46C31',
        '#E88329',
        '#D99D20',
        '#C9B51D',
    ]);

// Customize legend
$chart1->options([
    'legend' => [
        'display' => true,
        'position' => 'left',
        'labels' => [
            'generateLabels' => function ($chart) use ($top5Members) {
                $legendItems = [];
                $backgroundColor = [
                    '#FF5733',
                    '#F46C31',
                    '#E88329',
                    '#D99D20',
                    '#C9B51D',
                ];
                
                foreach ($top5Members as $index => $member) {
                    $legendItems[] = [
                        'text' => $member['title'],
                        'fillStyle' => $backgroundColor[$index],
                    ];
                }
                return $legendItems;
            },
        ],
    ],
]);

/////MESECNA ZARDA KLUBA od rentiranja filmova
$monthlyEarnings = Finance::selectRaw('DATE_FORMAT(DatePaidRentPrice, "%m") as month, SUM(RentPrice) as total')
->groupBy('month') 
->orderBy('month')
->pluck('total', 'month')
->all();
//dd($monthlyEarnings);
$chart2 = new RecordChart;
$chart2->labels(array_keys($monthlyEarnings));
$chart2->dataset('Club earnings per month', 'line', array_values($monthlyEarnings));

$chart2->options([
    'scales' => [
        'yAxes' => [
            [
                'ticks' => [
                    'beginAtZero' => true,
                ],
            ],
        ],
    ],
    'legend' => [
        'display' => false, 
    ],
    'elements' => [
        'line' => [
            'tension' => 0, 
            'borderColor' => '#FF5733', // Postavljena boja linije
            'borderWidth' => 2, // Postavljena debljina linije
            'fill' => false, // Da se ne popunjava ispod linije prostor
        ],
    ],
]);


/////MESECNA ZARDA KLUBA od kasnjenja //ne vracanja kopija na vreme
$monthlyDelay = Finance::selectRaw('DATE_FORMAT(DatePaidRentPrice, "%m") as month, SUM(costLate) as total')
->groupBy('month') 
->orderBy('month')
->pluck('total', 'month')
->all();
//dd($monthlyDelay);
$chart3 = new RecordChart;
$chart3->labels(array_keys($monthlyDelay));
$chart3->dataset('earnings from delay cost', 'line', array_values($monthlyDelay));

$chart3->options([
    'scales' => [
        'yAxes' => [
            [
                'ticks' => [
                    'beginAtZero' => true,
                ],
            ],
        ],
    ],
    'legend' => [
        'display' => false, 
    ],
    'elements' => [
        'line' => [
            'tension' => 0, 
            'borderColor' => '#C9B51D', 
            'borderWidth' => 2, 
            'fill' => false, 
        ],
    ],
]);


///UKUPNA ZARADA PO MESECIMA ZBIR RENTIRANJA I KASNJENJA

$finances = Finance::orderBy('DatePaidRentPrice', 'ASC')->get(); //preuzete finansije koje su redjane po datumu (od 1. meseca ...)


//prazan niz koji kasnije se popunjava
$monthlyEarningsTotal = [];

foreach ($finances as $finance) {
    //prolazi se kroz celu tabelu i def se variabla $totalEarnings zasnovana na costLate
    if ($finance->costLate === null) {
        $totalEarnings = $finance->RentPrice;
    } else {
        $totalEarnings = $finance->RentPrice + $finance->costLate;
    }

    // definise se month koji ce da bude samo mesec
    $month = date('m', strtotime($finance->DatePaidRentPrice));

    //Na odgovarajuci mesec u noizu dodaje ukupnu zaradu
    if (!isset($monthlyEarningsTotal[$month])) {
        $monthlyEarningsTotal[$month] = 0;
    }
    $monthlyEarningsTotal[$month] += $totalEarnings;
}

$chart4 = new RecordChart;
$chart4->labels(array_keys($monthlyEarningsTotal));
$chart4->dataset('Club earnings per month', 'line', array_values($monthlyEarningsTotal));
$chart4->options([
    'scales' => [
        'yAxes' => [
            [
                'ticks' => [
                    'beginAtZero' => true,
                ],
            ],
        ],
    ],
    'legend' => [
        'display' => false, 
    ],
    'elements' => [
        'line' => [
            'tension' => 0, 
            'borderColor' => '#C9B51D', 
            'borderWidth' => 2, 
            'fill' => false, 
        ],
    ],
]);


///UKUPNA ZARADA 

$finances = Finance::all();


$totalEarnings = 0;
//prolazi kroz finansije i racuna $totalEarnings;
foreach ($finances as $finance) {
    if ($finance->costLate === null) {
        $totalEarnings += $finance->RentPrice;
    } else {
        $totalEarnings += $finance->RentPrice + $finance->costLate;
    }
}

$chart5 = new RecordChart;
$chart5->labels(['Total Earnings']);
$chart5->dataset('Club earnings', 'bar', [$totalEarnings])->backgroundColor(['#C9B51D']);

$chart5->options([
    'scales' => [
        'yAxes' => [
            [
                'ticks' => [
                    'beginAtZero' => true,
                ],
            ],
        ],
    ],
    'legend' => [
        'display' => false, 
    ],
]);

//view

    return view('statistic', compact('chart', 'top5Films','chart1', 'top5Members', 'chart2', 'chart3','chart4', 'chart5'));
 
}




}
