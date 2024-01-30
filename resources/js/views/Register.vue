<template>
    <Header />
    <div class="container mt-4">
        <div class="col-md-8 mx-auto">
            <div class="card bg-white">
                <div class="card-heading">
                    <h3 class="card-title">
                        Please sign up <small>It's free!</small>
                    </h3>
                </div>
                <div class="card-body">
                    <form @submit.prevent="register()">
                        <div class="form-group mt-3">
                            <input
                                type="text"
                                class="form-control input-sm"
                                placeholder="Enter Name"
                                v-model="formData.name"
                            />
                        </div>
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
import Header from "../components/Header.vue";
export default {
    name: "Register",
    data() {
        return {
            formData: {
                name: "",
                email: "",
                passowrd: "",
                password_confirmation: "",
            },
        };
    },
    components: {
        Header,
    },
    methods: {
        async register() 
        {
            await this.axios
                .post("register", this.formData)
                .then((response) => {
                    this.$moshaToast(
                        { title: "Registered successfully" },
                        {
                            type: "success",
                            showIcon: true,
                            hideProgressBar: true,
                        }
                    );
                    localStorage.setItem(
                        "auth_sanctum_token",
                        response.data.data.token
                    );
                    this.$router.push("/home");
                })
                .catch((errors) => {
                    this.$showFlattenedErrorsInMoshaToast(errors);
                });
        },
    },
};
</script>
