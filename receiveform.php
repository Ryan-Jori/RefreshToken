<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            text-align: center;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translateX(-50%) translateY(-50%);
            inline-size: 80%;
            overflow-wrap: break-word;
        }

    </style>
</head>
<body>
    <?php
        require 'jwtclass.php';
        $myjwt = new myJWT();
        $myrt = new myRefreshToken();

        $user = "adminprogweb";
        $pass = "ProgWeb3";
        $db = "progweb3";
        $conn = mysqli_connect("localhost", $user, $pass, $db);
        if ($conn->connect_errno)
        {
            die("<h1> Erro de conexão:" . $conn->connect_error . "</h1>");
        }
        
        $user_id = $_POST["usuario"];
        $user_password = $_POST["senha"];
        $sql = "select * from usuarios where idusuario = '{$user_id}' and senhausuario = '{$user_password}'";
        $query_result = mysqli_query($conn, $sql);
        if ($query_result->num_rows == 0 ){
            die("<h1>Usuário e/ou senha inválidos!</h1>");
        }
        $array_query = $query_result->fetch_assoc();
        
        if (isset($_POST["token"]))
        {
            $token = $_POST["token"];
            $refresh_token = $_POST["refresh_token"];
            if ($myrt->validate_token($token,$refresh_token))
            {
                $payload = $myjwt->get_payload($token);
                $payload = (array)json_decode($payload);
                if($payload['exp'] <= time())
                {
                    $payload['exp'] = time() + 120;
                }
                $token = $myjwt->generate_token($payload);
                $remaining_time = $payload["exp"] - time();
                echo "Token possui <b>{$remaining_time}</b> segundos restantes.<br><br>";
            }else{
                die("Refresh token inválido!<br><br>");
            }

        }
        else
        {
            $refresh_token = $myrt->generate_refresh_token($user_id);
            $payload = [
                'iss' => 'localhost',
                'nome' => $array_query["nomeusuario"],
                'email' => $array_query["email"],
                'exp' => time() + 120, //expira em 2 minutos
                'rt' => $refresh_token
            ];
            $token = $myjwt->generate_token($payload);
            
        }

        echo "</br> Usuário digitado: {$array_query["idusuario"]} </br></br>
                </br>senha digitada:  {$array_query["senhausuario"]}
                </br></br></br>Token:</br>{$token}
                </br></br>Token validado com sucesso: ";
            
            if ($myjwt->validate_token($token)){
                echo "Sim</br>";
            }else{
                echo "Não</br>";
            }
    ?>
    <form action="./receive_form.php" method="post">
    <input type="hidden" value=<?php echo $user_id ?> name="usuario">
    <input type="hidden" value=<?php echo $user_password ?> name="senha">
    <input type="hidden" value=<?php echo $token ?> name="token">
    <input type="hidden" value=<?php echo $refresh_token ?> name="refresh_token">
    </br><input type="submit" value="Refresh"></form>
</body>
</html>