<template>
    <Header />
    <div class="container mt-3">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header">Give Feedback</div>
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
                                <option value="bug report">Bug Report</option>
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
                            <label for="" class="form-label">Description</label>
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
    },
};
</script>
