<template>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <router-link class="navbar-brand" to="/">Logo</router-link>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <!-- Left Side Of Navbar -->
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <router-link class="nav-link" to="/feedback-form">Feedback Form</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/feedback-list">Feedback List</router-link>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <li v-if="!isLoggedIn" class="nav-item">
          <router-link class="nav-link" to="/register">Register</router-link>
        </li>
        <li v-if="!isLoggedIn" class="nav-item">
          <router-link class="nav-link" to="/login">Login</router-link>
        </li>
        <li v-else class="nav-item">
          <a class="nav-link" href="#" @click="logout()">Log out</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
</template>

<script>

export default {
    name: 'Header',
    data() {
        return {
            isLoggedIn: false,
        }
    },
    methods:{
        async logout()
        {
            await this.axios.post('user/logout').then(() => {
                localStorage.removeItem('auth_sanctum_token');
            }).catch(() => {
                localStorage.removeItem('auth_sanctum_token');
            }).finally(() => {
                this.$router.push('/login');
            });
        },
    },
    mounted() {
        this.isLoggedIn = localStorage.getItem('auth_sanctum_token') !== null;
    }
}

</script>