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
use app\common\lib\Curl;
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
    public function Create(Task $task, $id, $type = false)
    {
        $post = $this->request->post();
        if ($type)
            $post['template_id'] = $type;
        $validate = new \app\api\validate\Task();
        if ($validate->scene('add')->check($post)) {
            return $task->add($this->uid, $id, $post) ? Res::Json(200, 'ok', $post) : Res::Json(400, $task->error);
        } else {
            return Res::Json(400, $validate->getError());
        }
    }


    /** 转发 */
    public function forward($id)
    {
        $old = Task::get($id);
        $new = new Task();
        $post = $this->request->post();
        $validate = new \app\api\validate\Task();
        if ($validate->scene('add')->check($post)) {

            if ($new->add($this->uid, $old->data_id, $post)) {
                $old->status = 3;
                return $old->save() ? Res::Json(200, 'ok', $post) : Res::Json(400, '出错了.');
            } else {
                return Res::Json(400, $new->error);
            }

        } else {

            return Res::Json(400, $validate->getError());

        }
    }

    /** 处理 */
    public function dispose($id)
    {
        //checked
        $post = $this->request->post();
        $task = Task::get($id);
        if ($task->dispose_validate($post, $this->uid)) {
            return $task->dispose($post) ? Res::Json(200, 'ok', $post) : Res::Json(400, '保存失败!');
        } else {
            return Res::Json(400, $task->error);
        }
    }

    /** 撤销任务 */
    public function revocation($id)
    {
        $task = Task::get($id);
        if ($this->uid != 1) {
            if ($task->se_id != $this->uid) {
                return Res::Json(400, '不是当前用户发布的任务无法撤回.');
            }
        }
        $task->status = -1;
        return $task->save() ? Res::Json(200) : Res::Json(400);
    }

    /**
     * 获取任务列表
     * @param Task $m
     * @return \think\response\Json
     */
    public function List(Task $m)
    {
        $conent = $m->getTotals();
        $curl = new Curl();
        $res = $curl->Get("http://localhost:2121/?type=publish&content=$conent&to=$this->uid");
        //分页参数
        $params = $this->request->only(['page', 'rows', 'sort', 'order'], 'post');
        //条件规则
        $rule = $this->request->post('rule');
        //绑定字段 如果是搜搜就属于表单参数
        $fieids = $this->request->except(['page', 'rows', 'sort', 'order', 'rule', 'type', 'time'], 'post');
        //类型参数
        $type = $this->request->post('type');
        //时间表达式条件
        $time = $this->request->post('time');
        //替换用户ID
        if (isset($fieids['uid'])) $fieids['uid'] = $this->uid;
        switch ($type) {
            /** 表单条件 **/
            case 'sousou':
                $lists = $m->search($params, $fieids);
                break;
            /** 自定义规则字符串绑定 **/
            case 'list':
                $lists = $m->List($params, $rule, $fieids);
                break;
            /** 逾期查询 */
            case 'overdue':
                $lists = $m->overdue($params, $rule, $fieids);
                break;
            case 'day':
                $lists = $m->ListByTime($params, $rule, $fieids, $time);
                break;
            case 'tomorrow':
                ////date("Y-m-d",Time::daysAfter(1))
                //Time::daysAfter(1)
                $tomorrow = date("Y-m-d", Time::daysAfter(1));//明天
                $lists = $m->ListByTimeBettween($params, $rule, $fieids, [$tomorrow . ' 00:00:00', $tomorrow . ' 23:59:59']);
                break;
            default:
                if ($rule == null || $fieids == null) {
                    $rule = "1 = :id";
                    $fieids = ['id' => 1];
                }
                $lists = $m->List($params, $rule, $fieids);
        }
        $lists['type'] = $type;
        return json($lists);
    }
}