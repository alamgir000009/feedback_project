<template>
    <Header />

    <div class="container mb-5 mt-2">
        <div class="col-md-10 mx-auto">
            <div class="card shadow-lg">
                <div class="card-header bg-dark text-white">Feedback preview with comments</div>
                <div class="card-body" v-if="Object.keys(feedback).length>0">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-start gap-2">
                                <img :src="feedback.user.image" class="rounded-circle" style="object-fit:cover" alt="User Profile Image" width="50" height="50">
                                <h4 class="mt-2">{{ feedback.user.name }}</h4>
                            </div>
                            <hr/>
                            <div>
                                <h1 class="feedback-title"> {{ feedback.title }} </h1>
                            </div>
                            <div class="feedback-details">
                                <div v-html="feedback.description"></div>
                            </div>
                            <div class="comments-area">
                                <hr />
                                <h4>Below are the comments on the feedback</h4>
                                <hr/>
                                <div class="mb-3" v-if="feedback.comments.length > 0" v-for="(comment, index) in feedback.comments" :key="index">
                                    <div class="d-flex justify-content-start gap-2">
                                        <img :src="comment.user.image" class="rounded-circle" style="object-fit:cover" alt="User Profile Image" width="50" height="50">
                                        <p class="mt-2">{{ comment.user.name }}</p>
                                    </div>
                                    <div class="comment-details ms-5">
                                        <div v-html="comment.comment"></div>
                                    </div>
                                    <div style="width: 100%; border-bottom: 2px dashed black;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form @submit.prevent="addComment()">
                        <Mentionable
                            :keys="['@']"
                            :items="users"
                            >
                            <textarea placeholder="Enter comment type @ to tag someone" class="form-control" v-model="comment"/>
                        </Mentionable>
                        <button type="submit" class="btn mt-2 btn-success">Add comment</button>
                    </form>
                </div>                
            </div>
        </div>
    </div>
    
</template>

<script>
import Header from "./../components/Header.vue";
import Pagination from "../components/Pagination.vue";
import { Mentionable } from 'vue-mention'

export default {
    name: "FeedbackView",
    data() {
        return {
            feedback: {},
            users: [],
            comment: "",
        };
    },
    components: {
        Header,
        Pagination,
        Mentionable
    },
    methods: {
        async addComment() {
            await this.axios
                .post("feedback-comment", {
                    feedback_id: this.$route.params.id,
                    comment: this.comment,
                })
                .then(() => {
                    alert("Feedback added successfully")
                    this.fetchFeedback();
                    this.comment = "";
                })
        },
        async fetchUsers() {
            await this.axios.get(`user/list`).then((response) => {
                this.users = response.data.data;
            });
        },
        async fetchFeedback() {
            await this.axios.get(`feedback/${this.$route.params.id}`).then((response) => {
                this.feedback = response.data.data;
            });
        },
    },
    created() {
        this.fetchUsers();
        this.fetchFeedback();
    },
};
</script>

<style>
.mention-item {
  padding: 4px 10px;
  border-radius: 4px;
}

.mention-selected {
  background: rgb(192, 250, 153);
}
</style>

<style scoped>
.demo {
  margin: 24px 0;
}

.input {
  width: 100%;
  border: #ccc 1px solid;
  border-radius: 6px;
  resize: vertical;
  min-height: 42px;
  padding: 12px;
  box-sizing: border-box;
  line-height: 1.2em;
  font-size: inherit;
}

.issue {
  padding: 4px 6px;
  border-radius: 4px;
  cursor: pointer;
}

.mention-selected .issue {
  background: rgb(139, 212, 255);
}

.issue .number {
  font-family: monospace;
}

.dim {
  color: #666;
}

.preview {
  font-family: monospace;
  white-space: pre-wrap;
  margin-top: 12px;
  padding: 12px;
  background: #f8f8f8;
  border-radius: 6px;
}

.comments-area {
    max-height: 350px !important;
    overflow-y: auto;
}
</style>
