<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = "feedback";
    public $timestamps = true;
    protected $primaryKey = "id";
    protected $guarded = [];

    /**
     * 管理员删除反馈
     * @param $teacher_id
     * @param $created_at
     * @return bool
     */
    public static function lx_delete_feedback($teacher_id, $created_at)
    {
        try {
            $data = self::where('teacher_id','=',$teacher_id)
                ->where('created_at','=',$created_at)
                ->delete();
            return $data;
        } catch (\Exception $e) {
            logError('操作失败', [$e->getMessage()]);
            return false;
        }
    }

    /**
     * 查看反馈
     * @return bool
     */

    public static function lx_selete_feedback()
    {
        try {
            $data = self::select('created_at','teacher_id','feedback')
                ->get();
            return $data;
        } catch (\Exception $e) {
            logError('操作失败', [$e->getMessage()]);
            return false;
        }
    }
}
