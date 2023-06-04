<header class="header">
    <section class="header-top">
        <div class="header-profile-picture-container">
            <img class="header-profile-picture" src="<?= $profile_picture ?>">
        </div>

        <nav class="header-nav">
            <div class="header-nav-item <?php if($active == "home") { echo "header-nav-item_selected"; }?>" data-link="home"><i class='bx bx-home'></i></div>
            <div class="header-nav-item <?php if($active == "follow") { echo "header-nav-item_selected"; }?>" data-link="follow"><i class='bx bx-user'></i></div>
            <div class="header-nav-item <?php if($active == "message") { echo "header-nav-item_selected"; }?>" data-link="message"><i class='bx bx-chat'></i></div>
            <div class="header-nav-item <?php if($active == "community") { echo "header-nav-item_selected"; }?>" data-link="community"><i class='bx bx-group'></i></div>
            <div class="header-nav-item <?php if($active == "search") { echo "header-nav-item_selected"; }?>" data-link="search"><i class='bx bx-search'></i></div>
        </nav>
    </section>

    <div class="header-logout-item"><i class='bx bx-exit' ></i></div>
</header>