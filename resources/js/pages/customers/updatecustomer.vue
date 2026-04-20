<template>
    <v-container class="form-wrapper">
        <v-card class="w-full mx-auto" max-width="800">
            <!-- Header -->
            <v-card-title class="px-6 py-3 d-flex justify-space-between">
                <h2>تغیر مشتری</h2>
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
                            />
                        </v-col>

                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.father_name"
                                label="ولد "
                                variant="outlined"
                                density="compact"
                            />
                        </v-col>

                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.phone_number"
                                label="شماره تماس  "
                                type="number"
                                variant="outlined"
                                density="compact"
                            />
                        </v-col>

                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.tazkira_number"
                                label="شماره تذکره  "
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
                <v-btn color="light-blue-darken-1" @click="updatecustomers">
                    ثبت کردن
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-container>
</template>

<script setup>
import { reactive, ref, onMounted  , watch} from "vue";
import { useWareHouseRepository } from "../../repositories/WareHouseRepository";
let WareHouseRepository = useWareHouseRepository();
import { useRouter , useRoute } from "vue-router";

const route = useRoute();
const router = useRouter();
const formRef = ref(null);

const formData = reactive({
    id: "",
    name: "",
    last_name: "",
    father_name: "",
    phone_number: "",
    tazkira_number: "",
    image: "",
    note: "",
});

// Example account types, you can modify this

watch(
    () => WareHouseRepository.customer,
    (newcustomers) => {
        if (newcustomers) {
            Object.assign(formData, newcustomers);
        }
    },
    { immediate: true },
);

const rules = {
    required: (value) => !!value || "Required.",
};

const updatecustomers = async () => {
    const isValid = formRef.value.validate();
    if (isValid) {
        WareHouseRepository.updatecustomer(formData.id , formData);

        router.push("/customers");
    }
};
// WareHouseRepository.fetchwarehouseForDropDowns();
// WareHouseRepository.fetchProductTypesForDropDowns();
onMounted(() => {
    WareHouseRepository.fetchcustomer(route.params.id);
});
</script>
