<script lang="ts" setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';
import CommentForm from './Partials/CommentForm.vue';

import { Comment } from '@/interfaces/comment';
defineProps<{
    comments: Comment[],
    maxPage: number,
}>();
</script>

<template>
    <Head title="Add comment" />
    <MainLayout>
        <CommentForm />
    </MainLayout>
</template>

<style></style>
