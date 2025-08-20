<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\SaveImageTrait;

class AboutController extends Controller
{
    use SaveImageTrait;

    // public function __construct()
    // {
    //     $this->middleware('permission:view_abouts|add_abouts', ['only' => ['index','store']]);
    //     $this->middleware('permission:add_abouts', ['only' => ['create','store']]);
    //     $this->middleware('permission:edit_abouts', ['only' => ['edit','update']]);
    //     $this->middleware('permission:delete_abouts', ['only' => ['destroy']]);
    // }

    public function index()
    {
        return view('admin.abouts.index');
    }

    public function datatable(Request $request)
    {
        $items = About::query()->orderBy('id', 'DESC');
        return $this->filterDataTable($items, $request);
    }

    public function create()
    {
        return view('admin.abouts.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try {
             DB::beginTransaction();
            $about = About::first();

            if ($request->hasFile('image1')) {
                $data['image1'] = $this->saveImage($request->file('image1'),'abouts');
            }
             if ($request->hasFile('image2')) {
                $data['image2'] = $this->saveImage($request->file('image2'),'abouts');
            }
            if ($about) {
                $about->update($data);
            } else {
                $about = About::create($data);
            }





            DB::commit();
            return $this->response_api(200, __('admin.form.added_successfully'), '');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->response_api(400, $this->exMessage($e));
        }
    }


    public function edit($id)
    {
        $about = About::findOrFail($id);
        return view('admin.abouts.create', compact('about'));
    }

    public function update(Request $request, About $about)
    {
        $data = $request->all();

        try {
            DB::beginTransaction();

            if ($request->input('remove_image') == '1') {
                if ($about->image) {
                    $this->deleteImage($about->image);
                    $data['image'] = null; // اجعل الحقل فارغًا
                }
            }

                if ($request->hasFile('image1')) {
                    if ($about->image) {
                        $this->deleteImage($about->image);
                    }
                    $data['image1'] = $this->saveImage($request->file('image1'), 'abouts');

                }

                  if ($request->hasFile('image2')) {
                    if ($about->image) {
                        $this->deleteImage($about->image);
                    }
                    $data['image2'] = $this->saveImage($request->file('image2'), 'abouts');

                }
                $about->update($data);

                DB::commit();
                return $this->response_api(200, __('admin.form.updated_successfully'), '');
            }
        catch(\Exception $e) {
                DB::rollback();
                return $this->response_api(400, $this->exMessage($e));
            }

    }


    public function destroy($id)
    {
//        About::destroy($id);
//        return $this->response_api(200, __('admin.form.deleted_successfully'), '');
        $about=About::findorfail($id);
        try {
            DB::beginTransaction();
            $this->deleteImage($about->image);
            $about->delete();
            DB::commit();
            return $this->response_api(200, __('admin.form.deleted_successfully'), '');

        }catch (\Exception $e) {
            DB::rollback();
            return $this->response_api(400, $this->exMessage($e));
        }

    }
}
