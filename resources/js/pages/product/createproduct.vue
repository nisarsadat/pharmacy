<template>
    <v-container class="form-wrapper">
        <v-card class="w-full mx-auto" max-width="800">
            <!-- Header -->
            <v-card-title class="px-6 py-3 d-flex justify-space-between">
                <h2>ساختن محصول</h2>
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
                            <v-autocomplete
                                v-model="formData.product_type_id"
                                label="نوعیت محصول"
                                :items="
                                    WareHouseRepository.ProductTypesForDropDown
                                "
                                item-title="label"
                                item-value="value"
                                clearable
                                variant="outlined"
                                density="compact"
                            />
                        </v-col>

                        <v-col cols="6">
                            <v-autocomplete
                                v-model="formData.warehouse_id"
                                label="گدام"
                                :items="
                                    WareHouseRepository.warehouseForDropDown
                                "
                                item-title="label"
                                item-value="value"
                                clearable
                                variant="outlined"
                                density="compact"
                            />
                        </v-col>

                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.code"
                                label="کود نمبر"
                                type="number"
                                variant="outlined"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>

                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.main_price"
                                label="قيمت اصلي"
                                type="number"
                                variant="outlined"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.sale_price"
                                label="قيمت فروش"
                                type="number"
                                variant="outlined"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>

                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.main_stock_alert"
                                label="هوشدار موجودی"
                                type="number"
                                variant="outlined"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>

                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.expire_date_alert"
                                label="هوشدار تاریخ انقضا"
                                type="date"
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
                                :rules="[rules.required]"
                            />
                        </v-col>

                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.product_amount_carton"
                                label="مقدار در کارتن"
                                type="number"
                                variant="outlined"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>

                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.product_amount"
                                label="مقدار محصول"
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
                <v-btn color="light-blue-darken-1" @click="createproducts">
                    ثبت کردن
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-container>
</template>

<script setup>
import { reactive, ref, onMounted } from "vue";
import { useWareHouseRepository } from "../../repositories/WareHouseRepository";
let WareHouseRepository = useWareHouseRepository();
import { useRouter } from "vue-router";

const router = useRouter();
const formRef = ref(null);

const formData = reactive({
    warehouse_id: "",
    product_type_id: "",
    code: "",
    name: "",
    main_price: "",
    sale_price: "",
    main_stock_alert: "",
    expire_date_alert: "",
    date: "",
    product_amount_carton: "",
    product_amount: "",
    note: " ",
});

// Example account types, you can modify this

const rules = {
    required: (value) => !!value || "Required.",
};

const createproducts = async () => {
    const isValid = formRef.value.validate();
    if (isValid) {
        WareHouseRepository.createproducts(formData);

            router.push("/products");
        
    }
};
WareHouseRepository.fetchwarehouseForDropDowns();
WareHouseRepository.fetchProductTypesForDropDowns();
</script>
