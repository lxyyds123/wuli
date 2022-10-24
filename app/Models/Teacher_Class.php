<?php

namespace App\Models;

use AlibabaCloud\SDK\OSS\OSS\SelectObjectRequest\body\selectRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Teacher_Class extends Model
{
    protected $table = "teacher_class";
    public $timestamps = true;
    protected $primaryKey = "id";
    protected $guarded = [];


    /**
     * 管理班级的显示已分配的班级
     * @param $teacher_id
     * @return bool
     */
    public static function lx_show_class($teacher_id)
    {

        try {
            $data = self::select('class')
                ->where('teacher_id',$teacher_id)
                ->get();
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
     * 管理班级下的删除班级
     * @param $class
     * @return bool
     */

    public static function delete_class($class,$teacher_id)
    {
        try {
            $data = self::where('class',$class)
                ->where('teacher_id',$teacher_id)
                ->delete();
            return $data;
        } catch (\Exception $e) {
            logError('操作失败', [$e->getMessage()]);
            return false;
        }
    }

    /**
     * 管理班级下提交新增班级
     * @param $teacher_id
     * @param $teacher_class
     * @return false
     */

    public static function lx_create_class($teacher_id, $class)
    {
        $data=self::where('class',$class)
        ->count();
        if($data==0){
            try {
                $data = self::create([
                    'teacher_id' => $teacher_id,
                    'class' => $class
                ]);
                return $data;
            } catch (\Exception $e) {
                logError('操作失败', [$e->getMessage()]);
                return false;
            }
        }else{
            return false;
        }

    }
}
