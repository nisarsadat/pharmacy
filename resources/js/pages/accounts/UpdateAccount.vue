<template>
    <v-dialog
        transition="dialog-top-transition"
        v-model="AccountRepository.updateDialog"
        width="800px"
        class="form-wrapper"
    >
        <template v-slot:default="{ isActive }">
            <v-card class="px-3 w-full">
                <v-card-title class="px-6 py-4 d-flex justify-space-between">
                    <h2>Update Account</h2>
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
                    <v-btn color="light-blue-darken-1" @click="updateAccount">
                        Submit
                    </v-btn>
                </div>
            </v-card>
        </template>
    </v-dialog>
</template>

<script setup>
import { reactive, ref, watch } from "vue";
import { useAccountRepository } from "../../repositories/AccountRepository";

let AccountRepository = useAccountRepository();
const formRef = ref(null);

// Initialize reactive form with account data
const formData = reactive({
    id: "",
    name: "",
    price: "",
    date: "",
    note: "",
    account_type: "",
});

// Update formData whenever AccountRepository.account changes
watch(
    () => AccountRepository.account,
    (newAccount) => {
        if (newAccount) {
            formData.id = newAccount.id;
            formData.name = newAccount.name;
            formData.price = newAccount.price;
            formData.date = newAccount.date;
            formData.note = newAccount.note;
            formData.account_type = newAccount.account_type;
        }
    },
    { immediate: true }
);

const accountTypes = ["Bank", "Cash", "Digital Wallet"];

const rules = {
    required: (value) => !!value || "Required.",
};

const updateAccount = async () => {
    formRef.value.validate().then((valid) => {
        if (valid) {
            AccountRepository.updateAccount(formData.id, formData);
        }
    });
};
</script>