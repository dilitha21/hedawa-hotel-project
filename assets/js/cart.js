// Cart interactions
document.addEventListener('DOMContentLoaded', () => {
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    
    addToCartButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const itemId = e.target.dataset.id;
            const quantity = e.target.closest('form').querySelector('input[name="quantity"]').value || 1;
            
            // Simple AJAX to cart_process.php
            fetch('../actions/cart_process.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=add&item_id=${itemId}&quantity=${quantity}`
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    alert('Item added to cart! You can continue adding items or view your cart.');
                } else {
                    alert('Failed to add item.');
                }
            })
            .catch(err => console.error(err));
        });
    });
});
