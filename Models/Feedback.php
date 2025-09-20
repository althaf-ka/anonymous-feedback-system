<?php
namespace models;

class Feedback
{
    public $id, $title, $message;

    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->title = $data['title'];
        $this->message = $data['message'];
    }
}
