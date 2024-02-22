<script setup>
import CommentItem from '@/Components/CommentItem.vue';

const comments = [
   {
      name: 'GlebMiz',
      email: 'glebmiz14@gmail.com',
      date: '12.12.2024',
      text: 'Text TExt TExt',
      children: [
         {
            name: 'GlebMiz',
            email: 'glebmiz14@gmail.com',
            date: '12.12.2024',
            text: 'Text TExt TExt <br> <p>asd</p>',
            files: [
               {
                  type: 'image',
                  name: 'Image',
                  path: '/comment/img/photo.jpg'
               }
            ]
         }
      ]
   }
];
</script>

<template>
   <div class="comments-block mt-2">
      <div class="comment-filter">
         <div class="comment-filter__name">
            <span data-filter="up">Name</span>
         </div>
         <div class="comment-filter__email">
            <span data-filter="down">Email</span>
         </div>
         <div class="comment-filter__date">
            <span>Date Added</span>
         </div>
      </div>
      <div class="comment-list">
         <CommentItem :comments="comments" />
      </div>
      <nav class="mt-3 d-flex justify-content-center" aria-label="Page navigation example">
         <ul class="pagination">
            <li class="page-item">
               <a class="page-link" href="#" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
               </a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
               <a class="page-link" href="#" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
               </a>
            </li>
         </ul>
      </nav>
   </div>
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

