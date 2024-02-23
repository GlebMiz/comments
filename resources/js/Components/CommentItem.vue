<script lang="ts" setup>
import { Comment } from '@/interfaces/comment';
defineProps<{
    comments: Comment[];
}>();
</script>

<template>
    <div v-for="(comment, key) in comments" :key="key" class="comment comment--main">
        <div class="comment__item">
            <div class="comment__info">
                <span class="comment__info-name">{{ comment.name }}</span>
                <span class="comment__info-email">{{ comment.email }}</span>
                <span class="comment__info-date">{{ comment.date }}</span>
            </div>
            <div class="comment__text" v-html="comment.text" />
            <div v-if="comment.files" class="comment__files">
                <a v-for="(file, fileKey) in comment.files" :key="fileKey" :href="file.path" :data-lightbox="file.name"
                    :data-title="file.name" class="comment__files-item comment__files-img"
                    :class="'comment__files-' + file.type == 'txt' ? 'txt' : 'img'">
                    <img :src="file.path" :alt="file.name">
                    <span v-if="file.type == 'txt'" class="comment__files-text">{{ file.name }}</span>
                </a>
            </div>
            <div v-if="comment.id" class="comment__reply">
                <span data-bs-toggle="modal" data-bs-target="#commentModal" :data-bs-id="comment.id" class="link-primary">
                    <i class="bx bx-reply" />
                    Reply
                </span>
            </div>
        </div>
        <template v-if="comment.replies">
            <CommentItem :comments="comment.replies" />
        </template>
    </div>
</template>

<style lang="scss">
.comment {
    margin-top: 8px;

    &.comment--main {
        margin-top: 12px;
    }

    >.comment {
        border-left: solid 1px var(--bs-gray-300);
        padding-left: 16px;
    }
}

.comment__item {
    border: solid 1px var(--bs-gray-300);
}

.comment__item>div {
    padding: 8px 16px;
}

.comment__info {
    display: flex;
    gap: 12px;
    background-color: var(--bs-gray-300)
}

.comment__info-name {
    font-weight: bold;
    width: 100px;
}

.comment__info-email {
    font-size: .9rem;
    width: 200px;
}

.comment__info-email,
.comment__info-name {
    overflow: hidden;
    text-overflow: ellipsis;
}

.comment__info-date {
    margin-left: auto;
    color: var(--bs-gray-700);
}

.comment__text {
    white-space: pre-wrap;
}

.comment__files {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}

.comment__files-item {
    cursor: pointer;
    border-radius: 4px;
    height: 80px;
    width: 80px;
    border: solid 1px lightblue;
    position: relative;

    >img {
        height: 100%;
        width: 100%;
        object-fit: cover;
    }
}

.comment__files-img {
    >img {
        height: 100%;
        width: 100%;
        object-fit: cover;
    }
}

.comment__files-txt {
    padding: 12px;

    img {
        transition: all .15s ease-out;
    }

    &:hover img {
        filter: blur(2px);
    }
}

.comment__files-text {
    position: absolute;
    top: 50%;
    left: 50%;
    padding: 2px 8px;
    max-width: 100%;
    transform: translate(-50%, -50%);
    color: var(--bs-black);
    opacity: 0;
    transition: all .15s ease-out;
    background-color: var(--bs-gray-100);
    border-radius: 4px;
    font-weight: bold;

    .comment__files-txt:hover & {
        opacity: .7;
    }
}

.comment__reply span {
    cursor: pointer;
}
</style>
