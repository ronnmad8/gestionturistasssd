<?php

namespace App\Http\Controllers\Mediafiles;

use App\Models\Mediafiles;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Transformers\MediafilesTransformer;

class MediafilesController extends ApiController
{

    public function __construct()
    {
        //$this->middleware('transform.input:'. MediafilesTransformer::class)->only(['index']);
        //$this->middleware('auth:api')->except(['index']);
    }


    /**
     * Display the specified resource.
     *
     * @param  Mediafiles  $textcontent
     * @return \Illuminate\Http\Response
     */

     public function index()
     {
         $data = Mediafiles::all();
         return $this->showAllWp($data);
         
     }
    
    public function show(Textcontent  $textcontent)
    {
       ///
    }

    public function store(Request $request)
    {
        $rules = [
            'visit_id' => 'required',
            'type' => 'required'
        ];

        $this->validate($request, $rules);
        $data = $request->all();
        
        $data->path = "storage/image/". time().rand(100,999).".".$data->type ;

        $mediafile = Mediafiles::create($data);

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            if($file != null){

                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                Storage::disk('public')->put('image/' . $filename, $file);
        
                $mediafile->filename = $filename;
                $mediafile->path = $data->path;
                $mediafile->url = Storage::disk('public')->url('images/' . $filename); // Use Storage::url
                $mediafile->save();
            }
        }

        return $this->showOne($Visit, 201);
        
    }

    public function update(Request $request)
    {
       ///
    }


    public function destroy(Red $red)
    {
        ///
    }

    public function edit($id)
    {
        //
    }

    public function create()
    {
        //
    }
}
