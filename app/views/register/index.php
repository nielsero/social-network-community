<?php
    $title = "Registro";
    $state = $data["state"];
    include("../app/views/header.php");
?>

<main class="register">
    <section class="register-image-section">
        <img class="register-image" src="<?= $url."assets/images/register.jpg" ?>" loading="lazy">
    </section>

    <section class="register-form-section">
        <form class="register-form" action="<?= $url."register/submit" ?>" method="POST">
            <h1 class="register-title">Registro</h1>
            <input class="register-username" type="text" name="name" placeholder="Nome de usuario" required>
            <input class="register-email" type="email" name="email" placeholder="Email" required>
            <input class="register-password" type="password" name="password" placeholder="Senha" required>
            <label class="register-date-birth-label">Data de nascimento:</label>
            <input class="register-date-birth" name="date" type="date">
            <input class="register-city" type="text" name="city" placeholder="Cidade">
            <input class="register-country" type="text" name="country" placeholder="País">
            <button class="register-button" type="submit" name="register">Registrar</button>
            <p class="register-info">Já estás registrado? <a href="<?= $url."login" ?>">Faz login</a></p>

            <?php
                if($state == "error") {
                    echo "
                        <div class='register-error'>
                            <p>Falha ao registrar os dados</p>
                        </div>
                    ";
                }

                else if($state == "exists") {
                    echo "
                        <div class='register-exists'>
                            <p>Credenciais já registradas</p>
                        </div>
                    ";
                }
            ?>
        </form>

    </section>
</main>

<?php 
    include("../app/views/footer.php");
?>