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
                    <h2>ساختن کتگوری مصارف</h2>
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

                            <v-text-field
                                v-model="formData.date"
                                variant="outlined"
                                density="compact"
                                label="تاریخ"
                                type="date"
                                :rules="[rules.required]"
                            />
                        </v-row>
                        <v-textarea
                            v-model="formData.details"
                            variant="outlined"
                            density="compact"
                            label="نوت"
                        ></v-textarea>
                    </v-form>
                </v-card-text>
                <v-card-actions class="px-6 pb-6">
                    <v-btn
                        color="light-blue-darken-1"
                        @click="createExpenseCategory"
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
    date: "",
    details: "",
});

// Example account types, you can modify this

const rules = {
    required: (value) => !!value || "Required.",
};

const createExpenseCategory = async () => {
    const isValid = formRef.value.validate();
    if (isValid) {
        AccountRepository.createExpenseCategory(formData);
    }
};
</script>
