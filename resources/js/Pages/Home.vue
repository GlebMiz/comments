<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';
import CommentForm from './Partials/CommentForm.vue';
import CommentList from './Partials/CommentList.vue';
</script>

<template>
    <Head title="Home" />
    <MainLayout>
        <CommentForm />
        <CommentList />
    </MainLayout>
</template>

<style>

</style>
