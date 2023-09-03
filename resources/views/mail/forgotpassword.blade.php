<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Estilos para o corpo do e-mail */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Estilos para o contêiner principal */
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
        }

        /* Estilos para o cabeçalho */
        .header {
            background-color: #007bff;
            color: #fff;
            text-align: center;
            padding: 20px;
        }

        /* Estilos para o corpo do e-mail */
        .content {
            padding: 20px;
        }

        /* Estilos para o botão */
        .button {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Redefinição de Senha</h1>
        </div>
        <div class="content">
            <p>Olá,</p>
            <p>Você solicitou a redefinição de senha para sua conta. Para redefinir sua senha, use o código de verificação abaixo:</p>
            <p style="font-size: 24px; font-weight: bold;">{{$code}}</p>
            <p>Este código de verificação expirará em 1 hora. Se você não solicitou a redefinição de senha, pode ignorar este e-mail.</p>
            <p>Obrigado,<br>Sua Equipe</p>
            <a class="button" href="#">Redefinir Senha</a>
        </div>
    </div>
</body>
</html>
