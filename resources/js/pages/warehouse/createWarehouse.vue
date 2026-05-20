<template>
    <v-dialog
        transition="dialog-top-transition"
        v-model="WareHouseRepository.createDialog"
        width="600px"
        class="form-wrapper"
    >
        <template v-slot:default="{ isActive }">
            <v-card class="w-full">
                <v-card-title class="px-6 py-1 d-flex justify-space-between">
                    <h2>ساختن گدام</h2>
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
                                    label="اسم"
                                    :rules="[rules.required]"
                                />
                            </v-col>
                            <v-text-field
                                v-model="formData.owner_name"
                                variant="outlined"
                                density="compact"
                                label="اسم صاحب"
                                :rules="[rules.required]"
                            />
                        </v-row>

                        <v-text-field
                            v-model="formData.owner_phone"
                            type="tel"
                            :counter="10"
                            maxlength="10"
                            variant="outlined"
                            density="compact"
                            label="شماره صاحب"
                            :rules="[rules.required, rules.phone]"
                        />
                        <v-textarea
                            v-model="formData.note"
                            variant="outlined"
                            density="compact"
                            label="نوت"
                        ></v-textarea>
                    </v-form>
                </v-card-text>
                <v-card-actions class="px-6 pb-6">
                    <v-btn color="light-blue-darken-1" @click="createwarehose"
                        >ثبت کردن
                    </v-btn>
                </v-card-actions>
            </v-card>
        </template>
    </v-dialog>
</template>

<script setup>
import { reactive, ref } from "vue";
import { useWareHouseRepository } from "../../repositories/WareHouseRepository";
let WareHouseRepository = useWareHouseRepository();
const formRef = ref(null);

const formData = reactive({
    name: "",
    owner_name: "",
    owner_phone: "",
    note: "",
});

// Example account types, you can modify this

const rules = {
    required: (value) => !!value || "Required.",

    // ✅ this is for phone validation
    phone: (v) => (v && /^[0-9]{10}$/.test(v)) || "شماره تماس باید 10 عدد باشد",
};

const createwarehose = async () => {
    const isValid = formRef.value.validate();
    if (isValid) {
        WareHouseRepository.createwarehouse(formData);
    }
};
</script>
