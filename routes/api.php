<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('admin/login','adminController@admin_login');//管理员登录
Route::get('admin/teacher','adminController@Lx_teacher');//教师管理显示教师信息
Route::post('admin/delete_teacher','adminController@Lx_delete_teacher');//删除老师信息
Route::post('admin/update_password','adminController@Lx_update_teacher_password');//重置教师密码
Route::post('admin/create_teacher','adminController@Lx_create_teacher');//新增教师
Route::get('admin/create_teacher_class_school','adminController@Lx_create_class_school');//新增教师分配班级学院
Route::post('admin/show_class','adminController@Lx_show_class');//管理班级的显示已分配班级
Route::post('admin/delete_class','adminController@delete_class');//管理班级下的删除班级
Route::post('admin/create_class','adminController@Lx_create_class');//管理班级的提交新增班级
Route::post("admin/select_teacher", 'adminController@Lx_select_teacher');//通过工号查询老师信息
Route::get('admin/select_class','adminController@Lx_select_class');//班级管理显示数据
Route::post('admin/select_id_class','adminController@Lx_select_id_class');//班级管理搜索框搜索
Route::post('admin/delete_class_info','adminController@Lx_delete_class');//班级管理删除班级
Route::post('admin/create_class_info','adminController@Lx_create_class_info');//班级管理下的新增班级
Route::get("admin/select_feedback", 'adminController@Lx_select_feedback');//查看反馈
Route::post("admin/delete_feedback", 'adminController@Lx_delete_feedback');//删除反馈
Route::post('admin/create_teacher_class_pre','adminController@Lx_create_teacher_class_pre');//新增教师分配班级专业
Route::post('admin/create_teacher_class_class','adminController@Lx_create_class_class');//新增教师分配班级的班级










