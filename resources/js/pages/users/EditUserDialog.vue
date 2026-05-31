<template>

    <v-dialog
        :model-value="modelValue"
        max-width="500"
        @update:modelValue="$emit('update:modelValue', $event)"
    >

        <v-card>

            <v-card-title>
                Edit User
            </v-card-title>

            <v-card-text>

                <v-text-field
                    v-model="form.name"
                    label="Name"
                />

                <v-text-field
                    v-model="form.username"
                    label="Username"
                />

                <v-text-field
                    v-model="form.email"
                    label="Email"
                />

                <v-textarea
                    v-model="form.note"
                    label="Note"
                />

            </v-card-text>

            <v-card-actions>

                <v-spacer />

                <v-btn
                    text
                    @click="closeDialog"
                >
                    Cancel
                </v-btn>

                <v-btn
                    color="warning"
                    :loading="loading"
                    @click="submit"
                >
                    Update
                </v-btn>

            </v-card-actions>

        </v-card>

    </v-dialog>

</template>

<script setup>

import { reactive, watch, ref } from "vue";

import { toast } from "vue3-toastify";

import usersRepository from "@/repositories/usersRepository";

const props = defineProps({
    modelValue: Boolean,
    user: Object,
});

const emit = defineEmits([
    "update:modelValue",
    "updated",
]);

const loading = ref(false);

const form = reactive({
    name: "",
    username: "",
    email: "",
    note: "",
});

// ===================================
// WATCH USER
// ===================================

watch(
    () => props.user,
    (user) => {

        if (!user) return;

        form.name = user.name;
        form.username = user.username;
        form.email = user.email;
        form.note = user.note;
    },
    {
        immediate: true,
    }
);

// ===================================
// CLOSE
// ===================================

const closeDialog = () => {

    emit("update:modelValue", false);
};

// ===================================
// UPDATE
// ===================================

const submit = async () => {

    try {

        loading.value = true;

        await usersRepository.updateUser(
            props.user.id,
            form
        );

        toast.success("User updated");

        emit("updated");

        closeDialog();

    } catch (error) {

        console.log(error);

    } finally {

        loading.value = false;
    }
};

</script>