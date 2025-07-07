<?php
switch($_REQUEST['b1'])
{
 case 'red': echo "Your favourite color is Red";
             break;

 case 'pink': echo "Your favourite color is pink";
             break;
			 
case 'blue': echo "Your favourite color is blue";
             break;




}
<html>
<body>
<form name="f1" method="get">
<input type="submit" name='b1' value="red">
<input type="submit" name='b1' value="pink">
<input type="submit" name='b1' value="blue">



</form>
</body>
</html>