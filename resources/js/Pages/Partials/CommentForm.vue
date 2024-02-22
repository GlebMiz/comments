<script setup>
import CommentItem from '@/Components/CommentItem.vue';
import { ref, watch } from 'vue';

const name = ref(null);
const email = ref(null);
const text = ref(null);

const allowedTags = ['a', 'code', 'i', 'strong'];
watch(text, () => {
    const regex = new RegExp(`<(?!/?(${allowedTags.join('|')})\\b)[^>]+>`, 'gi');
    text.value = text.value.replace(regex, '');
});
</script>

<template>
    <div class="comment-form__cta">
        <span>Left your comment</span>
        <div class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#commentModal">
            Write a comment
        </div>
    </div>
    <div id="commentModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Write a comment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" />
                </div>
                <div class="modal-body comment-modal-body">
                    <div class="comment-form">
                        <form method="POST" action="">
                            <div class="mb-2">
                                <label for="input-username" class="form-label form-label-required">User Name</label>
                                <input id="input-username" v-model="name" type="text" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label for="input-email" class="form-label form-label-required">E-mail</label>
                                <input id="input-email" v-model="email" type="email" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label for="input-homepage" class="form-label">Home Page</label>
                                <input id="input-homepage" type="text" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label for="input-text" class="form-label form-label-required">Comment Text</label>
                                <textarea class="form-control" v-model="text" id="input-text" rows="3"></textarea>
                            </div>
                            <button type="button" class="btn btn-primary mt-1 px-4">Submit</button>
                        </form>
                    </div>
                    <div class="comment-preview">
                        <h5 class="text-center fw-normal lh-1 ">Preview</h5>
                        <CommentItem :comments="[
                            {
                                name: name || 'Name',
                                email: email || 'email@email.com',
                                date: new Date().toLocaleDateString(),
                                text: text || 'Text...',
                            }
                        ]" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss">
.comment-form__cta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: solid 1px var(--bs-gray-300);
    padding: 8px 16px;
    border-radius: 8px;
    margin-bottom: 12px;
}

.comment-modal-body {
    display: grid;
    gap: 12px;
    grid-template-columns: repeat(2, 1fr);
}
</style>
