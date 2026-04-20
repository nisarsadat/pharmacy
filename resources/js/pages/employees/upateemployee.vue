<template>
    <v-container class="form-wrapper">
        <v-card class="w-full mx-auto" max-width="800">
            <!-- Header -->
            <v-card-title class="px-6 py-3 d-flex justify-space-between">
                <h2>تغیر  کارمند</h2>
            </v-card-title>

            <!-- Form -->
            <v-card-text>
                <v-form ref="formRef">
                    <v-row dense>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.name"
                                label="اسم"
                                variant="outlined"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.last_name"
                                label="تخلص"
                                variant="outlined"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.father_name"
                                label="ولد"
                                variant="outlined"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.tazkira_number"
                                label="شماره تذکره"
                                variant="outlined"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>
                        <v-col cols="6">
                            <v-file-input
                                v-model="formData.image"
                                label="عکس "
                                type="image"
                                density="compact"
                            />
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.phone_number"
                                label="شماره تماس"
                                variant="outlined"
                                type="number"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.whatsapp_number"
                                label="شماره واتساپ"
                                variant="outlined"
                                type="number"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>
                        <v-col cols="6">
                            <v-select
                                v-model="formData.gender"
                                :items="gendertypes"
                                label=" جنسیت"
                                variant="outlined"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.shift_from"
                                label="شفت از "
                                variant="outlined"
                                type="time"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.shift_to"
                                label="شفت تا  "
                                variant="outlined"
                                type="time"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.salary_amount"
                                label=" مقدر معاش"
                                type="number"
                                variant="outlined"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.salary_amount_per_day"
                                label=" مقدار معاش روزانه "
                                type="number"
                                variant="outlined"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.job_type"
                                label=" نویعت وظیفه   "
                                variant="outlined"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.entry_date"
                                label=" تاریخ ورودی  "
                                variant="outlined"
                                type="date"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.leave_date"
                                label=" تاریخ خروجی   "
                                type="date"
                                variant="outlined"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.work_days"
                                label="  روز های کاری    "
                                type="number"
                                variant="outlined"
                                density="compact"
                                :rules="[rules.required]"
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
                <v-btn color="light-blue-darken-1" @click="updateemployee">
                    ثبت کردن
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-container>
</template>

<script setup>
import { reactive, ref, onMounted , watch } from "vue";
import { useWareHouseRepository } from "../../repositories/WareHouseRepository";
let WareHouseRepository = useWareHouseRepository();
import { useRouter } from "vue-router";

const router = useRouter();
const formRef = ref(null);

const formData = reactive({
    name: "",
    father_name: "",
    image: "",
    last_name: "",
    tazkira_number: "",
    phone_number: "",
    whatsapp_number: "",
    gender: "",
    shift_from: "",
    shift_to: "",
    salary_amount: "",
    salary_amount_per_day: "",
    job_type: "",
    entry_date: "",
    leave_date: "",
    work_days: "",
});

// Example account types, you can modify this
const gendertypes = ["male", "female"];

watch(
    () => WareHouseRepository.employees,
    (newemployees) => {
        if (newemployees && !Array.isArray(newemployees)) {  // Add !Array check
            Object.assign(formData, newemployees);
        }
    },
    { immediate: true, deep: true }  // Add deep: true
);

const rules = {
    required: (value) => !!value || "Required.",
};

const updateemployee = async () => {  // Make async
    const { valid } = await formRef.value?.validate();  // Async + safe ref
    if (valid) {
        await WareHouseRepository.updateemployee(formData);  // Await
        router.push("/employees");
    }
};
// WareHouseRepository.fetchwarehouseForDropDowns();
// WareHouseRepository.fetchProductTypesForDropDowns();
</script>
