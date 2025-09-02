<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { API_BASE_URL } from './../constants/constants.js'

const router = useRouter();

const email = ref('');
const password = ref('');
const error = ref('');

const roleRoutes = {
  admin: "/admin",
  operator: "/operator",
  backoffice: "/backoffice",
};

const login = async () => {
  error.value = '';
  try {
    const res = await axios.post(`${API_BASE_URL}/login`, {
      email: email.value,
      password: password.value,
    });

    sessionStorage.setItem("token", res.data.token);
    sessionStorage.setItem("user", JSON.stringify(res.data.user));

    // redirect based on role
    const role = res?.data?.user?.roles[0].name;

    if (role && roleRoutes[role]) {
      router.push(roleRoutes[role]);
    } else {
      router.push("/");
    }
  } catch (err) {
    if (err.response && err.response.data.message) {
      error.value = err.response.data.message;
    } else {
      error.value = 'Login failed. Please try again.';
    }
  }
};
</script>

<template>
  <div class="login-container">
    <div class="login-box">
      <h2>Login</h2>
      <form @submit.prevent="login">
        <div class="form-group">
          <label for="email">Email</label>
          <input
            type="email"
            id="email"
            v-model="email"
            placeholder="Enter your email"
            required
          />
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input
            type="password"
            id="password"
            v-model="password"
            placeholder="Enter your password"
            required
          />
        </div>

        <button type="submit">Login</button>

        <p v-if="error" class="error-message">{{ error }}</p>
      </form>
    </div>
  </div>
</template>

<style scoped>
/* container  */
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #f2f2f2;
  padding: 1rem;
  box-sizing: border-box;
}

/* login box */
.login-box {
  background-color: #fff;
  padding: 2rem;
  width: 100%;
  max-width: 400px;
  border-radius: 8px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

/* heading */
.login-box h2 {
  text-align: center;
  margin-bottom: 1.1rem;
  font-size: 1.8rem;
  color: #333;
}

/* form */
.form-group {
  margin-bottom: 1rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.3rem;
  color: #555;
  font-weight: bold;
}

.form-group input {
  width: 100%;
  padding: 0.6rem 0.8rem;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 1rem;
  box-sizing: border-box;
}

.form-group input:focus {
  outline: none;
  border-color: #007BFF;
  box-shadow: 0 0 4px rgba(0,123,255,0.4);
}

/* button */
button {
  width: 100%;
  padding: 0.8rem;
  margin-top: 10px;
  background-color: #1c5980;
  color: white;
  font-weight: bold;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 1rem;
  transition: background-color 0.2s;
}

button:hover {
  background-color: #2980b9;
}

/* error message */
.error-message {
  margin-top: 1rem;
  color: red;
  font-size: 0.9rem;
  text-align: center;
}

/* mobile adjustments */
@media (max-width: 480px) {
  .login-box {
    padding: 1.5rem;
  }

  .login-box h2 {
    font-size: 1.5rem;
  }

  button {
    padding: 0.7rem;
  }
}
</style>

