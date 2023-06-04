<?php 
    $title = "Pagina não encontrada";
    include ("../app/views/header.php");
?>

<main class="error">
    <h1 class="error-title">Pagina não encontrada</h1>
    <div class="error-image-container">
        <img class="error-image" src="<?= $url."assets/images/error.webp" ?>">
    </div>
    <button class="error-back-button" onclick="goBack();">Voltar</button>
</main>

<script>
    function goBack() {
        location.href = "<?= $url ?>";
    }
</script>

<?php 
    include ("../app/views/footer.php");
?>