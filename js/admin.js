function effectSideBar() {
    const allSideMenu = document.querySelectorAll("#menu ul li a");    
    // Lấy đường dẫn hiện tại trên URL
    const currentPage = new URLSearchParams(window.location.search).get("page");    
    
    allSideMenu.forEach(item => {
        // Lấy giá trị 'page' từ href
        const page = new URL(item.href).searchParams.get("page");        
        if (page === currentPage) {
            item.parentElement.classList.add("active");
        } else {
            item.parentElement.classList.remove("active");
        }
    });    
    
}
function hiddenSideBar(){
    let hiddenBtn = document.getElementById("hideSideBar");
    let leftContainer = document.getElementById("container-left");
    hiddenBtn.addEventListener("click", function(){
        let icon = this.querySelector("i");
        let attributeOfIcon = icon.getAttribute("class");
        if(attributeOfIcon.indexOf("fa-arrow-left") != -1){
            leftContainer.style.width = '60px';
        }else{
            leftContainer.style.width = '20%';
        }
        icon.classList.toggle("fa-arrow-left");
        icon.classList.toggle("fa-arrow-right");
    });
}
window.onload = function () {
    effectSideBar();
    hiddenSideBar();
};
