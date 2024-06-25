<?php

?>
<!DOCTYPE HTML>
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://www.transports-mesguen.fr/ressources/images/25f3e9c81773.png">
    <title>Connexion</title>
    <nav class="px-2 sm:px-4 py-4 bg-green-900">
        <div class="container flex flex-wrap items-center justify-between mx-auto">
            <div class="flex flex-wrap">
                <img src="https://www.transports-mesguen.fr/ressources/images/5040ec2b0e96.png" class="h-6 mr-3 sm:h-9" alt="Mesguen Logo" />
            </div>
            <span class="self-center text-xl font-semibold whitespace-nowrap text-white">Interface de connexion</span>        
        </div>
    </nav>
</head>
<body>
    <form action="connexion.lib.php" method="post">
        <div class="md:w-1/3 my-8 ml-8">
            <label class="text-xl block md-2 font-medium text-gray-500">Identifiant :<input type="text" id="login" name="login" class="bg-green-700 text-white text-xl rounded-lg block w-full p-2.5"/></label>
        </div>
        <div class="md:w-1/3 my-8 ml-8">
            <label class="text-xl block md-2 font-medium text-gray-500">Mot de passe :<input type="password" id="password" name="password" class="bg-green-700 text-white text-xl rounded-lg block w-full p-2.5"/></label>
        </div>
        <div class="md:w-1/3 my-8 ml-8">
            <button type="submit" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-xl px-5 py-2.5 mr-2 mb-2 bg-green-600 hover:bg-green-700 focus:ring-green-800">Se connecter</button>
        </div>
    </form> 
</body>