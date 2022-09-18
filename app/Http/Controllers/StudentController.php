<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Log;
use Exception;
use App\Models\student;

class StudentController extends Controller
{
    
    public function getAllStudent(){
        try{
            $students = Student::orderBy('id','DESC')->get();
            return response()->json($students);
        }catch(Exception $e){
            Log::error($e);
        }
    }

    public function getByid($id){
        try{
            $students = Student::findOrFail($id);
            return response()->json($students);
        }catch(Exception $e){
            Log::error($e);
        }
    }

    public function student(Request $request){
        $imagesName = [];
        $response = [];
        if($request->has('images')) {
                $image = $request->file('images');
                $name = time(). '.'.$image->getClientOriginalExtension();
                $image->move('uploads/', $name);

                Student::create([
                    'name' => $request->name,
                    'gender' => $request->gender,
                    'DOB'=> $request->dob,
                    'avatar' => $name
                ]);

            $response["status"] = "successs";
            $response["message"] = "Success! image(s) uploaded";
        }

        else {
            $response["status"] = "failed";
            $response["message"] = "Failed! image(s) not uploaded";
        }
        return response()->json($response);
    }

    public function update(Request $request,$id){
        $students = Student::findOrFail($id);
        if($request->images == null){
                $students->update([
                    'name' => $request->name,
                    'gender' => $request->gender,
                    'DOB'=> $request->dob
                ]);
        }else{
            $image_path = public_path("uploads/$students->avatar");

            $image = $request->file('images');
            $name = time(). '.'.$image->getClientOriginalExtension();
            $image->move('uploads/', $name);
                $students->update([
                    'name' => $request->name,
                    'gender' => $request->gender,
                    'DOB'=> $request->dob,
                    'avatar' =>$name,
                ]);

            if (File::exists($image_path)) {
                //File::delete($image_path);
                unlink($image_path);
            }
        }

        return response()->json('berhasil');
    }

    public function delete($id){
        $students = Student::findOrFail($id);
        
        $image_path = public_path("uploads/$students->avatar");
            if (File::exists($image_path)) {
                //File::delete($image_path);
                unlink($image_path);
            }
        $students->delete();
        return response()->json('berhasil');

    }
    

}
