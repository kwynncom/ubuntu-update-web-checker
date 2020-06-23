<?php 
    if (!isset($KWUPV->vital)) {
	http_response_code(400);
	die('invalid data');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>Upuntu updates?</title>

<style>
    body { font-family: sans-serif }
    .res { font-size: 500%; font-weight: bold}
    .date { font-size: 150%; margin-top: 0.0ex; margin-bottom: 0.1ex }
    .resPar { display: table; }
    .cstc   { vertical-align: middle; display: table-cell; }
    button.btn   { font-size: 175%; margin-left: 2ex; }
</style>

</head>
<body>
    <div class='resPar'>
    <div class='res cstc'>
        <?php echo $KWUPV->vital ? '**Y**' : 'N'; ?>
    </div>
    
    <div class='btn cstc'><button  class='btn' onclick='history.go(0)' >redo</button></div>
    </div>

    <div class='date'>
	<?php
	    $dates = date('g:i A ');
	    $dates .= '(' . date('s') . 's) ' . date('l, F j, Y');
	    echo($dates);
	?>
    </div>
    
    <div>
	<?php echo($KWUPV->kernv . "<br/>\n" . $KWUPV->kernr) . "<br />\n" . $KWUPV->kerndtraw; ?>
    </div>
</body>
</html>
