<template>
    <v-dialog
        transition="dialog-top-transition"
        v-model="WareHouseRepository.updateDialog"
        width="600px"
        class="form-wrapper"
    >
        <template v-slot:default="{ isActive }">
            <v-card class="w-full">
                <v-card-title class="px-6 py-1 d-flex justify-space-between">
                    <h2>تغیر کردن گدام</h2>
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
                                    v-model="formData.owner_name"
                                    label="صاحب حساب "
                                    item-title="label"
                                    item-value="value"
                                    :rules="[rules.required]"
                                    variant="outlined"
                                    density="compact"
                                />
                            </v-col>
                            <v-col cols="6">
                                <v-text-field
                                    v-model="formData.owner_phone"
                                    label=" شماره صاحب"
                                    item-title="label"
                                    item-value="value"
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
                    <v-btn color="light-blue-darken-1" @click="updatewarehouse"
                        >ثبت کردن
                    </v-btn>
                </v-card-actions>
            </v-card>
        </template>
    </v-dialog>
</template>

<script setup>
import { reactive, ref , watch} from "vue";
import { useWareHouseRepository } from "../../repositories/WareHouseRepository";

let WareHouseRepository = useWareHouseRepository();
const formRef = ref(null);

const formData = reactive({
   name: "",
   owner_phone: "",
   owner_name: "",
   note: "",
});

watch(
    () => WareHouseRepository.warehouse,
    (newWareHouseRepository) => {
        if (newWareHouseRepository) {
            Object.assign(formData, newWareHouseRepository);
        }
    },
    { immediate: true },
);
// Example account types, you can modify this

const rules = {
    required: (value) => !!value || "Required.",
};

const updatewarehouse = async () => {
    const isValid = formRef.value.validate();
    if (isValid) {
        WareHouseRepository.updatewarehouse(formData.id, formData);
    }
};
</script>
