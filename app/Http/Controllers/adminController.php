<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Banji;
use App\Models\Class1;
use App\Models\Feedback;
use App\Models\Pre;
use App\Models\School;
use App\Models\Teacher;
use App\Models\Teacher_Class;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Class_;

class adminController extends Controller
{

    private static function userhandle($request)//加密账号
    {
        $registeredInfo = $request->except('password_confirmation');
        $registeredInfo['password'] = bcrypt($registeredInfo['password']);
        $registeredInfo['admin_id'] = $registeredInfo['admin_id'];
        return $registeredInfo;
    }

    /**
     * 测试的注册账号
     */
    public function res(Request $request)
    {
        $date = Admin::creteAdmin(self::userhandle($request));
        return $date ?
            json_success("增加成功", $date, 200) :
            json_fail("增加失败", null, 100);


    }

    /**登录账号
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function admin_login(Request $request)
    {
        $credentials = self::credentials($request);
        $token = auth('api')->attempt($credentials);//获取token

        return $token ?
            json_success('登录成功!', $token, 200) :
            json_fail('登录失败!账号或密码错误', null, 100);

    }

    protected function credentials($request)//从前端获取账号密码
    {
        return ['admin_id' => $request['admin_id'], 'password' => $request['password']];
    }

    /**
     * 管理员删除反馈
     */
    public function Lx_delete_feedback(Request $request)
    {
        $teacher_id = $request['teacher_id'];
        $created_at = $request['created_at'];
        $data = Feedback::lx_delete_feedback($teacher_id, $created_at);
        return $data ?
            json_success('删除成功!', $data, 200) :
            json_fail('删除失败！', null, 100);
    }

    /**
     * 按工号查询老师
     */
    public function Lx_select_teacher(Request $request)
    {

        $teacher_id = $request['teacher_id'];
        $data = Teacher::lx_select_teacher($teacher_id);
        return $data ?
            json_success('查询成功!', $data, 200) :
            json_fail('查询失败！', null, 100);
        }



    /**
     * 教师管理显示教师信息
     */
    public function Lx_teacher()
    {
        $data = Teacher::lx_teacher();
        return $data ?
            json_success('查询成功！', $data, 200) :
            json_fail('查询失败！', null, 100);
    }

    /**
     * 删除教师信息
     */
    public function Lx_delete_teacher(Request $request)
    {
        $data = Teacher::lx_delete_teacher($request['teacher_id']);
        return $data ?
            json_success('删除成功！', $data, 200) :
            json_fail('删除失败！', null, 100);
    }

    /**
     * 重置教师密码
     */

    public function Lx_update_teacher_password(Request $request)
    {
        $teacher_id = $request['teacher_id'];
        $password1 = 123456;
        $password2 = self::userHandle111($password1);
        $data = DB::table('teacher')->where('teacher_id', '=', $teacher_id)->update([
            'password' => $password2
        ]);
        return $data ?
            json_success('重置成功！', $data, 200) :
            json_fail('重置失败！', null, 100);
    }

    /**
     * 修改密码时重新加密
     */
    protected function userHandle111($password)   //对密码进行哈希256加密
    {
        $red = bcrypt($password);
        return $red;
    }

    /**
     *查看反馈
     */
    public function Lx_select_feedback(){
        $data = Feedback::lx_selete_feedback();
        return $data ?
            json_success('查询成功！', $data, 200) :
            json_fail('查询失败！', null, 100);
    }
    /**
     * 班级管理显示数据
     */

    public function Lx_select_class(){
        $data = Banji::lx_select_class();
        return $data?
            json_success('查询成功！',$data,200):
            json_fail('查询失败！',null,100);

    }

    /**
     * 班级管理搜索框搜索
     */
    public function Lx_select_id_class(Request $request){
        $class = $request['class'];
        $data = Banji::lx_select_id_class($class);
        return $data?
            json_success('查询成功！',$data,200):
            json_fail('查询失败！',null,100);
    }
    /**
     * 班级管理下的新增班级
     */
    public function Lx_create_class_info(Request $request){
        $school = $request['school'];
        $pre = $request['pre'];
        $class = $request['class'];
        $data = Banji::lx_create_class_info($school,$pre,$class);
        return $data?
            json_success('添加成功！',$data,200):
            json_fail('添加失败！',null,100);
    }

    /**
     * 班级管理的删除班级
     */
    public function Lx_delete_class(Request $request){
        $class = $request['class'];
        $data = Banji::lx_delete_class($class);
        return $data?
            json_success('删除成功！',$data,200):
            json_fail('删除失败！',null,100);
    }
    /**
     * 管理班级的显示已分配的班级
     */
    public function Lx_show_class(Request $request){
        $teacher_id = $request['teacher_id'];
        $data = Teacher_Class::lx_show_class($teacher_id);
        return $data?
            json_success('查询成功！',$data,200):
            json_fail('查询失败！',null,100);
    }

    /**
     * 管理班级下的删除班级
     */
    public function delete_class(Request $request){
        $class = $request['class'];
        $teacher_id = $request['teacher_id'];

        $data = Teacher_Class::delete_class($class,$teacher_id);
        return $data?
            json_success('删除成功！',$data,200):
            json_fail('删除失败！',null,100);
    }
    /**
     * 新增教师的分配班级学院
     */

    public function Lx_create_class_school(){
        $data = School::lx_create_class_school();
        return $data?
            json_success('分配成功！',$data,200):
            json_fail('分配失败！',null,100);
    }

    /**
     * 新增教师分配班级专业
     */
    public function Lx_create_teacher_class_pre(Request $request){
        $from_school = $request['from_school'];
        $data = Pre::lx_create_teacher_class_pre($from_school);
        return $data?
            json_success('分配成功！',$data,200):
            json_fail('分配失败！',null,100);
    }
    /**
     * 新增教师分配班级的班级
     */
    public function Lx_create_class_class(Request $request){
        $pre = $request['pre'];
        $data = Class1::lx_create_class_class($pre);
        return $data?
            json_success('分配成功！',$data,200):
            json_fail('分配失败！',null,100);
    }

    /**
     * 管理班级下提交新增班级
     */
    public function Lx_create_class(Request $request){
        $teacher_id = $request['teacher_id'];
        $class = $request['class'];
        $data = Teacher_Class::lx_create_class($teacher_id,$class);
        return $data?
            json_success('提交成功！',$data,200):
            json_fail('提交失败！',null,100);
    }

    /**
     *新增教师
     */
    public function Lx_create_teacher(Request $request){
        $teacher_id = $request['teacher_id'];
        $teacher_name = $request['teacher_name'];
        $password1 = 123456;
        $class = $request['class'];
        $teacher_school = $request['teacher_school'];
        $password2 = self::userHandle111($password1);
        $data = Teacher::lx_create_teacher($teacher_id,$teacher_name,$class,$teacher_school,$password2);
        return $data?
            json_success('提交成功！',$data,200):
            json_fail('提交失败！',null,100);
    }

}
