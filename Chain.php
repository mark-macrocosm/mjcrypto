<?php

class Chain
{
    protected string $name;

    protected int $age;
    
    protected string $gender;

    public function name($name){
        $this->name = $name;
        return $this;
    }

    public function age($age){
        $this->age = $age;
        return $this;
    }

    public function gender($gender){
        $this->gender = $gender;
        return $this;
    }

    public function bio(){
        return 'Name: '.$this->name.', Age: '.$this->age.', Gender: '.$this->gender;
    }
}