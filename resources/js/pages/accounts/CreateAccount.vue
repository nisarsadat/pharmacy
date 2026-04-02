<template>
    <v-dialog
        transition="dialog-top-transition"
        v-model="AccountRepository.createDialog"
        width="600px"
        class="form-wrapper"
    >
        <template v-slot:default="{ isActive }">
            <v-card class="w-full">
                <v-card-title class="px-6 py-1 d-flex justify-space-between">
                    <h2>ساختن حساب</h2>
                    <v-btn
                        variant="text"
                        @click="isActive.value = false"
                        color="red"
                    >
                        <v-icon size="x-small">mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <v-form ref="formRef">
                        <v-row class="" dense>
                            <v-col cols="6">
                                <v-text-field
                                    v-model="formData.name"
                                    variant="outlined"
                                    density="compact"
                                    label="نام*"
                                    :rules="[rules.required]"
                                />
                            </v-col>

                            <v-col cols="6">
                                <v-text-field
                                    v-model="formData.price"
                                    variant="outlined"
                                    density="compact"
                                    label="مقدار*"
                                    type="number"
                                    :rules="[rules.required]"
                                />
                            </v-col>
                        </v-row>

                        <v-row dense>
                            <v-col cols="6">
                                <v-text-field
                                    v-model="formData.date"
                                    variant="outlined"
                                    density="compact"
                                    label="تاریخ"
                                    type="date"
                                    :rules="[rules.required]"
                                />
                            </v-col>

                            <v-col cols="6">
                                <v-select
                                    v-model="formData.account_type"
                                    :items="accountTypes"
                                    label="نوعیت حساب"
                                    :rules="[rules.required]"
                                    variant="outlined"
                                    density="compact"
                                />
                            </v-col>
                        </v-row>
                        <v-textarea
                            v-model="formData.note"
                            variant="outlined"
                            density="compact"
                            label="نوت"
                        ></v-textarea>
                    </v-form>
                </v-card-text>
                <v-card-actions class="px-6 pb-6">
                    <v-btn color="light-blue-darken-1" @click="createAccount"
                        >ثبت کردن
                    </v-btn>
                </v-card-actions>
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
const accountTypes = ["Bank", "Cash", "Digital Wallet", "khan", "jan"];

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
