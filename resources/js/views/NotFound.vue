<script setup>
</script>

<template>
    <div class="notfound-container">
        <div class="content">
            <h1>404</h1>
            <p>Oops! The page you are looking for does not exist.</p>
            <a href="/" class="home-btn">Go Back Home</a>
        </div>
    </div>
</template>

<style scoped>
.notfound-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 80vh;
    text-align: center;
    padding: 20px;
    background: #f8f9fa;
}

.content h1 {
    font-size: 6rem;
    margin: 0;
    color: #e74c3c;
}

.content p {
    font-size: 1.25rem;
    margin: 15px 0 25px;
    color: #333;
}

.home-btn {
    display: inline-block;
    padding: 10px 20px;
    background: #1c5980;
    color: white;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    transition: background 0.2s;
}

.home-btn:hover {
    background: #2980b9;
}

/* Responsive */
@media (max-width: 768px) {
    .content h1 {
        font-size: 4rem;
    }

    .content p {
        font-size: 1rem;
    }

    .home-btn {
        padding: 8px 16px;
        font-size: 0.9rem;
    }
}

@media (max-width: 480px) {
    .content h1 {
        font-size: 3rem;
    }

    .content p {
        font-size: 0.9rem;
    }
}
</style>
