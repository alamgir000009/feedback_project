<template>
    <Header />
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header bg-dark text-white">Give Feedback</div>
                    <div class="card-body">
                        <Error :errors="errors"/>
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
                                    <option v-for="category in categories" :value="category.name">{{ category.name }}</option>
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
        </div>
    </div>
</template>

<script>
import Header from "../components/Header.vue";
import Error from "../Components/Error.vue";

export default {
    name: "FeedbackForm",
    data() {
        return {
            formData: {
                category: "",
                title: "",
                description: "",
            },
            categories: [],
            errors: "",
        };
    },
    components: {
        Header,
        Error
    },
    methods: {
        async feedback() {
            this.errors = "";
            await this.axios
                .post("feedback", this.formData)
                .then((response) => {
                    this.formData = {
                        category: "",
                        title: "",
                        description: "",
                    };
                })
                .catch((errors) => {
                    this.errors =  this.$laravelErrors(errors);
                });
        },
        async fetchCategories() {
            await this.axios.get("category").then((response) => {
                this.categories = response.data.data;
            });
        },
    },
    created() {
        this.fetchCategories();
    },
};
</script>
