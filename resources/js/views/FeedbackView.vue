<template>
    <Header />

    <div class="container mt-3">
        <div class="col-md-10 mx-auto">
            <div class="card shadow-lg">
                <div class="card-header bg-dark text-white">Feedback list</div>
                <div class="card-body">
                    {{ users }}
                    <Mentionable
                        :keys="['@']"
                        :items="items"
                        offset="6"
                    >
                        <textarea v-model="text"/>
                    </Mentionable>
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
            text: 'hok',
            items: [
                {
                value: 'cat',
                label: 'Mr Cat',
                },
                {
                value: 'dog',
                label: 'Mr Dog',
                },
            ],
        };
    },
    components: {
        Header,
        Pagination,
        Mentionable
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
        async fetchUsers() {
            await this.axios.get(`user/list`).then((response) => {
                this.users = response.data.data.data;
            });
        },
    },
    created() {
        this.fetchUsers();
    },
};
</script>
