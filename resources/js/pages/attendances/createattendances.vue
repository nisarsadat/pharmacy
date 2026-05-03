<template>
    <v-container class="form-wrapper">
        <!-- Header -->
        <v-card-title class="px-6 py-3 d-flex justify-space-between">
            <h2>ساختن حاضری</h2>
        </v-card-title>

        <!-- Form -->
        <v-card-text>
            <v-form ref="formRef" validate-on="submit">
                <v-row dense>
                    <v-col cols="6">
                        <v-select
                            v-model="formData.employee_id"
                            :items="PeopleRepository.employeesdropdown"
                            label="مشتری"
                            item-title="label"
                            item-value="value"
                            :rules="[rules.required]"
                            variant="outlined"
                            density="compact"
                        />
                    </v-col>
                    <v-col cols="6">
                        <v-text-field
                            v-model="formData.date"
                            label="تاریخ"
                            type="date"
                            variant="outlined"
                            density="compact"
                        />
                    </v-col>
                    <v-col cols="6">
                        <v-select
                            v-model="formData.status"
                            :items="StatusDropDownItems"
                            label="وضعیت"
                            :rules="[rules.required]"
                            variant="outlined"
                            density="compact"
                        />
                    </v-col>
                    <v-col cols="6">
                        <v-text-field
                            :model-value="formData.check_in"
                            label="Check In"
                            prepend-icon="mdi-clock-time-four-outline"
                            readonly
                            variant="outlined"
                            density="compact"
                        >
                            <v-menu
                                v-model="showMenuCheckIn"
                                :close-on-content-click="false"
                                activator="parent"
                                min-width="0"
                            >
                                <v-time-picker v-model="formData.check_in"></v-time-picker>
                            </v-menu>
                        </v-text-field>
                    </v-col>
                    <v-col cols="6">
                        <v-text-field
                            :model-value="formData.check_out"
                            label="Check Out"
                            prepend-icon="mdi-clock-time-four-outline"
                            readonly
                            variant="outlined"
                            density="compact"
                        >
                            <v-menu
                                v-model="showMenuCheckOut"
                                :close-on-content-click="false"
                                activator="parent"
                                min-width="0"
                            >
                                <v-time-picker v-model="formData.check_out"></v-time-picker>
                            </v-menu>
                        </v-text-field>
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
            <v-btn color="black" variant="tonal" @click="createattendances">
                ثبت کردن
            </v-btn>
        </v-card-actions>
    </v-container>
</template>

<script setup>
import { reactive, ref, onMounted, watch } from "vue";
import { usePeopleRepository } from "../../repositories/PeopleRepository";
let PeopleRepository = usePeopleRepository();
import { useRouter } from "vue-router";
const time = ref(null);
const showMenuCheckIn = ref(false);
const showMenuCheckOut = ref(false);
const router = useRouter();
const formRef = ref(null);
const StatusDropDownItems = ["present", "absent", "leave"];
const formData = reactive({
    employee_id: "",
    date: "",
    status: "",
    check_in: null,
    check_out: null,
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
        if (newattendances && !Array.isArray(newattendances)) {
            // Add !Array check
            Object.assign(formData, newattendances);
        }
    },
    { immediate: true, deep: true }, // Add deep: true
);

const createattendances = async () => {
    const { valid } = await formRef.value.validate();

    if (!valid) return;

    try {
        await PeopleRepository.createattendances(formData);
        router.push("/attendances");
    } catch (error) {
        console.error(error);
    }
};

PeopleRepository.fetchemployeesfordropdown();
// PeopleRepository.fetchProductTypesForDropDowns();
</script>
