<?php 
    function all_classes($class) {
        include $class. '.php';
    }

    spl_autoload_register('all_classes');

    $object = new Singleton(); 


    // print($object->userEcho("Danny Boy"));
    // echo PHP_EOL;    

    // print($object->userQuery("Danny"));
    // echo PHP_EOL;    

    // print($object->userFile("https://www.villageveterinaryclinic.com/services/cats/blog/20-cat-facts-thatll-blow-your-kitty-crazed-mind !!"));
    // echo PHP_EOL;    

    // print($object->nestedConditions());
    // echo PHP_EOL;    

    // print($object->returnStatements());
    // echo PHP_EOL;    

    // print($object->nullCoalescing());
    // echo PHP_EOL;    

    // print($object->methodChained());
    // echo PHP_EOL;

    // print($object->checkValue('string'));
    // echo PHP_EOL;

    // print($object->regexTest('42:96'));
    // echo PHP_EOL;
?>