<template>
    <v-container class="form-wrapper">
        <v-card class="mx-auto">
            <!-- Header -->
            <v-card-title class="px-6 py-3 d-flex justify-space-between">
                <h2>ایجاد فروشات</h2>
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

                                <div class="mt-2 d-flex justify-end">
                                    <v-btn
                                        color="primary"
                                        variant="flat"
                                        @click="openCreateAccount"
                                    >
                                        <v-icon start>mdi-plus</v-icon>
                                        ایجاد حساب جدید
                                    </v-btn>
                                </div>
                            </v-col>
                        </v-col>

                        <v-col cols="6">
                            <v-select
                                v-model="formData.warehouse_id"
                                :items="WareHouseRepository.warehouseForDropDown"
                                label="گدام"
                                item-title="label"
                                item-value="value"
                                :rules="[rules.required]"
                                variant="outlined"
                                density="compact"
                            />
                        </v-col>

                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.total_amount"
                                label="مقدار مجموعی"
                                variant="outlined"
                                type="number"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>

                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.discount"
                                label="تخفیف"
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

                        <v-col cols="12">
                            <v-card class="pa-4" elevation="1">
                                <h3 class="mb-4">بخش فروشات</h3>

                                <v-row
                                    v-for="(item, index) in formData.items"
                                    :key="index"
                                    class="mb-2"
                                >
                                    <v-col cols="3">
                                        <v-select
                                            v-model="item.product_id"
                                            :items="WareHouseRepository.ProductForDropDown"
                                            label="محصول"
                                            item-title="label"
                                            :rules="[rules.required]"
                                            item-value="value"
                                            variant="outlined"
                                            density="compact"
                                        />
                                    </v-col>

                                    <v-col cols="3">
                                        <v-text-field
                                            v-model="item.quantity"
                                            label="تعداد"
                                            type="number"
                                            variant="outlined"
                                            density="compact"
                                        />
                                    </v-col>

                                    <v-col cols="3">
                                        <v-text-field
                                            v-model="item.price"
                                            label="قیمت"
                                            type="number"
                                            variant="outlined"
                                            density="compact"
                                        />
                                    </v-col>

                                    <v-col cols="2">
                                        <v-text-field
                                            v-model="item.total"
                                            label="مجموع"
                                            type="number"
                                            variant="outlined"
                                            density="compact"
                                            readonly
                                        />
                                    </v-col>

                                    <v-col cols="1" class="d-flex align-center">
                                        <v-btn
                                            icon
                                            color="red"
                                            variant="text"
                                            @click="removeItem(index)"
                                        >
                                            <v-icon>mdi-delete</v-icon>
                                        </v-btn>
                                    </v-col>
                                </v-row>

                                <v-btn
                                    color="primary"
                                    variant="flat"
                                    @click="addItem"
                                >
                                    افزودن بخش
                                </v-btn>
                            </v-card>
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

            <v-card-actions class="px-6 pb-6">
                <v-btn color="light-blue-darken-1" @click="createsales">
                    ثبت کردن
                </v-btn>
            </v-card-actions>
        </v-card>

        <CreateAccount />
    </v-container>
</template>

<script setup>
import { reactive, ref, watch } from "vue";
import { useWareHouseRepository } from "../../repositories/WareHouseRepository";
import { useRouter } from "vue-router";
import { useAccountRepository } from "../../repositories/AccountRepository";
import CreateAccount from "../accounts/CreateAccount.vue";

const WareHouseRepository = useWareHouseRepository();
const AccountRepository = useAccountRepository();
const router = useRouter();
const formRef = ref(null);

// ✅ MUST be defined BEFORE watch (fix crash)
const formData = reactive({
    note: "",
    date: "",
    customer_id: "",
    account_id: "",
    warehouse_id: "",
    total_amount: "",
    discount: "",
    final_amount: "",
    paid_amount: "",
    due_amount: "",
    items: [
        {
            product_id: "",
            quantity: "",
            price: "",
            total: "",
        },
    ],
});

// ✅ safe watch (same logic, no change)
watch(
    () => formData.items,
    (items) => {
        items.forEach((item) => {
            const qty = Number(item.quantity) || 0;
            const price = Number(item.price) || 0;
            item.total = qty * price;
        });
    },
    { deep: true }
);

const openCreateAccount = () => {
    AccountRepository.createDialog = true;
};

const rules = {
    required: (value) => !!value || "Required.",
};

const addItem = () => {
    formData.items.push({
        product_id: "",
        quantity: "",
        price: "",
        total: "",
    });
};

const removeItem = (index) => {
    formData.items.splice(index, 1);
};

const createsales = async () => {
    const isValid = await formRef.value.validate();

    if (isValid) {
        await WareHouseRepository.createsales(formData);
        router.push("/sales");
    }
};

// dropdown loads
WareHouseRepository.fetchaccountForDropDowns();
WareHouseRepository.fetchcustomerForDropDowns();
WareHouseRepository.fetchwarehouseForDropDowns();
WareHouseRepository.fetchproductForDropDowns();
</script>