<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home')

;


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')
->middleware(['auth', 'verified']);
;

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');


use Illuminate\Http\Request;

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::post('/email/verify/resend', function(Request $request){
    $request->user()->sendEmailVerificationNotification();
    return back()->with(["message"=>"Verification link resent"]);
})->name('resend');

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// profile
Route::get('/profile', [App\Http\Controllers\Profile::class, 'getProfile'])->name('profile');
Route::post('/profile/addphoto', [App\Http\Controllers\Profile::class, 'addPhoto'])->name('addphoto');
// profile followers
Route::get('/profile/followers', [\App\Http\Controllers\FollowersController::class, 'page'])->name('followers');
//profile invite
Route::get('/profile/invites',[\App\Http\Controllers\InviteController::class, 'page'])->name('lookinvites');
//profile personal info set
Route::post('/profile/personal/save',[\App\Http\Controllers\PersonalInfoController::class, 'addInfo'])->name('savepersonals');
//profile gallery
Route::get('/profile/gallery', [\App\Http\Controllers\GalleryController::class, 'index'])->name('profilegallery');
Route::post('/profile/gallery/add', [\App\Http\Controllers\GalleryController::class, 'addToGallery'])->name('savegallery');
Route::get('/profile/gallery/show/{id}', [\App\Http\Controllers\GalleryController::class, 'photoById'])->name('profilephotobyid');
Route::post('/profile/gallery/deletephoto', [\App\Http\Controllers\GalleryController::class, 'deletePhotoById'])->name('deletephoto');
//gallery
//addcomment
Route::post('/gallery/addcomment', [\App\Http\Controllers\CommentController::class, 'addComment'])->name('addcomment');
//delete comment
Route::post('gallery/deletecomment', [\App\Http\Controllers\CommentController::class, 'deleteCommentById'])->name('deletecomment');

// visitors
Route::get('/visitor/profile/{id}/{name}', [\App\Http\Controllers\VisitorController::class, 'visitProfile'])->name('profilevisitor');
//visitors invite
Route::post('/visitor/profile/invite/', [\App\Http\Controllers\VisitorController::class, 'inviteProfile'])->name('invite');
//visitor gallery
//Route::get('/visitor/profile/gallery/{id}/{name}', [\App\Http\Controllers\GalleryController::class, 'getGalleryForVisitor'])->name('getgalleryforvisitor');
Route::get('/visitor/profile/gallery/show/{id}/{user_id}/{name}', [\App\Http\Controllers\GalleryController::class, 'visitorPhotoById'])->name('visitorphotoid');
// visitor delete comment
Route::post('gallery/visitor/deletecomment', [\App\Http\Controllers\CommentController::class, 'visitorDeleteCommentById'])->name('deletecommentbyvisitor');
// visitor block user
Route::post('/visitor/profile/block/', [\App\Http\Controllers\BlockController::class, 'block'])->name('blockuser');
Route::post('/visitor/profile/unlock/', [\App\Http\Controllers\BlockController::class, 'unlock'])->name('unlockuser');
Route::get('/visitor/profile/blocked', function(){return view('blocked');})->name('blocked');

//invite controller - accept - decline
Route::get('/profile/invites/accept/{id_A}/{id_B}', [\App\Http\Controllers\AcceptInviteController::class, 'acceptInvite'])->name('accept');
Route::get('/profile/invites/cancel/{id_A}/{id_B}', [\App\Http\Controllers\AcceptInviteController::class, 'cancelInvite'])->name('cancel');

//messages
//send
Route::post('/send', [\App\Http\Controllers\MessageController::class, 'sendMessage'])->name('sendmessage');
//profile-mail-box
Route::get('/profile/messages', [\App\Http\Controllers\MessageController::class, 'showMailBox'])->name('mailbox');
Route::get('/profile/messages/{id}/{page}/{name}', [\App\Http\Controllers\MessageController::class, 'showMailBox'])->name('mailbox.id');
Route::post('/21nzidadn/31312313213/request',[\App\Http\Controllers\MessageController::class, 'getLastMessage'])->name('last');


//party-profile
Route::get('/profile/party', [\App\Http\Controllers\PartyController::class, 'profileParty'])->name('profileparty');
Route::get('/profile/party/add', [\App\Http\Controllers\PartyController::class, 'addPartyPage'])->name('addpartypage');
Route::post('/profile/party/add/post', [\App\Http\Controllers\PartyController::class, 'postParty'])->name('postparty');
//delete party
Route::post('profile/party/delete', [\App\Http\Controllers\PartyController::class, 'deleteParty'])->name('deleteparty');
//party managaer
Route::get('/profile/party/manager', [\App\Http\Controllers\PartyController::class, 'showPartyManager'])->name('showmanager');
//partybox
Route::get('/partybox/{id}/{title}', [\App\Http\Controllers\PartyController::class, 'getPartyBox'])->name('partybox');
//joinparty
Route::post('/partybox/join', [\App\Http\Controllers\PartyController::class, 'join'])->name('joinparty');
//leaveparty
Route::post('/partybox/leave', [\App\Http\Controllers\PartyController::class, 'leave'])->name('leaveparty');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
