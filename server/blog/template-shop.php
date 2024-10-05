<?php
/*
Template Name: Shop Page
*/
get_header();

// Get the site URL from WordPress
$site_url = get_site_url();
?>

<div id="shop-container">
    <!-- Products will be populated here by JavaScript -->
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Use PHP to print the site URL in the JavaScript code
        const siteUrl = "<?php echo $site_url; ?>";
        fetch(`${siteUrl}/wp-json/cpd/v1/products`)
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('shop-container');
                data.forEach(product => {
                    container.innerHTML += `
                        <div class="product-item">
                            <img src="${product.image}" alt="${product.name}" />
                            <h2>${product.name}</h2>
                            <p>${product.description}</p>
                            <p>Price: $${product.price.toFixed(2)}</p>
                            <button>Add to Cart</button>
                        </div>
                    `;
                });
            })
            .catch(error => {
                console.error('Error fetching products:', error);
            });
    });
</script>

<?php get_footer(); ?>
