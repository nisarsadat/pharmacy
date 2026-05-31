<template>
    <v-container class="product-edit-page" fluid dir="rtl">
        <v-card class="product-card mx-auto" max-width="1050" elevation="0">
            <!-- Header -->
            <div class="header-section">
                <div>
                    <h2 class="text-h5 font-weight-bold mb-1">
                        ویرایش محصول
                    </h2>
                    <p class="text-body-2 text-medium-emphasis mb-0">
                        معلومات محصول، گدام، نوعیت، تاریخ‌ها و تصویر جدید را تغییر دهید.
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
                        <!-- Images -->
                        <v-col cols="12">
                            <div class="section-title">
                                <v-icon size="20">mdi-image-multiple</v-icon>
                                تصاویر محصول
                            </div>

                            <div class="images-panel">
                                <!-- Existing Images -->
                                <div class="image-column">
                                    <div class="image-column-title">
                                        تصاویر فعلی
                                    </div>

                                    <div v-if="existingImages.length" class="existing-grid">
                                        <v-img
                                            v-for="image in existingImages"
                                            :key="image.id || image.image"
                                            :src="getImageUrl(image.image)"
                                            height="120"
                                            cover
                                            class="existing-img"
                                        />
                                    </div>

                                    <div v-else class="no-existing-image">
                                        <v-icon size="44" color="grey-lighten-1">
                                            mdi-image-off-outline
                                        </v-icon>
                                        <span>برای این محصول عکس ثبت نشده است</span>
                                    </div>
                                </div>

                                <!-- New Image -->
                                <div class="image-column">
                                    <div class="image-column-title">
                                        افزودن تصویر جدید
                                    </div>

                                    <div
                                        class="upload-box"
                                        :class="{ 'upload-box-error': imageError }"
                                        @click="triggerFile"
                                    >
                                        <input
                                            ref="fileInput"
                                            type="file"
                                            accept="image/*"
                                            class="d-none"
                                            @change="onImageChange"
                                        />

                                        <template v-if="newImagePreview">
                                            <div class="new-preview">
                                                <v-img
                                                    :src="newImagePreview"
                                                    height="170"
                                                    cover
                                                    class="rounded-lg"
                                                />

                                                <v-btn
                                                    icon="mdi-close"
                                                    size="x-small"
                                                    color="red"
                                                    class="remove-image-btn"
                                                    @click.stop="removeNewImage"
                                                />
                                            </div>
                                        </template>

                                        <template v-else>
                                            <div class="placeholder">
                                                <v-icon size="48" color="primary">
                                                    mdi-image-plus
                                                </v-icon>

                                                <div class="font-weight-bold mt-2">
                                                    برای انتخاب عکس جدید کلیک کنید
                                                </div>

                                                <div class="text-body-2 text-medium-emphasis mt-1">
                                                    در حالت فعلی فقط یک عکس جدید اضافه می‌شود
                                                </div>

                                                <v-btn
                                                    color="primary"
                                                    class="mt-4"
                                                    prepend-icon="mdi-upload"
                                                    @click.stop="triggerFile"
                                                >
                                                    انتخاب تصویر
                                                </v-btn>
                                            </div>
                                        </template>
                                    </div>

                                    <div
                                        v-if="imageError"
                                        class="text-error text-caption mt-2"
                                    >
                                        {{ imageError }}
                                    </div>
                                </div>
                            </div>
                        </v-col>

                        <!-- Product Info -->
                        <v-col cols="12">
                            <div class="section-title mt-5">
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
                                v-model="formData.product_company"
                                label="شرکت / کارخانه محصول"
                                variant="outlined"
                                density="compact"
                                prepend-inner-icon="mdi-factory"
                            />
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

                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="formData.product_quantity"
                                label="مقدار محصول"
                                type="number"
                                variant="outlined"
                                density="compact"
                                prepend-inner-icon="mdi-counter"
                                :rules="[rules.required, rules.positiveNumber]"
                            />
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-select
                                v-model="formData.product_type_id"
                                label="نوعیت محصول"
                                :items="WareHouseRepository.ProductTypesForDropDown"
                                item-title="label"
                                item-value="value"
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
                                variant="outlined"
                                density="compact"
                                prepend-inner-icon="mdi-warehouse"
                                :rules="[rules.required]"
                            />
                        </v-col>

                        <!-- Dates -->
                        <v-col cols="12">
                            <div class="section-title mt-5">
                                <v-icon size="20">mdi-calendar</v-icon>
                                تاریخ‌ها
                            </div>
                        </v-col>

                        <v-col cols="12" md="4">
                            <v-text-field
                                v-model="formData.date"
                                label="تاریخ ثبت"
                                type="date"
                                variant="outlined"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>

                        <v-col cols="12" md="4">
                            <v-text-field
                                v-model="formData.produced_date"
                                label="تاریخ تولید"
                                type="date"
                                variant="outlined"
                                density="compact"
                            />
                        </v-col>

                        <v-col cols="12" md="4">
                            <v-text-field
                                v-model="formData.expire_date"
                                label="تاریخ انقضا"
                                type="date"
                                variant="outlined"
                                density="compact"
                            />
                        </v-col>

                        <v-col cols="12">
                            <v-textarea
                                v-model="formData.note"
                                label="نوت"
                                variant="outlined"
                                density="compact"
                                rows="3"
                                prepend-inner-icon="mdi-note-text"
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
import { reactive, ref, onMounted, onBeforeUnmount } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useWareHouseRepository } from "../../repositories/WareHouseRepository";

