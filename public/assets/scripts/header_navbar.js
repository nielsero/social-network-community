const url = "http://localhost/rede_social/public/";
const navItems = document.querySelectorAll(".header-nav-item");

console.log(navItems);

navItems.forEach((item) => {
    console.log(item.dataset.link);
    item.addEventListener("click", () => { handleNavItemClick(item.dataset.link); });
})

function handleNavItemClick(link) {
    location.href = url + link;
}