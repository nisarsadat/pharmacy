<template>
    <v-container class="product-edit-page" fluid dir="rtl">
        <v-card class="product-card mx-auto" max-width="1000" elevation="0">
            <!-- Header -->
            <div class="header-section">
                <div>
                    <h2 class="text-h5 font-weight-bold mb-1">
                        ویرایش محصول
                    </h2>
                    <p class="text-body-2 text-medium-emphasis mb-0">
                        معلومات محصول را تغییر دهید و دوباره ثبت کنید.
                    </p>
                </div>

                <v-btn
                    color="grey-darken-1"
                    variant="tonal"
                    prepend-icon="mdi-arrow-left"
                    @click="router.push('/products')"
                >
                    برگشت
                </v-btn>
            </div>

            <v-divider />

            <!-- Loading -->
            <div v-if="pageLoading" class="loading-box">
                <v-progress-circular indeterminate color="primary" size="44" />
                <div class="mt-3 text-body-2 text-medium-emphasis">
                    در حال بارگذاری معلومات محصول...
                </div>
            </div>

            <!-- Form -->
            <v-card-text v-else class="pa-6">
                <v-form ref="formRef" @submit.prevent="updateProduct">
                    <v-row dense>
                        <!-- Main Info -->
                        <v-col cols="12">
                            <div class="section-title">
                                <v-icon size="20">mdi-package-variant</v-icon>
                                معلومات اصلی محصول
                            </div>
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="formData.name"
                                label="اسم محصول"
                                variant="outlined"
                                density="compact"
                                prepend-inner-icon="mdi-tag"
                                :rules="[rules.required]"
                            />
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="formData.code"
                                label="کود نمبر"
                                type="number"
                                variant="outlined"
                                density="compact"
                                prepend-inner-icon="mdi-barcode"
                                :rules="[rules.required]"
                            />
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-autocomplete
                                v-model="formData.product_type_id"
                                label="نوعیت محصول"
                                :items="WareHouseRepository.ProductTypesForDropDown"
                                item-title="label"
                                item-value="value"
                                clearable
                                variant="outlined"
                                density="compact"
                                prepend-inner-icon="mdi-shape"
                                :rules="[rules.required]"
                            />
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-autocomplete
                                v-model="formData.warehouse_id"
                                label="گدام"
                                :items="WareHouseRepository.warehouseForDropDown"
                                item-title="label"
                                item-value="value"
                                clearable
                                variant="outlined"
                                density="compact"
                                prepend-inner-icon="mdi-warehouse"
                                :rules="[rules.required]"
                            />
                        </v-col>

                        <!-- Prices -->
                        <v-col cols="12">
                            <div class="section-title mt-4">
                                <v-icon size="20">mdi-cash-multiple</v-icon>
                                قیمت و موجودی
                            </div>
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="formData.main_price"
                                label="قیمت اصلی"
                                type="number"
                                variant="outlined"
                                density="compact"
                                prepend-inner-icon="mdi-cash"
                                :rules="[rules.required, rules.positiveNumber]"
                            />
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="formData.sale_price"
                                label="قیمت فروش"
                                type="number"
                                variant="outlined"
                                density="compact"
                                prepend-inner-icon="mdi-sale"
                                :rules="[rules.required, rules.positiveNumber]"
                            />
                        </v-col>

                        <v-col cols="12" md="4">
                            <v-text-field
                                v-model="formData.main_stock_alert"
                                label="هوشدار موجودی"
                                type="number"
                                variant="outlined"
                                density="compact"
                                prepend-inner-icon="mdi-alert-circle"
                                :rules="[rules.required, rules.positiveNumber]"
                            />
                        </v-col>

                        <v-col cols="12" md="4">
                            <v-text-field
                                v-model="formData.product_amount_carton"
                                label="مقدار در کارتن"
                                type="number"
                                variant="outlined"
                                density="compact"
                                prepend-inner-icon="mdi-package"
                                :rules="[rules.required, rules.positiveNumber]"
                            />
                        </v-col>

                        <v-col cols="12" md="4">
                            <v-text-field
                                v-model="formData.product_amount"
                                label="مقدار محصول"
                                type="number"
                                variant="outlined"
                                density="compact"
                                prepend-inner-icon="mdi-counter"
                                :rules="[rules.required, rules.positiveNumber]"
                            />
                        </v-col>

                        <!-- Dates -->
                        <v-col cols="12">
                            <div class="section-title mt-4">
                                <v-icon size="20">mdi-calendar</v-icon>
                                تاریخ‌ها
                            </div>
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="formData.date"
                                label="تاریخ"
                                type="date"
                                variant="outlined"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="formData.expire_date_alert"
                                label="هوشدار تاریخ انقضا"
                                type="date"
                                variant="outlined"
                                density="compact"
                            />
                        </v-col>

                        <!-- Note -->
                        <v-col cols="12">
                            <div class="section-title mt-4">
                                <v-icon size="20">mdi-note-text</v-icon>
                                نوت
                            </div>
                        </v-col>

                        <v-col cols="12">
                            <v-textarea
                                v-model="formData.note"
                                label="نوت"
                                variant="outlined"
                                density="compact"
                                rows="3"
                                prepend-inner-icon="mdi-note"
                            />
                        </v-col>
                    </v-row>

                    <v-alert
                        v-if="serverError"
                        type="error"
                        variant="tonal"
                        class="mt-3"
                        density="compact"
                    >
                        {{ serverError }}
                    </v-alert>

                    <div class="actions">
                        <v-btn
                            color="grey"
                            variant="tonal"
                            :disabled="loading"
                            @click="router.push('/products')"
                        >
                            لغو
                        </v-btn>

                        <v-btn
                            color="primary"
                            type="submit"
                            :loading="loading"
                            prepend-icon="mdi-content-save-edit"
                        >
                            ثبت تغییرات
                        </v-btn>
                    </div>
                </v-form>
            </v-card-text>
        </v-card>

        <v-snackbar
            v-model="snackbar.show"
            :color="snackbar.color"
            timeout="2500"
            location="top"
        >
            {{ snackbar.text }}
        </v-snackbar>
    </v-container>
