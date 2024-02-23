<script lang="ts" setup>
import CommentItem from '@/Components/CommentItem.vue';
import { onMounted, ref, watch } from 'vue';
import { useForm } from 'vee-validate';
import { router } from '@inertiajs/vue3';
import axios from 'axios';
import { schema } from '@/helpers/commentFormSchema';
import Captcha from '@/Components/Captcha.vue';

const { errors, defineField, handleSubmit, resetForm, } = useForm({
    validationSchema: schema
});

const server_errors = ref<{ name?: string, email?: string, homepage?: string, text?: string, file?: string, image?: string, captcha?: string }>({});

const onSubmit = handleSubmit(() => {
    Object.keys(server_errors.value).forEach(key => {
        // eslint-disable-next-line @typescript-eslint/ban-ts-comment
        // @ts-expect-error
        server_errors.value[key] = null;
    });
    const formData = new FormData(document.getElementById('commentForm') as HTMLFormElement);
    axios.post(route('comment.add'), formData
    ).then(response => {
        console.log(response.data.message);
        const btnClose = document.querySelector('*[data-bs-dismiss="modal"]') as HTMLButtonElement;
        if (btnClose)
            btnClose.click();
        router.visit('');
    }).catch(error => {
        if (error.response.status === 422) {
            const res_errors = error.response.data.errors;
            Object.entries(res_errors).forEach(([key, value]) => {
                // eslint-disable-next-line @typescript-eslint/ban-ts-comment
                // @ts-expect-error
                server_errors.value[key] = value[0];
            });


            console.log(res_errors);
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
const [captcha] = defineField('captcha');

watch(text, newvalue => {
    if (newvalue) {
        const allowedTags = ['a', 'code', 'i', 'strong'];
        const regex = new RegExp(`<(?!/?(${allowedTags.join('|')})\\b)[^>]+>`, 'gi');
        text.value = text.value.replace(regex, '');
    }
});

const writeTextTag = (usedTag: string) => {
    const tags = [
        { tag: 'a', value: '<a href="*yourlink*"></a>' },
        { tag: 'code', value: '<code></code>' },
        { tag: 'i', value: '<i></i>' },
        { tag: 'strong', value: '<strong></strong>' },
    ]

    const conversion = tags.find(conv => conv.tag === usedTag);
    const result = conversion ? conversion.value : usedTag;

    if (text.value)
        text.value += result;
    else
        text.value = result;
}


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
                        <form id="commentForm" enctype="multipart/form-data" @submit="onSubmit">
                            <input id="commentId" v-model="comment_id" type="hidden" name="comment_id">
                            <div class="mb-2">
                                <label for="input-username" class="form-label form-label-required">User Name</label>
                                <input id="input-username" v-model="name" name="name" type="text" class="form-control">
                                <div v-if="errors.name || server_errors.name" id="error-name" class="validation-error">
                                    {{ errors.name ?? server_errors.name }}
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="input-email" class="form-label form-label-required">E-mail</label>
                                <input id="input-email" v-model="email" name="email" type="email" class="form-control">
                                <div v-if="errors.email || server_errors.email" id="error-email" class="validation-error">
                                    {{ errors.email ?? server_errors.email }}
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="input-homepage" class="form-label">Home Page</label>
                                <input id="input-homepage" v-model="homepage" name="homepage" type="text"
                                    class="form-control">
                                <div v-if="errors.homepage || server_errors.homepage" id="error-homepage"
                                    class="validation-error">
                                    {{ errors.homepage ?? server_errors.homepage }}
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="input-text" class="form-label form-label-required">Comment Text</label>
                                <div class="comment-text-field">
                                    <div class="text-btn-panel">
                                        <div class="btn btn-primary " @click="writeTextTag('i')">
                                            <i class="bx bx-italic" />
                                        </div>
                                        <div class="btn btn-primary " @click="writeTextTag('strong')">
                                            <i class="bx bx-bold" />
                                        </div>
                                        <div class="btn btn-primary " @click="writeTextTag('code')">
                                            <i class="bx bx-code-alt" />
                                        </div>
                                        <div class="btn btn-primary " @click="writeTextTag('a')"><i class="bx bx-link" />
                                        </div>
                                    </div>
                                    <textarea id="input-text" v-model="text" name="text" class="form-control border-0"
                                        rows="3" />
                                </div>
                                <div v-if="errors.text || server_errors.text" id="error-text" class="validation-error">
                                    {{ errors.text ?? server_errors.text }}
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="input-image" class="form-label">Additional image</label>
                                <input id="input-image" name="image" class="form-control" type="file"
                                    accept=".png, .gif, .jpg">
                                <div v-if="server_errors.image" id="error-image" class="validation-error">
                                    {{ server_errors.image }}
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="input-file" class="form-label">Additional txt file</label>
                                <input id="input-file" name="file" class="form-control" type="file" accept=".txt">
                                <div v-if="server_errors.file" id="error-file" class="validation-error">
                                    {{ server_errors.file }}
                                </div>

                            </div>
                            <div class="mb-2">
                                <label for="input-file" class="form-label">Input the text from the image</label>
                                <div class="capthca-field">
                                    <Captcha />
                                    <input id="input-captcha" v-model="captcha" name="captcha" type="text"
                                        class="form-control mt-1">
                                </div>
                                <div v-if="errors.captcha || server_errors.captcha" id="error-image" class="validation-error">
                                    {{ errors.captcha ?? server_errors.captcha }}
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

.text-btn-panel {
    display: flex;
    gap: 8px;
    margin-bottom: 12px;
}

.comment-text-field {
    border: solid 1px var(--bs-gray-300);
    padding: 12px;
}

.capthca-field {
    max-width: 200px;
}

.captcha_canvas {
    flex: 1;
}
</style>
