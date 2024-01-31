<template>
    <Header />
    <div class="container mt-5">
        <div class="col-md-6 mx-auto">
            <div class="card bg-white">
                <div class="card-heading">
                    <h3 class="text-center bg-dark text-white py-3">Register</h3>
                </div>
                <div class="card-body">
                    <Error :errors="errors" />
                    <form @submit.prevent="register()">
                        <div class="form-group mt-3">
                            <label for="" class="form-label">Name</label>
                            <input
                                type="text"
                                class="form-control input-sm"
                                placeholder="Enter Name"
                                v-model="formData.name"
                            />
                        </div>
                        <div class="form-group mt-3">
                            <label for="" class="form-label">Username</label>
                            <input
                                type="text"
                                class="form-control input-sm"
                                placeholder="Enter Unique Username"
                                v-model="formData.username"
                            />
                        </div>
                        <div class="form-group mt-3">
                            <label for="" class="form-label">Email</label>
                            <input
                                type="email"
                                class="form-control input-sm"
                                placeholder="Email Address"
                                v-model="formData.email"
                            />
                        </div>
                        <div class="form-group mt-3">
                            <label for="" class="form-label"
                                >Select Image (Optional)</label
                            >
                            <input
                                type="file"
                                class="form-control input-sm"
                                placeholder="Email Address"
                                @change="imageSelected($event)"
                            />
                        </div>
                        <div class="form-group mt-3">
                            <input
                                type="password"
                                class="form-control input-sm"
                                placeholder="Password"
                                v-model="formData.password"
                            />
                        </div>
                        <div class="form-group mt-3">
                            <input
                                type="password"
                                v-model="formData.password_confirmation"
                                class="form-control input-sm"
                                placeholder="Confirm Password"
                            />
                        </div>
                        <button
                            type="submit"
                            class="btn mt-3 btn-success w-100"
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
import Header from "../components/Header.vue";
import Error from "../components/Error.vue";
export default {
    name: "Register",
    data() {
        return {
            formData: {
                name: "",
                username:"",
                email: "",
                passowrd: "",
                password_confirmation: "",
            },
            image: "",
            errors: "",
        };
    },
    components: {
        Header,
        Error,
    },
    methods: {
        imageSelected(event) {
            this.image = event.target.files[0];
        },
        async register() {
            this.errors = "";
            const data = new FormData();
            if (this.image) {
                data.append("image", this.image);
            }
            data.append("name", this.formData.name);
            data.append("username", this.formData.username);
            data.append("email", this.formData.email);
            data.append("password", this.formData.password);
            data.append(
                "password_confirmation",
                this.formData.password_confirmation
            );
            await this.axios
                .post("register", data)
                .then((response) => {
                    localStorage.setItem(
                        "auth_sanctum_token",
                        response.data.data.token
                    );
                    this.$router.push("/feedback-form");
                })
                .catch((errors) => {
                    this.errors = this.$laravelErrors(errors);
                });
        },
    },
};
</script>
