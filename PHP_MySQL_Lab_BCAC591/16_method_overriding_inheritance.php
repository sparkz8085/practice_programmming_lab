<?php
class Animal {
    public function sound(): string {
        return "Animal makes a sound";
    }
}
class Dog extends Animal {
    public function sound(): string {
        return "Dog barks";
    }
}
$animal = new Animal();
$dog = new Dog();
echo $animal->sound() . "<br>";
echo $dog->sound();
?>