<template>
    <Header />
    <div class="container mt-4">
        <div class="col-md-8 mx-auto">
            <div class="card bg-white">
                <div class="card-heading">
                    <h3 class="card-title">Login</h3>
                </div>
                <div class="card-body">
                    <Error :errors="errors"></Error>
                    <form @submit.prevent="login()">
                        <div class="form-group mt-3">
                            <input
                                type="email"
                                class="form-control input-sm"
                                placeholder="Email Address"
                                v-model="formData.email"
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
                        <button
                            type="submit"
                            class="btn mt-3 btn-info btn-block"
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
                        this.$router.push("/home");
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
