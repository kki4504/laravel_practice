<template>
    <div class="m-3 rounded">
        <div class="form-group mt-2">
            <label class="block text-left" style="max-width: 100%;">
                <span class="text-gray-700">댓글 작성</span>
                <textarea class="form-textarea mt-1 block w-full" v-model="comment" rows="2"></textarea>
            </label>
            <button class="btn btn-outline-success" type="submit" @click="storeCommnet">댓글 작성</button>
        </div>
        <button class="btn btn-outline-info textcolor-white mt-4 btn-block" @click="getComment">댓글 불러오기</button>
        <comment-item v-for="(comment, index) in comments.data" :key="index" :comment="comment" class="mt-3 w-100" @deleteComment="getComment" />
        <comment-pagination class="mt-3" v-if="comments.data != null" :links="comments.links" @pageClicked="getPage($event)"/>
    </div>
</template>
<script>
import CommentItem from './CommentItem.vue'
import CommentPagination from './CommentPagination.vue'
    export default {
        props:['post', 'loginuser'],
        components: {CommentItem, CommentPagination},
        data() {
            return {
                comment:'',
                comments : [],
            }
        },
        methods: {
            getPage(url) {
                axios.get(url)
                .then(res => {
                    this.comments = res.data;
                })
                .catch(err => {
                    console.log(err.message);
                })
            },
            getComment(){
                axios
                    .get('/comment/index/'+this.post.id)
                    .then(res => {
                        this.comments = res.data;
                        return console.log(res);
                    })
                    .catch(err => {
                        console.log(err.message);
                    })
                // this.comments = ['1st comment', '2nd comment', '3rd  comment', '4th comment', '5th comment'];
            },
            // 서버에 현재 게시글의 댓글 리스트를 비동기적으로 요청
            // 즉, axios를 이용해서 요청
            // 서버가 댓글 리스트를 주면 그놈을 
            // this.comments에 할당
            storeCommnet() {
                console.log("comment");
                console.log(this.comment);
                // console.log(this.post);
                axios
                    .post('/comment/store/'+this.post.id, {'comment' : this.comment})
                    .then(res => {
                        this.getComment();
                    })
                    .catch(err => {
                        console.log(err);
                    });
                this.comment = '';
            },
        },

    }
</script>
