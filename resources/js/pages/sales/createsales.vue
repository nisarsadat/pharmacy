<template>
    <v-container class="form-wrapper">
        <v-card class="mx-auto">
            <!-- Header -->
            <v-card-title class="px-6 py-3 d-flex justify-space-between">
                <h2>ایجاد مشتری</h2>
            </v-card-title>

            <!-- Form -->
            <v-card-text>
                <v-form ref="formRef">
                    <v-row dense>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.date"
                                label="تاریخ"
                                variant="outlined"
                                type="date"
                                density="compact"
                                :rules="[rules.required]"
                            />

                            <v-select
                                v-model="formData.customer_id"
                                :items="WareHouseRepository.customerForDropDown"
                                label="مشتری "
                                item-title="label"
                                item-value="value"
                                variant="outlined"
                                :rules="[rules.required]"
                                density="compact"
                            />
                        </v-col>

                        <v-col cols="6">
                            <v-select
                                v-model="formData.account_id"
                                :items="WareHouseRepository.accountForDropDown"
                                label="حساب"
                                item-title="label"
                                item-value="value"
                                :rules="[rules.required]"
                                variant="outlined"
                                density="compact"
                            />

                            <!-- <v-col cols="6">
                            <v-text-field
                                v-model="formData.user_id"
                                label="   "
                                type="number"
                                variant="outlined"
                                density="compact"
                            />
                        </v-col> -->

                            <v-text-field
                                v-model="formData.total_amount"
                                label="مقدار مجموعی "
                                variant="outlined"
                                type="number"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.discount"
                                label="تخفیف "
                                variant="outlined"
                                type="number"
                                density="compact"
                            />

                            <v-text-field
                                v-model="formData.final_amount"
                                label="مقدار نهایی"
                                variant="outlined"
                                type="number"
                                density="compact"
                            />
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.paid_amount"
                                label="مقدار پرداختی"
                                variant="outlined"
                                type="number"
                                density="compact"
                            />

                            <v-text-field
                                v-model="formData.due_amount"
                                label="مقدار قرض"
                                variant="outlined"
                                type="number"
                                density="compact"
                            />
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.payment_status"
                                label=" وضعیت پرداخت"
                                variant="outlined"
                                type="number"
                                density="compact"
                            />
                        </v-col>
                    </v-row>

                    <v-textarea
                        v-model="formData.note"
                        label="نوت"
                        variant="outlined"
                        density="compact"
                    />
                </v-form>
            </v-card-text>

            <!-- Actions -->
            <v-card-actions class="px-6 pb-6">
                <v-btn color="light-blue-darken-1" @click="createsales">
                    ثبت کردن
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-container>
</template>

<script setup>
import { reactive, ref, onMounted } from "vue";
import { useWareHouseRepository } from "../../repositories/WareHouseRepository";
const WareHouseRepository = useWareHouseRepository();
import { useRouter } from "vue-router";

const router = useRouter();
const formRef = ref(null);

const formData = reactive({
    note: "",
    date: "",
    customer_id: "",
    account_id: "",
    user_id: "",
    total_amount: "",
    discount: "",
    final_amount: "",
    paid_amount: "",
    due_amount: "",
    payment_status: "",
    items: [],
});

// Example account types, you can modify this

const rules = {
    required: (value) => !!value || "Required.",
};

const createsales = async () => {
    const isValid = formRef.value.validate();
    if (isValid) {
        WareHouseRepository.createsales(formData);

        router.push("/sales");
    }
};
WareHouseRepository.fetchaccountForDropDowns();
WareHouseRepository.fetchcustomerForDropDowns();
</script>
