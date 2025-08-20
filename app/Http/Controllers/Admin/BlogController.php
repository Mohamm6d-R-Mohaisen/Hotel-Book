<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;


use App\Models\RoomType;
use App\Traits\SaveImageTrait;
use Illuminate\Support\Facades\DB;


class BlogController extends Controller
{
    use SaveImageTrait;
    // public function __construct()
    // {
    //     $this->middleware('permission:view_admins|add_admins', ['only' => ['index','store']]);
    //     $this->middleware('permission:add_admins', ['only' => ['create','store']]);
    //     $this->middleware('permission:edit_admins', ['only' => ['edit','update']]);
    //     $this->middleware('permission:delete_admins', ['only' => ['destroy']]);
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function index()
    {
        return view('admin.blogs.index');
    }

    public function datatable(Request $request)
    {
        $items = Blog::query()->orderBy('id', 'DESC');
        return $this->filterDataTable($items, $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();


        try {
            DB::beginTransaction();
             if ($request->hasFile('image')) {
                $data['image'] = $this->saveImage($request->file('image'),'blogs');
            }
                $blog = Blog::create($data);
            DB::commit();

            return $this->response_api(200 ,"Blog Added ", '');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->response_api(400, $this->exMessage($e));
        }
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['blog'] = Blog::findOrFail($id);
        return view('admin.bolgs.create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

            $data = $request->all();
            $blog = Blog::findOrFail($id);
            try {
                DB::beginTransaction();
                 if ($request->input('remove_image') == '1') {
                if ($blog->image) {
                    $this->deleteImage($blog->image);
                    $data['image'] = null; // اجعل الحقل فارغًا
                }
            }

                if ($request->hasFile('image')) {
                    if ($blog->image) {
                        $this->deleteImage($blog->image);
                    }
                    $data['image'] = $this->saveImage($request->file('image'), 'blogs');

                }
                    $blog->update($data);
                DB::commit();

                return $this->response_api(200, "blog Edited", '');
            } catch (\Exception $e) {
                DB::rollback();
                return $this->response_api(400, $this->exMessage($e));
            }

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $blog= Blog::findorfail($id);
        if ($blog->image) {
            $this->deleteImage($blog->image);
        }
        $blog->delete();

        return $this->response_api(200, __('admin.form.deleted_successfully'), '');
    }



}

