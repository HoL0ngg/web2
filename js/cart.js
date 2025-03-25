document.querySelectorAll('.plus').forEach(button => {
    button.addEventListener('click', function () {

        const quantityElement = this.previousElementSibling;
        let currentQuantity = parseInt(quantityElement.textContent);
        quantityElement.textContent = currentQuantity + 1;

        // Cập nhật giỏ hàng nếu cần
        // updateCart();
    });
})

document.querySelectorAll('.minus').forEach(button => {
    button.addEventListener('click', function () {
        const quantityElement = this.nextElementSibling;
        let currentQuantity = parseInt(quantityElement.textContent);

        if (currentQuantity > 1) {
            quantityElement.textContent = currentQuantity - 1;

            // Cập nhật giỏ hàng nếu cần
            // updateCart();
        }
    });
});