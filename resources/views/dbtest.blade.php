
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Database connection test</title>
    </head>
    <body class="bg-primary">
        <div>
            <?php 
            $users =  DB::select("select * from users");
                            
            foreach ($users as $user) {
                echo "<tr>    
                        <th>$user->name</th>               
                      </tr>";
            }

            ?>
        </div>
    </body>
</html>
