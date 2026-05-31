<template>
    <div class="users-container">

        <!-- HEADER -->
        <div class="header-section">

            <div class="header-content">

                <div class="title-section">

                    <div class="title-icon">
                        <v-icon
                            size="28"
                            color="primary"
                        >
                            mdi-account-group
                        </v-icon>
                    </div>

                    <div>
                        <h1 class="page-title">
                            Users
                        </h1>

                        <p class="page-subtitle">
                            Manage system users
                        </p>
                    </div>

                </div>

                <v-btn
                    color="primary"
                    size="large"
                    elevation="0"
                    class="add-btn"
                    @click="createDialog = true"
                >
                    <v-icon start>
                        mdi-plus
                    </v-icon>

                    Add User
                </v-btn>

            </div>

        </div>

        <!-- TABLE -->

        <v-card
            class="table-card"
            elevation="0"
            variant="outlined"
        >

            <v-data-table-server
                :headers="headers"
                :items="users"
                item-value="id"
                hover
                class="custom-table"
            >

                <!-- USER -->

                <template v-slot:item.user="{ item }">

                    <div class="user-cell">

                        <v-avatar
                            size="42"
                            color="grey-lighten-3"
                        >

                            <v-img
                                v-if="item.image"
                                :src="item.image"
                            />

                            <span
                                v-else
                                class="avatar-placeholder"
                            >
                                {{ getInitials(item.name) }}
                            </span>

                        </v-avatar>

                        <div>

                            <div class="user-name">
                                {{ item.name }}
                            </div>

                            <div class="user-email">
                                {{ item.email }}
                            </div>

                        </div>

                    </div>

                </template>

                <!-- USERNAME -->

                <template v-slot:item.username="{ item }">

                    <v-chip
                        size="small"
                        color="primary"
                        variant="tonal"
                    >
                        @{{ item.username }}
                    </v-chip>

                </template>

                <!-- NOTE -->

                <template v-slot:item.note="{ item }">

                    <div class="note-text">

                        {{ item.note || "-" }}

                    </div>

                </template>

                <!-- ACTIONS -->

                <template v-slot:item.actions="{ item }">

                    <div class="action-buttons">

                        <v-btn
                            icon
                            size="small"
                            color="warning"
                            variant="text"
                            @click="openEdit(item)"
                        >
                            <v-icon>
                                mdi-pencil
                            </v-icon>
                        </v-btn>

                        <v-btn
                            icon
                            size="small"
                            color="error"
                            variant="text"
                            @click="openDelete(item)"
                        >
                            <v-icon>
                                mdi-delete
                            </v-icon>
                        </v-btn>

                    </div>

                </template>

                <!-- EMPTY -->

                <template v-slot:no-data>

                    <div class="empty-state">

                        <v-icon
                            size="60"
                            color="grey-lighten-1"
                        >
                            mdi-account-off
                        </v-icon>

                        <p>
                            No users found
                        </p>

                    </div>

                </template>

            </v-data-table-server>

        </v-card>

        <!-- DIALOGS -->

        <CreateUserDialog
            v-model="createDialog"
            @saved="getUsers"
        />

        <EditUserDialog
            v-model="editDialog"
            :user="selectedUser"
            @updated="getUsers"
        />

        <DeleteUserDialog
            v-model="deleteDialog"
            :user="selectedUser"
            @deleted="getUsers"
        />

    </div>
</template>

<script setup>

import { ref, onMounted } from "vue";

import usersRepository from "@/repositories/usersRepository";

import CreateUserDialog from "./CreateUserDialog.vue";

import EditUserDialog from "./EditUserDialog.vue";

import DeleteUserDialog from "./DeleteUserDialog.vue";

// ========================================
// STATE
// ========================================

const users = ref([]);

const createDialog = ref(false);

const editDialog = ref(false);

const deleteDialog = ref(false);

const selectedUser = ref(null);

// ========================================
// TABLE HEADERS
// ========================================

const headers = [

    {
        title: "User",
        key: "user",
    },

    {
        title: "Username",
        key: "username",
    },

    {
        title: "Note",
        key: "note",
    },

    {
        title: "Actions",
        key: "actions",
        sortable: false,
        align: "end",
    },
];

// ========================================
// GET USERS
// ========================================

const getUsers = async () => {

    try {

        const response = await usersRepository.getUsers();

        users.value = response;

    } catch (error) {

        console.log(error);

    }
};

// ========================================
// INITIALS
// ========================================

const getInitials = (name) => {

    if (!name) return "?";

    return name
        .split(" ")
        .map(word => word[0])
        .join("")
        .toUpperCase()
        .slice(0, 2);
};

// ========================================
// EDIT
// ========================================

const openEdit = (user) => {

    selectedUser.value = user;

    editDialog.value = true;
};

// ========================================
// DELETE
// ========================================

const openDelete = (user) => {

    selectedUser.value = user;

    deleteDialog.value = true;
};

// ========================================
// MOUNTED
// ========================================

onMounted(() => {

    getUsers();
});

</script>

<style scoped>

.users-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 24px;
    background: #f5f7fb;
    min-height: 100vh;
}

/* ========================================
HEADER
======================================== */

.header-section {
    margin-bottom: 28px;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.title-section {
    display: flex;
    align-items: center;
    gap: 16px;
}

.title-icon {
    width: 52px;
    height: 52px;
    background: rgba(79, 70, 229, 0.1);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.page-title {
    font-size: 28px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0 0 4px 0;
}

.page-subtitle {
    font-size: 14px;
    color: #6b7280;
    margin: 0;
}

.add-btn {
    border-radius: 14px !important;
    text-transform: none !important;
    font-weight: 600 !important;
    padding: 0 22px !important;
}

/* ========================================
TABLE
======================================== */

.table-card {
    border-radius: 20px;
    border: 1px solid #e5e7eb;
    overflow: hidden;
    background: white;
}

.custom-table :deep(th) {
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    color: #6b7280;
    background: #fafbfc;
}

.custom-table :deep(td) {
    padding: 18px 12px;
    border-bottom: 1px solid #f1f5f9;
}

/* ========================================
USER CELL
======================================== */

.user-cell {
    display: flex;
    align-items: center;
    gap: 14px;
}

.avatar-placeholder {
    font-size: 14px;
    font-weight: 600;
    color: #4f46e5;
}

.user-name {
    font-weight: 600;
    color: #111827;
}

.user-email {
    font-size: 13px;
    color: #6b7280;
}

/* ========================================
NOTE
======================================== */

.note-text {
    max-width: 300px;
    color: #4b5563;
}

/* ========================================
ACTIONS
======================================== */

.action-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 6px;
}

/* ========================================
EMPTY
======================================== */

.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-state p {
    margin-top: 14px;
    color: #9ca3af;
}

/* ========================================
RESPONSIVE
======================================== */

@media (max-width: 768px) {

    .users-container {
        padding: 16px;
    }

    .header-content {
        flex-direction: column;
        align-items: stretch;
    }

    .page-title {
        font-size: 22px;
    }

    .add-btn {
        width: 100%;
    }
}

</style>