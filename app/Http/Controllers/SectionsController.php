<?php

namespace App\Http\Controllers;

use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections=sections::all(); //select * from table
    return view('dashboard.sections.sections',compact('sections')); //وانت رايح الصفحه ديه خدوا معاك
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

/*
       $input=$request->all();
       $b_exist=sections::where('section_name',$input ['section_name'])->exists(); //   مينفعش  اضيف قسمين نفس الاسم
//لوموجود الاسمين شبه بعض اعرض الرساله ديه
       if($b_exist){
        session()->flash('Error','خطأ القسم مسجل سابقا');
        return redirect('/sections');
       }
       else{
        */

        $input=$request->validate([
            'section_name'=>'required|unique:sections',
            'description'=>'required|min:11|max:177',

        ],[
        'section_name.required'=>'يرجى ادخال اسم القسم',
        'section_name.unique'=>'هذا القسم مسجل سابقا',
        'description.required'=>'يرجى ادخال الوصف',
        'description.min'=>'الوصف يجب ان يكون على الاقل احد عشر رقما',
        'description.max'=>'الوصف على الاكثر يجب ان يكون مائة وسبع وسبعون حرفا',
        ]);
      sections::create([   //كريت الحاجه ديه فى الداتا بيز
        'section_name'=>$request->section_name,
        'description'=>$request->description,

      ]);
      session()->flash('Add','تم اضافة القسم بنجاح');
      return redirect('/sections');


    }

    /**
     * Display the specified resource.
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
       $id=$request->id;
       $section=$request->validate([
        'section_name'=>'required|unique:sections',
            'description'=>'required|min:11|max:177',

       ],[
        'section_name.required'=>'يرجى ادخال اسم القسم',
        'section_name.unique'=>'هذا القسم مسجل سابقا',
        'description.required'=>'يرجى ادخال الوصف',
        'description.min'=>'الوصف يجب ان يكون على الاقل احد عشر رقما',
        'description.max'=>'الوصف على الاكثر يجب ان يكون مائة وسبع وسبعون حرفا',
       ]);
     $section=sections::find($id);
      $section->update([
'section_name'=>$request->section_name,
'description'=>$request->description,
       ]);
session()->flash('Edit','تم التعديل بنجاح');
return redirect('/sections');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id=$request->id;
$section=sections::findorfail($id);
$section->delete();
session()->flash('Delete','تمت عملية الحذف بنجاح');
return redirect('/sections');

    }

}
