<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Class1 extends Model
{
    //
    protected $table = "class";
    public $timestamps = true;
    protected $primaryKey = "id";
    protected $guarded = [];

    /**
     * 新增教师分配班级的班级
     * @param $pre
     * @return bool
     */
    public static function lx_create_class_class($pre)
    {
        try {
            $data = self::where('pre','=',$pre)
                ->select('class')
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
