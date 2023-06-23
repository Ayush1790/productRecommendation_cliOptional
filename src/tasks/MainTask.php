<?php

declare(strict_types=1);

namespace MyApp\Tasks;

use Phalcon\Cli\Task;

class MainTask extends Task
{
    public function insertAction($id, $name, $qty, $price, $desc) {
        $this->mongo->order->insertOne(["id" => $id, "name" => $name, "qty" => $qty,
         "price" => $price, "desc"=>$desc]);
        $main=new MainTask();
        $main->mainAction();
    }
    
    public function mainAction()
    {
        $val=(int)readline("Enter 1 for order \nEnter 2 for show product ");
        $main=new MainTask();
        if($val==1){
            $id=(int)readline("Enter id ");
            $name=(string)readline("Enter name ");
            $qty=(int)readline("Enter qty ");
            $price=(int)readline("Enter price ");
            $date=(string)readline("Enter date ");
            $main->insertAction($id, $name, $qty, $price, $date);
        }elseif ($val==2) {
            $id=(int)readline("Enter id ");
            $res=$this->mongo->order->findOne(['id'=>$id]);
            $result=$this->mongo->product->find(['name'=>$res->name]);
           foreach ($result as $value) {
            echo "Name => ".$value->name."\nPrice => ".$value->price."\Description => ".$value->desc;
            echo "\n\n";
           }
        }else{
            echo "Wrong Choice";
        }
    }
}
