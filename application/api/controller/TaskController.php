<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/6
 * Time: 0:55
 */
namespace app\api\controller;
use app\api\model\Task;
use app\common\controller\Base;
use app\common\org\Res;
use app\api\model\Data;
use think\helper\Time;

class TaskController extends Base
{
    /**
     * 创建一个任务
     * @param Task $m
     * @param int $id
     * @return \think\response\Json
     */
    public function Create(Task $m, $id = 0, $type = 0)
    {
        $task = $this->request->post();
        $task['se_by_id'] = $this->uid;
        $task['clents_id'] = $id;

        if ($type != 0)
            $task['type'] = $type;
        //一审 二审 拿调令 添加外勤ID
        if ($task['type'] == 1 || $task['type'] == 2 || $task['type'] == 3) {
            $data = Data::get($id);
            $data->wuser_id = $task['re_by_id'];
            $data->save();
        }
        return $m->save($task) ? Res::Json(200) : Res::Json(400);
    }

    /**
     * 获取任务列表
     * @param Task $m
     * @return \think\response\Json
     */
    public function List(Task $m)
    {
        $params = $this->request->only(['page', 'rows', 'sort', 'order'], 'post');
        $rule = $this->request->post('rule');
        $fieids = $this->request->except(['page', 'rows', 'sort', 'order', 'rule', 'type'], 'post');
        $type = $this->request->post('type');
        //替换用户ID
        if (isset($fieids['uid'])) $fieids['uid'] = $this->uid;

        switch ($type) {
            case 'sousou':
                $lists = $m->search($params, $fieids);
                break;
            case 'list':
                $lists = $m->List($params, $rule, $fieids);
                break;
            case 'overdue':
                $lists = $m->overdue($params, $rule, $fieids);
                break;
            default:
                if ($rule == null || $fieids == null) {
                    $rule = "1 = :id";
                    $fieids = ['id' => 1];
                }
                $lists = $m->List($params, $rule, $fieids);
        }
        return json([
            'rows' => $lists,
            'total' => $m->total(),
            'type' => $type
        ]);
    }

    /**
     * _返回任务格式数组
     * @param $clents_id  客户id
     * @param $type       类型
     * @param $re_by_id   接收者ID
     * @param $time       任务时间
     * @return array
     */
    private function _systemTask($clents_id, $type, $re_by_id, $time, $tag = null, $error_msg = null)
    {
        $data = [
            'clents_id' => $clents_id,
            'type' => $type,
            'se_by_id' => 0,
            're_by_id' => $re_by_id,
            'task_time' => $time,
            'Tag' => $tag,
            'error' => $error_msg
        ];
        $newtask = new Task();
        return $newtask->isUpdate(false)->save($data);
    }

    //任务成功  如果用户组是外勤, 并且任务类型是1审的话就发布任务给内勤
    //如果用户组不是外勤.类型是1审二审,就修改DATA进度
    public function Finish($id)
    {
        $task = Task::get($id);
        $post = $this->request->post();
        if ($task->getData('finish_type') != 1)
            return Res::Json(400, '重复提交');
        if ($task->getData('re_by_id') != $this->uid)
            return Res::Json(400, "需处理用户不是前登录用户");
        $task->finish_type = 2;//成功
        $task->finish_time = time();
        $data = Data::get($task->clents_id);
        switch ($this->group_id) {
            /** 管理 */
            case self::GROUP_A:
                break;
            /** 业务 */
            case self::GROUP_Y:
                $task->ysuccess($data, $post);
                break;
            /** 内勤 */
            case self::GROUP_N:
                $task->nsuccess($data, $post);
                break;
            /** 外勤 */
            case self::GROUP_W:
                $task->wsuccess($data, $post);
                break;
        }
        return $task->save() ? Res::Json(200, '成功') : Res::Json(400);
    }


    //失败
    public function Failed($id)
    {
        $task = Task::get($id);
        if ($task->getData('finish_type') != 1)
            return Res::Json(400, '重复提交');
        if ($task->getData('re_by_id') != $this->uid)
            return Res::Json(400, '需处理用户不是当前登录用户');
        $errormsg = $this->request->param('error');
        $data = Data::get($task->clents_id);
        $task->error = $errormsg;
        $task->finish_type = 0;
        $task->finish_time = time();
        //外勤 外勤失败时候把回访任务备注失败信息.
        if ($this->group_id = 4) {
            $task->wFailed($data, $errormsg);
        }
        return $task->save() ? Res::Json(200, '提交成功') : Res::Json(400);
    }

    //转发 2种方案, 1 直接编辑转发 2 完成当前转发.  还是推荐完成后转发
    public function Forward($id, $clents_id = 0, $type = 0)
    {
        $task = Task::get($id);
        $task->finish_type = 3;//转发
        $task->finish_time = time();
        $post = $this->request->post();
        $post['se_by_id'] = $this->uid;
        $post['clents_id'] = $clents_id;
        $data = Data::get($clents_id);
        if ($type != 0) $post['type'] = $type;
        //修改所属外勤..
        if ($this->group_id == 4) {
            if ($post['type'] == Task::SIGN || $post['type'] == Task::SUBMIT ||
                $post['type'] == Task::GET_DIAOLING || $post['type'] == Task::SUBMIT_DATA
            ) {
                $data->setWuserById($post['re_by_id']);
            }
        }
        $newtask = new Task();
        if ($newtask->save($post)) {
            return $task->save() ? Res::Json(200) : Res::Json(400);
        } else {
            return Res::Json(400);
        }
    }
}