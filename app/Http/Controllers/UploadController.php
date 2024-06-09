<?php

namespace App\Http\Controllers;
use App\Models\Foods;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UploadController extends Controller
{
    public function create()
    {
        return view('upload');
    }

    public function store(Request $request){
            $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'category' => ['required', 'string', 'max:255'],
                'image' => ['required','image','mimes:jpeg,png,jpg','max:2048'],
                'ingredients' => ['nullable','string'],
                'description' => ['nullable','string'],
                'price' => ['required','numeric','min:0'],
                'status' => ['required','in:active,inactive'],
            ]);
            //upload images
    
            $image = $request->image;
            $ex = $image->getClientOriginalExtension();
            $imagename = time().'.'.$ex;
            $image->move(public_path('uploads'),$imagename);
            
            //insert into database
            $foods = new Foods();
            $foods->title = $request->title;
            $foods->category = $request->category;
            $foods->image = $imagename; 
            $foods->ingredients = $request->ingredients;
            $foods->description = $request->description;
            $foods->price = $request->price;
            $foods->status = $request->status;
            
            $foods->save();
            return redirect()->route("upload.create")->with('success', 'Food uploaded successfully');        
    }

    public function update(Request $request, $id){
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'image' => ['nullable','image','mimes:jpeg,png,jpg','max:2048'],
            'ingredients' => ['nullable','string'],
            'description' => ['nullable','string'],
            'price' => ['required','numeric','min:0'],
            'status' => ['required','in:active,inactive'],
        ]);
        //upload images
        if($request->hasFile('image')){
            $image = $request->image;
            $ex = $image->getClientOriginalExtension();
            $imagename = time().'.'.$ex;
            $image->move(public_path('uploads'),$imagename);
        }else{
            $foods = Foods::withTrashed()->find($id);
            if($foods) {
                $imagename = $foods->image;
            } else {
                $imagename = null;
            }
        }
        
        //insert into database
       // $foods = Foods::findOrFail($id);
        $foods->title = $request->title;
        $foods->category = $request->category;
        $foods->image = $imagename; 
        $foods->ingredients = $request->ingredients;
        $foods->description = $request->description;
        $foods->price = $request->price;
        $foods->status = $request->status;
        
        $foods->save();
        return redirect()->route("food.list")->with('success', 'Food updated successfully');
    }

    public function show(){
        //$foods = DB::table('foods')->get();
        $foods = Foods::orderBy('created_at','DESC')->get();
        return view('foodList', compact('foods'));
    }

    public function trash(){
        //$foods = DB::table('foods')->get();
        $foods = Foods::onlyTrashed()->orderBy('created_at','DESC')->get();
        return view('trash', compact('foods'));
    }
    public function edit($id){
        $food = Foods::withTrashed()->find($id);
         //dd($food);
        // exit;
        return view('edit', compact('food'));
    }

    public function destroy($id){
        $food = Foods::withTrashed()->findOrFail($id);
        //File::delete(public_path('uploads/'.$food->image));
        $food->forceDelete();
        return redirect()->route('food.list')->with('success', 'Food deleted successfully');
    }

    public function search(Request $request){
        $search = $request->get('search_item');
        $foods = Foods::where('title','like','%'.$search.'%')->get();
        return view('foodList', compact('foods'));
    }
    public function short($term){
    $sortby = session()->get('sortby', 0); 
    //dd($sortby);
    if($term == $sortby){ // Check if the term matches the current sorting order
        $sortby = ($sortby == 0) ? 1 : 0; // Toggle the sorting order
    } else {
        $sortby = $term; // Set the sorting order to the provided term
    }

    session()->put('sortby', $sortby); // Update the sorting order in the session

    $foods = Foods::orderBy('id', ($sortby == 0) ? 'ASC' : 'DESC')->get(); // Sort the foods based on the sorting order

    return view('foodList', compact('foods'));
}
    public function restore($id){
        $food = Foods::withTrashed()->find($id);
        $food->restore();
        return redirect()->route('move.trash')->with('success', 'Food restored successfully');
    }
}
