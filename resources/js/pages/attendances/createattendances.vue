<template>
    <v-container class="form-wrapper">
        <v-card class="w-full mx-auto" max-width="800">
            <!-- Header -->
            <v-card-title class="px-6 py-3 d-flex justify-space-between">
                <h2>ساختن حاضری </h2>
            </v-card-title>

            <!-- Form -->
            <v-card-text>
                <v-form ref="formRef">
                    <v-row dense>
                     
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
                <v-btn color="light-blue-darken-1" @click="createattendances">
                    ثبت کردن
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-container>
</template>

<script setup>
import { reactive, ref, onMounted, watch } from "vue";
import { usePeopleRepository } from "../../repositories/PeopleRepository";
let PeopleRepository = usePeopleRepository();
import { useRouter } from "vue-router";

const router = useRouter();
const formRef = ref(null);

const formData = reactive({
  employee_id: "",
  date: "",
  status: "",
  check_in: "",
  check_out: "",
  note: "",
 
});

// Example account types, you can modify this
const gendertypes = ["male", "female"];

const rules = {
    required: (value) => !!value || "Required.",
};
watch(
    () => PeopleRepository.attendances,
    (newattendances) => {
        if (newattendances && !Array.isArray(newattendances)) {  // Add !Array check
            Object.assign(formData, newattendances);
        }
    },
    { immediate: true, deep: true }  // Add deep: true
);

const createattendances = async () => {
    const isValid = formRef.value.validate();
    if (isValid) {
        PeopleRepository.createattendance(formData);

        router.push("/attendances");
    }
};
// PeopleRepository.fetchwarehouseForDropDowns();
// PeopleRepository.fetchProductTypesForDropDowns();
</script>
