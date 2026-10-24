<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Album;
use App\Photo;
use App\Package;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $albums = Album::all();
        return view('admin.photo_album.index',compact('albums'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $packages = Package::all();
        return view('admin.photo_album.create', compact('packages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $album_data = array(
            'package_id' => $request->package_id,
            'slug' => 'album-'.$request->package_id,
        );
        $album = Album::create($album_data);

        if ($request->image && count($request->image) > 0) {
            $i = 0;
            foreach ($request->image as $image)
            {
                $data = array(
                    'album_id' => $album->id,
                    'caption' => $request->image_caption[$i],
                );

                $photo = Photo::create($data);

                $image_name = $photo->id . '.'.$image->extension();
                $path = $image->move('uploads/photo/', $image_name);
                $photo->image = $image_name;
                $photo->imageThumb($path, 'photo');
                $photo->save();
            $i++;
            }
        }
        return redirect()->route('albums.index')->with('success', 'Album added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Album $album)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Album $album)
    {
        $packages = Package::all();
        return view('admin.photo_album.edit',compact('album','packages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Album $album)
    {
        $album_data = array(
            'package_id' => $request->package_id,
            'slug' => 'album-'.$request->package_id,
        );
        $albums = Album::where('id',$album->id)->update($album_data);

        if($request->edit_image_id && count($request->edit_image_id) > 0){
            $i = 0;
            foreach ($request->edit_image_id as $image_id) {
                $photo = Photo::find($image_id);
                $photo->caption = $request->edit_image_caption[$i];
                $photo->save();
            $i++;
            }

        }

        if ($request->image && count($request->image) > 0) {
            $i = 0;
            foreach ($request->image as $image) {

                $data = array(
                    'album_id' => $album->id,
                    'caption' => $request->image_caption[$i],
                );

                $photo = Photo::create($data);

                $image_name = $photo->id . '.'.$image->extension();
                $path = $image->move('uploads/photo/', $image_name);

                $photo->image = $image_name;
                $photo->imageThumb($path, 'photo');
                $photo->save();

            $i++;
            }
        }

        return redirect()->route('albums.index')->with('success', 'Album saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Album $album)
    {
        if($album){

            foreach ($album->photos as $photo) {
                if($photo->image){
                    // foreach (Photo::$_thumbdir as $dir) {
                    //     $old_image = public_path('uploads/photo/' . $dir . '/' . $photo->image);
                    //     if(file_exists($old_image)){
                    //         unlink($old_image);
                    //     }
                    // }
                    $image = public_path('uploads/photo/' . $photo->image);
                    if(file_exists($image)){
                        unlink($image);
                    }
                }
                $photo->delete();
            }

            if($album->delete()){
                return redirect()->route('albums.index')->with('success', 'Album deleted.');
            }else{
                return redirect()->route('albums.index')->with('error', 'Error while deleting Album.');
            }

        }else{
            abort();
        }
    }

    public function photodelete(Request $request)
    {
        if($request->id){
            $photo = Photo::find($request->id);
            if($photo){
                if($photo->image){
                    // foreach (Photo::$_thumbdir as $dir) {
                    //     $old_image = public_path('uploads/photo/' . $photo->image);
                    //     if(file_exists($old_image)){
                    //         unlink($old_image);
                    //     }
                    // }
                    $image = public_path('uploads/photo/' . $photo->image);
                    if(file_exists($image)){
                        unlink($image);
                    }
                }
                $photo->delete();
                return 'success';
            }
        }
        return 'error';
    }
}
