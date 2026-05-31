<template>

    <v-dialog
        :model-value="modelValue"
        max-width="400"
        @update:modelValue="$emit('update:modelValue', $event)"
    >

        <v-card>

            <v-card-title>
                Delete User
            </v-card-title>

            <v-card-text>

                Are you sure you want to delete:

                <strong>
                    {{ user?.name }}
                </strong>

                ?

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
                    color="error"
                    :loading="loading"
                    @click="submit"
                >
                    Delete
                </v-btn>

            </v-card-actions>

        </v-card>

    </v-dialog>

</template>

<script setup>

import { ref } from "vue";

import { toast } from "vue3-toastify";

import usersRepository from "@/repositories/usersRepository";

defineProps({
    modelValue: Boolean,
    user: Object,
});

const emit = defineEmits([
    "update:modelValue",
    "deleted",
]);

const loading = ref(false);

// ===================================
// CLOSE
// ===================================

const closeDialog = () => {

    emit("update:modelValue", false);
};

// ===================================
// DELETE
// ===================================

const submit = async () => {

    try {

        loading.value = true;

        await usersRepository.deleteUser(
            props.user.id
        );

        toast.success("User deleted");

        emit("deleted");

        closeDialog();

    } catch (error) {

        console.log(error);

    } finally {

        loading.value = false;
    }
};

</script>