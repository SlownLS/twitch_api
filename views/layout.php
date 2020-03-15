<?php Use SlownLS\Twitch\User; ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SlownLS | Twitch API</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.13/css/mdb.min.css" rel="stylesheet">       

        <style>
            body{
                background-color: #efefef;
            }
            .navbar {
                background-color: #392E5C;
                color: white;
                height: 80px;
                margin-bottom: 15px;
            }

            .navbar a{
                color: #b19dd8;
                transition: all 0.2s linear;
            }

            .navbar a:hover{
                color: white;
            }

            .navbar .navbar-brand, .navbar .navbar-brand:hover{
                color: white;
                border: none;
            }

            .btn-primary{
                background-color: #392E5C !important;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg mb-5">
            <div class="container">
                <a class="navbar-brand" href="./">SlownLS | Twitch API</a>
                
                <div class="collapse navbar-collapse" id="navbar">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="./">Home</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <?php if( User::IsLogged() ){ ?>
                                <a class="nav-link" href="./logout"><?= User::GetLocalInfo("display_name") ?> (Logout)</a>
                            <?php } else { ?>
                                <a class="nav-link" href="./login">Login</a>
                            <?php } ?>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
                            
        <?= $content ?>

        <footer>
            <div class="container">
                <div class="text-center">
                    <hr>
                    <p>&copy; 2020 Your Web Site | Created by <a href="https://slownls.fr" target="_blank">SlownLS</a></p>
                </div>
            </div>
        </footer>
    </body>
</html>