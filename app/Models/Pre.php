<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pre extends Model
{
    protected $table = "pre";
    public $timestamps = true;
    protected $primaryKey = "id";
    protected $guarded = [];
    //

    /**
     * 新增教师分配班级专业
     * @param $school
     * @return bool
     */
    public static function lx_create_teacher_class_pre($from_school)
    {
        try {
            $data = self::where('from_school',$from_school)
                ->select('pre')
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
}
