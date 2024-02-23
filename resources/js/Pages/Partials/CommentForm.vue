<script lang="ts" setup>
import CommentItem from '@/Components/CommentItem.vue';
import { onMounted, watch } from 'vue';
import { useForm } from 'vee-validate';
import { router } from '@inertiajs/vue3';
// @ts-expect-error yup
import * as yup from 'yup';
import axios from 'axios';

const { values, errors, defineField, handleSubmit, resetForm } = useForm({
    validationSchema: yup.object({
        name: yup.string().required(),
        email: yup.string().email().required(),
        homepage: yup.string(),
        text: yup.string().required(),
    }),
});

const onSubmit = handleSubmit(() => {
    axios.put(route('comment.add'), values
    ).then(response => {
        console.log(response.data.message);
        const btnClose = document.querySelector('*[data-bs-dismiss="modal"]') as HTMLButtonElement;
        if (btnClose)
            btnClose.click();
        router.visit('');
    }).catch(error => {
        if (error.response.status === 422) {
            console.log(error.response.data.errors);
        } else {
            console.log(error);
        }
    })
});

const [comment_id] = defineField('comment_id');
const [name] = defineField('name');
const [email] = defineField('email');
const [homepage] = defineField('homepage');
const [text] = defineField('text');

const allowedTags = ['a', 'code', 'i', 'strong'];
watch(text, () => {
    const regex = new RegExp(`<(?!/?(${allowedTags.join('|')})\\b)[^>]+>`, 'gi');
    text.value = text.value.replace(regex, '');
});

onMounted(() => {
    const exampleModal = document.getElementById('commentModal')
    if (exampleModal) {
        // eslint-disable-next-line @typescript-eslint/no-explicit-any
        exampleModal.addEventListener('show.bs.modal', (event: any) => {
            resetForm();
            const button = event.relatedTarget
            comment_id.value = button.getAttribute('data-bs-id');

        })
    }
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
                        <form id="commentForm" @submit="onSubmit">
                            <input id="commentId" v-model="comment_id" type="hidden" name="comment_id">
                            <div class="mb-2">
                                <label for="input-username" class="form-label form-label-required">User Name</label>
                                <input id="input-username" v-model="name" type="text" class="form-control">
                                <div v-if="errors.name" class="validation-error">
                                    {{ errors.name }}
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="input-email" class="form-label form-label-required">E-mail</label>
                                <input id="input-email" v-model="email" type="email" class="form-control">
                                <div v-if="errors.email" class="validation-error">
                                    {{ errors.email }}
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="input-homepage" class="form-label">Home Page</label>
                                <input id="input-homepage" v-model="homepage" type="text" class="form-control">
                                <div v-if="errors.homepage" class="validation-error">
                                    {{ errors.homepage }}
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="input-text" class="form-label form-label-required">Comment Text</label>
                                <textarea id="input-text" v-model="text" class="form-control" rows="3" />
                                <div v-if="errors.text" class="validation-error">
                                    {{ errors.text }}
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-1 px-4">Submit</button>
                        </form>
                    </div>
                    <div class="comment-preview">
                        <h5 class="text-center fw-normal lh-1 ">Preview</h5>
                        <CommentItem :comments="[
                            {
                                name: name || 'Name',
                                email: email || 'Email',
                                date: new Date().toLocaleDateString(),
                                text: text || 'Text text ...',
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
