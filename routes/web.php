<?php

use App\Models\Member;
use App\Models\Finance;
//use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CopyController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/lang/{locale}', function (string $locale) {
    //App::setLocale($locale);
    session(['locale' => $locale]);

    //povratak na prethodnu stranicu
    return redirect()->back();
})->whereIn('locale', ['en', 'sr'])->name('lang');


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        //prikaz svih podataka
        Route::get('/genre', [GenreController::class, 'index'])
        ->name('genre.index');
    
        //prikaz forme za unos
        Route::get('/genre/create', [GenreController::class, 'create'])
        ->name('genre.create');
        
        //validacija podataka i upis novog reda u tabelu
        Route::post('/genre', [GenreController::class, 'store'])
        ->name('genre.store');
    
        //forma za izmenu podatka
        Route::get('/genre/{genre}/edit', [GenreController::class, 'edit'])
        ->name('genre.edit');
    
        //izmena postojećeg podatka
        Route::put('/genre/{genre}', [GenreController::class, 'update'])
        ->name('genre.update');
    
        //brisanje podatka
        Route::delete('/genre/{genre}', [GenreController::class, 'destroy'])
        ->name('genre.destroy');
    
        //definisanje svih 7 ruta za kontroler
        Route::resource('film', FilmController::class);

        Route::post('/film', [FilmController::class, 'index'])
    ->name('film.index');
 

 //prikaz forme za unos
 Route::get('/film/create', [FilmController::class, 'create'])
 ->name('film.create');
 
 //validacija podataka i upis novog reda u tabelu
 Route::post('/film', [FilmController::class, 'store'])
 ->name('film.store');

 //forma za izmenu podatka
 Route::get('/film/{film}/edit', [FilmController::class, 'edit'])
 ->name('film.edit');

 //izmena postojećeg podatka
 Route::put('/film/{film}', [FilmController::class, 'update'])
 ->name('film.update');

 //brisanje podatka
 Route::delete('/film/{film}', [FilmController::class, 'destroy'])
 ->name('film.destroy');








    ///////////////

    //rute za person - (people tabela)


    //prikaz svih podataka person - people table
    Route::get('/person', [PersonController::class, 'index'])
        ->name('person.index');
    //prikaz forme za unos
    Route::get('/person/create', [PersonController::class, 'create'])
        ->name('person.create');

    //validacija podataka i upis novog reda u tabelu
    Route::post('/person', [PersonController::class, 'store'])
        ->name('person.store');

    //forma za izmenu podatka
    Route::get('/person/{person}/edit', [PersonController::class, 'edit'])
        ->name('person.edit');

    //izmena postojećeg podatka
    Route::put('/person/{person}', [PersonController::class, 'update'])
        ->name('person.update');

     //brisanje podatka
     Route::delete('/person/{person}', [PersonController::class, 'destroy'])
     ->name('person.destroy');

     //detaljan prikaz podatka
Route::get('/person/{person}', [PersonController::class, 'show'])
->name('person.show');

///////////////////////////////
// rute za copy
 //prikaz svih podataka person - people table
 Route::get('/copy', [CopyController::class, 'index'])
 ->name('copy.index');

  //prikaz forme za unos
  Route::get('/copy/create', [CopyController::class, 'create'])
  ->name('copy.create');

  
    //validacija podataka i upis novog reda u tabelu
    Route::post('/copy', [CopyController::class, 'store'])
        ->name('copy.store');


  //forma za izmenu podatka
  Route::get('/copy/{copy}/edit', [CopyController::class, 'edit'])
  ->name('copy.edit');

//izmena postojećeg podatka
Route::put('/copy/{copy}', [CopyController::class, 'update'])
  ->name('copy.update');

//brisanje podatka
Route::delete('/copy/{copy}', [CopyController::class, 'destroy'])
->name('copy.destroy');

//detaljan prikaz podatka
Route::get('/copy/{copy}', [CopyController::class, 'show'])
->name('copy.show');
///////////////////////////////////////////////////////////////
//MEMBER
Route::get('/member', [MemberController::class, 'index'])
->name('member.index');

Route::get('/member/create', [MemberController::class, 'create'])
    ->name('member.create');

  //validacija podataka i upis novog reda u tabelu
  Route::post('/member', [MemberController::class, 'store'])
  ->name('member.store');

    //forma za izmenu podatka
    Route::get('/member/{member}/edit', [MemberController::class, 'edit'])
    ->name('member.edit');

    //izmena postojećeg podatka
Route::put('/member/{member}', [MemberController::class, 'update'])
->name('member.update');

//brisanje podatka
Route::delete('/member/{member}', [MemberController::class, 'destroy'])
->name('member.destroy');

//detaljan prikaz podatka
Route::get('/member/{member}', [MemberController::class, 'show'])
->name('member.show');
//////////////////////////////////////////////////////////////
//RECORD



Route::get('/record', [RecordController::class, 'index'])
->name('record.index');

Route::get('/record/create', [RecordController::class, 'create'])
    ->name('record.create');

  //validacija podataka i upis novog reda u tabelu
  Route::post('/record', [RecordController::class, 'store'])
  ->name('record.store');

    //forma za izmenu podatka
    Route::get('/record/{record}/edit', [RecordController::class, 'edit'])
    ->name('record.edit');

    //izmena postojećeg podatka
Route::put('/record/{record}', [RecordController::class, 'update'])
->name('record.update');

//brisanje podatka
Route::delete('/record/{record}', [RecordController::class, 'destroy'])
->name('record.destroy');

//detaljan prikaz podatka
Route::get('/record/{record}', [RecordController::class, 'show'])
->name('record.show');

   
   /////////////////////////rute finances

   Route::get('/finance', [FinanceController::class, 'index'])
->name('finance.index');

Route::get('/finance/create', [FinanceController::class,'create'])
    ->name('finance.create');

  //validacija podataka i upis novog reda u tabelu
  Route::post('/finance', [FinanceController::class, 'store'])
  ->name('finance.store');

    //forma za izmenu podatka
    Route::get('/finance/{finance}/edit', [FinanceController::class, 'edit'])
    ->name('finance.edit');

    //izmena postojećeg podatka
Route::put('/finance/{finance}', [FinanceController::class, 'update'])
->name('finance.update');

//brisanje podatka
Route::delete('/finance/{finance}', [FinanceController::class, 'destroy'])
->name('finance.destroy');

//detaljan prikaz podatka
Route::get('/finance/{finance}', [FinanceController::class, 'show'])
->name('finance.show');


///////////RUTA ZA STATSITIKU
// Route::get('/statistic', [RecordController::class, 'statistic'])
// ->name('statistic');
Route::get('/statistic', [FilmController::class, 'statistic'])
->name('statistic');


});

require __DIR__ . '/auth.php';

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