const router = useRouter();
const route = useRoute();
const WareHouseRepository = useWareHouseRepository();

const formRef = ref(null);
const fileInput = ref(null);

const loading = ref(false);
const pageLoading = ref(true);
const serverError = ref("");
const imageError = ref("");

const existingImages = ref([]);
const newImage = ref(null);
const newImagePreview = ref("");

const snackbar = reactive({
    show: false,
    text: "",
    color: "success",
});

const formData = reactive({
    name: "",
    main_price: "",
    sale_price: "",
    product_quantity: "",
    product_company: "",
    date: "",
    expire_date: "",
    produced_date: "",
    warehouse_id: "",
    product_type_id: "",
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

const getImageUrl = (path) => {
    if (!path) return "";

    if (path.startsWith("http")) {
        return path;
    }

    const cleanPath = path.startsWith("/") ? path.slice(1) : path;

    return `http://127.0.0.1:8000/storage/${cleanPath}`;
};

const triggerFile = () => {
    fileInput.value?.click();
};

const revokeNewPreview = () => {
    if (newImagePreview.value) {
        URL.revokeObjectURL(newImagePreview.value);
    }
};

const onImageChange = (event) => {
    imageError.value = "";

    const file = event.target.files?.[0];

    if (!file) {
        return;
    }

    if (!file.type.startsWith("image/")) {
        imageError.value = "لطفاً فقط فایل عکس انتخاب کنید.";
        event.target.value = "";
        return;
    }

    revokeNewPreview();

    newImage.value = file;
    newImagePreview.value = URL.createObjectURL(file);

    event.target.value = "";
};

const removeNewImage = () => {
    revokeNewPreview();

    newImage.value = null;
    newImagePreview.value = "";
    imageError.value = "";
};

const fillForm = (product) => {
    formData.name = product?.name ?? "";
    formData.main_price = product?.main_price ?? "";
    formData.sale_price = product?.sale_price ?? "";
    formData.product_quantity = product?.product_quantity ?? "";
    formData.product_company = product?.product_company ?? "";
    formData.date = product?.date ?? "";
    formData.expire_date = product?.expire_date ?? "";
    formData.produced_date = product?.produced_date ?? "";
    formData.warehouse_id = product?.warehouse_id ?? "";
    formData.product_type_id = product?.product_type_id ?? "";
    formData.note = product?.note ?? "";

    existingImages.value = Array.isArray(product?.images) ? product.images : [];
};

const buildFormData = () => {
    const data = new FormData();

    data.append("_method", "PUT");
    data.append("name", formData.name);
    data.append("main_price", formData.main_price);
    data.append("sale_price", formData.sale_price);
    data.append("product_quantity", formData.product_quantity);
    data.append("product_company", formData.product_company || "");
    data.append("date", formData.date);
    data.append("expire_date", formData.expire_date || "");
    data.append("produced_date", formData.produced_date || "");
    data.append("warehouse_id", formData.warehouse_id);
    data.append("product_type_id", formData.product_type_id);
    data.append("note", formData.note || "");

    if (newImage.value) {
        data.append("image", newImage.value);
    }

    return data;
};

const updateProduct = async () => {
    serverError.value = "";
    imageError.value = "";

    const result = await formRef.value?.validate();

    if (!result?.valid) {
        showMessage("لطفاً فیلدهای ضروری را درست خانه‌پری کنید.", "error");
        return;
    }

    loading.value = true;

    try {
        const data = buildFormData();

        await WareHouseRepository.updateproduct(route.params.id, data);

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

onBeforeUnmount(() => {
    revokeNewPreview();
});
</script>

<style scoped>
.product-edit-page {
    min-height: 100%;
    padding: 28px;
    background:
        radial-gradient(
            circle at top right,
            rgba(103, 58, 183, 0.14),
            transparent 32%
        ),
        linear-gradient(180deg, #fafafa, #f5f7fb);
}

.product-card {
    border-radius: 26px;
    overflow: hidden;
    border: 1px solid rgba(120, 120, 120, 0.16);
    background: rgba(255, 255, 255, 0.96);
}

.header-section {
    padding: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    background:
        radial-gradient(circle at left top, rgba(103, 58, 183, 0.14), transparent 34%),
        linear-gradient(135deg, rgba(103, 58, 183, 0.08), rgba(33, 150, 243, 0.06));
}

.section-title {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
    font-weight: 800;
    color: #4527a0;
}

.loading-box {
    min-height: 390px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

.images-panel {
    display: grid;
    grid-template-columns: 1.15fr 0.85fr;
    gap: 18px;
    padding: 16px;
    border-radius: 22px;
    border: 1px solid rgba(103, 58, 183, 0.12);
    background:
        linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(250, 247, 255, 0.95));
}

.image-column {
    min-width: 0;
}

.image-column-title {
    font-size: 13px;
    font-weight: 800;
    color: #5e35b1;
    margin-bottom: 10px;
}

.existing-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(115px, 1fr));
    gap: 12px;
}

.existing-img {
    border-radius: 16px;
    border: 1px solid rgba(0, 0, 0, 0.08);
    background: #f3f4f8;
}

.no-existing-image {
    min-height: 170px;
    border: 2px dashed #d6d6d6;
    border-radius: 18px;
    background: #fafafa;
    color: #9e9e9e;
    display: flex;
    flex-direction: column;
    gap: 8px;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.upload-box {
    min-height: 170px;
    border: 2px dashed #b39ddb;
    border-radius: 18px;
    background: #fbfaff;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 14px;
    cursor: pointer;
    transition: 0.2s ease;
}

.upload-box:hover {
    border-color: #673ab7;
    background: #f7f2ff;
}

.upload-box-error {
    border-color: #f44336;
    background: #fff5f5;
}

.placeholder {
    text-align: center;
}

.new-preview {
    width: 100%;
    position: relative;
}

.remove-image-btn {
    position: absolute;
    top: 8px;
    left: 8px;
}

.actions {
    margin-top: 22px;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}

@media (max-width: 800px) {
    .product-edit-page {
        padding: 16px;
    }

    .images-panel {
        grid-template-columns: 1fr;
    }
}
</style>