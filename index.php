<?php
require_once __DIR__ . '/classes/Auth.php';
$auth = new Auth();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-dark text-light d-flex justify-content-center align-items-center vh-100">

    <div id="mainCarousel" class="carousel slide w-75" data-bs-ride="carousel" data-bs-interval="5000">

        <!-- 🔹 Indicateurs -->
        <div class="carousel-indicators">
            <?php if (!$auth->isLoggedIn()): ?>
                <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Connexion"></button>
                <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1" aria-label="Inscription"></button>
            <?php else: ?>
                <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Page 1"></button>
            <?php endif; ?>
        </div>

        <div class="carousel-inner">
            <?php if (!$auth->isLoggedIn()): ?>
                <!-- 🔹 Slide Connexion -->
                <div class="carousel-item active">
                    <div class="card bg-secondary text-light p-4 rounded-4 shadow">
                        <h2 class="mb-3 text-center">Connexion</h2>
                        <form method="POST" action="login.php">
                            <div class="mb-3">
                                <label for="usernameLogin" class="form-label">Nom d'utilisateur</label>
                                <input type="text" class="form-control" id="usernameLogin" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="passwordLogin" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" id="passwordLogin" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                        </form>
                    </div>
                </div>

                <!-- 🔹 Slide Inscription -->
                <div class="carousel-item">
                    <div class="card bg-secondary text-light p-4 rounded-4 shadow">
                        <h2 class="mb-3 text-center">Inscription</h2>
                        <form method="POST" action="register.php">
                            <div class="mb-3">
                                <label for="usernameRegister" class="form-label">Nom d'utilisateur</label>
                                <input type="text" class="form-control" id="usernameRegister" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="passwordRegister" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" id="passwordRegister" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">S'inscrire</button>
                        </form>
                    </div>
                </div>

            <?php else: ?>
                <!-- 🔹 Slide 1 : Page avec iframe -->
                <div class="carousel-item active">
                    <div class="card bg-secondary text-light p-4 rounded-4 shadow">
                        <h2 class="mb-3 text-center">Bienvenue <?= htmlspecialchars($auth->getUsername()) ?> !</h2>
                        
                        <!-- 🎲 Contrôle du volume -->
                        <div class="container text-center mb-3">
                            <h5>Contrôle du volume</h5>
                            
                            <!-- Dés -->
                            <div id="dice-container" class="mb-2 d-flex justify-content-center flex-wrap">
                            <!-- 10 dés -->
                            <div class="die">1</div>
                            <div class="die">1</div>
                            <div class="die">1</div>
                            <div class="die">1</div>
                            <div class="die">1</div>
                            <div class="die">1</div>
                            <div class="die">1</div>
                            <div class="die">1</div>
                            <div class="die">1</div>
                            <div class="die">1</div>
                            </div>
                            <button id="rollBtn" class="btn btn-primary mb-3">Try your luck</button>
                        </div>
                        
                        <!-- Iframe YouTube -->
                        <div id="player-container" class="text-center mb-3">
                            <iframe id="youtube-player" width="1296" height="729"
                                src="https://www.youtube.com/embed/ihYlyQFDM88?enablejsapi=1"
                                title="Les PIRES guerres entre voisins #2 (ils n'ont aucune limite)"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin"
                                allowfullscreen></iframe>
                        </div>

                        <div class="text-center mt-3">
                            <a href="logout.php" class="btn btn-danger">Se déconnecter</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>

        <!-- 🔹 Contrôles -->
        <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://www.youtube.com/iframe_api"></script>
    <script>
    let player;

    // 1️⃣ Création du player YouTube à partir de l'iframe existant
    function onYouTubeIframeAPIReady() {
        player = new YT.Player('youtube-player', {
            events: {
                'onReady': () => { player.setVolume(50); } // volume initial 50%
            }
        });
    }

    // 2️⃣ Gestion des dés
    const diceContainer = document.getElementById('dice-container');
    const dice = Array.from(document.getElementsByClassName('die'));
    const rollBtn = document.getElementById('rollBtn');

    rollBtn.addEventListener('click', () => {
        let volumeStr = '';

        dice.forEach(die => {
            // Ajouter animation
            die.classList.add('roll-animation');

            // Générer un nombre 0-9 aléatoire
            const val = Math.floor(Math.random() * 10) ;
            
            // Changer le chiffre après l'animation
            setTimeout(() => {
                die.textContent = val;
                die.classList.remove('roll-animation');
            }, 600);

            volumeStr += val;
        });

        // Calculer volume et appliquer après un petit délai pour que les dés aient tourné
        setTimeout(() => {
            let volume = parseInt(volumeStr);
            if(volume > 100) volume = 100;
            if(volume < 0) volume = 0;
            if(player && player.setVolume) {
                player.setVolume(volume);
            }
            console.log('Volume appliqué :', volume);
        }, 650);
    });

    </script>

</body>

</html>