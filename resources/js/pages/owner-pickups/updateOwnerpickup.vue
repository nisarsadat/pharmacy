<template>
    <v-dialog
        transition="dialog-top-transition"
        v-model="AccountRepository.updateDialog"
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
                                <v-select
                                    v-model="formData.account_id"
                                    :items="
                                        AccountRepository.AccountForDropDown
                                    "
                                    label="حساب"
                                    item-title="label"
                                    item-value="value"
                                    :rules="[rules.required]"
                                    variant="outlined"
                                    density="compact"
                                />
                            </v-col>
                            <v-col cols="6">
                                <v-text-field
                                    v-model="formData.owener_name"
                                    variant="outlined"
                                    density="compact"
                                    label="نام مالک *"
                                    :rules="[rules.required]"
                                />
                            </v-col>
                        </v-row>

                        <v-row dense>
                            <v-col cols="6">
                                <v-text-field
                                    v-model="formData.owener_phone"
                                    variant="outlined"
                                    density="compact"
                                    label="شماره تماس مالک "
                                    type="number"
                                    :rules="[rules.required]"
                                />
                            </v-col>

                            <v-col cols="6">
                                <v-text-field
                                    v-model="formData.amount"
                                    :items="accountTypes"
                                    label="مقدار"
                                    type="number"
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
                    <v-btn color="light-blue-darken-1" @click="update"
                        >ثبت کردن
                    </v-btn>
                </v-card-actions>
            </v-card>
        </template>
    </v-dialog>
</template>

<script setup>
import { reactive, ref , watch   } from "vue";
import { useAccountRepository } from "../../repositories/AccountRepository";

let AccountRepository = useAccountRepository();
const formRef = ref(null);

const formData = reactive({
    id: "",
    account_id: "",
    owener_name: "",
    owener_phone: "",
    amount: "",
    note: "",
});
watch(
    () => AccountRepository.Ownerpickup,
    (newownerpickup) => {
        if (newownerpickup) {
            Object.assign(formData, newownerpickup);
        }
    },
    { immediate: true },
);
// Example account types, you can modify thi
const rules = {
    required: (value) => !!value || "Required.",
};

const update = async () => {
    const isValid = formRef.value.validate();
    if (isValid) {
        AccountRepository.updateOwnerpickup(formData.id , formData);
    }
};
</script>
