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

        return view('index',compact('values') );
    }


    public function create(Request $request)
    {
        //
        $Persons = $this->objPersons;
        $nameValue = $request['name'];
        $ageValue = $request['age'];
        $petValue = $request['pet'];
        $Persons::insert([
            "name"=>$nameValue,
            "pet"=>$petValue,
            "age"=>$ageValue
        ]);

        $values = $Persons::all();
        return view('index',compact('values'));
    }


    public function find($value)
    {
        $Persons = $this->objPersons;
        $valuesDB = "$value%";

        $values = $Persons::whereRaw('pet like ?  or name like ?  or age like ? ',[$valuesDB,$valuesDB,$valuesDB])->get();
        return view('index',compact('values') );
    }
    public function updateone(Request $request)
    {
        $Persons = $this->objPersons;
        $nameValue = $request['name'];
        $ageValue = $request['age'];
        $petValue = $request['pet'];
        $ids = $request['id'];

        $Persons::where('id',$ids)
        ->update([
            'name'=>$nameValue,
            'age'=>$ageValue,
            'pet'=>$petValue
        ]);
        $values = $Persons::all();
        return view('index',compact('values'));
    }


    public function destroyMany(Request $request)
    {
        $Persons = $this->objPersons;
        $ids = $request['ids'];
        $Persons::destroy( collect( $ids ) );

        $values = $Persons::all();

        return view('index',compact('values'));
    }

    public function destroyOne($id)
    {
        $Persons = $this->objPersons;

        $Persons::destroy( $id );

        $values = $Persons::all();

        return view('index',compact('values'));
    }
}
