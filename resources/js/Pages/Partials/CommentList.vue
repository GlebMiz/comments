<script lang="ts" setup>
import CommentItem from '@/Components/CommentItem.vue';
import { Comment } from '@/interfaces/comment';
import { router } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { replaceQueryParams } from '@/helpers/replaceQueryParams';
import Pagination from '@/Components/Pagination.vue';

defineProps<{
   comments: Comment[],
   maxPage: number,
}>();

const filter = (filter: string) => {
   const filter_item = document.getElementById('filter-' + filter);
   if (filter_item) {
      const order = filter_item.getAttribute('data-filter') == 'up' ? 'down' : 'up';
      const query = replaceQueryParams({filter: filter, order: order, page: ''})
      router.visit(`/${query}`);
   }
};

onMounted(() => {
   const urlParams = new URLSearchParams(window.location.search);
   const filterParam = urlParams.get('filter') ?? 'date';
   const orderParam = urlParams.get('order') ?? 'down';

   if (filterParam) {
      const filterSpan = document.getElementById(`filter-${filterParam}`);
      if (filterSpan) {
            filterSpan.setAttribute('data-filter', orderParam);
      }
   }
});

</script>

<template>
   <div v-if="comments" class="comments-block mt-2">
      <div class="comment-filter">
         <div class="comment-filter__name">
            <span id="filter-username" @click="filter('username')">Name</span>
         </div>
         <div class="comment-filter__email">
            <span id="filter-email" @click="filter('email')">Email</span>
         </div>
         <div class="comment-filter__date">
            <span id="filter-date" @click="filter('date')">Date Added</span>
         </div>
      </div>
      <div class="comment-list">
         <CommentItem :comments="comments" />
      </div>
      <Pagination :max="maxPage" />
   </div>
   <div v-else class="text-center">There are empty now</div>
</template>

<style lang="scss">
.comment-filter {
   $filter-border: solid 2px var(--bs-black);

   padding: 8px 16px;
   display: flex;
   gap: 12px;
   align-items: center;
   width: 100%;
   font-size: .9rem;
   border-bottom: solid 1px var(--bs-gray-300);

   span {
      position: relative;
      padding-right: 10px;
      cursor: pointer;

      &::after {
         font-size: 1.2rem;
         font-family: 'boxicons';
         position: absolute;
         left: calc(100%);
         top: 50%;
         transform: translateY(-50%);
      }

      &[data-filter="down"]::after {
         content: '\ea4a';
      }

      &[data-filter="up"]::after {
         margin-top: 3px;
         content: '\ea57';
      }

   }
}

.comment-filter__name {
   width: 100px;
}

.comment-filter__email {
   width: 200px;
}

.comment-filter__date {
   margin-left: auto;
}
</style>

