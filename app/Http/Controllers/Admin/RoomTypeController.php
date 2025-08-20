<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\RoomType;
use App\Traits\SaveImageTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class RoomTypeController extends Controller
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
        return view('admin.roomtypes.index');
    }

    public function datatable(Request $request)
    {
        $items = RoomType::query()->orderBy('id', 'DESC')->search($request);
        return $this->filterDataTable($items, $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.roomtypes.create');
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
                $data['image'] = $this->saveImage($request->file('image'),'roomtypes');
            }
                $type = RoomType::create($data);
            DB::commit();

            return $this->response_api(200 , __('admin.form.added_successfully'), '');
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
        $data['type'] = RoomType::findOrFail($id);
        return view('admin.roomtypes.create', $data);
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
            $type = RoomType::findOrFail($id);
            try {
                DB::beginTransaction();
                 if ($request->input('remove_image') == '1') {
                if ($type->image) {
                    $this->deleteImage($type->image);
                    $data['image'] = null; // اجعل الحقل فارغًا
                }
            }

                if ($request->hasFile('image')) {
                    if ($type->image) {
                        $this->deleteImage($type->image);
                    }
                    $data['image'] = $this->saveImage($request->file('image'), 'reomtypes');

                }
                    $type->update($data);
                DB::commit();

                return $this->response_api(200, __('admin.form.updated_successfully'), '');
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
       $type= RoomType::findorfail($id);
        if ($type->image) {
            $this->deleteImage($type->image);
        }
        $type->delete();

        return $this->response_api(200, __('admin.form.deleted_successfully'), '');
    }


    public function bluckDestroy(Request $request)
    {
        $ids = $request->id;
        foreach ($ids as $row) {
            $item = RoomType::find($row);
            if(!$item) {
                return $this->response_api(400 ,  __('admin.form.not_existed') , '');
            }
            $item->delete();
        }
        return $this->response_api(200, __('admin.form.deleted_successfully'), '');
      }
}

