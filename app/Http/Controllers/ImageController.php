<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Image;
class ImageController extends Controller
{

    public function refreshTable()
    {

   

           if(file_exists(public_path('data.json'))){
      $current_data=file_get_contents(public_path('data.json'));
      $array_data=json_decode($current_data,true);
       return $array_data;
    }
       
   
}

    public function addImage()
    {

  
           if(file_exists(public_path('data.json'))){
      $current_data=file_get_contents(public_path('data.json'));
      $array_data=json_decode($current_data,true);
       return  $array_data[count($array_data)-1];
    }
       
   
}
 public function delImage($key){
     
             if(file_exists(public_path('data.json'))){
      $current_data=file_get_contents(public_path('data.json'));
      $array_data=json_decode($current_data,true);
      $image_name=$array_data[$key]['image'];
      $file_path=public_path('images/'.$image_name);
      unlink($file_path);
      unset($array_data[$key]);
      $array_data = array_values($array_data);
      file_put_contents('data.json', json_encode($array_data));
     
      
    }



 }

  
   


    public function store(Request $request)
    {

    if ($request->ajax()) {
        $rules = array(
            'title'    =>  'required',
            'file' => 'required|image|mimes:png|max:10120'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['error' => $error->errors()->all()]);
        }

        $image = $request->file('file');

        $new_name = rand() . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('images'), $new_name);

        $form_data = array(
            'title'    =>  $request->title,
            'image' => $new_name
        );

      if(file_exists(public_path('data.json'))){
      $current_data=file_get_contents(public_path('data.json'));
      $array_data=json_decode($current_data,true);
      $array_data[]=$form_data;
      $final_data=json_encode($array_data);
      file_put_contents(public_path('data.json'),$final_data);


      }


    return response()->json(['success' => 'Image Added successfully.']);
 
  }
    }

 
}
