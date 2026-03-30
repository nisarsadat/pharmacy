<template>
  <div class="page">
    <h1>User List</h1>

    <div class="users">
      <div v-for="user in users" :key="user.id" class="card">
        <h3>{{ user.name }}</h3>
        <p><strong>Email:</strong> {{ user.email }}</p>
        <p><strong>Role:</strong> {{ user.role }}</p>
        <p><strong>Status:</strong> 
          <span :class="user.active ? 'active' : 'inactive'">
            {{ user.active ? 'Active' : 'Inactive' }}
          </span>
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const users = ref([
  {
    id: 1,
    name: 'Ali Ahmad',
    email: 'ali@example.com',
    role: 'Admin',
    active: true,
  },
  {
    id: 2,
    name: 'Sara Khan',
    email: 'sara@example.com',
    role: 'User',
    active: false,
  },
  {
    id: 3,
    name: 'John Doe',
    email: 'john@example.com',
    role: 'Editor',
    active: true,
  },
  {
    id: 4,
    name: 'Fatima Noor',
    email: 'fatima@example.com',
    role: 'User',
    active: true,
  },
])
</script>

<style scoped>
.page {
  padding: 30px;
  font-family: Arial, sans-serif;
}

h1 {
  text-align: center;
  margin-bottom: 30px;
}

.users {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
}

.card {
  background: #fff;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.card h3 {
  margin-bottom: 10px;
}

.active {
  color: green;
  font-weight: bold;
}

.inactive {
  color: red;
  font-weight: bold;
}
</style>