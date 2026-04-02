<template>
    <v-dialog
        v-model="AccountRepository.updateDialog"
        width="600"
        transition="dialog-top-transition"
        class="form-wrapper"
    >
        <v-card class="w-full">
            <!-- Card Header -->
            <v-card-title
                class="d-flex justify-space-between align-center px-6 py-4"
            >
                <span class="text-h6">ویرایش حساب </span>
                <v-btn
                    size="x-small"
                    color="red"
                    variant="text"
                    @click="AccountRepository.updateDialog = false"
                >
                    <v-icon size="x-small">mdi-close</v-icon>
                </v-btn>
            </v-card-title>

            <v-divider />

            <!-- Card Form -->
            <v-card-text>
                <v-form ref="formRef">
                    <v-row dense>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.name"
                                label="اسم*"
                                variant="outlined"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.price"
                                label="قیمت *"
                                variant="outlined"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>
                    </v-row>
                    <v-row dense>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.date"
                                label="تاریخ*"
                                type="date"
                                variant="outlined"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>
                        <v-col cols="6">
                            <v-select
                                v-model="formData.account_type"
                                :items="accountTypes"
                                label="نوعیت اکونت *"
                                variant="outlined"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>
                    </v-row>
                    <v-textarea
                        v-model="formData.note"
                        label="نکته "
                        variant="outlined"
                        density="compact"
                    />
                </v-form>
            </v-card-text>

            <!-- Card Actions -->
            <v-card-actions class="px-6 pb-6">
                <v-btn color="light-blue-darken-1" @click="updateAccount"
                    >ثبت کردن
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { reactive, ref, watch } from "vue";
import { useAccountRepository } from "../../repositories/AccountRepository";

const AccountRepository = useAccountRepository();
const formRef = ref(null);

const formData = reactive({
    id: "",
    name: "",
    price: "",
    date: "",
    note: "",
    account_type: "",
});

watch(
    () => AccountRepository.account,
    (newAccount) => {
        if (newAccount) {
            Object.assign(formData, newAccount);
        }
    },
    { immediate: true },
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
