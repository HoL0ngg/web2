document.addEventListener("DOMContentLoaded", function () {
    const rows = document.querySelectorAll("#productTable tr");

    rows.forEach(row => {
        const visibilityCell = row.querySelector(".visibility-cell");
        if (visibilityCell && visibilityCell.textContent.trim() === "🔴") {
            row.classList.add("gray-row");
        }
    });
});
