<template>
    <v-container class="form-wrapper">
        <!-- Header -->
        <v-card-title class="px-6 py-3 d-flex justify-space-between">
            <h2>ساختن کارمند</h2>
        </v-card-title>

        <!-- Form -->
        <v-card-text>
            <v-form ref="formRef">
                <v-row>
                    <v-col cols="12">
                        <div class="image-upload-wrapper">
                            <!-- Hidden file input -->
                            <input
                                ref="fileInput"
                                type="file"
                                accept="image/*"
                                style="display: none"
                                @change="onImageChange"
                            />

                            <!-- Click area -->
                            <div class="image-box" @click="triggerFile">
                                <v-img
                                    v-if="imagePreview"
                                    :src="imagePreview"
                                    height="160"
                                    width="100%"
                                    cover
                                    class="rounded-lg"
                                />

                                <div v-else class="placeholder">
                                    <v-icon size="40">mdi-image-plus</v-icon>
                                    <p>Click to upload image</p>
                                </div>
                            </div>
                        </div>
                    </v-col>
                </v-row>
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
                        <v-text-field
                            v-model="formData.phone_number"
                            type="tel"
                            :counter="10"
                            maxlength="10"
                            label="شماره تماس  "
                            variant="outlined"
                            density="compact"
                            :rules="[rules.required, rules.phone]"
                        />
                    </v-col>
                    <v-col cols="6">
                        <v-text-field
                            v-model="formData.whatsapp_number"
                            type="tel"
                            :counter="10"
                            maxlength="10"
                            label="شماره واتساپ  "
                            variant="outlined"
                            density="compact"
                            :rules="[rules.required, rules.phone]"
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
            <v-btn color="light-blue-darken-1" @click="create">
                ثبت کردن
            </v-btn>
        </v-card-actions>
    </v-container>
</template>

<script setup>
import { reactive, ref, onMounted, watch } from "vue";
import { useWareHouseRepository } from "../../repositories/WareHouseRepository";
let WareHouseRepository = useWareHouseRepository();
import { useRouter } from "vue-router";

const router = useRouter();
const formRef = ref(null);
const image = ref([]);
const fileInput = ref(null);
const imagePreview = ref(null);
const triggerFile = () => {
    fileInput.value.click();
};

const onImageChange = (event) => {
    const file = event.target.files[0];

    if (file) {
        image.value = [file]; // keep your existing logic for FormData

        // preview image
        imagePreview.value = URL.createObjectURL(file);
    }
};
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

const rules = {
    required: (value) => !!value || "Required.",
    // ✅ this is for phone validation
    phone: (v) => (v && /^[0-9]{10}$/.test(v)) || "شماره تماس باید 10 عدد باشد",
};

watch(
    () => WareHouseRepository.employees,
    (newemployees) => {
        if (newemployees && !Array.isArray(newemployees)) {
            // Add !Array check
            Object.assign(formData, newemployees);
        }
    },
    { immediate: true, deep: true }, // Add deep: true
);

const create = async () => {
    const { valid } = await formRef.value.validate();

    if (valid) {
        const data = new FormData();

        data.append("name", formData.name);
        data.append("father_name", formData.father_name);
        data.append("last_name", formData.last_name);
        data.append("tazkira_number", formData.tazkira_number);
        data.append("phone_number", formData.phone_number);
        data.append("whatsapp_number", formData.whatsapp_number);
        data.append("phone_number", formData.phone_number);
        data.append("shift_from", formData.shift_from);
        data.append("shift_to", formData.shift_to);
        data.append("gender", formData.gender);
        data.append("salary_amount", formData.salary_amount);
        data.append("salary_amount_per_day", formData.salary_amount_per_day);
        data.append("job_type", formData.job_type);
        data.append("entry_date", formData.entry_date);
        data.append("leave_date", formData.leave_date);
        data.append("work_days", formData.work_days);

        // ✅ image handling
        if (image.value.length > 0) {
            data.append("image", image.value[0]);
        }

        await WareHouseRepository.createemployees(data);

        router.push("/employees");
    }
};
// WareHouseRepository.fetchwarehouseForDropDowns();
// WareHouseRepository.fetchProductTypesForDropDowns();
</script>
<style scoped>
.custom-image-input {
    border: 2px dashed #90caf9;
    border-radius: 12px;
    padding: 10px;
    background: #f5faff;
    transition: all 0.3s ease;
}

.custom-image-input:hover {
    border-color: #1e88e5;
    background: #e3f2fd;
}

.custom-image-input .v-field {
    background: transparent;
}

.custom-image-input .v-chip {
    background: #1e88e5 !important;
    color: white !important;
}
.image-upload-wrapper {
    cursor: pointer;
}

.image-box {
    border: 2px dashed #90caf9;
    border-radius: 12px;
    height: 160px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f5faff;
    transition: 0.3s;
}

.image-box:hover {
    border-color: #1e88e5;
    background: #e3f2fd;
}

.placeholder {
    text-align: center;
    color: #1e88e5;
}
</style>
