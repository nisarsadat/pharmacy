<template>
    <v-dialog
        transition="dialog-top-transition"
        v-model="AccountRepository.createDialog"
        width="800px"
        class="form-wrapper"
    >
        <template v-slot:default="{ isActive }">
            <v-card class="px-3 w-full">
                <v-card-title class="px-6 py-4 d-flex justify-space-between">
                    <h2>Create Account</h2>
                    <v-btn
                        variant="text"
                        @click="isActive.value = false"
                        color="red"
                    >
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-form ref="formRef">
                        <v-text-field
                            v-model="formData.name"
                            variant="outlined"
                            density="compact"
                            label="Name*"
                            :rules="[rules.required]"
                            class="pb-4"
                            fullWidth
                        ></v-text-field>

                        <v-text-field
                            v-model="formData.price"
                            variant="outlined"
                            density="compact"
                            label="Price*"
                            :rules="[rules.required]"
                            class="pb-4"
                        ></v-text-field>

                        <v-text-field
                            v-model="formData.date"
                            variant="outlined"
                            density="compact"
                            label="Date*"
                            type="date"
                            :rules="[rules.required]"
                            class="pb-4"
                        ></v-text-field>

                        <v-textarea
                            v-model="formData.note"
                            variant="outlined"
                            density="compact"
                            label="Note"
                            class="pb-4"
                        ></v-textarea>

                        <v-autocomplete
                            v-model="formData.account_type"
                            :items="accountTypes"
                            label="Account Type*"
                            :rules="[rules.required]"
                            variant="outlined"
                            density="compact"
                        ></v-autocomplete>
                    </v-form>
                </v-card-text>
                <div class="justify-start pl-6 pb-6">
                    <v-btn color="light-blue-darken-1" @click="createAccount">
                        Submit
                    </v-btn>
                </div>
            </v-card>
        </template>
    </v-dialog>
</template>

<script setup>
import { reactive, ref } from "vue";
import { useAccountRepository } from "../../repositories/AccountRepository";

let AccountRepository = useAccountRepository();
const formRef = ref(null);

const formData = reactive({
    name: "",
    price: "",
    date: "",
    note: "",
    account_type: "",
});

// Example account types, you can modify this
const accountTypes = ["Bank", "Cash", "Digital Wallet"];

const rules = {
    required: (value) => !!value || "Required.",
};

const createAccount = async () => {
    const isValid = formRef.value.validate();
    if (isValid) {
        AccountRepository.createAccount(formData);
    }
};
</script>