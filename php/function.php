
<?php

//function.php

function make_avatar($character)
{
    $path = "avatar/". time() . ".png";
	$image = imagecreate(200, 200);
	$red = rand(0, 255);
	$green = rand(0, 255);
	$blue = rand(0, 255);
    imagecolorallocate($image, $red, $green, $blue);  
    $textcolor = imagecolorallocate($image, 255,255,255);  

    imagettftext($image, 100, 0, 55, 150, $textcolor, 'font/arial.ttf', $character);  
    //header("Content-type: image/png");  
    imagepng($image, $path);
    imagedestroy($image);
    return $path;
}

function Get_Customer_image($user_name, $connect)
{
	$query = "
	SELECT Customer_image FROM customer 
    WHERE user_name = '".$user_name."'
	";

	$statement = $connect->prepare($query);

	$statement->execute();

	$result = $statement->get_result();

	foreach($result as $row)
	{
		return '<img src="'.$row['Customer_image'].'" width="25" class="img-circle" />';
	}
}
function Get_user_profile_data($user_name, $connect)
{
    $query = "
    SELECT * FROM customer 
    WHERE user_name = '".$user_name."'
    ";
    return $connect->query($query);
}

function Get_user_profile_data_html($user_name, $connect)
{
    $result = Get_user_profile_data($user_name, $connect);

    $output = '
    <div class="table-responsive">
        <table class="table">
    ';

    foreach($result as $row)
    {
        if($row['Customer_image'] != '')
        {
            $output .= '
            <tr>
                <td colspan="2" align="center" style="padding:16px 0">
                    <img src="'.$row["Customer_image"].'" width="175" class="img-thumbnail img-circle" />
                </td>
            </tr>
            ';
        }

        $output .= '
        <tr>
            <th>Name</th>
            <td>'.$row["user_name"].'</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>'.$row["Customer_Email"].'</td>
        </tr>
        <tr>
            <th>Customer_Contact_num</th>
            <td>'.$row["Customer_Contact_num"].'</td>
        </tr>
        <tr>
            <th>Customer Age</th>
            <td>'.$row["customer_age"].'</td>
        </tr>
        <tr>
            <th>Address</th>
            <td>'.$row["Customer_Address"].'</td>
        </tr>
        ';
    }
    $output .= '
        </table>
    </div>
    ';

    return $output;
}

function wrap_tag($argument)
{
    return '<b>' . $argument . '</b>';
}

function Get_user_avatar_big($user_name, $connect)
{
    $query = "
    SELECT Customer_image FROM customer 
    WHERE user_name = '".$user_name."'
    ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
        return '<img src="'.$row['Customer_image'].'" class="img-responsive img-circle" />';
    }
}


?>