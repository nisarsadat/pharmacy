<template>

    <v-dialog
        :model-value="modelValue"
        max-width="500"
        @update:modelValue="$emit('update:modelValue', $event)"
    >

        <v-card>

            <v-card-title>
                Create User
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

                <v-text-field
                    v-model="form.password"
                    label="Password"
                    type="password"
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
                    color="primary"
                    :loading="loading"
                    @click="submit"
                >
                    Save
                </v-btn>

            </v-card-actions>

        </v-card>

    </v-dialog>

</template>

<script setup>

import { reactive, ref } from "vue";

import { toast } from "vue3-toastify";

import usersRepository from "@/repositories/usersRepository";

const props = defineProps({
    modelValue: Boolean,
});

const emit = defineEmits([
    "update:modelValue",
    "saved",
]);

const loading = ref(false);

const form = reactive({
    name: "",
    username: "",
    email: "",
    password: "",
    note: "",
});

// ===================================
// CLOSE
// ===================================

const closeDialog = () => {

    emit("update:modelValue", false);
};

// ===================================
// SUBMIT
// ===================================

const submit = async () => {

    try {

        loading.value = true;

        await usersRepository.createUser(form);

        toast.success("User created");

        emit("saved");

        closeDialog();

    } catch (error) {

        console.log(error);

    } finally {

        loading.value = false;
    }
};

</script>