<?php

namespace App\Http\Controllers;

use App\Models\ModelPersons;
use Illuminate\Http\Request;

class Persons extends Controller
{
    private $objPersons;
    public function __construct()
    {
        $this->objPersons = new ModelPersons();

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Persons = $this->objPersons;
        $values = $Persons::all();

        return view('index',compact('values'));

    }


    public function create()
    {
        //

        $Persons = new ModelPersons();

    }


    public function edit($id)
    {
        //
    }

    public function find($name,$value){
        $Persons = $this->objPersons;
        $values = dd($Persons::all()->where($name,$value));

        return $values;
    }
    public function update(Request $request, $id)
    {
        $Persons = $this->objPersons;
        $searchValue = $request->input('name');
     //   $values = dd($Persons::all()->where('pet',$searchValue));
        return  $searchValue;
    }


    public function destroy($id)
    {
        $Persons = $this->objPersons;

        $Persons::destroy( collect([$id]) );

        $values = $Persons::all();

        return view('index',compact('values'));
    }
}
