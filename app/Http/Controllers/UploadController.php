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
            $imagename = Foods::find($id)->image;
        }
        
        //insert into database
        $foods = Foods::findOrFail($id);
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
        $food = Foods::find($id);
        // dd($food);
        // exit;
        return view('edit', compact('food'));
    }

    public function destroy($id){
        $food = Foods::findOrFail($id);
        //File::delete(public_path('uploads/'.$food->image));
        $food->delete();
        return redirect()->route('food.list')->with('success', 'Food deleted successfully');
    }

    public function search(Request $request){
        $search = $request->get('search_item');
        $foods = Foods::where('title','like','%'.$search.'%')->get();
        return view('foodList', compact('foods'));
    }
    public function short($term){
        $sortby1 = $term;
        $sortby=0;
        if($sortby != $sortby1){
            $foods = Foods::orderBy('id','ASC')->get();
            $sortby = 1;
        }else{
            $foods = Foods::orderBy('id','DESC')->get();
            $sortby = 0;
        }
        // $foods = Foods::orderBy('id','ASC')->get();
        return view('foodList', compact('foods'));
    }
}
