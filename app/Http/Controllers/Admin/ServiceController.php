<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\SaveImageTrait;

class ServiceController extends Controller
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
        return view('admin.services.index');
    }

    public function datatable(Request $request)
    {
        $items = Service::query()->orderBy('id', 'DESC')->search($request);
        return $this->filterDataTable($items, $request);
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {


        try {
             DB::beginTransaction();
             $data = $request->all();
             if ($request->hasFile('image')) {
                 $data['image'] = $this->saveImage($request->file('image'), 'services');
             }
             Service::create($data);


            DB::commit();
            return $this->response_api(200, __('admin.form.added_successfully'), '');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->response_api(400, $this->exMessage($e));
        }
    }


    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('admin.services.create', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->all();

        try {
            DB::beginTransaction();

            if ($request->input('remove_image') == '1') {
                if ($service->image) {
                    $this->deleteImage($service->image);
                    $data['image'] = null; // اجعل الحقل فارغًا
                }
            }

                if ($request->hasFile('image')) {
                    if ($service->image) {
                        $this->deleteImage($service->image);
                    }
                    $data['image'] = $this->saveImage($request->file('image'), 'abouts');

                }

            $service->update($data);

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
        $service=Service::findorfail($id);
        try {
            DB::beginTransaction();
            $service->delete();
            $this->deleteImage($service->image);
            DB::commit();
            return $this->response_api(200, __('admin.form.deleted_successfully'), '');

        }catch (\Exception $e) {
            DB::rollback();
            return $this->response_api(400, $this->exMessage($e));
        }

    }
}
