<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $table = "school";
    public $timestamps = true;
    protected $primaryKey = "id";
    protected $guarded = [];
    //
    /**
     * 新增教师的分配班级学院
     * @return bool
     */
    public static function lx_create_class_school()
    {
        try {
            $data = self::select('school')->get();
            return $data;

        } catch (\Exception $e) {
            logError('操作失败', [$e->getMessage()]);
            return false;
        }
    }
}
