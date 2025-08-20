<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\SaveImageTrait;
use App\Traits\HasImages;

class RoomController extends Controller
{
    use SaveImageTrait,HasImages;

    // public function __construct()
    // {
    //     $this->middleware('permission:view_abouts|add_abouts', ['only' => ['index','store']]);
    //     $this->middleware('permission:add_abouts', ['only' => ['create','store']]);
    //     $this->middleware('permission:edit_abouts', ['only' => ['edit','update']]);
    //     $this->middleware('permission:delete_abouts', ['only' => ['destroy']]);
    // }

    public function index()
    {
        return view('admin.rooms.index');
    }

    public function datatable(Request $request)
    {
        $items = Room::query()->orderBy('id', 'DESC')->search($request);
        return $this->filterDataTable($items, $request);
    }

    public function create()
    {
        $room_types = RoomType::all();
        return view('admin.rooms.create', compact('room_types'));
    }
public function show($id)
{

}
    public function store(Request $request)
    {

        try {
            DB::beginTransaction();

            $room = Room::create($request->except('media_repeater','images'));

            // حفظ الصور
            if ($request->hasFile('images')) {
                $this->storeModelImages($room, $request->file('images'));
            }

            DB::commit();

            return $this->response_api(200, __('admin.form.added_successfully'), '');
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->response_api(400, $this->exMessage($e));
        }
    }


    public function edit($id)
    {
        $room = Room::with('images')->findOrFail($id);
        $room_types = RoomType::all();
        return view('admin.rooms.create', compact('room', 'room_types'));
    }


    public function update(Request $request, $id)
    {
//        dd($request->all());
        try {
            DB::beginTransaction();

            $room = Room::findOrFail($id);
            $room->update($request->except([ 'images', 'id','current_image']));


            $this->updateModelImages(
                $room,
                $request->images ?? [],
                $request->id ?? [],
                $request->images_current ?? []
            );
            DB::commit();

            return $this->response_api(200, __('admin.form.updated_successfully'), '');

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->response_api(400, $this->exMessage($e));
        }
    }

    public function destroy($id)
    {
//        Project::destroy($id);
//         return $this->response_api(200, __('admin.form.deleted_successfully'), '');
//



        try {
            DB::beginTransaction();
            $room=Room::findorfail($id);
            if($room->images->count() > 0){
                foreach ($room->images as $image){
                    $this->deleteImage($image->image);
                }
            }

            Room::destroy($id);
            return $this->response_api(200, __('admin.form.deleted_successfully'), '');
        }
        catch (\Exception $e) {
            DB::rollBack();
            return $this->response_api(400, $this->exMessage($e));
        }
    }
}
