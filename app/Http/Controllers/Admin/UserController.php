<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Entity\admin;
use App\Entity\adminGroup;
use App\Entity\adminRole;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class UserController extends Controller
{
    public $status = [0=>'启用', 1=>'锁定'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = admin::orderby('id')->paginate(5);
//        dd(1111);
        $sum = admin::count('id');
        $status = $this->status;
        return view('admin/userManager/index', compact('data', 'status', 'sum'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $status = $this->status;
//        dd(11);
        $data = admin::find($id);
//        dd($data->gid);

        //将管理员表中的gid给一个变量  为了查询所属组信息
        $gid = $data->gid;
        $str = adminGroup::find($gid);
//        dd($str->role_list);

        //查询所属组中的权限id字符串 分割并遍历为数组, 查询到权限信息
        $arr = explode(',', $str->role_list);
//        dd($arr);

        foreach($arr as $k=>$v) {
//            dump($v);
            $group_id[$k] = DB::table('adminrole')->where('id', $v)->first();

            $array = array_merge((array)$group_id);

//            dump($array);

        }
//        dd($array);


       return view('admin/userManager/showUser', compact('data', 'str', 'array', 'status'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = admin::find($id);
//        dd($data);
        $status = [0=>'启用', 1=>'锁定'];
        return view('admin/userManager/editUser', compact('data', 'status'));
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
//        dd($request->status);
        if (admin::where('id','=',$id)->update(['username'=>$request->username, 'password'=>bcrypt($request->password), 'gid'=>$request->gid, 'status'=>$request->status ]))
        {
//            dd(111);
            return redirect('/admin/user');
        } else {
            return back();
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
       return DB::table('admin')->delete($id);
    }
}