</template>

<script setup>
import { reactive, ref, onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useWareHouseRepository } from "../../repositories/WareHouseRepository";

const router = useRouter();
const route = useRoute();
const WareHouseRepository = useWareHouseRepository();

const formRef = ref(null);
const loading = ref(false);
const pageLoading = ref(true);
const serverError = ref("");

const snackbar = reactive({
    show: false,
    text: "",
    color: "success",
});

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
    note: "",
});

const rules = {
    required: (value) => !!value || "این فیلد ضروری است.",
    positiveNumber: (value) => {
        if (value === "" || value === null || value === undefined) {
            return true;
        }

        return Number(value) >= 0 || "عدد باید منفی نباشد.";
    },
};

const showMessage = (text, color = "success") => {
    snackbar.text = text;
    snackbar.color = color;
    snackbar.show = true;
};

const fillForm = (product) => {
    formData.warehouse_id = product?.warehouse_id ?? "";
    formData.product_type_id = product?.product_type_id ?? "";
    formData.code = product?.code ?? "";
    formData.name = product?.name ?? "";
    formData.main_price = product?.main_price ?? "";
    formData.sale_price = product?.sale_price ?? "";
    formData.main_stock_alert = product?.main_stock_alert ?? "";
    formData.expire_date_alert = product?.expire_date_alert ?? "";
    formData.date = product?.date ?? "";
    formData.product_amount_carton = product?.product_amount_carton ?? "";
    formData.product_amount = product?.product_amount ?? "";
    formData.note = product?.note ?? "";
};

const updateProduct = async () => {
    serverError.value = "";

    const result = await formRef.value?.validate();

    if (!result?.valid) {
        showMessage("لطفاً فیلدهای ضروری را درست خانه‌پری کنید.", "error");
        return;
    }

    loading.value = true;

    try {
        await WareHouseRepository.updateproduct(route.params.id, {
            warehouse_id: formData.warehouse_id,
            product_type_id: formData.product_type_id,
            code: formData.code,
            name: formData.name,
            main_price: formData.main_price,
            sale_price: formData.sale_price,
            main_stock_alert: formData.main_stock_alert,
            expire_date_alert: formData.expire_date_alert,
            date: formData.date,
            product_amount_carton: formData.product_amount_carton,
            product_amount: formData.product_amount,
            note: formData.note,
        });

        showMessage("محصول موفقانه ویرایش شد.");

        setTimeout(() => {
            router.push("/products");
        }, 700);
    } catch (error) {
        serverError.value =
            error?.response?.data?.message ||
            "در ویرایش محصول مشکل رخ داد. لطفاً دوباره کوشش کنید.";

        showMessage("ویرایش محصول انجام نشد.", "error");
    } finally {
        loading.value = false;
    }
};

onMounted(async () => {
    pageLoading.value = true;

    try {
        await Promise.all([
            WareHouseRepository.fetchwarehouseForDropDowns(),
            WareHouseRepository.fetchProductTypesForDropDowns(),
            WareHouseRepository.fetchproduct(route.params.id),
        ]);

        fillForm(WareHouseRepository.product);
    } catch (error) {
        serverError.value =
            "معلومات محصول بارگذاری نشد. لطفاً صفحه را دوباره باز کنید.";

        showMessage("معلومات محصول پیدا نشد.", "error");
    } finally {
        pageLoading.value = false;
    }
});
</script>

<style scoped>
.product-edit-page {
    min-height: 100%;
    padding: 28px;
    background:
        radial-gradient(
            circle at top right,
            rgba(103, 58, 183, 0.12),
            transparent 32%
        ),
        linear-gradient(180deg, #fafafa, #f5f7fb);
}

.product-card {
    border-radius: 24px;
    overflow: hidden;
    border: 1px solid rgba(120, 120, 120, 0.16);
}

.header-section {
    padding: 22px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    background: linear-gradient(
        135deg,
        rgba(103, 58, 183, 0.08),
        rgba(33, 150, 243, 0.06)
    );
}

.section-title {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
    font-weight: 700;
    color: #4527a0;
}

.loading-box {
    min-height: 360px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

.actions {
    margin-top: 22px;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}
</style>