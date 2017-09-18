<?php
namespace app\api\controller;
use think\Db;
class Index
{
    public function index()
    {

    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
    public function test($name)
    {
      $query =  Db::table('test')
                ->where('name', 'like', '%think%')
                ->where('name', 'like', '%php%')
                ->where('id', 'in', [1, 5, 80, 50])
                ->where('id', '>', 10)
                ->fetchsql(true);
                //->find();

        $data = $query->where('cc','like','%aaa')->find();
        dump($data.$name);

    }
}
