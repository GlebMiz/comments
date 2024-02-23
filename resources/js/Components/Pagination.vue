<script lang="ts" setup>
import { replaceQueryParams } from '@/helpers/replaceQueryParams';
import { router } from '@inertiajs/vue3';

const props = defineProps<{
    max: number,
}>();

const setPage = (page: number) => {
    if (page > props.max)
        page = props.max;
    if (page < 1)
        page = 1;
    const query = replaceQueryParams({ page: page as unknown as string })
    router.visit(`/${query}`);
};

const urlParams = new URLSearchParams(window.location.search);
const currentPage = urlParams.get('page') as unknown as number ?? 1;
</script>

<template>
    <nav v-if="max > 1" class="mt-3 d-flex justify-content-center" aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item" :class="{ 'disabled': currentPage == 1 }" @click="setPage(currentPage - 1)">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li v-for="n in max" :key="n" class="page-item" @click="setPage(n)"><a class="page-link" href="#">{{ n }}</a>
            </li>
            <li class="page-item" :class="{ 'disabled': currentPage == max }" @click="setPage(currentPage + 1)">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</template>