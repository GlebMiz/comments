<script lang="ts" setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';
import CommentForm from './Partials/CommentForm.vue';
import CommentList from './Partials/CommentList.vue';
import { Comment } from '@/interfaces/comment';
defineProps<{
    comments: Comment[],
    maxPage: number,
    
}>();
</script>

<template>
    <Head title="Home" />
    <MainLayout>
        <CommentForm />
        <CommentList :comments="comments" :max-page="maxPage" />
    </MainLayout>
</template>

<style></style>
