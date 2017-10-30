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
        $data = $this->request->post();
        $data['se_by_id'] = $this->uid;
        $data['clents_id'] = $id;
        if ($type != 0)
            $data['type'] = $type;
        return $m->save($data) ? Res::Json(200, $data['se_by_id']) : Res::Json(400);
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

            //$lists =  $m->search($params['page'],$params['rows'],$fieids);
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

    //任务成功  如果用户组是外勤, 并且任务类型是1审的话就发布任务给内勤
    //如果用户组不是外勤.类型是1审二审,就修改DATA进度
    public function taskFinish($id)
    {
        $m = Task::get($id);
        if ($m->getData('finish_type') != 1)
            return Res::Json(400, '重复提交');
        if ($m->getData('re_by_id')!= $this->uid )
            return Res::Json(400, "需处理用户不是前登录用户");
        $m->finish_type = 2;//成功
        $m->finish_time = time();
        //..不是外勤.
        if ($this->group_id != 4) {
            //任务类型 是一审二审拿调令 修改DATA进度
            switch ($m->type) {
                case 1:
                    $this->sign($m->clents_id);
                    break;
                case 2:
                    $this->submit($m->clents_id);
                    break;
                case 3:
                    $this->takeDiaol($m->clents_id);
                    break;
            }
        } else if ($m->type == 1 || $m->type == 2 || $m->type == 3) {
            //是外勤如果任务类型是一审二审拿调令就回馈一个任务.
            $re_by_id = Db::table('Data')->where('id', $m->clents_id)->value('user_id');
            $newm = new Task();
            $data = [
                'clents_id' => $m->clents_id,
                'type' => $m->type,
                'se_by_id' => $this->uid,
                're_by_id' => $re_by_id,
                'title' => '回访任务',
                'comment' => '',
                'task_time' => time()
            ];
            $newm->isUpdate(false)->save($data);
        }
        return $m->save() ? Res::Json(200, '成功', $m) : Res::Json(400);
    }

    //失败
    public function taskFailed($id)
    {
        $errormsg = $this->request->param('error');
        $m = Task::get($id);
        if ($m->getData('finish_type') != 1)
            return Res::Json(400, '重复提交');
        if ($m->getData('re_by_id')!= $this->uid )
            return Res::Json(400, '需处理用户不是前登录用户');
        $m->error = $errormsg;
        $m->finish_type = 0;
        $m->finish_time = time();
        return $m->save() ? Res::Json(200, '提交成功', $m) : Res::Json(400);
    }

    //转发 2种方案, 1 直接编辑转发 2 完成当前转发.  还是推荐完成后转发
    public function taskForward($id, $clents_id = 0, $type = 0)
    {
        $d = Task::get($id);
        $d->finish_type = 3;//转发
        $d->finish_time = time();

        $data = $this->request->post();
        $data['se_by_id'] = $this->uid;
        $data['clents_id'] = $clents_id;
        if ($type != 0)
            $data['type'] = $type;

        $m = new Task();
        $m->save($data);

        return $d->save() ? Res::Json(200) : Res::Json(400);
    }
}