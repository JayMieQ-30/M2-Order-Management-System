<?php

session_start(); 

if (!isset($_SESSION['foods'])) {   
                                     
    $_SESSION['foods'] = [];
}

$food_menu = [
    "Chicken Joy"   => 94,    
    "Peach Mango Pie" => 50,
    "Burger steak"   => 60,
    "Spaghetti"  => 90,
    "Fries"  => 100,
    "Ice cream" => 50,
    "Mango float" => 120,
    "Strawberry Macha" => 175,
    "Cream Soda" => 50,
    "Samishi" => 400,
    "Sushi" => 300,
    "Maki " => 100,
    "Salad" => 120,
    "Ramen " =>160
    
];

$food_types = ["Dine-in", "Take out"];  
       
$form_title  = "Add Food";    
$button_name = "add";   

$button_text = "Add";  
$edit_id     = "";
$edit_name   = "";
$edit_type   = "";

if (isset($_POST['add'])) {   

    $name = $_POST['name'] ;  
    $type = $_POST['type'] ; 
    
    if (isset($food_menu[$name]) && in_array($type, $food_types)) {
        $_SESSION['foods'][] = [
            'name'  => $name,
            'type'  => $type,
            'price' => $food_menu[$name]
        ];
    }
}

if (isset($_POST['update'])) {
    $id   = $_POST['id'] ?? '';
    $name = $_POST['name'] ?? '';
    $type = $_POST['type'] ?? '';
    if ($id !== '' && isset($_SESSION['foods'][$id]) && isset($food_menu[$name]) && in_array($type, $food_types)) {
        $_SESSION['foods'][$id] = [
            'name'  => $name,
            'type'  => $type,
            'price' => $food_menu[$name]
        ];
    }
}

if (isset($_GET['delete'])) {
    array_splice($_SESSION['foods'], $_GET['delete'], 1);  
    header("Location: Food.php");   
    exit();
}

if (isset($_GET['cancel'])) {   
    $edit_id = $edit_name = $edit_type = "";  
    $form_title  = "Add Food";
    $button_name = "add";
    $button_text = "Add";
}

if (isset($_GET['edit'])) {   
    $edit_id   = $_GET['edit'];
    $edit_name = $_SESSION['foods'][$edit_id]['name']; 
     
    $edit_type = $_SESSION['foods'][$edit_id]['type'];
    $form_title  = "Edit Food";
    $button_name = "update";
    $button_text = "Update";
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Ordering Management System</title>
</head>


<body>


    <h1>Food Ordering Management System</h1>

    <h2><?php echo $form_title; ?></h2>

    <form method="post">

        <input type="hidden" name="id" value="<?php echo $edit_id; ?>">

        <select name="name">
            <option value="" disabled selected>Select Food</option> 
            

            <?php
            foreach (array_keys($food_menu) as $fname) { 
                $selected = ($edit_name == $fname) ? "selected" : "";
                echo "<option value='$fname' $selected>$fname (₱{$food_menu[$fname]})</option>";  
            }
            ?>

        </select>

        <select name="type">
            <option value="" disabled selected>Select Type</option>


            <?php
            foreach ($food_types as $type) {
                $selected = ($edit_type === $type) ? "selected" : "";
                echo "<option value='$type' $selected>$type</option>";
            }
            ?>

        </select>


        <button type="submit" name="<?php echo $button_name; ?>"><?php echo $button_text; ?></button>

        <?php 
        
        if ($form_title == "Edit Food") { ?>
            <a href="?cancel=1">Cancel</a>

        <?php } ?>

    </form>

    <hr>

    <h3>Food List</h3>

    <table>
        <tr>
            <th>Number</th>
            <th>Food Name</th>
            <th>Food Type</th>
            <th>Price</th>
            <th>Action</th>
        </tr>

        <?php
        if (!empty($_SESSION['foods'])) {
            
            $no = 1;
            foreach ($_SESSION['foods'] as $i => $f) {
                
                echo "<tr>
                        <td>$no</td>
                        <td>{$f['name']}</td>
                        <td>{$f['type']}</td>
                        <td>₱{$f['price']}</td>
                        <td>
                            <a href='?edit=$i'>Edit</a> 
                            <a  href='?delete=$i'>Delete</a>
                        </td>
                      </tr>";
                $no++;
            }
        } 
        ?>

    </table>


    <style>
        *{
            box-sizing: border-box;


    
           }

           body{
            font-family: sans-serif;
            background: linear-gradient(#a78bfa, #39669c);
            padding: 80px;
            color: #1e1b4b;
           }

        h1{
            text-align: center;
            margin-bottom: 35px;
            color: #312e81;
            font-weight: bold;
          }

        h2, h3{    
            text-align: center;
            margin-bottom: 12px;
            color: #3730a3;
          }
        form{
            background: linear-gradient(#e0e7ff, #ede9fe);
            max-width: 500px;
            padding: 25px;
            margin: 0 auto 30px auto;
            border-radius: 18px;
            box-shadow: 0 12px 25px rgba(79, 70, 229, 0.25);
          }
        select{
            width: 100%;
            padding: 12px;
            margin-bottom: 14px;
            border-radius: 12px;
            border: 1px solid #c7d2fe;
            background: #f5f3ff;
            color: #312e81;
            font-size: 14px;
          }


         button{
            width: 100%;
            padding: 12px;
            background: linear-gradient( #6366f1, #8b5cf6);
            color: white;
            border: none;
            border-radius: 14px;
            cursor: pointer;
            font-weight: bold;
            font-size: 15px;
            transition: transform 0.2s, opacity 0.2s;
          }

        button:hover{
            transform: scale(1.03);
            opacity: 0.9;
          }


        a{
            display: inline-block;
            margin-top: 10px;
            color: #6366f1;
            font-size: 14px;
            text-decoration: none;
         }

        a:hover{
            text-decoration: underline;
         }


        table{
            width: 70%;
            margin: 0 auto;
            background: linear-gradient(135deg, #eef2ff, #ede9fe);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.2);
            font-size: 14px;
         }

        th, td{
            padding: 10px;
            text-align: center;
         }

        th{
            background: #c7d2fe;
            color: #1e1b4b;
            font-weight: bold;
         }

        tr:nth-child(even){
            background: #f5f3ff;
         }

        tr:hover{
            background: #ddd6fe;
         }

        hr{
           margin: 35px 0;
           border: none;
         }


    </style>

   
</body>
</html>
