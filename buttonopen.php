<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $file = 'DoorSts.txt';

        $previous = file_get_contents($file);
        if ($previous === 'Open')
        {
            file_put_contents($file, 'Close');
            echo 'false'; //this is what we return to the client
        }
        else
        {
            file_put_contents($file, 'Open');
            echo 'true'; //this is what we return to the client
        }
        exit();
    }
?>
