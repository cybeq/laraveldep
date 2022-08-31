<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;


class Profile extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getProfile()
    {
        $photos = null;
        $photos = DB::table('users')->where('id',
        Auth::user()->id
        )->get()->toArray();


        $photos = json_decode(json_encode($photos), true);



        return view('profile')->with(array('photos'=>$photos));
    }
    public function addPhoto(Request $request){

        if ($request->file('image') == null) {
            $file = "";
        }else{

            $allowedMimeTypes = ['image/jpg', 'image/jpeg','image/gif','image/png'];
            $contentType = $request->file('image')->getClientMimeType();
            if(! in_array($contentType, $allowedMimeTypes) ){
                return response()->json('error: Not an image');
            }
        }


        $manager = new ImageManager(['driver'=>'imagick']);

// read image from file system
        $image = $manager->make($request->file('image'));
        $height = $image->height();
        $width = $image->width();
        while($height>900){
            $height*=0.9;
            $width*=0.9;
        }
        while($width>900){
            $height*=0.9;
            $width*=0.9;
        }
        $image->resize($width, $height);

        $image->encode('jpg', 75);


        $image->save('images/'.self::generateRandomString(40).'.jpg');


        DB::table('users')
            ->where('id', Auth::user()->id)
            ->update(['avatar' => 'images/'.$image->basename]);

//        DB::insert('insert into photos (user_id, url) values (?, ?)',
//            [Auth::user()->id, URL::asset('images').'/'.$image->basename]);

        return back();



    }



   public static function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
