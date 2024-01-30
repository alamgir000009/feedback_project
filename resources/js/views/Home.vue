<template>
    <Header />

    <div class="container mt-3">
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header bg-dark text-white">Give Feedback</div>
                    <div class="card-body">
                        <form @submit.prevent="feedback()">
                            <div class="form-group mt-3">
                                <label for="" class="form-label"
                                    >Select Category</label
                                >
                                <select
                                    class="form-control form-select"
                                    v-model="formData.category"
                                >
                                    <option value="">Select Category</option>
                                    <option value="bug report">
                                        Bug Report
                                    </option>
                                    <option value="feature request">
                                        Feature Request
                                    </option>
                                    <option value="improvements">
                                        Improvements
                                    </option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="form-group mt-3">
                                <label for="" class="form-label">Titl</label>
                                <input
                                    type="text"
                                    class="form-control input-sm"
                                    placeholder="Enter title"
                                    v-model="formData.title"
                                />
                            </div>
                            <div class="form-group mt-3">
                                <label for="" class="form-label"
                                    >Description</label
                                >
                                <textarea
                                    class="form-control input-sm"
                                    placeholder="Enter description"
                                    v-model="formData.description"
                                ></textarea>
                            </div>

                            <button
                                type="submit"
                                class="btn mt-3 btn-info btn-block"
                            >
                                Register
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header bg-dark text-white">
                        Feedback list
                    </div>
                    <div class="card-body">
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div v-for="(feedback, index) in feedbacks" :key="index" class="accordion-item">
                              <h2 class="accordion-header" :id="'flush-heading' + index">
                                <button class="accordion-button collapsed" type="button" :data-bs-toggle="'collapse'" :data-bs-target="'#flush-collapse' + index" :aria-expanded="false" :aria-controls="'flush-collapse' + index">
                                    <div class="d-flex align-items-center">
                                      <!-- Circular avatar with user name -->
                                      <div class="avatar me-3 d-flex justify-content-center align-items-center" style="width: 50px; height: 50px; border-radius: 50%; background-color: #aaa; overflow: hidden;">
                                        {{ feedback.user.name.charAt(0).toUpperCase() }}
                                      </div>
                                      {{ feedback.title }}
                                    </div>
                                  </button>
                              </h2>
                              <div :id="'flush-collapse' + index" class="accordion-collapse collapse" :aria-labelledby="'flush-heading' + index" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">{{ feedback.description }}</div>
                                <hr>
                                <div class="previous-comments" style="max-height: 100px; overflow-y: auto;">
                                    <div v-for="(comment, commentIndex) in feedback.comments" :key="commentIndex"
                                        class="d-flex mb-2">
                                        <div class="avatar d-flex justify-content-center align-items-center me-2" style="width: 30px; height: 30px; border-radius: 50%; background-color: #aaa; overflow: hidden;">
                                            {{ comment.user.name.charAt(0).toUpperCase() }}
                                        </div>
                                        <div>
                                            <strong>{{ comment.user.name }}</strong>
                                            <p>{{ comment.comment }}</p>
                                            <small><i>{{ $formatWithLaravelDate(comment.created_at) }}</i></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mt-3 mb-4">
                                    <input v-model="comment" type="text" class="form-control" placeholder="Add your comment...">
                                        <div class="input-group-append">
                                            <button type="button" @click="submitComment(feedback.id)" class="btn btn-primary">Submit</button>
                                        </div>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Header from "./../components/Header.vue";

export default {
    name: "Home",
    data() {
        return {
            formData: {
                category: "",
                title: "",
                description: "",
            },
            feedbacks: [],
            comment:''
        };
    },
    components: {
        Header,
    },
    methods: {
        async feedback() {
            await this.axios
                .post("feedback", this.formData)
                .then((response) => {
                    this.$moshaToast(
                        { title: "Feedback registered successfully" },
                        {
                            type: "success",
                            showIcon: true,
                            hideProgressBar: true,
                        }
                    );
                    this.fetchFeedbacks();
                    this.formData = {
                        category: "",
                        title: "",
                        description: "",
                    };
                })
                .catch((errors) => {
                    this.$showFlattenedErrorsInMoshaToast(errors);
                });
        },
        async submitComment(feedback_id) {
            await this.axios
                .post("feedback-comment", {feedback_id:feedback_id,comment:this.comment})
                .then((response) => {
                    this.$moshaToast(
                        { title: "Comment added successfully" },
                        {
                            type: "success",
                            showIcon: true,
                            hideProgressBar: true,
                        }
                    );
                    this.fetchFeedbacks();
                    this.comment = "";
                })
                .catch((errors) => {
                    this.$showFlattenedErrorsInMoshaToast(errors);
                });
        },
        async fetchFeedbacks() {
            await this.axios.get("feedback").then((response) => {
                this.feedbacks = response.data.data;
            });
        },
    },
    created() {
        this.fetchFeedbacks();
    },
};
</script>
