<template>
    <Header />
    <div class="container mt-3">
        <div class="col-md-10 mx-auto">
            <div class="card shadow-lg">
                <div class="card-header bg-dark text-white">Feedback list</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6" v-if="feedbacks.length > 0" v-for="(feedback, index) in feedbacks" :key="index">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <img :src="feedback.user.image" class="rounded-circle" style="object-fit:cover" alt="User Profile Image" width="50" height="50">
                                            <p class="mt-2">{{ feedback.user.name }}</p>
                                        </div>
                                        <div>
                                            <router-link :to="'feedback-details/'+feedback.id" class="btn btn-primary">
                                            View Details/Comments
                                        </router-link>
                                        </div>
                                    </div>
                                    <div class="feedback-details">
                                        <div v-html="feedback.description"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <Pagination :links="links" :prev="prev_page_url" :next="next_page_url" :currentPage="currentPage" :list="fetchFeedbacks" />
                </div>                
            </div>
        </div>
    </div>
</template>

<script>
import Header from "./../components/Header.vue";
import Pagination from "../components/Pagination.vue";

export default {
    name: "FeedbackList",
    data() {
        return {
            currentPage:1,
            prev_page_url: "",
            next_page_url: "",
            formData: {
                category: "",
                title: "",
                description: "",
            },
            feedbacks: [],
            links: [],
            comment: "",
        };
    },
    components: {
        Header,
        Pagination,
    },
    methods: {
        async submitComment(feedback_id) {
            await this.axios
                .post("feedback-comment", {
                    feedback_id: feedback_id,
                    comment: this.comment,
                })
                .then(() => {
                    alert("Feedback added successfully")
                    this.fetchFeedbacks();
                    this.comment = "";
                })
        },
        async fetchFeedbacks(page = 1) {
            await this.axios.get(`feedback?page=${page}`).then((response) => {
                this.currentPage = response.data.data.current_page
                this.feedbacks = response.data.data.data;
                this.links = response.data.data.links;
                this.next_page_url = response.data.data.next_page_url;
                this.prev_page_url = response.data.data.prev_page_url;
            });
        },
    },
    created() {
        this.fetchFeedbacks();
    },
};
</script>

<style>
.feedback-details {
    max-height: 200px !important;
    overflow-y: auto;
}
</style>
