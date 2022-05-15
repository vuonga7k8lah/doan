<?php

namespace DoAn\RabbitMQ\Controller;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQController
{
    protected AMQPStreamConnection $oAMQConnection;
    protected AMQPChannel          $oChannel;
    protected string               $topic;

    public function __construct()
    {
        $this->oAMQConnection = new AMQPStreamConnection(
            'gull.rmq.cloudamqp.com',
            5672,
            'xuhdijcc',
            'QW7uraabrfwGqD9LDIZtU2fL8HVs1Voc',
            'xuhdijcc'
        );
    }

    public function setChannel($topic): RabbitMQController
    {
        $this->oChannel = $this->oAMQConnection->channel();
        $this->topic = $topic;
        $this->oChannel->queue_declare($topic, false, false, false, false);
        return $this;
    }

    /**
     * @throws \Exception
     */
    public function sendMessage($message)
    {
        $msg = new AMQPMessage($message);
        $this->oChannel->basic_publish($msg,'',$this->topic);
        $this->oChannel->close();
        $this->oAMQConnection->close();
    }

    public function receiveMessage(){

        $callback = function ($msg) {
            call_user_func_array([$this,'handleReceiveMessage'],[
                $msg
            ]);
        };

        $this->oChannel->basic_consume($this->topic, '', false, true, false, false, $callback);

        while ( $this->oChannel->is_open()) {
            $this->oChannel->wait();
        }
        return true;
    }
    public function handleReceiveMessage($aData){
        var_dump($aData);
    }
}
