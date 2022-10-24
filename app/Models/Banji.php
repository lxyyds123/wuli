<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Banji extends Model
{
    protected $table = "total";
    public $timestamps = true;
    protected $primaryKey = "id";
    protected $guarded = [];

    /**
     * 班级管理显示数据
     * @return bool
     */
    public static function lx_select_class()
    {
        try {
            $data = self::select('school','pre','class')
            ->get();
            return $data;

        } catch (\Exception $e) {
            logError('操作失败', [$e->getMessage()]);
            return false;
        }


    }

    /**
     * 班级管理搜索框搜索
     * @param $class
     * @return bool
     */
    public static function lx_select_id_class($class)
    {
        try {
            $data = self::select('school','pre','class')
                ->where('class',$class)->get();
             if($data[0]!=null){
                 return $data;
             }else{
                 return false;
             }
        } catch (\Exception $e) {
            logError('操作失败', [$e->getMessage()]);
            return false;
        }
    }

    /**
     * 班级管理的删除班级
     * @param $class
     * @return bool
     */

    public static function lx_delete_class($class)
    {
        try {
            self::where('class', '=', $class)->delete();
            DB::table('class')
                ->where('class', '=', $class)->delete();
            DB::table('student')
                ->where('class','=',$class)->delete();
            DB::table('teacher_class')
                ->where('class','=',$class)->delete();
            return true;
        } catch (\Exception $e) {
            logError('操作失败', [$e->getMessage()]);
            return false;
        }
    }

    /**
     * 班级管理下的新增班级
     * @param $school
     * @param $pre
     * @param $class
     * @return bool
     */
    public static function lx_create_class_info($school, $pre, $class)
    {
        $data = self::where('class',$class)
            ->count();
        $data1 = Class1::where('class',$class)
            ->count();
        if($data == 0 && $data1 == 0){
            try {
                DB::table('total')
                    ->insert([
                        'school' => $school,
                        'pre' => $pre,
                        'class' => $class
                    ]);
                DB::table('class')
                    ->insert([
                        'pre' => $pre,
                        'class' => $class
                    ]);
                return true;
            } catch (\Exception $e) {
                logError('操作失败', [$e->getMessage()]);
                return false;
            }
        }else{
            return false;
        }

    }

}
