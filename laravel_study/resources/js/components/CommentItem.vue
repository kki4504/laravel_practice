<template>
<!-- component -->
<div class="antialiased w-100">
  <h3 class="mb-4 text-lg font-semibold text-gray-900">Comments</h3>

  <div class="space-y-4">
    <div class="flex">
      <div class="flex-1 border rounded-lg px-3 py-2 sm:px-6 sm:py-4 leading-relaxed">
        <strong>{{ comment.user.name }}</strong> 
        <span class="text-xs text-gray-400">
            {{ comment.updated_at }}
        </span>
        <p class="text-sm mt-2" v-if="showTextarea == false">
          {{comment.comment}}
        </p>
        <form class="form-group" v-if="showTextarea==true">
          <textarea class="form-textarea mt-1 block w-full" 
                    v-model="comment.comment" rows="2"></textarea>
        </form>
        <div>        
          <span class="float-right" v-if="comment.user.id == login_user_id">
            <button class="btn btn-outline-primary" v-if="showTextarea == false" @click="showText">댓글 수정</button>
            <button class="btn btn-outline-primary" v-if="showTextarea == true" @click="updateComment">댓글 수정 완료</button>
            <button class="btn btn-outline-danger" @click="deleteComment">댓글 삭제</button>
          </span>
          <!-- <div class="text-sm text-gray-500 font-semibold">
            5 Replies
          </div> -->
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
export default {
    props: ['comment', 'login_user_id'],
    data() {
        return {  
          showTextarea: false,
        }
    },
    methods: {
      showText() {
        this.showTextarea = !this.showTextarea;
      },
      updateComment() {
            // $('#comment' + this.comment.id).attr('readonly', false)
            // .html('<textarea v-model="newComment">'+this.comment.comment+'</textarea>');
            if(confirm('Are you sure to update?')) {
              axios
                  .patch('/comment/update/' + this.comment.id, {
                      'comment':this.comment.comment
                  }).then(res => {
                    this.showText();
                    console.log(res);
                  }).catch(err => {
                    console.log('err');
                  })
            }
            },
      deleteComment() {
          if(confirm('Are you sure to delete?')) {
            console.log('Delete Comment');
            axios
              .delete('/comment/delete/' + this.comment.id)
              .then(res => {
                this.$emit('deleteComment');
                // this.$parent.getComment();
                console.log('Delete Success');
              }) 
              .catch(err => {
                console.log(err);
                console.log ('Delete Error');
              })
          }
      }
    }
    
}
</script>
