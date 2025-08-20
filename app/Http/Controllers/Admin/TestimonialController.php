<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Testimonial;
use App\Traits\SaveImageTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestimonialController extends Controller
{
    use SaveImageTrait;
    // public function __construct()
    // {
    //     $this->middleware('permission:view_sliders|add_sliders', ['only' => ['index','store']]);
    //     $this->middleware('permission:add_sliders', ['only' => ['create','store']]);
    //     $this->middleware('permission:edit_sliders', ['only' => ['edit','update']]);
    //     $this->middleware('permission:delete_sliders', ['only' => ['destroy']]);
    // }

    public function index()
    {
        return view('admin.testimonials.index');
    }
    public function datatable(Request $request)
    {
        $items = Testimonial::query()->orderBy('id', 'DESC')->search($request);
        return $this->filterDataTable($items, $request);
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {

        try {
            DB::beginTransaction();

            $data = $request->all();

            if ($request->hasFile('image')) {
                $data['image'] = $this->saveImage($request->image, 'sliders');
            }

            Testimonial::create($data);
            DB::commit();
            return $this->response_api(200, __('admin.form.added_successfully'), '');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->response_api(400, $this->exMessage($e));
                }
    }

    public function edit($id)
    {
        $testimonial = Testimonial::find($id);
        return view('admin.testimonials.create', compact('testimonial'));
    }

    public function update(Request $request, $id)
    {


        try {
            DB::beginTransaction();

            $data = $request->all();
            $slider = Testimonial::find($id);
            if ($request->input('remove_image') == '1') {
                if ($slider->image) {
                    $this->deleteImage($slider->image);
                    $data['image'] = null; // اجعل الحقل فارغًا
                }
            }
            if ($request->hasFile('image')) {
                // حذف الصورة القديمة
                if ($slider->image) {
                    $this->deleteImage($slider->image);
                }
                $data['image'] = $this->saveImage($request->image, 'sliders');
            }

            $slider->update($data);

            DB::commit();
            return $this->response_api(200, __('admin.form.updated_successfully'), '');

        } catch (Exception $e) {
            DB::rollBack();
            return $this->response_api(400, $this->exMessage($e));
        }
    }

    public function destroy($id)
    {
        $slider = Testimonial::find($id);
        if(!$slider) {
            return $this->response_api(400, __('admin.form.not_existed'), '');
        }
        try {
            DB::beginTransaction();
            if ($slider->image) {
                $this->deleteImage($slider->image);
            }

            $slider->delete();

            DB::commit();
            return $this->response_api(200, __('admin.form.deleted_successfully'), '');

        } catch (Exception $e) {
            DB::rollBack();
            return $this->response_api(400, $this->exMessage($e));
        }
    }


}
