<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_admins|add_admins', ['only' => ['index','store']]);
        $this->middleware('permission:add_admins', ['only' => ['create','store']]);
        $this->middleware('permission:edit_admins', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_admins', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function index()
    {
        return view('admin.admins.index');
    }

    public function datatable(Request $request)
    {
        $items = Admin::query()->orderBy('id', 'DESC')->search($request);
        return $this->filterDataTable($items, $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('guard_name', 'admin')->get();
        return view('admin.admins.create', compact('roles'));
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
        $data['password'] = Hash::make($data['password']);


        try {
            DB::beginTransaction();
                $admin = Admin::create($data);
                $admin->assignRole($request->role);
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
        $data['admin'] = Admin::findOrFail($id);
        $data['roles'] = Role::where('guard_name', 'admin')->get();
        $data['adminRole'] = $data['admin']->roles->first();
        return view('admin.admins.create', $data);
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
            $admin = Admin::findOrFail($id);

            // فقط إذا تم إرسال password جديد
            if($request->password){
                $data['password'] = Hash::make($request->password);
            }
            try {
                DB::beginTransaction();
                    $admin->update($data);
                    $admin->syncRoles($request->role);
                DB::commit();

                return $this->response_api(200, __('admin.form.updated_successfully'), '');
            } catch (\Exception $e) {
                DB::rollback();
                return $this->response_api(400, $this->exMessage($e));
            }

    }

    public function activate($id)
    {
        try {
            $item = Admin::findOrFail($id);
            $item->status = 1 - $item->status;
            $item->save();
            return $this->response_api(200, __('admin.form.status_changed_successfully'), '');
        } catch (\Exception $e) {
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
        Admin::destroy($id);
        return $this->response_api(200, __('admin.form.deleted_successfully'), '');
    }


    public function bluckDestroy(Request $request)
    {
        $ids = $request->id;
        foreach ($ids as $row) {
            $item = Admin::find($row);
            if(!$item) {
                return $this->response_api(400 ,  __('admin.form.not_existed') , '');
            }
            $item->delete();
        }
        return $this->response_api(200, __('admin.form.deleted_successfully'), '');
      }
}
