<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/6
 * Time: 0:55
 */
namespace app\api\controller;
use app\api\model\Task;
use app\common\org\Res;
use app\api\controller\DataController;
use app\api\model\Data;
use think\Db;
use think\helper\Time;

class TaskController extends DataController
{
    /**
     * 创建一个任务
     * @param Task $m
     * @param int $id
     * @return \think\response\Json
     */
    public function taskCreate(Task $m, $id = 0, $type = 0)
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
    public function taskList(Task $m)
    {
        $params = $this->request->only(['page', 'rows', 'sort', 'order'], 'post');
        $rule = $this->request->post('rule');
        $fieids = $this->request->except(['page', 'rows', 'sort', 'order', 'rule', 'type'], 'post');
        $type = $this->request->post('type');
        //替换用户ID
        if (isset($fieids['uid'])) $fieids['uid'] = $this->uid;

        if ($type == 'sousou') {
            // 没有条件显示所有
            if ($rule == null || $fieids == null) {

                $rule = "1 = :id";
                $fieids = ['id' => 1];

            }

            $lists = $m->overdue($params, $rule, $fieids);

        } else {
            //没有条件显示所有
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
    public function taskFinish($id)
    {
        $task = Task::get($id);
        $tag = $this->request->post();
        if ($task->getData('finish_type') != 1)
            return Res::Json(400, '重复提交');
        if ($task->getData('re_by_id') != $this->uid)
            return Res::Json(400, "需处理用户不是前登录用户");

        $task->finish_type = 2;//成功
        $task->finish_time = time();

        $data = Data::get($task->clents_id);

        $re_by_id = Db::table('Data')->where('id', $task->clents_id)->value('user_id');

        //内勤 任务类型 是一审二审拿调令 修改DATA进度
        if ($this->group_id = 2) {
            switch ($task->type) {

                case Task::BACK_SIGN://回访 - 一审
                    if (!$task->Tag['success'] == false) {

                        $this->sign($task->clents_id);
                        //约号 3天后
                        $envd = $this->_systemTask($task->clents_id, Task::APPOINTMENT, $re_by_id, Time::daysAfter(1));
                        //计生 体检 盖章
                        $envd = $this->_systemTask($task->clents_id, Task::SUBMIT_DATA, $re_by_id, Time::daysAfter(7));

                    } else {

                        $envd = $this->_systemTask($task->clents_id, Task::APPOINTMENT, $re_by_id, Time::daysAfter(3));

                    }
                    break;

                case Task::SUBMIT_DATA:// 1.体检, 2.盖章 3.计生  必须都完成了才不会再次发布任务

                    $tag['js'] = isset($tag['js']) ? true : false;
                    $tag['tj'] = isset($tag['tj']) ? true : false;
                    $tag['gz'] = isset($tag['gz']) ? true : false;
                    if ($tag['js'] == false || $tag['tj'] == false || $tag['gz'] == false) {
                        $envd = $this->_systemTask(
                            $task->clents_id,
                            Task::SUBMIT_DATA, $re_by_id,
                            Time::daysAfter(8), $tag
                        );
                    }
                    break;

                case Task::BACK_SUBMIT://回访 - 二审

                    if ($task->Tag['success'] != false) {

                        $this->submit($task->clents_id);

                    } else {

                        $envd = $this->_systemTask($task->clents_id, Task::APPOINTMENT, $re_by_id, Time::daysAfter(3));

                    }
                    break;

                case Task::BACK_DIAOLIN://回访 - 拿调令
                    $this->takeDiaol($task->clents_id);
                    //准迁
                    $envd = $this->_systemTask($task->clents_id, Task::CAN_MOVE, $re_by_id, Time::daysAfter(7));
                    break;

                case Task::CAN_MOVE://准迁
                    //落户
                    $envd = $this->_systemTask($task->clents_id, Task::SETTLE, $re_by_id, Time::daysAfter(7));
                    break;

                case Task::SETTLE://落户
                    break;
            }

        }

        //外勤 如果任务类型是一审二审拿调令就回馈一个任务.
        if ($this->group_id = 4) {

            switch ($task->type) {
                case Task::SIGN: //一审
                    $envd = $this->_systemTask($task->clents_id, Task::BACK_SIGN, $re_by_id, time());
                    break;
                case Task::SUBMIT: //二审
                    $envd = $this->_systemTask($task->clents_id, Task::BACK_SUBMIT, $re_by_id, time());
                    break;
                case Task::GET_DIAOLING:  //拿调令
                    $envd = $this->_systemTask($task->clents_id, Task::GET_DIAOLING, $re_by_id, time());
                    break;
            }

        }

        return $task->save() ? Res::Json(200, '成功') : Res::Json(400);

    }


    //失败
    public function taskFailed($id)
    {
        $errormsg = $this->request->param('error');
        $task = Task::get($id);
        if ($task->getData('finish_type') != 1)
            return Res::Json(400, '重复提交');
        if ($task->getData('re_by_id') != $this->uid)
            return Res::Json(400, '需处理用户不是当前登录用户');
        $task->error = $errormsg;
        $task->finish_type = 0;
        $task->finish_time = time();

        //外勤 外勤失败时候把回访任务备注失败信息.
        if ($this->group_id = 4) {

            $re_by_id = Db::table('Data')->where('id', $task->clents_id)->value('user_id');

            switch ($task->type) {

                case Task::SIGN: //一审
                    $envd = $this->_systemTask($task->clents_id, Task::BACK_SIGN, $re_by_id, time(),
                        ['success' => false], $errormsg);
                    break;

                case Task::SUBMIT: //二审
                    $envd = $this->_systemTask($task->clents_id, Task::BACK_SUBMIT, $re_by_id, time(),
                        ['success' => false], $errormsg);
                    break;

                case Task::GET_DIAOLING:  //拿调令
                    $envd = $this->_systemTask($task->clents_id, Task::GET_DIAOLING, $re_by_id, time(),
                        ['success' => false], $errormsg);
                    break;
            }

        }

        return $task->save() ? Res::Json(200, '提交成功') : Res::Json(400);
    }


    //转发 2种方案, 1 直接编辑转发 2 完成当前转发.  还是推荐完成后转发
    public function taskForward($id, $clents_id = 0, $type = 0)
    {
        $task = Task::get($id);
        $task->finish_type = 3;//转发
        $task->finish_time = time();

        $data = $this->request->post();
        $data['se_by_id'] = $this->uid;
        $data['clents_id'] = $clents_id;
        if ($type != 0)
            $data['type'] = $type;

        $newtask = new Task();
        $newtask->save($data);


        return $task->save() ? Res::Json(200) : Res::Json(400);
    }
}