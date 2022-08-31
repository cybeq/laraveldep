<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Intervention\Image\ImageManager;
use Intervention\Image\Image;
use App\Http\Controllers\UserCustomController;
use App\Http\Controllers\BlockController;
class GalleryController extends Controller
{
    public function __construct(){
        $this->middleware('verified');
    }
    public function index(){
        return view('profilegallery');
    }

    public function addToGallery(Request $request){
        $check = DB::table('photos')->select()->where('user_id', Auth::user()->id)
            ->get()->count();
        if($check>9) return back();



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


//
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

        $galleryImage = new GalleryImage;
        $galleryImage->user_id = Auth::user()->id;
        $galleryImage->url = 'images/'.$image->basename;
        $galleryImage->save();
        return back();
    }

    public static function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return "gallery_".$randomString;
    }

    public function getGallery(){
        $count = DB::table('photos')->select()->where('user_id', Auth::user()->id)
            ->get()->toArray();
        return $count;
    }
    public function getPhotoById($id){
        $photo = DB::table('photos')->select()->where('id', $id)
            ->get()->toArray();
        return $photo;
    }

    public function photoById(Request $request){
        $photo = DB::table('photos')->select()->where('id', $request->id)
            ->get()->toArray();
        if(empty($photo)) return abort(404);
        if($photo[0]->user_id != Auth::user()->id) return abort(404);

        return view('profilegalleryid')->with(['id'=>$request->id]);
    }

    public function visitorPhotoById(Request $request){

        $photo = DB::table('photos')->select()->where('id', $request->id)
            ->get()->toArray();
        if(empty($photo)) return abort(404);
        if($photo[0]->user_id == Auth::user()->id) return abort(404);
        if($photo[0]->user_id != $request->user_id) return abort(404);
        $UsrController = new UserCustomController();
        if($UsrController->getUserDataById($photo[0]->user_id)[0]["name"] != $request->name) abort(404);

        $blockController = new BlockController();
        if($blockController->checkVisitorBlocked($photo[0]->user_id)){return view('blocked');};



        return view('visitorgalleryid')->with(['photo'=>$photo]);
    }

    public function deletePhotoById(Request $request){
        if($request->user_id==Auth::user()->id) {
            DB::table('photos')->where('id', $request->id)->delete();
            DB::table('comments')->where('photo_id', $request->id)->delete();
            return redirect()->route('profilegallery');
        }
            return abort(404);
        }
//visitor
public function getGalleryForVisitor(Request $request){
        $controller = new UserCustomController();
        if($request->id == Auth::user()->id) return redirect()->route('profilegallery');

        if($request->name != $controller->getUserDataById($request->id)[0]['name']) abort(404);

        $photos = DB::table('photos')->select()->where('user_id', $request->id)
        ->get()->toArray();



        return view('visitorgallery')->with(['photos'=>$photos]);
}
public function getShortVisitorGallery($id){
    $photos = DB::table('photos')->select()->where('user_id', $id)
        ->get()->toArray();
    return $photos;
}
}
