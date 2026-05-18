<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhotoRequest;
use App\Models\Photos;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class PhotoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();


        return view('photo.index', [
            'user' => $user,
            'photos' => Photos::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('photo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StorePhotoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePhotoRequest $request)
    {
        //getting file for request with key name 'photo'
        $file = $request->file('photo');
        //getting original name of our file and adding prefix with uniq_id
        $fileName = uniqid() . '_' . $file->getClientOriginalName();
        //moving file to our directory app/public/storage
        $file->move(public_path('storage'), $fileName);

        //creating new example model Photos?
        $photo = new Photos();
        //saving real file name into photo->name
        $photo->name = $fileName;
        //connecting photo user_id to our uploading user id
        $photo->user_id = $request->user()->id;
        //saving
        $photo->save();

        return redirect()->route('photo.index')->with('success', 'Photo added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Photos $photo
     * @return \Illuminate\Http\Response
     */
    public function edit(Photos $photo)
    {
        return view('photo.edit', [
            'photo' => $photo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photos $photo)
    {
        $uploadedFile = $request->file('photo');
        $photoRealName = uniqid() . '_' . $uploadedFile->getClientOriginalName();
        //checking file existing and deleting him for updating for new
        if ($photo->name && file_exists(public_path('storage/' . $photo->name))) {
            unlink(public_path('storage/' . $photo->name));
        }
        $uploadedFile->move(public_path('storage'), $photoRealName);

        $photo->name = $photoRealName;
        $photo->save();

        return redirect()->route('photo.index' )
            ->with('success', 'Photo updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Photos $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photos $photo)
    {
        try {
            $this->authorize('owner', $photo);
        } catch (AuthorizationException $e){
            return redirect()->route('photo.index')->with('error', 'not your photo');
        }

        $photo->delete();
        return redirect()->route('photo.index')
            ->with('success','Photo deleted');
    }
}
