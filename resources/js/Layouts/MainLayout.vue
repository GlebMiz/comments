<script setup>
    import HeaderComponent from '@/Components/HeaderComponent.vue'
</script>

<template>
    <HeaderComponent />
    <main>
        <div class="container">
            <slot />
        </div>
    </main>
</template>
