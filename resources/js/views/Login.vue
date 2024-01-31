<template>
    <Header />
    <div class="container mt-4">
        <div class="col-md-8 mx-auto">
            <div class="card bg-white">
                <div class="card-header bg-dark text-white text-center">
                    <h3>Login</h3>
                </div>
                <div class="card-body">
                    <Error :errors="errors"></Error>
                    <form @submit.prevent="login()">
                        <div class="form-group mt-3">
                        <label class="form-label">Enter your email</label>
                            <input
                                type="email"
                                class="form-control input-sm"
                                placeholder="Email Address"
                                v-model="formData.email"
                            />
                        </div>
                        <div class="form-group mt-3">
                        <label class="form-label">Enter your password</label>
                            <input
                                type="password"
                                class="form-control input-sm"
                                placeholder="Password"
                                v-model="formData.password"
                            />
                        </div>
                        <button
                            type="submit"
                            class="btn mt-3 btn-success w-100"
                        >
                            Login
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
    name: "Login",
    data() {
        return {
            errors : '',
            formData: {
                email: "",
                passowrd: "",
            },
        };
    },
    components: {
        Header,
        Error
    },
    methods: {
        async login() {
            this.errors = '';
            await this.axios
                .post("login", this.formData)
                .then((response) => {
                    localStorage.setItem(
                        "auth_sanctum_token",
                        response.data.data.token
                    );
                    if (response.data.data.user.role == "User") {
                        this.$router.push("/feedback-form");
                    } else {
                        this.$router.push("/dashboard");
                    }
                })
                .catch((errors) => {
                    this.errors = this.$laravelErrors(errors);
                });
        },
    },
};
</script>
