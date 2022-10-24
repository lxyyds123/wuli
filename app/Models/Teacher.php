<?php

namespace App\Models;

use AlibabaCloud\SDK\OSS\OSS\DeleteMultipleObjectsRequest\body\delete;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Teacher extends Model
{
    protected $table = "teacher";
    public $timestamps = true;
    protected $primaryKey = "id";
    protected $guarded = [];

    /**
     * 通过工号查询老师信息
     * @param $teacher_id
     * @return bool
     */

    public static function lx_select_teacher($teacher_id)
    {
        try {
            $data = self::where('teacher_id','=',$teacher_id)
                ->select('teacher_id','teacher_name','teacher_school')
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
     * 教师管理显示教师信息
     * @param $teacher_id
     * @return bool
     */

    public static function lx_teacher()
    {
        try {
            $data = self::select('teacher_id','teacher_name','teacher_school')
            ->get();
            return $data;
        } catch (\Exception $e) {
            logError('操作失败', [$e->getMessage()]);
            return false;
        }
    }

    /**
     * 删除老师信息
     * @param $teacher_id
     * @return bool
     */
    public static function lx_delete_teacher($teacher_id)
    {
        try {
            $data = self::where('teacher_id',$teacher_id)
                ->delete();
            return $data;
        } catch (\Exception $e) {
            logError('操作失败', [$e->getMessage()]);
            return false;
        }
    }
    /**
     * 查询该用户被创建的个数
     */
    public static function lx_checknumber($request){
        $teacher_id = $request['teacher_id'];
        try {
            $count = self::select('teacher_id')
                ->where('teacher_id',$teacher_id)
                ->count();
            return $count;
        }catch (\Exception $e) {
            logError("账号查询失败！", [$e->getMessage()]);
            return false;
        }
    }

    /**
     * 管理班级的显示已分配班级
     * @param $teacher_id
     * @return bool
     */

    public static function show_class($teacher_id)
    {
        try {
            $data = Teacher::where('teacher_id',$teacher_id)
                ->select('teacher_class1','teacher_class2','teacher_class3','teacher_class4','teacher_class5')
                ->get();
            return $data;
        } catch (\Exception $e) {
            logError('操作失败', [$e->getMessage()]);
            return false;
        }
    }


    /**
     * 新增教师
     * @param $teacher_id
     * @param $teacher_name
     * @param $class
     * @param $teacher_school
     * @param string $password2
     * @return array|null
     */

    public static function lx_create_teacher($teacher_id, $teacher_name, $class, $teacher_school,string $password2)
    {
            try {
                $data1 = self::where('teacher_id',$teacher_id)
                    ->count();
                if($data1 == 0){
                       $res1 =self::create([
                        'teacher_id' => $teacher_id,
                        'password' => $password2,
                        'teacher_name' => $teacher_name,
                        'teacher_school' => $teacher_school,
                    ]);
                    $red['res1'] = $res1;
                    $count = count($class);
                    for ($i=0;$i<$count;$i++){
                        $class1=$class[$i];
                        $time=Carbon::now()->toDateTimeString();
                        $res2 = DB::table('teacher_class')
                            ->insert([
                                'teacher_id' => $teacher_id,
                                'class' => $class1,
                                'created_at'=>$time,
                                'updated_at'=>$time,
                            ]);
                        $red['res2'] = $res2;
                    }
                return $red;
                }
                else{
                    return null;
                }
            }
            catch (\Exception $e) {
                logError('操作失败', [$e->getMessage()]);
                return null;
            }
        }
}
